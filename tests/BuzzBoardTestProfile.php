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
use BuzzBoard\Profile;

/**
 * Description of BuzzBoardTestClient
 *
 * @package BuzzBoard SDK
 * 
 * @author Mir Adnan
 */
class BuzzBoardTestProfile extends \PHPUnit_Framework_TestCase {

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
        $profile = new Profile($this->client);
        $profile->business = 'The business name'; // required
        $profile->website = 'http://thebusinessname.com'; // optional
        $profile->phone = '0249341760'; // required
        $profile->address = 'street address'; // required
        $profile->city = 'city'; // required
        $profile->state = 'state'; // required
        $profile->zip = '50001'; // required
        // ISO 3166-1 country code (http://en.wikipedia.org/wiki/ISO_3166-1)
        $profile->country_code = 'us';

        // Account Manager (under which this listing should be listed on BuzzBoard)
        $profile->username = 'qasalesrep1@vsplash.net'; // required
        // Contact Person
        $profile->contact_name = 'John Doe'; // optional - contact persons name
        $profile->contact_email = 'john@example.com'; // optional - contact persons email address
        $profile->contact_phone = '132-456-7891'; // optional - contact persons phone number

        $id = $profile->save();

        $this->assertNotEmpty($id);
    }

    /**
     * @test Check if profile is created with valid params
     */
    public function testProfileDetails() {
        $profile = new Profile($this->client);
        $id = TEST_PROFILE_ID;

        $details = $profile->get($id);

        $this->assertNotEmpty($details->id);
        $this->assertNotEmpty($details->name);
    }

    /**
     * @test Check if profile is created with valid params
     */
    public function testProfileRegenerate() {
        $profile = new Profile($this->client);
        $id = TEST_PROFILE_ID;

        $isRegenerated = $profile->regenerate($id);

        $this->assertTrue($isRegenerated);
    }

}
