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

use FlameCore\Essentials\KeywordsFinder;

/**
 * Test class for KeywordsFinder
 */
class KeywordsFinderTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $finder = new KeywordsFinder();

        $this->assertEquals(['abc', 'def', 'ghi'], $finder->find('ghi, ghi, Def; ABC'));
    }

    public function testFindWithStopwords()
    {
        $finder = new KeywordsFinder(['def', 'jkl']);

        $this->assertEquals(['abc', 'ghi', 'mno'], $finder->find('abc, def, ghi, jkl, mno'));
    }

    public function testAddStopword()
    {
        $finder = new KeywordsFinder(['foo']);
        $finder->addStopword('Bar');
        $finder->addStopword('BAZ');

        $this->assertEquals(['foo', 'bar', 'baz'], $finder->getStopwords());
    }

    public function testAddStopwords()
    {
        $finder = new KeywordsFinder(['foo']);
        $finder->addStopwords(['Bar', 'BAZ']);

        $this->assertEquals(['foo', 'bar', 'baz'], $finder->getStopwords());
    }
}
