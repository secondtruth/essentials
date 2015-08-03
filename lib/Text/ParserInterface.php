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

namespace FlameCore\Essentials\Text;

/**
 * Interface ParserInterface
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
interface ParserInterface
{
    /**
     * Parses the given text.
     *
     * @param string $string The string to parse
     * @return string Returns the formatted version of the text.
     */
    public function parse($string);
}
