<?php

/**
 * @author Evin Weissenberg
 */
class Validation {

    private $email;
    private $string;
    private $post_field;
    private $string_length_max; //Length of characters max (int)
    private $string_length_min; //Length of characters min (int)
    private $ip;
    private $zip_code;
    private $phone_number;

    /**
     * @param $email
     * @return Validation
     */
    function setEmail($email) {

        $this->email = (string)$email;
        return $this;

    }

    /**
     * @param $string
     * @return Validation
     */
    function setString($string) {

        $this->string = (string)$string;
        return $this;


    }

    /**
     * @param $string_length_max
     * @return Validation
     */
    function setStringLengthMax($string_length_max) {

        $this->string_length_max = (int)$string_length_max;
        return $this;
    }

    /**
     * @param $string_length_min
     * @return Validation
     */
    function setStringLengthMin($string_length_min) {

        $this->string_length_min = (int)$string_length_min;
        return $this;
    }

    /**
     * @return bool
     */
    function validateEmail() {

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $post_field
     * @return Validation
     */
    function setPostField($post_field) {

        $this->post_field = $post_field;
        return $this;

    }

    /**
     * @param $property
     * @return mixed
     */
    function __get($property) {

        return $this->$property;

    }

    /**
     * @return bool
     */
    function postFieldValidateIfNull() {
        /*
        |---------------------------
        | Check if POST field is null
        |---------------------------
        */

        if ($this->post_field == '') {

            return false;

        } else {

            return true;

        }
    }

    function validateStringLength() {
        /*
        |---------------------------
        | Checks if string is greater than or less than specified range.
        |---------------------------
        */
        $str = strlen($this->string);


        if ($str > $this->string_length_max || $str < $this->string_length_min) {

            return false;

        } else {

            return true;
        }
    }

    /**
     * @param $ip
     * @return Validation
     */
    function setIPAddress($ip) {

        $this->ip = (string)$ip;
        return $this;

    }

    /**
     * @return bool
     */
    function validateIPAddress() {

        $string = $this->ip;

        if (preg_match(
            '/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $string)
        ) {
            return true;

        } else {

            return false;

        }
    }

    /**
     * @param $zip_code
     * @return Validation
     */
    function setZipCode($zip_code) {

        $this->zip_code = (string)$zip_code;
        return $this;

    }

    /**
     * @return bool
     */
    function validateZipCode() {

        //US Based zip codes like... 12345-1234
        $string = $this->zip_code;
        if (preg_match('/^[0-9]{5}([- ]?[0-9]{4})?$/', $string)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @return bool
     */
    function validateEmailRegex() {

        $string = $this->email;
        if (preg_match(
            '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
            $string)
        ) {
            return true;
        } else {

            return false;

        }

    }

    function setPhoneNumber() {


    }

    function validatePhoneNumber() {


        //US based numbers like (232) 555-5555
        $string = $this->phone_number;
        if (preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $string)) {

            return true;

        } else {

            return false;

        }

    }

    function removeAccents($s) {

        $s = ereg_replace("[áàâãª]", "a", $s);
        $s = ereg_replace("[ÁÀÂÃ]", "A", $s);
        $s = ereg_replace("[ÍÌÎ]", "I", $s);
        $s = ereg_replace("[íìî]", "i", $s);
        $s = ereg_replace("[éèê]", "e", $s);
        $s = ereg_replace("[ÉÈÊ]", "E", $s);
        $s = ereg_replace("[óòôõº]", "o", $s);
        $s = ereg_replace("[ÓÒÔÕ]", "O", $s);
        $s = ereg_replace("[úùû]", "u", $s);
        $s = ereg_replace("[ÚÙÛ]", "U", $s);
        $s = str_replace("ç", "c", $s);
        $s = str_replace("Ç", "C", $s);
        $s = str_replace("[ñ]", "n", $s);
        $s = str_replace("[Ñ]", "N", $s);

        return $s;
    }
}