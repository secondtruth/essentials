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

namespace FlameCore\Essentials\Tests\Formatter;

use FlameCore\Essentials\Formatter\LinkFormatter;

/**
 * Test class for LinkFormatter
 */
class LinkFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $formatter = new LinkFormatter();

        $expected = '<a href="http://www.flamecore.org" rel="nofollow" target="_blank">http://www.flamecore.org</a>';
        $this->assertEquals($expected, $formatter->format('http://www.flamecore.org'));

        $expected = '<a href="mailto:info@flamecore.org" target="_blank">info@flamecore.org</a>';
        $this->assertEquals($expected, $formatter->format('info@flamecore.org'));

        $expected = '<a href="http://www.flamecore.org" rel="nofollow" target="_blank">Lorem ipsum</a>';
        $this->assertEquals($expected, $formatter->format('http://www.flamecore.org', 'Lorem ipsum'));

        $this->assertEquals('foobar', $formatter->format('foobar'));
    }

    public function testRegister()
    {
        $formatter = new LinkFormatter();
        $formatter->register('@(\w+)', 'user');

        $expected = array(
            '((?:https?|ftps?)://\S+)' => 'web',
            '([\w\-\.]+@[a-z\-\.]+\.[a-z]+)' => 'email',
            '@(\w+)' => 'user'
        );

        $this->assertEquals($expected, $formatter->getPatterns());
    }

    public function testRegisterWithTemplate()
    {
        $formatter = new LinkFormatter();
        $formatter->register('@(\w+)', 'user', '<a href="/{#1}">{title}</a>');

        $expected = array(
            '((?:https?|ftps?)://\S+)' => 'web',
            '([\w\-\.]+@[a-z\-\.]+\.[a-z]+)' => 'email',
            '@(\w+)' => 'user'
        );

        $this->assertEquals($expected, $formatter->getPatterns());

        $expected = array(
            'web' => '<a href="{#1}" rel="nofollow" target="_blank">{title}</a>',
            'email' => '<a href="mailto:{#1}" target="_blank">{title}</a>',
            'user' => '<a href="/{#1}">{title}</a>'
        );

        $this->assertEquals($expected, $formatter->getTemplates());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The link type "web" has already a template assigned.
     */
    public function testRegisterWithExistingTemplate()
    {
        $formatter = new LinkFormatter();
        $formatter->register('@(\w+)', 'web', '<a href="/{#1}">{title}</a>');
    }

    public function testSetTemplate()
    {
        $formatter = new LinkFormatter();
        $formatter->setTemplate('email', '<a href="mailto:{#1}">{title}</a>');
        $formatter->setTemplate('user', '<a href="/{#1}">{title}</a>');

        $expected = array(
            'web' => '<a href="{#1}" rel="nofollow" target="_blank">{title}</a>',
            'email' => '<a href="mailto:{#1}">{title}</a>',
            'user' => '<a href="/{#1}">{title}</a>'
        );

        $this->assertEquals($expected, $formatter->getTemplates());
        $this->assertTrue($formatter->hasTemplate('user'));
    }
}
