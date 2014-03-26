Markdown Benchmarks (PHP)
=========================

[![Build Status](https://travis-ci.org/kzykhys/Markbench.png?branch=master)](https://travis-ci.org/kzykhys/Markbench)
[![Latest Stable Version](https://poser.pugx.org/kzykhys/markbench/v/stable.png)](https://packagist.org/packages/kzykhys/markbench)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f85a4034-6089-4b14-acb5-990e202a5a55/mini.png)](https://insight.sensiolabs.com/projects/f85a4034-6089-4b14-acb5-990e202a5a55)

All parsers are managed by composer (minimum-stability=stable).
Tested with latest stable version.

[**See the latest benchmark on Travis-CI**](https://travis-ci.org/kzykhys/Markbench)

```
$ php bin/markbench benchmark --profile=github-sample
Runtime: PHP5.5.9
Host:    Linux testing-worker-linux-3-2-18579-linux-14-21570148 2.6.32-042stab079.5 #1 SMP Fri Aug 2 17:16:15 MSK 2013 x86_64
Profile: Sample content from Github (http://github.github.com/github-flavored-markdown/sample_content.html) / 1000 times
Class:   Markbench\Profile\GithubSampleProfile
+----------------------+---------+---------+---------------+----------+--------------+
| package              | version | dialect | duration (MS) | MEM (B)  | PEAK MEM (B) |
+----------------------+---------+---------+---------------+----------+--------------+
| sundown              | 0.3.11  |         | 902           | 9437184  | 9437184      |
| erusev/parsedown     | 0.9.4   |         | 4122          | 9699328  | 9961472      |
| cebe/markdown        | 0.9.2   |         | 5323          | 9699328  | 9699328      |
| cebe/markdown        | 0.9.2   | gfm     | 5660          | 9699328  | 9699328      |
| michelf/php-markdown | 1.4.0   |         | 14871         | 9699328  | 9961472      |
| michelf/php-markdown | 1.4.0   | extra   | 21313         | 9961472  | 9961472      |
| kzykhys/ciconia      | v1.0.3  |         | 28878         | 11010048 | 11272192     |
| kzykhys/ciconia      | v1.0.3  | gfm     | 34663         | 11010048 | 11534336     |
+----------------------+---------+---------+---------------+----------+--------------+
```

Tested parsers
--------------

* [michelf/php-markdown](https://github.com/michelf/php-markdown) [![Latest Stable Version](https://poser.pugx.org/michelf/php-markdown/v/stable.png)](https://packagist.org/packages/michelf/php-markdown)
* [kzykhys/ciconia](https://github.com/kzykhys/Ciconia) [![Latest Stable Version](https://poser.pugx.org/kzykhys/ciconia/v/stable.png)](https://packagist.org/packages/kzykhys/ciconia)
* [erusev/parsedown](https://github.com/erusev/parsedown) [![Latest Stable Version](https://poser.pugx.org/erusev/parsedown/v/stable.png)](https://packagist.org/packages/erusev/parsedown)
* [cebe/markdown](https://github.com/cebe/markdown) [![Latest Stable Version](https://poser.pugx.org/cebe/markdown/v/stable.png)](https://packagist.org/packages/cebe/markdown)
* [chobie/php-sundown](https://github.com/chobie/php-sundown) [**Extension**](http://pecl.php.net/package/sundown)

Internals
---------

Each parser is executed asynchronously using [kzykhys/Parallel.php](https://github.com/kzykhys/Parallel.php)

```
Runner
 +-->(kzykhys/Parallel.php)
        +-- child process #1 --+
        +-- child process #2 --+--> output
        +-- child process #3 --+
        |-- duration/mem usage --|
```

### Requirements

* PHP5.4+
* Compiled with --enable-pcntl
* sundown `> pecl install -f sundown`

Add a parser
------------

* Put your class that implements `Markbench\DriverInterface` into `Driver` directory.
* Run command again

**Feel free to fork and send a pull request!**

Run a benchmark
---------------

```
composer install
bin/markbench benchmark
```

```
$ bin/markbench help benchmark
Usage:
 benchmark [--parser="..."] [-p|--profile[="..."]]

Options:
 --parser              Name of a parser. Available: cebe/markdown, cebe/markdown:gfm, kzykhys/ciconia, kzykhys/ciconia:gfm, erusev/parsedown, michelf/php-markdown, michelf/php-markdown:extra
 --profile (-p)        Name of a profile. (default: "default")
 --help (-h)           Display this help message.
 --quiet (-q)          Do not output any message.
 --verbose (-v|vv|vvv) Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
 --version (-V)        Display this application version.
 --ansi                Force ANSI output.
 --no-ansi             Disable ANSI output.
 --no-interaction (-n) Do not ask any interactive question.
```

### Profiles

* default
* blank
* github-sample

### Add a profile

* Put your class that implements `Markbench\ProfileInterface` into `Profile` directory.
* Run `php bin/markbench benchmark --profile=your_profile_name`

**Feel free to fork and send a pull request!**

License
-------

The MIT License

Author
------

Kazuyuki Hayashi (@kzykhys)