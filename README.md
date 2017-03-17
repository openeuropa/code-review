## Code review component

Make automatic [conventions](CONVENTIONS.md) checking on each commit.

## Installation

Add the code review component to your `composer.json`:

```
composer require --dev ec-europa/poc-code-review
```

Add path to GrumPHP configuration file to your `composer.json`'s extra:

```
"extra": {
  "grumphp": {
    "config-default-path": "vendor/ec-europa/poc-code-review/dist/grumphp.yml"
  }
}
```

## Usage

Just commit some changes and you see warnings if you don't follow [conventions](CONVENTIONS.md).

## Note

When using a test editor to edit your commit message it is recommended to set:

```
$ git config --add commit.cleanup scissors # use --global if you wish this to apply globally.
```

This will ensure you can start your messages with an hash `#`.
