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

namespace FlameCore\Essentials\Text\BBCode;

/**
 * Class SimpleTag
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class SimpleTag implements TagInterface
{
    /**
     * The replacement string using a sprintf() variable for the inner text
     *
     * @var string
     */
    protected $replacement = '%s';

    /**
     * {@inheritdoc}
     */
    public function replace($inner, $param = null, $tag = null)
    {
        return sprintf($this->replacement, $inner);
    }

    /**
     * Returns the replacement string.
     *
     * @return string
     */
    public function getReplacement()
    {
        return $this->replacement;
    }

    /**
     * Sets the replacement string.
     *
     * @param string $replacement The replacement string using a sprintf() variable for the inner text
     */
    public function setReplacement($replacement)
    {
        $this->replacement = $replacement;
    }
}
