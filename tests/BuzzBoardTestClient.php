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

namespace BuzzBoard\Tests;

use BuzzBoard\Client;

/**
 * Description of BuzzBoardTestClient
 *
 * @author Mir Adnan
 */
class BuzzBoardTestClient extends \PHPUnit_Framework_TestCase {

    public $client;

    public function __construct() {

        $this->client = new Client(TEST_API_KEY);
    }

    /**
     * @test checks object serialization
     */
    public function testSerialization() {
        $serialized = unserialize(serialize($this->client));

        $this->assertInstanceOf('BuzzBoard\Client', $serialized);
    }

    /**
     * @test checks object serialization
     */
    public function testSetKey() {
        $this->client = new Client();
        $this->client->setKey(TEST_API_KEY);
        $key = $this->client->getKey();

        $this->assertNotEmpty($key);
    }

    /**
     * @test checks object serialization
     */
    public function testGetKey() {
        $key = $this->client->getKey();

        $this->assertNotEmpty($key);
    }

}
