<?php
/**
 * FlameCore Essentials
 * Copyright (C) 2015 IceFlame.net
 *
 * Permission to use, copy, modify, and/or distribute this software for
 * any purpose with or without fee is hereby granted, provided that the
 * above copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE
 * FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY
 * DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER
 * IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING
 * OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 *
 * @package  FlameCore\Essentials
 * @version  0.1-dev
 * @link     http://www.flamecore.org
 * @license  http://opensource.org/licenses/ISC ISC License
 */

namespace FlameCore\Essentials\Tests\Text;

use FlameCore\Essentials\Text\SimpleTextParser;

/**
 * Test class for SimpleTextParser
 */
class SimpleTextParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $text = <<<EOT
Lorem ipsum dolor http://www.example.org/index.html sit amet,
consetetur sadipscing elitr https://example.org.

At vero eos et accusam et @username duo -- dolores et ea rebum.
Stet clita kasd #hashtag, no sea takimata sanctus est. :)
EOT;

        $expected = <<<EOT
<p>Lorem ipsum dolor <a href="http://www.example.org/index.html" rel="nofollow" target="_blank">http://www.example.org/index.html</a> sit amet,
consetetur sadipscing elitr <a href="https://example.org" rel="nofollow" target="_blank">https://example.org</a>.</p>
<p>At vero eos et accusam et @username duo – dolores et ea rebum.
Stet clita kasd #hashtag, no sea takimata sanctus est. <img src="http://example.org/smile.gif" alt=":)" /></p>
EOT;

        $parser = new SimpleTextParser();
        $parser->setSymbols(['--' => '–']);
        $parser->setEmoticons([':)' => 'smile.gif']);
        $parser->setEmoticonsUrl('http://example.org');

        $this->assertEquals($expected, $parser->parse($text));
    }
}
