<?php

/*
 * Buzzboard PHP Class
 * @version 1.0
 */

class Buzzboard {

    const VERSION = '1.0';

    public static $endpoint = 'http://api.buzzboard.com/';

    /*
     * @protected $apiKey
     * Provided by Buzzboard
     */
    protected static $__apiKey = null;

    /*
     * @public $responseType
     * Buzzboard API v1.0 supports json and xml response types.
     * Default is set to json. However, you can change to xml as per your need.
     */
    public static $format = 'xml';

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

    /*
     * @method setAuth
     * @param string $apiKey
     * @return void
     */

    public static function setKey($apiKey = null) {
        if ($apiKey !== null) {
            self::$__apiKey = $apiKey;
            return;
        }
        trigger_error("Buzzboard::setAuth(); [Missing param API Key]", E_USER_ERROR);
    }

    /*
     * @method audit
     * @access public
     * @param string $listingID [Buzzboard listing id]
     * @return object response
     */

    public static function audit($listingID = null) {
        if ($listingID !== null) {
            return self::__request(__FUNCTION__, array('listing_id' => $listingID));
        } else {
            trigger_error("Buzzboard::audit(); [Missing param listing_id]", E_USER_ERROR);
        }
        return false;
    }

    /*
     * @method create
     * @access public
     * @param array $listing [listing details]
     * @return object response
     */

    public static function create($listing = array()) {
        /*
         * @var mandatoryParams [If not provided, api response will return error code.]
         */
        $mandatoryParams = array('business', 'address', 'city', 'state', 'zip', 'phone', 'username');

        # validating mandatory params
        foreach ($mandatoryParams AS $param):
            if (!isset($listing[$param]) || $listing[$param] == '') {
                trigger_error("Buzzboard::create(): [Missing parameter '$param'] %s", E_USER_WARNING);
                return false;
            }
        endforeach;

        return self::__request(__FUNCTION__, $listing, 'POST');
    }

    /*
     * @method create
     * @access public
     * @param string $listing [listing details]
     * @return object response
     */

    public static function regenerate($id = null) {
        if ($id !== null) {
            return self::__request(__FUNCTION__, array('id' => $id), 'POST');
        } else {
            trigger_error('Invalid ID provided in ' . __CLASS__ . '::' . __FUNCTION__ . '.', E_USER_ERROR);
        }
    }

    /*
     * @method __request
     * @access protected
     * @param string $action = action requested
     * @param array $postParam = post fields
     * @param string $method = HTTP request method
     */

    protected static function __request($action, $params = array(), $method = 'POST') {
        if (self::$__apiKey === null) {
            trigger_error('Invalid API key provided.', E_USER_ERROR);
            return;
        }
        $params['apikey'] = self::$__apiKey;
        $fields = array();
        foreach ($params as $key => $value)
            $fields[] = $key . '=' . urlencode($value);
        $paramsString = implode('&', $fields);
        # open connection
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT, 'Buzzboard/API');
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, self::$endpoint . 'v' . self::VERSION . '/listings/' . $action . '.' . self::$format);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $paramsString);

        $response['body'] = curl_exec($curl);
        if ($response['body'])
            $response['http_code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        else
            $response['error'] = array(
                'code' => curl_errno($curl),
                'message' => curl_error($curl),
            );

        # close connection
        @curl_close($curl);

        if (!empty($response['error'])) {
            return $response['error'];
        }
        return $response['body'];
    }

}
