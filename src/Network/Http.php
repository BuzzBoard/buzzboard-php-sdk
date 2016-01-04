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

namespace BuzzBoard\Network;

use GuzzleHttp\Client AS HttpClient;
use GuzzleHttp\Psr7\Request;
use BuzzBoard\Client;
use BuzzBoard\Exceptions\InvalidArgumentException;

/**
 * 
 * Class BuzzBoard\Network\Http
 * 
 * @package BuzzBoard
 * 
 * @author Mir Adnan
 */
class Http {

    /**
     *
     * @var string
     */
    protected static $url;

    /**
     *
     * @var array 
     */
    protected static $options = [
        'cookies' => false
    ];

    /**
     * 
     * @param type $path
     * @param array $params
     * @return array response
     */
    public static function get($path = null, array $params = []) {
        self::builUrl($path, $params);
        $client = static::getClient()->request('GET', static::getUrl());
        return json_decode((string) $client->getBody(), true);
    }

    /**
     * 
     * @param type $path
     * @param array $headers
     * @return array response
     */
    public static function post($path = null, array $headers = []) {
        self::builUrl($path);
        $client = (new HttpClient(static::$options))->request('POST', static::getUrl(), $headers = []);
        return json_decode((string) $client->getBody(), true);
    }

    /**
     * 
     * @return GuzzleHttp Object
     */
    protected static function getClient() {
        return (new HttpClient(static::$options));
    }

    /**
     * 
     * @param type $url
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function builUrl($url = null, array $params = []) {
        if (null === $url) {
            throw new InvalidArgumentException();
        }

        return static::$url = 'https://' . Client::ENDPOINT . '/' . Client::VERSION . '/' . $url . '?=' . http_build_query($params);
    }

    /**
     * 
     * @return string
     */
    public static function getUrl() {
        return static::$url;
    }

}
