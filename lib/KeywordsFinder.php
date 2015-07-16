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
 * Class KeywordsFinder
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class KeywordsFinder
{
    /**
     * @var array
     */
    protected $stopwords = array();

    /**
     * @param array $stopwords
     */
    public function __construct(array $stopwords = null)
    {
        if ($stopwords !== null) {
            $this->addStopwords($stopwords);
        }
    }

    /**
     * @param string $string
     * @return array
     */
    public function find($string)
    {
        $keywords = preg_split('/[\s,;]+/', $this->clean($string));
        $keywords = array_unique($keywords);

        foreach ($this->stopwords as $stopword) {
            $pos = array_search($stopword, $keywords);
            if ($pos !== false) {
                unset($keywords[$pos]);
            }
        }

        sort($keywords);

        return $keywords;
    }

    /**
     * @return array
     */
    public function getStopwords()
    {
        return $this->stopwords;
    }

    /**
     * @param string $stopword
     */
    public function addStopword($stopword)
    {
        $this->stopwords[] = $this->clean($stopword);
    }

    /**
     * @param array $stopwords
     */
    public function addStopwords(array $stopwords)
    {
        foreach ($stopwords as $stopword) {
            $this->addStopword($stopword);
        }
    }

    /**
     * @param string $string
     * @return string
     */
    protected function clean($string)
    {
        $string = strtolower(trim($string));
        $string = str_replace(['.', ':', '!', '?', '-', ' - ', '(', ')'], '', $string);

        return $string;
    }
}
