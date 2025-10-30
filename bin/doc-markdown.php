#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use League\HTMLToMarkdown\HtmlConverter;

$inputDir = $argv[1] ?? __DIR__ . '/../docs';
$outputDir = $argv[2] ?? $inputDir . '/markdown';

if (!is_dir($inputDir)) {
    fwrite(STDERR, "Input docs directory not found: {$inputDir}\nRun ./vendor/bin/phpdoc first.\n");
    exit(1);
}

if (!is_dir($outputDir)) {
    if (!mkdir($outputDir, 0775, true) && !is_dir($outputDir)) {
        fwrite(STDERR, "Failed to create output directory: {$outputDir}\n");
        exit(1);
    }
}

$converter = new HtmlConverter([
    'strip_tags' => false,
]);

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($inputDir));

$converted = 0;
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    // Skip symlinks to avoid traversing outside intended docs tree.
    if ($file->isLink()) continue;
    $path = $file->getPathname();
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    if (!in_array($ext, ['html', 'htm'])) continue;

    $html = file_get_contents($path);
    if ($html === false) {
        fwrite(STDERR, "Failed to read: {$path}\n");
        continue;
    }

    $markdown = $converter->convert($html);

    // Derive relative path and write .md file mirroring structure
    $relative = ltrim(str_replace($inputDir, '', $path), DIRECTORY_SEPARATOR);
    $mdPath = $outputDir . '/' . preg_replace('/\.(html|htm)$/i', '.md', $relative);
    $mdDir = dirname($mdPath);
    if (!is_dir($mdDir) && !mkdir($mdDir, 0775, true) && !is_dir($mdDir)) {
        fwrite(STDERR, "Failed to create directory for {$mdPath}\n");
        continue;
    }

    file_put_contents($mdPath, $markdown);
    $converted++;
}

echo "Converted {$converted} HTML files to Markdown in {$outputDir}\n";
