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
     * @const MAX connection timeout
     */
    const MAX_TIMEOUT = 10;

    /**
     *
     * @var string
     */
    protected static $url;

    /**
     *
     * @var int
     */
    public static $requestCount = 0;

    /**
     *
     * @var array 
     */
    protected static $options = [
        'cookies' => false,
        'verify' => true,
        'connect_timeout' => 3,
        'timeout' => Http::MAX_TIMEOUT,
        'debug' => false,
        'decode_content' => 'gzip',
        'http_errors' => false,
        'allow_redirects' => [
            'protocols' => ['http', 'https'],
        ]
    ];

    /**
     * 
     * @param string $path
     * @param array $params
     * @return array response
     */
    public static function get($path = null, array $params = []) {
        self::builUrl($path, $params);
        $client = static::getClient()->request('GET', static::getUrl());
        static::$requestCount++;
        return new Response($client);
    }

    /**
     * 
     * @param string $path
     * @param array $headers
     * @return array response
     */
    public static function post($path = null, array $headers = []) {
        self::builUrl($path, $headers);
        static::$requestCount++;
        $client = (new HttpClient(static::$options))->request('POST', static::getUrl(), $headers = []);
        return new Response($client);
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
     * @return string
     */
    public static function getUrl() {
        return static::$url;
    }

    /**
     * 
     * @param string $url
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function builUrl($url = null, array $params = []) {
        if (null === $url) {
            throw new InvalidArgumentException();
        }

        if (!empty($params)) {
            $query = '?' . http_build_query($params);
        } else {
            $query = '';
        }

        if (strpos($url, '/') === 0) {
            $endpoint = Client::ENDPOINT . $url;
        } else {
            $endpoint = Client::ENDPOINT . '/v' . Client::VERSION . '/' . $url;
        }

        return static::$url = $endpoint . '.json' . $query;
    }

}
