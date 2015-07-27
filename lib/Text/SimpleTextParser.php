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

use FlameCore\Essentials\Formatter\LinkFormatter;

/**
 * Class SimpleTextParser
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class SimpleTextParser extends AbstractTextParser
{
    /**
     * List of link patterns
     *
     * @var string[]
     */
    protected $linkPatterns = array(
        '(?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’])',
        '[@#]\w+'
    );

    /**
     * The link formatter to use
     *
     * @var \FlameCore\Essentials\Formatter\LinkFormatter
     */
    protected $linkFormatter;

    /**
     * Creates a SimpleTextParser object.
     *
     * @param \FlameCore\Essentials\Formatter\LinkFormatter $linkFormatter The link formatter to use
     */
    public function __construct(LinkFormatter $linkFormatter = null)
    {
        $this->linkFormatter = $linkFormatter ?: new LinkFormatter();
    }

    /**
     * Returns the list of link patterns.
     *
     * @return string[]
     */
    public function getLinkPatterns()
    {
        return $this->linkPatterns;
    }

    /**
     * Adds the given link pattern.
     *
     * @param string $linkPattern The link pattern to add
     */
    public function addLinkPattern($linkPattern)
    {
        $this->linkPatterns[] = (string) $linkPattern;
    }

    /**
     * Adds the given link patterns.
     *
     * @param string[] $linkPatterns The list of link patterns to add
     */
    public function addLinkPatterns(array $linkPatterns)
    {
        foreach ($linkPatterns as $linkPattern) {
            $this->addLinkPattern($linkPattern);
        }
    }

    /**
     * Returns the link formatter to use.
     *
     * @return \FlameCore\Essentials\Formatter\LinkFormatter
     */
    public function getLinkFormatter()
    {
        return $this->linkFormatter;
    }

    /**
     * Sets the link formatter to use.
     *
     * @param \FlameCore\Essentials\Formatter\LinkFormatter $linkFormatter The link formatter to use
     */
    public function setLinkFormatter(LinkFormatter $linkFormatter)
    {
        $this->linkFormatter = $linkFormatter;
    }

    /**
     * {@inheritdoc}
     */
    protected function format($string)
    {
        // Replace links
        $pattern = '{\b(?:'.join('|', $this->linkPatterns).')}i';
        $string = preg_replace_callback($pattern, function ($matches) {
            return $this->linkFormatter->format($matches[0]);
        }, $string);

        return $string;
    }
}
