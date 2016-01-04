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
use BuzzBoard\Network\Http;
use BuzzBoard\Exceptions\InvalidArgumentException;

/**
 * Class BuzzBoard\Profile
 * 
 * @package BuzzBoard
 */
class Profile {

    const PROFILE_CREATED_RESPONSE_CODE = 1019;

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

    /**
     *
     * @var array 
     */
    protected $data = [];

    /**
     * 
     * @param \BuzzBoard\Client $client
     */
    public function __construct(\BuzzBoard\Client $client) {
        $this->client = $client;
        # Set API Key
        $this->data['apikey'] = $client->getKey();
    }

    /**
     * 
     * @param int $id
     * @return array
     */
    public function get($id = 0) {

        if (!$id) {
            throw new InvalidArgumentException();
        }

        $this->data['id'] = $id;

        $request = Http::get('listings/audit', $this->data);
        $response = $request->getBody();

        return $response->listing;
    }

    /**
     * 
     * @param array $data
     * @return listing Id
     */
    public function save(array $data = []) {

        if (!empty($data) && self::load($data)) {
            $request = Http::post('listings/create', $this->data);
            $response = $request->getBody();
            return $response->listing->id;
        }
    }

    /**
     * 
     * @param int $id
     * @return boolean
     */
    public function regenerate($id = 0) {

        if (!$id) {
            throw new InvalidArgumentException();
        }

        $this->data['id'] = $id;

        $request = Http::get('listings/' . __FUNCTION__, $this->data);
        $response = $request->getBody();

        return $response->code == Network\Response::SUCCESS_CODE ? true : false;
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
                !$this->address ||
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
