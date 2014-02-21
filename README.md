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
Runtime: PHP5.5.1-2
Host:    Linux 3.2.0-4-amd64 #1 SMP Debian 3.2.32-1 x86_64
Profile: Sample content from Github (http://github.github.com/github-flavored-markdown/sample_content.html) / 1000 times
Class:   Markbench\Profile\GithubSampleProfile

+----------------------+---------+---------+---------------+---------+--------------+
| package              | version | dialect | duration (MS) | MEM (B) | PEAK MEM (B) |
+----------------------+---------+---------+---------------+---------+--------------+
| cebe/markdown        | 0.9.0   |         | 2930          | 7602176 | 7602176      |
| erusev/parsedown     | 0.9.4   |         | 3530          | 7602176 | 7602176      |
| cebe/markdown        | 0.9.0   | gfm     | 3674          | 7602176 | 7602176      |
| michelf/php-markdown | 1.4.0   |         | 8702          | 7864320 | 7864320      |
| michelf/php-markdown | 1.4.0   | extra   | 12427         | 7864320 | 8126464      |
| kzykhys/ciconia      | v1.0.3  |         | 15583         | 8650752 | 8912896      |
| kzykhys/ciconia      | v1.0.3  | gfm     | 18549         | 8912896 | 9175040      |
+----------------------+---------+---------+---------------+---------+--------------+
```

Tested parsers
--------------

* michelf/php-markdown (Github, Packagist)
* kzykhys/ciconia (Github, Packagist)
* erusev/parsedown (Github, Packagist)
* cebe/markdown (Github, Packagist)

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
$ php bin/markbench help benchmark
Usage:
 benchmark [-p|--profile[="..."]]

Options:
 --profile (-p)        Name of a profile (default: "default")
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