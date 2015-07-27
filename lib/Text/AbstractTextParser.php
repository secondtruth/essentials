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
     * The list of symbols
     *
     * @var array
     */
    protected $symbols = array(
        // '--' => '–'
    );

    /**
     * The list of emoticons
     *
     * @var array
     */
    protected $emoticons = array(
        // ':)'     => 'smile.gif',
        // ';)'     => 'wink.gif',
        // ':rose:' => 'giverose.gif'
    );

    /**
     * The emoticons URL
     *
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
     * Returns the list of symbols.
     *
     * @return array
     */
    public function getSymbols()
    {
        return $this->symbols;
    }

    /**
     * Sets the replacement for the given symbol.
     *
     * @param string $symbol The symbol
     * @param string $replacement The replacement
     */
    public function setSymbol($symbol, $replacement)
    {
        $this->symbols[$symbol] = (string) $replacement;
    }

    /**
     * Sets the given symbols with their replacements.
     *
     * @param array $symbols The list of symbols
     */
    public function setSymbols(array $symbols)
    {
        foreach ($symbols as $symbol => $replacement) {
            $this->setSymbol($symbol, $replacement);
        }
    }

    /**
     * Returns the list of emoticons.
     *
     * @return array
     */
    public function getEmoticons()
    {
        return $this->emoticons;
    }

    /**
     * Sets the replacement for the given emoticon.
     *
     * @param string $emoticon The emoticon
     * @param string $replacement The replacement
     */
    public function setEmoticon($emoticon, $replacement)
    {
        $this->emoticons[$emoticon] = (string) $replacement;
    }

    /**
     * Sets the given emoticons with their replacements.
     *
     * @param array $emoticons The list of emoticons
     */
    public function setEmoticons(array $emoticons)
    {
        foreach ($emoticons as $emoticon => $replacement) {
            $this->setEmoticon($emoticon, $replacement);
        }
    }

    /**
     * Returns the emoticons URL.
     *
     * @return string
     */
    public function getEmoticonsUrl()
    {
        return $this->emoticonsUrl;
    }

    /**
     * Sets the emoticons URL.
     *
     * @param string $emoticonsUrl
     */
    public function setEmoticonsUrl($emoticonsUrl)
    {
        $this->emoticonsUrl = (string) $emoticonsUrl;
    }

    /**
     * Formats the string.
     *
     * @param string $string
     * @return string
     */
    abstract protected function format($string);

    /**
     * Replaces the symbols in the string.
     *
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
     * Replaces the emoticons in the string.
     *
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
     * Renders the paragraphs.
     *
     * @param string[] $paragraphs
     * @return string
     */
    protected function renderParagraphs(array $paragraphs)
    {
        return '<p>'.join('</p>'.PHP_EOL.'<p>', $paragraphs).'</p>';
    }
}
