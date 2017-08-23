# OpenEuropa code review

[![Build Status](https://travis-ci.com/ec-europa/oe-code-review.svg?token=dqSmBxPQnRgBZvpCZAqo&branch=master)](https://travis-ci.com/ec-europa/oe-code-review)

Make automatic [conventions](CONVENTIONS.md) checking on each commit via [GrumPHP](https://github.com/phpro/grumphp).

## Installation

Install the code review component via Composer:

```
composer require --dev ec-europa/oe-code-review
```

In your project root create the following `grumphp.yml.dist`:

```yaml
imports:
  - { resource: vendor/ec-europa/oe-code-review/dist/library-conventions.yml }
```

For a list of available conventions please check [CONVENTIONS.md](CONVENTIONS.md).

Since GrumPHP uses the [Symfony Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection.html)
you can override specific parameters in your project's `grumphp.yml.dist` file as follows:

```yaml
imports:
  - { resource: vendor/ec-europa/oe-code-review/dist/library-conventions.yml }
parameters:
  tasks.git_commit_message.matchers: ['/^JIRA-\d+: [A-Z].+\./']
```

Below the list of task parameters can that be overridden on a per-project basis:

- `tasks.phpcs.ignore_patterns`
- `tasks.phpcs.triggered_by`
- `tasks.phpcs.whitelist_patterns`
- `tasks.phpmd.exclude`
- `tasks.phpmd.ruleset`
- `tasks.phpmd.triggered_by`
- `tasks.git_commit_message.matchers`

More on how to import and override configuration files [here](http://symfony.com/doc/current/service_container/import.html).

## Usage

GrumPHP tasks will be ran at every commit, if you with to run them without performing a commit use the following command:

```
$ ./vendor/bin/grumphp run
```

If you want to simulate a commit message use:

```
$ ./vendor/bin/grumphp git:pre-commit
```

Check [GrumPHP documentation](https://github.com/phpro/grumphp/tree/master/doc) for more.

## Tests

Run [PHPUnit](https://phpunit.de) tests with the following command:

```
$ ./vendor/bin/phpunit
```

## Troubleshooting

**GrumPHP not fired on new commits**
 
With Git 2.9+ (June 2016) you have a new option for centralizing hooks: `core.hooksPath`. In case GrumPHP is not
fired on new commits check for `core.hooksPath` global option by running:

```
$ git config --global --list
```

To unset that option run:

```
$ git config --global --unset core.hooksPath 
```


