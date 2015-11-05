<?php
/**
 * @author Evin Weissenberg
 */
class Write_File {

    private $file_path;
    private $string;
    private $failed_message;
    private $utf8;
    private $file_pointer;

    const CHARSET = 'default_charset';
    const ENCODING = 'UTF-8';

    /**
     *
     */
    function __constructor() {

        $this->utf8 = ini_set(self::CHARSET, self::ENCODING);

    }

    /**
     * @param $file_path
     * @return Write_File
     */
    function setFile($file_path) {

        $this->file_path = (string)$file_path;
        return $this;

    }

    /**
     * @param $string
     * @return Write_File
     */
    function setString($string) {

        $this->string = (string)$string;
        return $this;

    }

    /**
     * @param $failed_message
     * @return Write_File
     */
    function setFailedMessage($failed_message) {

        $this->failed_message = (string)$failed_message;
        return $this;

    }

    /**
     * @param $property
     * @return mixed
     */
    function _get($property) {

        return $this->$property;

    }

    /**
     * @return bool
     */
    function write() {

        $this->file_pointer = fopen($this->file_path, 'w') or die($this->failed_message);
        fwrite($this->file_pointer, $this->string);
        return true;

    }

    function __destruct() {

        fclose($this->file_pointer);
        unset($this->file_path);
        unset($this->string);
        unset($this->failed_message);
        unset($this->utf8);

    }
}
//$w = new Write_File();
//$w->setFile('./file.csv')
//    ->setString('This is what I want to write')
//    ->setFailedMessage('Failed')
//    ->write();