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

namespace FlameCore\Essentials\Text;

use FlameCore\Essentials\Text\BBCode\TagInterface;

/**
 * Class BBCodeParser
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class BBCodeParser extends AbstractTextParser
{
    /**
     * The list of registered tags
     *
     * @var \FlameCore\Essentials\Text\BBCode\TagInterface[]
     */
    protected $tags = array();

    /**
     * Returns the list of registered tags.
     *
     * @return \FlameCore\Essentials\Text\BBCode\TagInterface[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Registers the given tag.
     *
     * @param string $name The tag name
     * @param \FlameCore\Essentials\Text\BBCode\TagInterface $tag The tag object
     */
    public function register($name, TagInterface $tag)
    {
        $this->tags[$name] = $tag;
    }

    /**
     * Registers all given tags.
     *
     * @param \FlameCore\Essentials\Text\BBCode\TagInterface[] $tags The tags
     */
    public function registerAll(array $tags)
    {
        foreach ($tags as $name => $tag) {
            if (!$tag instanceof TagInterface) {
                throw new \InvalidArgumentException('The $tags array may only contain FlameCore\Essentials\Text\BBCode\TagInterface instances.');
            }

            $this->register($name, $tag);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function format($string)
    {
        // Replace BBCode tags
        while (preg_match_all('#\[(\S+?)=?(.*?)\]([^\]]*)\[/\1\]#', $string, $matches)) {
            foreach ($matches[0] as $key => $match) {
                list($tag, $param, $inner) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]);

                $replacement = $this->getReplacement($tag, $inner, $param);
                $string = str_replace($match, $replacement, $string);
            }
        }

        return $string;
    }

    /**
     * Returns the tag replacement.
     *
     * @param string $tag Tthe tag name
     * @param string $inner The inner text
     * @param string $param The parameter value
     * @return string
     */
    protected function getReplacement($tag, $inner, $param)
    {
        if (isset($this->tags[$tag])) {
            $replacer = $this->tags[$tag];
            return $replacer->replace($inner, $param, $tag) ?: $inner;
        }

        return $inner;
    }
}
