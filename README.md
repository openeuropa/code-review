# Code review
[![Build Status](https://drone.fpfis.eu/api/badges/openeuropa/code-review/status.svg?branch=master)](https://drone.fpfis.eu/openeuropa/code-review)
[![Packagist](https://img.shields.io/packagist/v/openeuropa/code-review.svg)](https://packagist.org/packages/openeuropa/code-review)

Make automatic [conventions](CONVENTIONS.md) checking on each commit via [GrumPHP](https://github.com/phpro/grumphp).

## Installation

Install the code review component via Composer:

```bash
composer require --dev openeuropa/code-review
```

As this project uses some [patches](#Patches), you will have to enable patching in your project's `composer.json` file.

```yaml
"extra": {
    "enable-patching": true,
    "composer-exit-on-patch-failure": true
}
```

See the [cweagans/composer-patches](https://github.com/cweagans/composer-patches) package for more information on how to
apply patches in a project.

See also the [#Patches](#Patches) section for further information.

In your project root create the following `grumphp.yml.dist`:

```yaml
imports:
  - { resource: vendor/openeuropa/code-review/dist/library-conventions.yml }
```

### Using Docker Compose

Alternatively, you can build a development setup using [Docker](https://www.docker.com/get-docker) and 
[Docker Compose](https://docs.docker.com/compose/) with the provided configuration.

Docker provides the necessary services and tools such as a web server and a database server to get the site running, 
regardless of your local host configuration.

#### Requirements:

- [Docker](https://www.docker.com/get-docker)
- [Docker Compose](https://docs.docker.com/compose/)

#### Configuration

By default, Docker Compose reads two files, a `docker-compose.yml` and an optional `docker-compose.override.yml` file.
By convention, the `docker-compose.yml` contains your base configuration and it's provided by default.
The override file, as its name implies, can contain configuration overrides for existing services or entirely new 
services.
If a service is defined in both files, Docker Compose merges the configurations.

Find more information on Docker Compose extension mechanism on [the official Docker Compose documentation](https://docs.docker.com/compose/extends/).

#### Usage

To start, run:

```bash
docker-compose up
```

It's advised to not daemonize `docker-compose` so you can turn it off (`CTRL+C`) quickly when you're done working.
However, if you'd like to daemonize it, you have to add the flag `-d`:

```bash
docker-compose up -d
```

Then:

```bash
docker-compose exec web composer install
```

#### Running the tests

To run the grumphp checks:

```bash
docker-compose exec web ./vendor/bin/grumphp run
```

To run the phpunit tests:

```bash
docker-compose exec web ./vendor/bin/phpunit
```

## Customization

This component offers a variety of ready conventions that all projects need to follow.
This list of default conventions can be found in [CONVENTIONS.md](CONVENTIONS.md).

Since GrumPHP uses the [Symfony Dependency Injection component](http://symfony.com/doc/current/components/dependency_injection.html)
you can override specific parameters in your project's `grumphp.yml.dist` file as follows:

```yaml
imports:
  - { resource: vendor/openeuropa/code-review/dist/library-conventions.yml }

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
- `tasks.phpcsfixer2.config`
- `tasks.phpcsfixer2.allow_risky`
- `tasks.jsonlint.ignore_patterns`

More on how to import and override configuration files [here](http://symfony.com/doc/current/service_container/import.html).

It is also possible to extend the list of tasks to be run by loading the extra tasks extension and adding tasks under
the `extra_tasks:` parameter as shown below:

```yaml
imports:
  - { resource: vendor/openeuropa/code-review/dist/library-conventions.yml }

parameters:
  extra_tasks:
    phpparser: ~
  extensions:
    - OpenEuropa\CodeReview\ExtraTasksExtension
```

GrumPHP already has a series of tasks that can be used out of the box, you can find the complete list in the
[GrumPHP tasks page](https://github.com/phpro/grumphp/blob/master/doc/tasks.md).

It is also possible to create your own tasks as explained in the [GrumPHP extensions page](https://github.com/phpro/grumphp/blob/master/doc/extensions.md).

## Usage

GrumPHP tasks will be ran at every commit, if you with to run them without performing a commit use the following command:

```bash
./vendor/bin/grumphp run
```

If you want to simulate the tasks that will be run when creating a new commit:

```bash
./vendor/bin/grumphp git:pre-commit
```

Check [GrumPHP documentation](https://github.com/phpro/grumphp/tree/master/doc) for more.

## Changelog

The changelog is generated using a local docker installation which installs [muccg/docker-github-changelog-generator](https://github.com/muccg/docker-github-changelog-generator)

This reads the [Github API](https://api.github.com/repos/openeuropa/code-review) for the required repository and writes the CHANGELOG.md to the root of the repository.

**Prerequisites**

- Local Docker machine running.
- A [Github Access Token](https://github.com/settings/tokens) should be generated and exported (or written to ~/.gitconfig) as `CHANGELOG_GITHUB_TOKEN=<YOUR TOKEN HERE>`  

Before tagging a new release export the following:

```bash
export CHANGELOG_GITHUB_TOKEN=<YOUR TOKEN HERE>
export CHANGELOG_FUTURE_RELEASE=0.1.0
```

The changelog can then be generated by running:

```bash
composer run-script changelog
```

## Troubleshooting

**GrumPHP not fired on new commits**
 
With Git 2.9+ (June 2016) you have a new option for centralizing hooks: `core.hooksPath`. In case GrumPHP is not
fired on new commits check for `core.hooksPath` global option by running:

```bash
git config --global --list
```

To unset that option run:

```bash
git config --global --unset core.hooksPath 
```

**Generate Changelog on Mac**

* Best results were gained using the [Docker app](https://docs.docker.com/docker-for-mac/install/)
* The local repo folder should be shared under Docker -> Preferences -> File sharing to enable the file to be written locally.

## Patches

The component uses the PSR-2 standard based on version 3.4 of package [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).
As the PSR-2 standard does not enforce indentation, we decided to add custom rules in a custom ruleset in order to make sure
that our code is properly indented.

Unfortunately, there are some issues in versions 3.4 of [squizlabs/PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) regarding
code indentation and we fixed them by including custom patches.

Those issues are partially solved in version 3.5 which is not stable yet.

As soon as 3.5 reaches a stable version, we will remove those patches.
