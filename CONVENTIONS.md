# Conventions

Information about conventions for OpenEuropa projects and components.

## Available conventions

These conventions can be used in your projects:

* [Library](dist/library-conventions.yml) for generic PHP projects.
* [Drupal](dist/drupal-conventions.yml) for Drupal projects.
* [OE Component](dist/oe-component-conventions.yml) for oe component projects.

There is also a [base conventions](dist/base-conventions.yml) file, this one is only meant to be extended and shouldn't be used directly.

## PHP Code Sniffer

- For generic PHP projects: [PSR-12 coding standards](https://www.php-fig.org/psr/psr-12)
  with the following additions:
  - Comments, array declarations and code that is split over multiple lines also
    need to be indented with 4 characters.
- For Drupal projects: [Drupal coding standards](https://www.drupal.org/docs/develop/standards)
  except:
  - `Drupal.Commenting.Deprecated` because this rule only makes sense for core and projects in drupal.org.

## PHP Stan

- For generic PHP projects: PHPStan default config, more info about available configuration: https://phpstan.org/user-guide/getting-started

- For Drupal projects:
  - [mglaman/phpstan-drupal](https://github.com/mglaman/phpstan-drupal): allows to understand how to read code in a Drupal.
  - [phpstan/phpstan-deprecation-rules](https://github.com/phpstan/phpstan-deprecation-rules): this extension emits deprecation warnings on code.
  - [phpstan/extension-installer](https://github.com/phpstan/extension-installer): package autoconfigures PHPStan to load the previous packages.

## Commit messages

Valid default commit messages: `Issue #123: My commit.` or `OPENEUROPA-123: My commit.`

- Must start with GitHub issue reference or a Jira-like ticket ID.
- Must have a colon followed by a space after the issue reference.
- Must start with capital letter and end with a period.
