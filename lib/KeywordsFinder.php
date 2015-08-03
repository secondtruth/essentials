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

namespace FlameCore\Essentials;

/**
 * Class KeywordsFinder
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class KeywordsFinder
{
    /**
     * The list of stopwords
     *
     * @var string[]
     */
    protected $stopwords = array();

    /**
     * Creates a KeywordsFinder object.
     *
     * @param string[] $stopwords The list of stopwords
     */
    public function __construct(array $stopwords = null)
    {
        if ($stopwords !== null) {
            $this->addStopwords($stopwords);
        }
    }

    /**
     * Finds the keywords in the given string.
     *
     * @param string $string The string
     * @return string[] Returns a list of found keywords.
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
     * Returns the list of stopwords.
     *
     * @return string[]
     */
    public function getStopwords()
    {
        return $this->stopwords;
    }

    /**
     * Adds the given stopword.
     *
     * @param string $stopword The stopword to add
     */
    public function addStopword($stopword)
    {
        $this->stopwords[] = $this->clean($stopword);
    }

    /**
     * Adds the given stopwords.
     *
     * @param string[] $stopwords The stopwords to add
     */
    public function addStopwords(array $stopwords)
    {
        foreach ($stopwords as $stopword) {
            $this->addStopword($stopword);
        }
    }

    /**
     * Cleans the given string.
     *
     * @param string $string The string to clean
     * @return string Returns the cleaned string.
     */
    protected function clean($string)
    {
        $string = strtolower(trim($string));
        $string = str_replace(['.', ':', '!', '?', '-', ' - ', '(', ')'], '', $string);

        return $string;
    }
}
