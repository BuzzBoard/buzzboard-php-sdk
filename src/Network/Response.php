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

use BuzzBoard\Profile;
use BuzzBoard\Exceptions\RequestFailedException;

/**
 * Class BuzzBoard\Network\Response
 * 
 * @package BuzzBoard
 */
class Response {

    /**
     * @const Http Success code
     */
    const SUCCESS_CODE = 200;

    /**
     *
     * @var type 
     */
    protected $response;

    /**
     * 
     * @param \GuzzleHttp\Client $response
     */
    public function __construct(\GuzzleHttp\Psr7\Response $response) {
        $this->response = $response;
    }

    /**
     * 
     * @return int
     */
    public function getStatusCode() {
        return (int) !empty($this->response) ? $this->response->code : 0;
    }

    /**
     * 
     * @return type
     * @throws RequestFailedException
     */
    public function getBody() {
        $body = (string) $this->response->getBody();
        $response = json_decode($body);

        $response->code = (int) $response->code;

        if (
                !in_array($response->code, [
                    self::SUCCESS_CODE,
                    Profile::PROFILE_CREATED_RESPONSE_CODE
                ])
        ) {
            throw new RequestFailedException(sprintf('%s', $response->message), E_USER_ERROR);
        }

        return $response;
    }

}
