<?php

/**
 * Copyright 2015 BuzzBoard, Inc.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

namespace BuzzBoard\Helpers;

use BuzzBoard\Exceptions\InvalidArgumentException;

/**
 * Class BuzzBoard\Helpers\Time
 * 
 * @package BuzzBoard
 */
class Time {

    /**
     * Returns time ago in words.
     * @param int $time
     * @return string
     */
    public static function getTimeAgoInWords($time = null) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        if (null === $time) {
            throw new InvalidArgumentException();
        }

        $now = time();

        $difference = $now - $time;
        $tense = "ago";

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] 'ago' ";
    }

    /**
     * Checks whether currently is daytime
     * @param float $latitude
     * @param float $longitude
     * @static
     * @return bool
     */
    public static function getIsDaytime($latitude, $longitude) {
        $time = time();
        $sunrise = strtotime('today ' . static::getSunriseTime($latitude, $longitude));
        $sunset = strtotime('today ' . static::getSunsetTime($latitude, $longitude));
        if ($time >= $sunrise && $time <= $sunset) {
            return true;
        }
        return false;
    }

    /**
     * Returns sunrise time
     * @param float $latitude
     * @param float $longitude
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @param null|int $gmtOffset If not set, current GMT offset will be used.
     * @static
     * @return string
     */
    public static function getSunriseTime($latitude, $longitude, $timestamp = null, $gmtOffset = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        if ($gmtOffset === null) {
            $gmtOffset = self::getGmtOffset();
        }
        return date_sunrise($timestamp, SUNFUNCS_RET_STRING, $latitude, $longitude, ini_get('date.sunrise_zenith'), $gmtOffset);
    }

    /**
     * Returns sunset time
     * @param float $latitude
     * @param float $longitude
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @param null|int $gmtOffset If not set, current GMT offset will be used.
     * @static
     * @return string
     */
    public static function getSunsetTime($latitude, $longitude, $timestamp = null, $gmtOffset = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        if ($gmtOffset === null) {
            $gmtOffset = self::getGmtOffset();
        }
        return date_sunset($timestamp, SUNFUNCS_RET_STRING, $latitude, $longitude, ini_get('date.sunrise_zenith'), $gmtOffset);
    }

    /**
     * Calculates and returns current GMT offset
     * @return int
     */
    public static function getGmtOffset() {
        $gmtOffset = date('Z') / 60 / 60;
        $gmtOffset = round($gmtOffset);
        return $gmtOffset;
    }

    /**
     * Calculates daytime duration
     * @param float $latitude
     * @param float $longitude
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @static
     * @return int
     */
    public static function getDaytimeDuration($latitude, $longitude, $timestamp = null) {
        $startTime = strtotime('today ' . self::getSunriseTime($latitude, $longitude, $timestamp));
        $endTime = strtotime('today ' . self::getSunsetTime($latitude, $longitude, $timestamp));
        return $endTime - $startTime;
    }

    /**
     * Converts seconds to human readable format (H:i:s) string.
     * @param int $seconds
     * @param bool $hideSeconds
     * @static
     * @return string
     */
    public static function getHmsFromSeconds($seconds, $hideSeconds = false) {
        $hours = intval(intval($seconds) / 3600);
        $hm = $hours;
        $minutes = intval(($seconds / 60) % 60);
        $hm .= ':' . str_pad($minutes, 2, "0", STR_PAD_LEFT);
        if (!$hideSeconds) {
            $seconds = intval($seconds % 60);
            $hm .= ':' . str_pad($seconds, 2, "0", STR_PAD_LEFT);
        }
        return $hm;
    }

    /**
     * Returns ISO8601 full datetime
     * E.g.: 2014-12-14T09:31:12+00:00
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @static
     * @return string
     */
    public static function getIso8601Date($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return date("c", $timestamp);
    }

    /**
     * Returns RFC 2822 formatted date.
     * Usually used in RSS feeds.
     * E.g.: Sun, 14 Dec 2014 09:39:45 +0000
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @static
     * @return string
     */
    public static function getRfc2822Date($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return date('r', $timestamp);
    }

    /**
     * Converts timestamp to numeric date (YYYYMMDD)
     * E.g.: 20141214
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @static
     * @return int
     */
    public static function getNumericDate($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return (int) date('Ymd', $timestamp);
    }

    /**
     * Converts timestamp to numeric month (YYYYMM)
     * E.g.: 201412
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @static
     * @return int
     */
    public static function getNumericMonth($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return (int) date('Ym', $timestamp);
    }

    /**
     * Return datetime.
     * Uses same format as mysql.
     * E.g.: 2014-12-14 09:46:01
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @return string
     */
    public static function getTime($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return date("Y-m-d H:i:s", $timestamp);
    }

    /**
     * Return current date
     * @param null|int $timestamp If not set, current timestamp will be used.
     * @return string
     */
    public static function getDate($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        return date("Y-m-d", $timestamp);
    }

    /**
     * Return formatted week number.
     * We use ISO-8601 standard, weeks starting on Monday.
     * E.g.: 2014-W52
     * @return string
     */
    public static function getWeek() {
        return date('o-\\WW');
    }

    /**
     * Return time difference between two timestamps with microseconds.
     * @param float $start
     * @param null|float $end If not set, current microtime will be used.
     * @return float Returns difference in seconds
     */
    public static function difference($start, $end = null) {
        if ($end === null) {
            $end = microtime(true);
        }
        $totalTime = ($end - $start);
        return $totalTime;
    }

    /**
     * Checks is given timestamp is today.
     * @param int $timestamp
     * @return boolean
     */
    public static function isToday($timestamp) {
        return date('Y-m-d', $timestamp) == date('Y-m-d');
    }

    /**
     * Checks is given timestamp is yesterday.
     * @param int $timestamp
     * @return boolean
     */
    public static function isYesterday($timestamp) {
        return date('Y-m-d', $timestamp) == date('Y-m-d', strtotime('yesterday'));
    }

    /**
     * Checks is given timestamp is in this week
     * We use ISO-8601 standard, weeks starting on Monday.
     * @param int $timestamp
     * @return boolean True if date is in this week
     */
    public static function isThisWeek($timestamp) {
        return date('o-\\WW', $timestamp) == date('o-\\WW');
    }

    /**
     * Checks is given timestamp is in this month
     * @param int $timestamp
     * @return boolean True if date is in this month
     */
    public static function isThisMonth($date) {
        return date('m Y', $date) == date('m Y', time());
    }

    /**
     * Checks is given timestamp is in this year
     * @param int $timestamp
     * @return boolean True if date is in this year
     */
    public static function isThisYear($timestamp) {
        return date('Y', $timestamp) == date('Y', time());
    }

}
