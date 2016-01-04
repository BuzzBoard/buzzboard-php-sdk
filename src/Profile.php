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

use BuzzBoard\Helpers\Text;
use BuzzBoard\Helpers\Url;
use BuzzBoard\Helpers\Time;

/**
 * Class BuzzBoard\Profile
 * 
 * @package BuzzBoard
 */
class Profile {

    /**
     *
     * @var object BuzzBoard\Client 
     */
    protected $client;

    /**
     *
     * @var int Profile Id
     */
    protected $id;
    protected $data = [];

//    /**
//     *
//     * @var string business name
//     */
//    public $business;
//
//    /**
//     *
//     * @var string website
//     */
//    public $website;
//
//    /**
//     *
//     * @var string phone
//     */
//    public $phone;
//
//    /**
//     *
//     * @var string street
//     */
//    public $street;
//
//    /**
//     *
//     * @var string city
//     */
//    public $city;
//
//    /**
//     *
//     * @var string state
//     */
//    public $state;
//
//    /**
//     *
//     * @var string zip
//     */
//    public $zip;
//
//    /**
//     *
//     * @var string country_code
//     */
//    public $country_code;
//
//    /**
//     *
//     * @var string 
//     */
//    public $username;

    /**
     * 
     * @param \BuzzBoard\Client $client
     */
    public function __construct(\BuzzBoard\Client $client) {
        $this->client = $client;
    }

    /**
     * 
     * @param int $id
     * @return array
     */
    public function get($id = 0) {

        $id = 0;
        self::load();

        return (int) $id;
    }

    /**
     * 
     * @param array $data
     * @return type
     */
    public function save(array $data = []) {

        if (!empty($data)) {
            self::load($data);
        }

        $id = null;
        if (self::validate()) {
            $response = Network\Http::request('listings/create', $this->data);
            $id = $response->id;
        }

        return $id;
    }

    /**
     * 
     * @param int $id
     * @return array
     */
    public function regenerate($id = 0) {
        $this->id = $id;
        return true;
    }

    /**
     * 
     * @param array $data
     */
    protected function load(array $data = []) {
        $this->business = Text::cleanBusinessName($data['business']);
        $this->website = Url::getHost($data['website']);
        $this->phone = Text::cleanPhoneNumber($data['phone']);
        $this->street = !empty($data['address']) ? Text::clean($data['address']) : Text::clean($data['street']);
        $this->city = Text::clean($data['city']);
        $this->state = Text::clean($data['state']);
        $this->zip = Text::clean($data['zip']);
        $this->country_code = Text::clean($data['country_code']);
        $this->username = Text::clean($data['username']);

        # validate
        return self::validate();
    }

    /**
     * @method validate 
     * @use validates Profile fields
     */
    protected function validate() {
        if (
                !$this->business ||
                !$this->phone ||
                !$this->street ||
                !$this->city ||
                !$this->state ||
                !$this->zip ||
                !$this->country_code ||
                !$this->username ||
                // website url validation
                (!empty($this->website) && Url::isValid($this->website) === false)
        ) {
            throw new Exceptions\ProfileValidationFailed();
        }
        return true;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return void
     */
    public function __set($name, $value) {
        $this->data[(string) $name] = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[(string) $name];
        } else {
            return null;
        }
    }

}
