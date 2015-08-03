<?php
/**
 * FlameCore Essentials
 * Copyright (C) 2015 IceFlame.net
 *
 * Permission to use, copy, modify, and/or distribute this software for
 * any purpose with or without fee is hereby granted, provided that the
 * above copyright notice and this permission notice appear in all copies.
 *
 * @package  FlameCore\Essentials
 * @version  0.1-dev
 * @link     http://www.flamecore.org
 * @license  http://opensource.org/licenses/ISC ISC License
 */

namespace FlameCore\Essentials\Tests;

use FlameCore\Essentials\WordlistGenerator;

/**
 * Test class for WordlistGenerator
 */
class WordlistGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerate()
    {
        $generator = new WordlistGenerator();

        $this->assertEquals('abc, def, ghi', $generator->generate(['ghi', 'def', 'abc']));
        $this->assertEquals('abc; def; ghi', $generator->generate(['ghi', 'def', 'abc'], '; '));
        $this->assertEquals('<a href="/foo">abc</a>, <a href="/foo">def</a>', $generator->generate(['abc', 'def'], ', ', '/foo'));
        $this->assertEquals('<a href="/abc">abc</a>; <a href="/def">def</a>', $generator->generate(['abc', 'def'], '; ', '/%s'));
    }
}
