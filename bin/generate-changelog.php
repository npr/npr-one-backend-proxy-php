#!/usr/bin/env php
<?php
declare(strict_types=1);

// Simple GitHub milestone-based changelog generator.
// Requires env var GITHUB_TOKEN (classic repo scope or fine-grained with issues/pr read) or --token option.
// Usage examples:
//   php bin/generate-changelog.php --milestone=12
//   php bin/generate-changelog.php -m 12 -o CHANGELOG.md --prepend
// By default writes Markdown to STDOUT.

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

const EXIT_INVALID_ARGUMENT = 2;
const EXIT_RUNTIME_ERROR = 3;

function stderr(string $msg): void { fwrite(STDERR, $msg . "\n"); }

function usage(): void {
    echo <<<HELP
GitHub Milestone Changelog Generator

Required:
  --milestone, -m   Milestone number (not title) to generate.

Options:
  --owner, -o       Repository owner (default: npr)
  --repo, -r        Repository name (default: npr-one-backend-proxy-php)
  --token, -t       GitHub token (else env GITHUB_TOKEN used)
  --output, -O      Output file path (default: stdout)
  --prepend         If output file exists, prepend new changelog section (keep previous content)
  --categories      Comma list of label:Heading mappings. Default built-ins applied if omitted.
  --since-tag       Infer compare links: tag to treat as previous version (optional)
  --new-version     Version heading to use (default: milestone title or number)
  --date            Override date (YYYY-MM-DD) in heading (default: today)
  --unreleased      Treat as unreleased (omit date) even if milestone closed
  --help, -h        Show help

Label -> Category default mapping (case-insensitive label match):
  breaking          Breaking Changes
  feature|enhancement  Added
  bug|bugfix|fix    Fixed
  docs|documentation Documentation
  refactor          Changed
  deprecation       Deprecated
  security          Security

All other items fall under "Other".
HELP;
}

