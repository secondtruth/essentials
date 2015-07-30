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

namespace FlameCore\Essentials;

/**
 * Class WordlistGenerator
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class WordlistGenerator
{
    /**
     * Generates a word list.
     *
     * @param string[] $words The words
     * @param string $separator The word separator
     * @param string|bool $link The link URL including a sprintf() variable for the word.
     * @return string Returns the word list.
     */
    public function generate(array $words, $separator = ', ', $link = false)
    {
        $words = $this->sort($words);

        $wordList = array();

        foreach ($words as $word) {
            if ($link !== false) {
                $word = $this->link($word, sprintf($link, $word));
            }

            $wordList[] = $word;
        }

        return implode($separator, $wordList);
    }

    /**
     * Sorts the words.
     *
     * @param array $words The words
     * @return array
     */
    protected function sort(array $words)
    {
        natsort($words);

        return $words;
    }

    /**
     * Links the given word.
     *
     * @param $word The word to link
     * @param $url The URL of the link
     * @return string
     */
    protected function link($word, $url)
    {
        return sprintf('<a href="%s">%s</a>', $url, $word);
    }
}
