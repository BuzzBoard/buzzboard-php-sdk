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

use BuzzBoard\Exceptions\InvalidUrlException;

/**
 * Class BuzzBoard\Helpers\Url
 * 
 * @package BuzzBoard
 */
class Url {

    /**
     * 
     * @param string $host
     * @return string
     */
    public function clean($link = null, $lower = true) {
        if ($lower === true) {
            $link = strtolower($link);
        }
        return trim(str_ireplace([' '], [''], trim($link, '/')));
    }

    /**
     * 
     * @param string $url
     * @return string
     */
    public static function removeParams($url = null) {
        return Url::clean(strtok($url, '?'), false);
    }

    /**
     * 
     * @param string $url
     * @return string
     */
    public static function getParams($url = '') {
        $url = substr($url, strpos($url, '?') + 1);
        parse_str($url, $return);
        return $return;
    }

    /**
     * 
     * @param string $url
     * @return string
     */
    public function parse($url = null) {
        $urlParse = parse_url($url);
        if ($urlParse['scheme'] != '' && $urlParse['host'] != '')
            return $urlParse['scheme'] . '://' . $urlParse['host'];

        return trim(rtrim($url, '/'));
    }

    /**
     * 
     * @param type $url
     * @return type
     * @throws InvalidUrlException
     */
    public static function getHost($url = null) {
        if (!$url) {
            throw new InvalidUrlException();
        }

        $url = self::removeParams($url);

        if (stripos($url, 'http') === false) {
            $url = 'http://' . $url;
        }

        $domain = parse_url(preg_replace('/www\./', '', $url));

        if (!empty($domain["host"])) {
            $url = $domain["host"];
        } else {
            $url = $domain["path"];
        }

        if (preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $url, $matches)) {
            $url = $matches['domain'];
        }

        if (strpos($url, '%3') !== false) {
            $url = strtok($url, '%3');
        }

        if (strpos($url, '#') !== false) {
            $url = strtok($url, '#');
        }

        return self::clean($url);
    }

    /**
     * 
     * @param type $url
     * @return boolean
     * @throws \BuzzBoard\Exceptions\InvalidArgumentException
     */
    public static function isValid($url = null) {
        if (null === $url) {
            throw new \BuzzBoard\Exceptions\InvalidArgumentException();
        }

        $regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        if (preg_match($regex, $url)) {
            return true;
        }
        return false;
    }

}
