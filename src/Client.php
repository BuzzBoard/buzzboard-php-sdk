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

namespace BuzzBoard;

/**
 * Class Controller
 * 
 * @package BuzzBoard
 */
class Client {

    /**
     * const API Version
     */
    const VERSION = '1.0';

    /**
     * const API Host URL
     */
    const ENDPOINT = 'http://api.buzzboard.com';

    /*
     * @protected $apiKey
     * Provided by BuzzBoard
     */

    protected $__apiKey = null;

    /**
     * Constructor, used if you're not calling the class statically
     *
     * @param string $apiKey API KEY
     * @return void
     */
    public function __construct($apiKey = null) {
        if ($apiKey !== null)
            self::setKey($apiKey);
    }

    /**
     * 
     * @param type $apiKey
     * @return \BuzzBoard\Client
     * @throws Exceptions\InvalidArgumentException
     */
    public function setKey($apiKey = null) {
        if (null === $apiKey) {
            throw new Exceptions\InvalidArgumentException();
        }

        $this->__apiKey = $apiKey;

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getKey() {
        return $this->__apiKey;
    }

    /**
     * 
     * @param type $timezone
     * @return \BuzzBoard\Client
     * @throws Exceptions\InvalidArgumentException
     */
    public function setTimezone($timezone = null) {
        if (null === $timezone) {
            throw new Exceptions\InvalidArgumentException();
        }
        return $this;
    }

}
