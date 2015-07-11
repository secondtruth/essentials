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

/**
 * Class AbstractTextParser
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
abstract class AbstractTextParser implements ParserInterface
{
    /**
     * @var array
     */
    protected $symbols = array(
        // '--' => '–'
    );

    /**
     * @var array
     */
    protected $emoticons = array(
        // ':)'     => 'smile.gif',
        // ';)'     => 'wink.gif',
        // ':rose:' => 'giverose.gif'
    );

    /**
     * @var string
     */
    protected $emoticonsUrl;

    /**
     * {@inheritdoc}
     */
    public function parse($string)
    {
        // Clean the text
        $string = htmlentities($string);

        // Format the text
        $string = $this->format($string);

        // Replace emoticons and other symbols
        $string = $this->replaceSymbols($string);
        $string = $this->replaceEmoticons($string);

        // Render the paragraphs
        $paragraphs = preg_split('/\r?\n\r?\n/', $string);
        $string = $this->renderParagraphs($paragraphs);

        return $string;
    }

    /**
     * @return array
     */
    public function getSymbols()
    {
        return $this->symbols;
    }

    /**
     * @param string $symbol
     * @param string $replacement
     */
    public function setSymbol($symbol, $replacement)
    {
        $this->symbols[$symbol] = (string) $replacement;
    }

    /**
     * @param array $symbols
     */
    public function setSymbols(array $symbols)
    {
        foreach ($symbols as $symbol => $replacement) {
            $this->setSymbol($symbol, $replacement);
        }
    }

    /**
     * @return array
     */
    public function getEmoticons()
    {
        return $this->emoticons;
    }

    /**
     * @param string $emoticon
     * @param string $replacement
     */
    public function setEmoticon($emoticon, $replacement)
    {
        $this->emoticons[$emoticon] = (string) $replacement;
    }

    /**
     * @param array $emoticons
     */
    public function setEmoticons(array $emoticons)
    {
        foreach ($emoticons as $emoticon => $replacement) {
            $this->setEmoticon($emoticon, $replacement);
        }
    }

    /**
     * @return string
     */
    public function getEmoticonsUrl()
    {
        return $this->emoticonsUrl;
    }

    /**
     * @param string $emoticonsUrl
     */
    public function setEmoticonsUrl($emoticonsUrl)
    {
        $this->emoticonsUrl = (string) $emoticonsUrl;
    }

    /**
     * @param string $string
     * @return string
     */
    abstract protected function format($string);

    /**
     * @param string $string
     * @return string
     */
    protected function replaceSymbols($string)
    {
        $search = array();
        $replace = array();

        foreach ($this->symbols as $symbol => $value) {
            $search[] = '/(\s+)'.preg_quote($symbol, '/').'/';
            $replace[] = '$1'.$value;
        }

        return preg_replace($search, $replace, $string);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function replaceEmoticons($string)
    {
        $search = array();
        $replace = array();

        foreach ($this->emoticons as $symbol => $icon) {
            $search[] = '/(\s+)'.preg_quote($symbol, '/').'/';
            $replace[] = '$1'.sprintf('<img src="%s" alt="%s" />', $this->emoticonsUrl.'/'.$icon, $symbol);
        }

        return preg_replace($search, $replace, $string);
    }

    /**
     * @param string[] $paragraphs
     * @return string
     */
    protected function renderParagraphs(array $paragraphs)
    {
        return '<p>'.join('</p>'.PHP_EOL.'<p>', $paragraphs).'</p>';
    }
}
