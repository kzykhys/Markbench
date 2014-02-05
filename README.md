Markdown Benchmarks (PHP)
=========================

All parsers are managed by composer (minimum-stability=stable).
Tested with latest stable version.

[**See the latest benchmark on Travis-CI**](https://travis-ci.org/kzykhys/Markbench)

```
$ php bin/markbench benchmark --profile=github-sample
Runtime: PHP5.5.3
Host:    Linux vm1 3.8.0-31-generic #46-Ubuntu SMP Tue Sep 10 20:03:44 UTC 2013 x86_64
Profile: Sample content from Github (http://github.github.com/github-flavored-markdown/sample_content.html) / 1000 times
Class:   Markbench\Profile\GithubSampleProfile

+----------------------+---------+---------+---------------+---------+--------------+
| package              | version | dialect | duration (MS) | MEM (B) | PEAK MEM (B) |
+----------------------+---------+---------+---------------+---------+--------------+
| erusev/parsedown     | 0.4.6   |         | 10819         | 6291456 | 6553600      |
| michelf/php-markdown | 1.3     |         | 36887         | 6815744 | 6815744      |
| michelf/php-markdown | 1.3     | extra   | 49626         | 6815744 | 7340032      |
| kzykhys/ciconia      | v0.1.4  |         | 64959         | 7340032 | 7602176      |
| kzykhys/ciconia      | v0.1.4  | gfm     | 68987         | 7077888 | 7602176      |
+----------------------+---------+---------+---------------+---------+--------------+
```

Tested parsers
--------------

* michelf/php-markdown (Github, Packagist)
* kzykhys/ciconia (Github, Packagist)
* erusev/parsedown (Github, Packagist)

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