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
 * @version  0.1
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
     * Formats the given time.
     *
     * @param int $time The timestamp
     * @param int $precision The number of shown units
     * @param string $separator The unit separator
     * @return string Returns the formatted time.
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

                $num = floor($passed / $period);
                if ($num > 0) {
                    $list[] = sprintf('%d %s', $num, $this->translate($num == 1 ? $name[0] : $name[1]));
                    $passed -= $num * $period;
                    $exit++;
                } elseif ($exit > 0) {
                    $exit++;
                }
            }

            return $this->translate('%time_ago% ago', ['time_ago' => implode($separator, $list)]);
        }
    }

    /**
     * Returns the periods to names map. The names array defines singular and plural.
     *
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
     * Translates the given string.
     *
     * @param string $string The string to translate
     * @param array $vars The variables to replace
     * @return string Returns the translated string.
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
