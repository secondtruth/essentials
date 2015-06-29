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

namespace FlameCore\Essentials\Formatter;

/**
 * Class RelativeTimeFormatter
 *
 * @author   Christian Neff <christian.neff@gmail.com>
 */
class RelativeTimeFormatter
{
    const YEAR   = 31536000; // 365 * 24 * 60 * 60
    const MONTH  = 2592000;  // 30 * 24 * 60 * 60
    const WEEK   = 604800;   // 7 * 24 * 60 * 60
    const DAY    = 86400;    // 24 * 60 * 60
    const HOUR   = 3600;     // 60 * 60
    const MINUTE = 60;
    const SECOND = 1;

    /**
     * @param int $time
     * @param int $precision (Default: `1`)
     * @param string $separator (Default: `', '`)
     * @return string
     */
    public function format($time, $precision = 1, $separator = ', ')
    {
        $passed = time() - $time;

        if ($passed < 5) {
            return $this->translate('just now');
        } else {
            $list = array();
            $exit = 0;

            foreach ($this->getPeriods() as $period => $name) {
                if ($exit >= $precision || ($exit > 0 && $period < 60)) {
                    break;
                }

                $result = floor($passed / $period);
                if ($result > 0) {
                    $list[] = $result.' '.$this->translate($result == 1 ? $name[0] : $name[1]);
                    $passed -= $result * $period;
                    $exit++;
                } elseif ($exit > 0) {
                    $exit++;
                }
            }

            return $this->translate('%time_ago% ago', ['time_ago' => implode($separator, $list)]);
        }
    }

    /**
     * @return array
     */
    protected function getPeriods()
    {
        return array(
            self::YEAR   => ['year', 'years'],
            self::MONTH  => ['month', 'months'],
            self::WEEK   => ['week', 'weeks'],
            self::DAY    => ['day', 'days'],
            self::HOUR   => ['hour', 'hours'],
            self::MINUTE => ['minute', 'minutes'],
            self::SECOND => ['second', 'seconds']
        );
    }

    /**
     * @param string $string
     * @param array $vars
     * @return string
     */
    protected function translate($string, array $vars = null)
    {
        // Replace variables if needed
        if ($vars !== null) {
            foreach ($vars as $key => $value) {
                $string = str_replace('%'.$key.'%', $value, $string);
            }
        }

        return $string;
    }
}
