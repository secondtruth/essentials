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
 * @version  0.1
 * @link     http://www.flamecore.org
 * @license  http://opensource.org/licenses/ISC ISC License
 */

namespace FlameCore\Essentials\Tests;

use FlameCore\Essentials\Slugifier;

/**
 * Test class for Slugifier
 */
class SlugifierTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugify()
    {
        $slugifier = new Slugifier();

        if (function_exists('iconv')) {
            $umlauts = @iconv('UTF-8', 'ASCII//TRANSLIT', 'äöü');
            $this->assertEquals("foo-bar-baz-foo--$umlauts", $slugifier->slugify('foo_bar, baz-foo;  äöü'));
        } else {
            $this->assertEquals('foo-bar-baz-foo--foo', $slugifier->slugify('foo_bar, baz-foo;  foo'));
        }

        $this->assertEquals('foo_bar_baz_foo', $slugifier->slugify('foo-bar baz foo', '_'));
        $this->assertEquals('foo_bar_baz', $slugifier->slugify('foo-bar baz äöü', '_', false));
    }
}
