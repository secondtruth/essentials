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

namespace FlameCore\Essentials\Tests\Formatter;

use FlameCore\Essentials\Formatter\RelativeTimeFormatter;

/**
 * Test class for RelativeTimeFormatter
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class RelativeTimeFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $formatter = new RelativeTimeFormatter();
        $now = time();

        $this->assertEquals('just now', $formatter->format($now));
        $this->assertEquals('1 minute ago', $formatter->format($now - RelativeTimeFormatter::MINUTE));
        $this->assertEquals('1 hour ago', $formatter->format($now - RelativeTimeFormatter::HOUR));
        $this->assertEquals('1 day ago', $formatter->format($now - RelativeTimeFormatter::DAY));
        $this->assertEquals('1 week ago', $formatter->format($now - RelativeTimeFormatter::WEEK));
        $this->assertEquals('1 month ago', $formatter->format($now - RelativeTimeFormatter::MONTH));
        $this->assertEquals('1 year ago', $formatter->format($now - RelativeTimeFormatter::YEAR));
    }

    public function testFormatPlural()
    {
        $formatter = new RelativeTimeFormatter();
        $now = time();

        $this->assertEquals('59 seconds ago', $formatter->format($now - RelativeTimeFormatter::SECOND * 59));
        $this->assertEquals('59 minutes ago', $formatter->format($now - RelativeTimeFormatter::MINUTE * 59));
        $this->assertEquals('23 hours ago', $formatter->format($now - RelativeTimeFormatter::HOUR * 23));
        $this->assertEquals('6 days ago', $formatter->format($now - RelativeTimeFormatter::DAY * 6));
        $this->assertEquals('4 weeks ago', $formatter->format($now - RelativeTimeFormatter::WEEK * 4));
        $this->assertEquals('11 months ago', $formatter->format($now - RelativeTimeFormatter::MONTH * 11));
        $this->assertEquals('2 years ago', $formatter->format($now - RelativeTimeFormatter::YEAR * 2));
    }

    public function testFormatWithPrecision()
    {
        $formatter = new RelativeTimeFormatter();
        $now = time();

        $value = $now - RelativeTimeFormatter::HOUR - RelativeTimeFormatter::MINUTE;
        $this->assertEquals('1 hour, 1 minute ago', $formatter->format($value, 2));

        $value = $now - RelativeTimeFormatter::DAY - RelativeTimeFormatter::HOUR - RelativeTimeFormatter::MINUTE * 59;
        $this->assertEquals('1 day, 1 hour, 59 minutes ago', $formatter->format($value, 3));

        $value = $now - RelativeTimeFormatter::DAY - RelativeTimeFormatter::HOUR * 23;
        $this->assertEquals('1 day; 23 hours ago', $formatter->format($value, 2, '; '));
    }
}
