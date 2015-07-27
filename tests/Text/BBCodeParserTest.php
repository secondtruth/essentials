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

use FlameCore\Essentials\Text\BBCodeParser;
use FlameCore\Essentials\Text\BBCode\SimpleTag;

/**
 * Test class for BBCodeParser
 */
class BBCodeParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $text = <<<EOT
Lorem ipsum [b]dolor sit amet[/b], consetetur sadipscing elitr,
ed diam nonumy eirmod tempor invidunt ut labore et dolore.

At vero eos et accusam et justo duo -- dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus est. :)
EOT;

        $expected = <<<EOT
<p>Lorem ipsum <strong>dolor sit amet</strong>, consetetur sadipscing elitr,
ed diam nonumy eirmod tempor invidunt ut labore et dolore.</p>
<p>At vero eos et accusam et justo duo – dolores et ea rebum.
Stet clita kasd gubergren, no sea takimata sanctus est. <img src="http://example.org/smile.gif" alt=":)" /></p>
EOT;

        $parser = new BBCodeParser();
        $parser->setSymbols(['--' => '–']);
        $parser->setEmoticons([':)' => 'smile.gif']);
        $parser->setEmoticonsUrl('http://example.org');
        
        $tag = new SimpleTag();
        $tag->setReplacement('<strong>%s</strong>');
        $parser->register('b', $tag);

        $this->assertEquals($expected, $parser->parse($text));
    }
}
