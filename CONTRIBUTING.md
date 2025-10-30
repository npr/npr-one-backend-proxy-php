# Contributing

If you're interested in contributing to this project by submitting bug reports, helping to improve the documentation, or writing actual code, please read on.

##### Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Submitting Issues](#submitting-issues)
  - [Got a Question or Problem?](#got-a-question-or-problem)
  - [Found a Bug?](#found-a-bug)
  - [Want a Feature?](#want-a-feature)
- [Contributing to Development](#contributing-to-development)
  - [Getting Set Up](#getting-set-up)
  - [Coding Style](#coding-style)
  - [Testing](#testing)
  - [Generating Documentation](#generating-documentation)
  - [Generating a Changelog](#generating-a-changelog)


## Code of Conduct

Please note that this project has a [Code of Conduct](CODE_OF_CONDUCT.md). By participating in this project, you agree to abide by its terms.


## Submitting Issues

When you're considering [submitting an issue to our GitHub repository](https://github.com/npr/npr-one-backend-proxy-php/issues/new), please consider the following guidelines:

### Got a Question or Problem?

If you have questions about how to use this package, we would generally prefer that you [contact us via e-mail](mailto:NPROneEnterprise@npr.org) rather than opening a ticket. That said, if you have constructive feedback for how we can make this package better by improving the documentation, by all means, [submit an issue](https://github.com/npr/npr-one-backend-proxy-php/issues/new). Please be detailed about your specific pain points, so that we're clear on what aspects of the documentation should be improved.

### Found a Bug?

If you find a bug in the source code or a mistake in the documentation, you can help us by [submitting an issue to our GitHub repository](https://github.com/npr/npr-one-backend-proxy-php/issues/new). Even better, you can submit a pull request with a fix. (Please read and follow our [Development Guidelines](#contributing-to-development) before submitting your PR.)

### Want a Feature?

You can request a new feature by [submitting an issue to our GitHub repository](https://github.com/npr/npr-one-backend-proxy-php/issues/new). Even if the feature is small and you are able to submit a pull request to implement it yourself, we would prefer to discuss it in the comments on the issue before you run off and write the code. Because this package is largely intended to function as an educational tool and documentation companion, we are trying to keep the codebase as simple and clear as possible, and not all new feature requests will be accepted. That said, you are always welcome to maintain a fork of our repository that has the additional features that you need.


## Contributing to Development

If you would like to contribute to the development of this project, here is the additional information you need:

### Getting Set Up

This project uses [Composer](https://getcomposer.org/).

Additionally, we highly recommend doing your development with [Xdebug enabled](https://xdebug.org/docs/install), to allow you to take advantage of various features, such as automatic code coverage measurement.

### Coding Style

We follow the [PSR-1](http://www.php-fig.org/psr/psr-1/) basic coding standards and [PSR-2](http://www.php-fig.org/psr/psr-2/) coding style guide, with the following addenda, exceptions, and clarifications:

* All variables/property names should be in `$camelCase` only.
* We put all opening curly braces on their own separate line, even for control structures.
* We prefer `else if` to `elseif`.
* We do not enforce any soft limit on line length (but expect developers to practice common sense here).

Pull requests not conforming to our coding style may be asked to be updated before they are merged.

### Testing

This project includes tests which can be executed with PHPUnit.

- `./vendor/bin/phpunit`: runs all unit tests

PHPUnit is configured to generate coverage reports in a `coverage` folder under `test-results` in the root of the project. (N.B. These coverage reports are purposely excluded from source control.) Note that [Xdebug must be enabled](https://xdebug.org/docs/install) in order for code coverage to be generated.

XML files are also generated for reporting test results and coverage on a CI server; again, those can be found under `test-results`.

### Generating Documentation

We generate API documentation using [phpDocumentor 3](https://www.phpdoc.org). By default it produces HTML output in the `docs` directory (configured via `phpdoc.xml`). If you also want Markdown versions for easier in-repo browsing or diffing, an optional conversion script is provided.

To generate or update the HTML documentation:

```
./vendor/bin/phpdoc
```

This will populate (or refresh) the contents under `docs/`.

To convert all generated HTML files to Markdown run:

```
php bin/doc-markdown.php docs docs/markdown
```

The converter (using `league/html-to-markdown`) will mirror the HTML directory tree under `docs/markdown` with `.md` files. You can omit the second argument to use the default output directory (`docs/markdown`).

Notes:
* The legacy `phpdocmd` pipeline has been removed; `structure.xml` is no longer produced.
* Regenerate after code or docblock changes before opening a PR that updates docs.
* Do not hand-edit generated files; instead edit source docblocks.

### Generating a Changelog

Use the provided script to build a Markdown section from a GitHub milestone (milestone number, not title). Only maintainers normally run this.

Example (prints to stdout):

```
php bin/generate-changelog.php -m 1 --token=YOUR_TOKEN
```

Common options (see `--help` for full list):
* `-m/--milestone` (required) Milestone number.
* `-t/--token`     GitHub token (or set `GITHUB_TOKEN` env instead of passing `--token`).
* `-O/--output`    Write to file instead of stdout.
* `--prepend`      Prepend to existing changelog file.

Writing & prepending to `CHANGELOG.md` for milestone 1:

```
export GITHUB_TOKEN=YOUR_TOKEN
php bin/generate-changelog.php -m 1 -O CHANGELOG.md --prepend
```

Run `php bin/generate-changelog.php --help` to see advanced flags (custom categories, comparison links, unreleased mode, etc.).
