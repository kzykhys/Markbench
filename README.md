Markdown Benchmarks (PHP)
=========================

All parsers are managed by composer (minimum-stability=stable).
Tested with latest stable version.

[**See the latest benchmark on Travis-CI**][]

```
$ php bin/markbench benchmark --profile=github-sample
Profile: Sample content from Github (http://github.github.com/github-flavored-markdown/sample_content.html) / 1000 times
         Markbench\Profile\GithubSampleProfile
Runtime: PHP5.5.3
Host:    Linux vm1 3.8.0-31-generic #46-Ubuntu SMP Tue Sep 10 20:03:44 UTC 2013 x86_64
+--------------------------------+---------------+---------+--------------+
| package                        | duration (MS) | MEM (B) | PEAK MEM (B) |
+--------------------------------+---------------+---------+--------------+
| erusev/parsedown (default)     | 10609         | 6029312 | 6029312      |
| michelf/php-markdown (default) | 36426         | 6553600 | 6553600      |
| michelf/php-markdown (extra)   | 48915         | 6553600 | 6815744      |
| kzykhys/ciconia (default)      | 63964         | 6815744 | 7077888      |
| kzykhys/ciconia (gfm)          | 68512         | 7077888 | 7340032      |
+--------------------------------+---------------+---------+--------------+
```

Tested parsers
--------------

* michelf/php-markdown (Github, Packagist)
* kzykhys/ciconia (Github, Packagist)
* erusev/parsedown (Github, Packagist)

Add a parser
------------

* Put your class that implements `Markbench\DriverInterface` into `Driver` directory.
* Run command again

**Feel free to fork and send a pull request!**

Run a benchmark
---------------

```
composer install
php bin/markbench benchmark
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