// Parse CLI args (minimalistic)
$args = $argv;
array_shift($args);
$opts = [
    'milestone' => null,
    'owner' => 'npr',
    'repo' => 'npr-one-backend-proxy-php',
    'token' => getenv('GITHUB_TOKEN') ?: null,
    'output' => null,
    'prepend' => false,
    'categories' => null,
    'since-tag' => null,
    'new-version' => null,
    'date' => (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d'),
    'unreleased' => false,
];

for ($i = 0; $i < count($args); $i++) {
    $arg = $args[$i];
    if ($arg === '--help' || $arg === '-h') { usage(); exit(0); }
    if ($arg === '--prepend') { $opts['prepend'] = true; continue; }
    if ($arg === '--unreleased') { $opts['unreleased'] = true; continue; }
    $key = null; $value = null;
    if (str_starts_with($arg, '--')) {
        $parts = explode('=', substr($arg, 2), 2);
        $key = $parts[0];
        if (isset($parts[1])) {
            $value = $parts[1];
        } else {
            // Allow space separated: --milestone 12
            if (($i + 1) < count($args) && !str_starts_with($args[$i+1], '-')) {
                $value = $args[++$i];
            }
        }
    } elseif (strlen($arg) > 1 && $arg[0] === '-') {
        $short = substr($arg, 1, 1);
        $map = ['m' => 'milestone','o'=>'owner','r'=>'repo','t'=>'token','O'=>'output'];
        $key = $map[$short] ?? null;
        if ($key === null) { stderr("Unknown short option -$short"); exit(EXIT_INVALID_ARGUMENT); }
        $tail = substr($arg, 2); // support -m12
        if ($tail !== '') {
            $value = $tail;
        } else {
            if (($i + 1) < count($args) && !str_starts_with($args[$i+1], '-')) {
                $value = $args[++$i];
            }
        }
    } else {
        stderr("Unexpected argument: $arg"); exit(EXIT_INVALID_ARGUMENT);
    }
    if ($key !== null) {
        if ($value === null) {
            stderr("Option --$key requires a value");
            exit(EXIT_INVALID_ARGUMENT);
        }
        $opts[$key] = $value;
    }
}

if (!$opts['milestone']) {
    stderr('Missing required --milestone=N');
    usage();
    exit(EXIT_INVALID_ARGUMENT);
}
// Milestone must be numeric to avoid malformed API paths.
if (!ctype_digit((string)$opts['milestone'])) {
    stderr('Milestone must be a numeric ID');
    exit(EXIT_INVALID_ARGUMENT);
}
if (!$opts['token']) {
    stderr('Missing GitHub token (set GITHUB_TOKEN env or pass --token=...)');
    exit(EXIT_INVALID_ARGUMENT);
}

// Category mapping build
$defaultCategorySpec = 'breaking:Breaking Changes,feature:Added,enhancement:Added,bug:Fixed,bugfix:Fixed,fix:Fixed,docs:Documentation,documentation:Documentation,refactor:Changed,deprecation:Deprecated,security:Security';
$catSpec = $opts['categories'] ?? $defaultCategorySpec;
$labelToCategory = [];
foreach (explode(',', $catSpec) as $pair) {
    [$label, $heading] = array_map('trim', explode(':', $pair, 2) + ['', '']);
    if ($label !== '' && $heading !== '') {
        // Sanitize heading to mitigate unintended markdown injection (allow alnum, space, common punctuation)
        $cleanHeading = preg_replace('/[^A-Za-z0-9 \-&()\/]/', '', $heading);
        $labelToCategory[strtolower($label)] = $cleanHeading;
    }
}

$http = new Client([
    'base_uri' => 'https://api.github.com/',
    'headers' => [
        // Use Bearer scheme (GitHub also accepts the older 'token' prefix). This avoids exposing pattern of classic tokens.
        'Authorization' => 'Bearer ' . $opts['token'],
        'Accept' => 'application/vnd.github+json',
        'User-Agent' => 'npr-one-backend-proxy-changelog'
    ],
    'http_errors' => false,
]);

/** @throws RuntimeException */
function gh(Client $http, string $method, string $uri, array $query = []): array {
    try {
        $resp = $http->request($method, $uri, ['query' => $query]);
    } catch (GuzzleException $e) {
        throw new RuntimeException('HTTP request failed: ' . $e->getMessage(), 0, $e);
    }
    $status = $resp->getStatusCode();
    $body = (string)$resp->getBody();
    $json = json_decode($body, true);
    if ($status >= 400) {
        $msg = is_array($json) && isset($json['message']) ? $json['message'] : $body;
        throw new RuntimeException("GitHub API error $status: $msg");
    }
    if (!is_array($json)) {
        throw new RuntimeException('Unexpected JSON response');
    }
    return $json;
}

try {
    $milestone = gh($http, 'GET', sprintf('repos/%s/%s/milestones/%s', $opts['owner'], $opts['repo'], $opts['milestone']));
} catch (RuntimeException $e) {
    stderr('Failed to load milestone: ' . $e->getMessage());
    exit(EXIT_RUNTIME_ERROR);
}

$versionHeading = $opts['new-version'] ?? ($milestone['title'] ?? ('Milestone ' . $opts['milestone']));
$isClosed = ($milestone['state'] ?? '') === 'closed';
$datePart = ($opts['unreleased'] || !$isClosed) ? '' : ' - ' . $opts['date'];

// Collect issues (includes PRs via state=all, filter by milestone number)
$issues = [];
$page = 1;
do {
    try {
        $batch = gh($http, 'GET', sprintf('repos/%s/%s/issues', $opts['owner'], $opts['repo']), [
            'milestone' => $opts['milestone'],
            'state' => 'all',
            'per_page' => 100,
            'page' => $page,
            'direction' => 'asc'
        ]);
    } catch (RuntimeException $e) {
        stderr('Failed to fetch issues: ' . $e->getMessage());
        exit(EXIT_RUNTIME_ERROR);
    }
    $issues = array_merge($issues, $batch);
    $page++;
} while (count($batch) === 100);

// Categorize
$categories = [];
foreach ($issues as $issue) {
    if (isset($issue['pull_request'])) {
        $type = 'Pull Request'; // Keep distinction via label mapping still
    }
    $labels = $issue['labels'] ?? [];
    $assignedCategory = null;
    foreach ($labels as $label) {
        $lname = strtolower(is_array($label) ? ($label['name'] ?? '') : $label);
        if (isset($labelToCategory[$lname])) {
            $assignedCategory = $labelToCategory[$lname];
            break;
        }
    }
    $assignedCategory = $assignedCategory ?? 'Other';
    $categories[$assignedCategory][] = $issue;
}

ksort($categories); // alphabetical headings (deterministic)

// Build Markdown
$md = [];
$md[] = sprintf('## %s%s', $versionHeading, $datePart);
$md[] = '';
$md[] = sprintf('- Milestone: [%s](%s)', $milestone['title'] ?? $opts['milestone'], $milestone['html_url'] ?? '');
if ($opts['since-tag']) {
    $md[] = sprintf('- Comparison: [%1$s...%2$s](https://github.com/%3$s/%4$s/compare/%1$s...%2$s)', $opts['since-tag'], $versionHeading, $opts['owner'], $opts['repo']);
}
$md[] = '';

foreach ($categories as $heading => $items) {
    $md[] = '### ' . $heading;
    foreach ($items as $item) {
        $title = trim($item['title'] ?? '');
        $number = $item['number'];
        $url = $item['html_url'];
        $user = $item['user']['login'] ?? '';
        $labels = array_map(function ($l) { return is_array($l) ? ($l['name'] ?? '') : (string)$l; }, $item['labels'] ?? []);
        $labelStr = $labels ? ' [' . implode(', ', $labels) . ']' : '';
        $md[] = sprintf('- %s (#%d by @%s)%s', $title, $number, $user, $labelStr);
    }
    $md[] = '';
}

$output = implode("\n", $md) . "\n";

if ($opts['output']) {
    // Guard: output path must not be an existing directory.
    if (is_dir($opts['output'])) {
        stderr('Output path is a directory; provide a file path.');
        exit(EXIT_INVALID_ARGUMENT);
    }
    if (file_exists($opts['output']) && $opts['prepend']) {
        $existing = file_get_contents($opts['output']);
        file_put_contents($opts['output'], $output . "\n" . $existing);
    } else {
        file_put_contents($opts['output'], $output);
    }
} else {
    echo $output;
}

exit(0);
