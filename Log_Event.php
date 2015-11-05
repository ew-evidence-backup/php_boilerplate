<?php

/**
 * @author Evin Weissenberg
 */
class Log_Event {

    private $event_message;
    private $file_path;
    private $exception_message = 'Log_Event failed.';
    private $time_zone;
    private $utf8;
    private $pointer;

    const CHARSET = 'default_charset';
    const ENCODING = 'UTF-8';

    function __constructor() {

        $this->utf8 = ini_set(self::CHARSET, self::ENCODING);

    }

    function setEventMessage($event_message) {

        $this->event_message = (string)$event_message;
        return $this;

    }

    function setFilePath($file_path) {

        $this->file_path = (string)$file_path;
        return $this;

    }

    function setFailedMessage($failed_message) {

        $this->exception_message = (string)$failed_message;
        return $this;

    }

    function setTimeZone($time_zone) {

        $this->time_zone = (string)$time_zone;
        return $this;

    }

    function __get($property) {

        return $this->$property;

    }

    function logEvent() {

        $my_file = $this->file_path;
        $this->pointer = fopen($my_file, 'a') or die($this->exception_message);
        $string_data = "$this->event_message," . date('m/d/y,h:m:s,a,') . $this->time_zone . "\n";
        fwrite($this->pointer, $string_data);

        return true;

    }

    public function __destructor() {

        fclose($this->pointer);
        unset($this->utf8);

    }
}
//$l = new Log_Event();
//$l->setEventMessage('Logging')->setFilePath('file.csv')->setFailedMessage('failed')->setTimeZone('PST')->logEvent();

