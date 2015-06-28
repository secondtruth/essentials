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
 * @license  ISC License <http://opensource.org/licenses/ISC>
 */

namespace FlameCore\Essentials;

/**
 * Class Util
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class Util
{
    /**
     * Constructor disabled
     */
    private function __construct()
    {
    }

    /**
     * @param string $string
     * @param string $separator
     * @param bool $normalize
     * @return string
     */
    public static function makeSlug($string, $separator = '-', $normalize = true)
    {
        if (function_exists('iconv') && $normalize) {
            $string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        }

        $chars = " _-$separator";
        $charsx = preg_quote($chars);

        $string = preg_replace("/[^a-zA-Z0-9$charsx]/", '', $string);
        $string = str_replace([' ', '_', '-'], $separator, strtolower($string));
        $string = trim($string, $chars);

        return $string;
    }

    /**
     * @param string[] $tags
     * @param string $separator
     * @param string|bool $link
     * @return string
     */
    public static function listTags(array $tags, $separator = ', ', $link = false)
    {
        natsort($tags);

        foreach ($tags as $tag) {
            if ($link !== false) {
                $tag = sprintf('<a href="%s">%s</a>', sprintf($link, $tag), $tag);
            }

            $tagList[] = $tag;
        }

        return implode($separator, $tagList);
    }
}
