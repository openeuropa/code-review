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
  - { resource: vendor/ec-europa/oe-code-review/dist/conventions.yml }
```

Since GrumPHP uses the [Symfony Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection.html)
you can override specific parameters in your project's `grumphp.yml.dist` file as follows:

```yaml
imports:
  - { resource: vendor/ec-europa/oe-code-review/dist/conventions.yml }
parameters:
  tasks.git_commit_message.matchers: ['/^JIRA-\d+: [A-Z].+\./']
```

Check [``dist/conventions.yml``](dist/conventions.yml) for a list of parameters that can be overridden.

More on how to import and override configuration files [here](http://symfony.com/doc/current/service_container/import.html).

## Usage

Just commit some changes and you'll see warnings if you don't follow [conventions](CONVENTIONS.md).

If you want to perform all checks without a performing a commit run:

```
$ ./vendor/bin/grumphp run
```

If you want to simulate a commit message use:

```
$ ./vendor/bin/grumphp git:pre-commit
```

Check [GrumPHP documentation](https://github.com/phpro/grumphp/tree/master/doc) for more.

## Tests

Tests are provided by [PHPUnit](https://phpunit.de), run them with the following command:

```
$ ./vendor/bin/phpunit
```

## Troubleshooting

### GrumPHP not fired on new commits
 
With Git 2.9+ (June 2016) you have a new option for centralizing hooks: `core.hooksPath`. In case GrumPHP is not
fired on new commits check for `core.hooksPath` global option by running:

```
$ git config --global --list
```

To unset that option run:

```
$ git config --global --unset core.hooksPath 
```


