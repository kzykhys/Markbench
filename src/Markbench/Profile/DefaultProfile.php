<?php

namespace Markbench\Profile;

use Markbench\ProfileInterface;

/**
 * @author Kazuyuki Hayashi <hayashi@valnur.net>
 */
class DefaultProfile implements ProfileInterface
{

    /**
     * Returns the name of this profile
     *
     * @return mixed
     */
    public function getName()
    {
        return 'default';
    }

    /**
     * Describe this profile
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Basic markdown content with all official syntax / 1000 times';
    }

    /**
     * Returns markdown content to test
     *
     * @return string
     */
    public function getContent()
    {
        return <<<EOF
Header1
=======

Header2
-------

# Header1

## Header2

### Header3

#### Header4

##### Header5

###### Header6

> This is a blockquote with two paragraphs. Lorem ipsum dolor sit amet,
> consectetuer adipiscing elit. Aliquam hendrerit mi posuere lectus.
> Vestibulum enim wisi, viverra nec, fringilla in, laoreet vitae, risus.
>
> Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
> id sem consectetuer libero luctus adipiscing.

> Donec sit amet nisl. Aliquam semper ipsum sit amet velit. Suspendisse
id sem consectetuer libero luctus adipiscing.

> This is the first level of quoting.
>
> > This is nested blockquote.
>
> Back to the first level.

> ## This is a header.
>
> 1.   This is the first list item.
> 2.   This is the second list item.
>
> Here's some example code:
>
>     return shell_exec('echo 1');

*   Red
*   Green
*   Blue

1.  Bird
2.  McHale
3.  Parish

*   Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
    Aliquam hendrerit mi posuere lectus. Vestibulum enim wisi,
    viverra nec, fringilla in, laoreet vitae, risus.
*   Donec sit amet nisl. Aliquam semper ipsum sit amet velit.
    Suspendisse id sem consectetuer libero luctus adipiscing.

*   A list item with a blockquote:

    > This is a blockquote
    > inside a list item.

Here is an example of AppleScript:

    tell application "Foo"
        beep
    end tell

* * *

***

*****

- - -

---------------------------------------

This is [an example](http://example.com/ "Title") inline link.

[This link](http://example.net/) has no title attribute.

See my [About](/about/) page for details.

This is [an example][id] reference-style link.
Visit [Daring Fireball][] for more information.

I get 10 times more traffic from [Google] [1] than from
[Yahoo] [2] or [MSN] [3].

*single asterisks*

_single underscores_

**double asterisks**

__double underscores__

un*frigging*believable

Use the `printf()` function.

A single backtick in a code span: `` ` ``

A backtick-delimited string in a code span: `` `foo` ``

![Alt text](/path/to/img.jpg)

![Alt text](/path/to/img.jpg "Optional title")

<http://example.com/>

<address@example.com>

  [1]: http://google.com/        "Google"
  [2]: http://search.yahoo.com/  "Yahoo Search"
  [3]: http://search.msn.com/    "MSN Search"

[id]: http://example.com/  "Optional Title Here"
[Daring Fireball]: http://daringfireball.net/
EOF;

    }

    /**
     * @return mixed
     */
    public function getLoopCount()
    {
        return 1000;
    }

}