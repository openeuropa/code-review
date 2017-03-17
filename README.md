# Code review component

Make automatic [conventions](CONVENTIONS.md) checking on each commit via [GrumPHP](https://github.com/phpro/grumphp).

## Installation

Install the code review component via Composer:

```
composer require --dev ec-europa/poc-code-review
```

In your project root create the following `grumphp.yml.dist`:

```yaml
imports:
  - { resource: vendor/ec-europa/poc-code-review/dist/conventions.yml }
parameters:
  # Your GrumPHP parameters here.
```

Since GrumPHP uses the [Symfony Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection.html)
you can override specific parameters in your project's `grumphp.yml.dist` file as follows:

```yaml
imports:
  - { resource: vendor/ec-europa/poc-code-review/dist/conventions.yml }
parameters:
  tasks.git_commit_message.matchers: ['/^JIRA-\d+: [A-Z].+\./']
```

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

## Note

When using a test editor to edit your commit message it is recommended to set:

```
$ git config --add commit.cleanup scissors # use --global if you wish this to apply globally.
```

This will ensure you can start your messages with an hash `#`.
