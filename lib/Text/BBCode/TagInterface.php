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

namespace FlameCore\Essentials\Text\BBCode;

/**
 * Interface TagInterface
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
interface TagInterface
{
    /**
     * Returns the tag replacement.
     *
     * @param string $inner The inner text
     * @param string $param The parameter value
     * @param string $tag Tthe tag name
     * @return string
     */
    public function replace($inner, $param = null, $tag = null);
}
