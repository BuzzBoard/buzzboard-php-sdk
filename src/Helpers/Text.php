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

namespace BuzzBoard\Helpers;

/**
 * Class BuzzBoard\Helpers\Text
 * 
 * @package BuzzBoard
 * @author Mir Adnan
 */
class Text {

    /**
     * 
     * @param string $phone
     * @return string
     */
    public static function cleanPhoneNumber($phone = 0) {
        return preg_replace("/[^0-9]/", "", $phone);
    }

    /**
     * 
     * @param string $business
     * @return string
     */
    public static function cleanBusinessName($business = null) {
        return self::clean(trim(trim($business, ', '), '.'));
    }

    /**
     * 
     * @param string $text
     * @return string
     */
    public static function clean($text = []) {
        return trim(str_ireplace(['  '], [' '], $text));
    }

}
