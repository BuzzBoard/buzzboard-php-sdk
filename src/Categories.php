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

use BuzzBoard\Network\Http;

/**
 * Description of BuzzBoard\Categories
 *
 * @package BuzzBoard SDK
 * 
 * @author Mir Adnan
 */
class Categories {

    /**
     * PATH
     */
    const PATH = '/categories';

    /**
     *
     * @var type 
     */
    protected $data;

    /**
     * 
     * @param \BuzzBoard\Client $client
     */
    public function __construct(\BuzzBoard\Client $client) {
        # Set API Key
        $this->data['apikey'] = $client->getKey();
    }

    /**
     * @return array
     */
    public function all() {

        $request = Http::get(self::PATH, $this->data);

        return $request->getBody();
    }

}
