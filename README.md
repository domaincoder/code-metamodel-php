# [WIP] CodeMetamodel-PHP

Code Metamodel for PHP

[![Build Status](https://travis-ci.org/domaincoder/code-metamodel-php.svg?branch=master)](https://travis-ci.org/domaincoder/code-metamodel-php)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/5c98f622-4bdf-43f8-963a-be7c9e4e3e1f/mini.png)](https://insight.sensiolabs.com/projects/5c98f622-4bdf-43f8-963a-be7c9e4e3e1f)
[![Total Downloads](https://poser.pugx.org/domaincoder/code-metamodel-php/downloads.png)](https://packagist.org/packages/domaincoder/code-metamodel-php)
[![Latest Stable Version](https://poser.pugx.org/domaincoder/code-metamodel-php/v/stable.png)](https://packagist.org/packages/domaincoder/code-metamodel-php)
[![Latest Unstable Version](https://poser.pugx.org/domaincoder/code-metamodel-php/v/unstable.png)](https://packagist.org/packages/domaincoder/code-metamodel-php)
[![Dependency Status](https://www.versioneye.com/php/domaincoder:code-metamodel-php/dev-master/badge.svg)](https://www.versioneye.com/php/webmozart:console/1.0.0)
## Features

- `Parser\Parser` parses PHP sources under a project to generate metamodel objects (via CLI command).
- `Element\*` are metamodel classes. Currently supports
  - [x] namespace
  - [x] use
  - [x] class
  - [x] class annotation
  - [ ] class inheritance
  - [x] property
  - [x] property annotation
  - [ ] property type resolving (only declared by use)
  - [x] method
  - [x] method annotation
- `Dumper\SimpleDumper` dumps metamodel objects to simple text.

## Installation

`CodeMetamodel-PHP` can be installed using  [Composer](http://getcomposer.org/).

```
composer require domaincoder/code-metamodel-php "@dev"
```

## Commands

Some features of `CodeMetamodel-PHP` are provided via CLI commands. CLI commands can be ran as follows:

```
$ php bin/domaincoder-parser.php COMMAND_NAME TARGET_DIR (OPTIONS)
```

### parse

This command parses codes under the TARGET_DIR and create model cache.

```
$ php bin/domaincoder-parser.php parse /path/to/project/root
```

### dump

This command dumps meta-model objects of a specified location.

```
$ php bin/domaincoder-parser.php dump /path/to/project/root
```

### filter-class

With this command you can search classes in a meta-model objects of a specified location.
Options are:

- annotation: Annotation name (ex. ORM\\Entity, author)
- comment: keyword (ex. related to tax)

```
$ php bin/domaincoder-parser.php filter-class /path/to/project/root --annotation=Route --comment=Test
```

### filter-property

With this command you can search properties in a meta-model objects of a specified location.
Options are:

- annotation: Annotation name (ex. ORM\\Entity, author)
- comment: keyword (ex. related to tax)

```
$ php bin/domaincoder-parser.php filter-property /path/to/project/root --annotation=Route --comment=Test
```

### filter-method

With this command you can search methods in a meta-model objects of a specified location.
Options are:

- annotation: Annotation name (ex. ORM\\Entity, author)
- comment: keyword (ex. related to tax)

```
$ php bin/domaincoder-parser.php filter-method /path/to/project/root --annotation=Route --comment=Test
```

## Roadmap

- v 0.0.1 implements parser which parses codes to build metamodel objects. saving model objects to a cache (APC) or json format.
- v 0.0.2 adds filter commands.
- v 0.0.3 adds modifying existing AST to add fields, change annotations, etc.

## Support

If you find a bug or have a question, or want to request a feature, create an issue or pull request for it on [Issues](https://github.com/domaincoder/code-metamodel-php/issues).

## Copyright

Copyright (c) 2015 GOTO Hidenori, All rights reserved.

## License

[The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause)
