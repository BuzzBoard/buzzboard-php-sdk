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
use BuzzBoard\Categories;

/**
 * Description of BuzzBoardTestClient
 *
 * @package BuzzBoard SDK
 * 
 * @author Mir Adnan
 */
class BuzzBoardTestCategories extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @var type 
     */
    protected $client;

    /**
     * 
     */
    public function __construct() {
        $this->client = new Client(TEST_API_KEY);
    }

    /**
     * @test Check if profile is created with valid params
     */
    public function testProfileCreate() {
        $categories = (new Categories($this->client))
                ->all();

        $this->assertNotEmpty($categories);
    }

}
