<?php

/**
 * @author Evin Weissenberg
 */
class CURL {

    private $url;
    private $params;

    /**
     * @param $url
     * @return CURL
     */
    function setUrl($url) {

        $this->url = (string)$url;

        return $this;

    }

    /**
     * @param $params
     * @return CURL
     */
    function setParams($params) {

        $this->params = $params;

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
     * @return mixed
     */
    function post() {

        $url = $this->url;
        $params = $this->params;

        $user_agent = "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * @return mixed
     */
    function get() {

        $url = $this->url;

        $user_agent = "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}