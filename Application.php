<?php

/**
 * Class Application Container
 */
class Application_Container {

    const SITE_TITLE = '';
    const AUTHOR = 'Evin Weissenberg';
    const ADDRESS = '';
    const PRODUCTION = 'domain.com';
    const STAGING = 's.domain.com';
    const DEVELOPMENT = 'd.domain.com';
    const TIME_ZONE = 'America/Los_Angeles';
    const IMAGES_FOLDER = '/images/';
    const VIDEO_FOLDER = '/video/';
    const CSS_FOLDER = '/css/';
    const JAVASCRIPT_FOLDER = '/js/';
    const LOGO = 'logo.png';
    const MAX_UPLOAD = '5242880'; // 5mb
    const JQUERY = 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js';

    //PRODUCTION
    public static $db_host_production = '';
    public static $db_username_production = '';
    public static $db_password_production = '';
    public static $db_name_production = '';
    public static $db_port_production = '3306';

    //STAGING
    public static $db_host_staging = '';
    public static $db_username_staging = '';
    public static $db_password_staging = '';
    public static $db_name_staging = '';
    public static $db_port_staging = '3306';

    //DEVELOPMENT
    public static $db_host_development = '';
    public static $db_username_development = '';
    public static $db_password_development = '';
    public static $db_name_development = '';
    public static $db_port_development = '3306';

    //ACTIVE CONNECTION (this detects what is the current connection.)
    public $db_host_active;
    public $db_username_active;
    public $db_password_active;
    public $db_database_name_active;
    public $db_port_active;
    public static $connection;
    
    function __construct() {

        ob_start();
        session_start();
        ini_set('default_charset', 'UTF-8');
        date_default_timezone_set(self::TIME_ZONE);
        ini_set('auto_detect_line_endings', TRUE);
        ini_set('memory_limit', '16M');

        if (!ini_get('safe_mode')) {
            set_time_limit(25);
        }

        define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT']);
        define('IMAGES', DOC_ROOT . self::IMAGES_FOLDER);
        define('JAVASCRIPT', DOC_ROOT . self::JAVASCRIPT_FOLDER);
        define('CSS', DOC_ROOT . self::CSS_FOLDER);

        if ($_SERVER['HTTP_HOST'] == self::PRODUCTION) {

            error_reporting(0);

            //Database Connection
            $db = new mysqli(self::$db_host_production, self::$db_username_production, self::$db_password_production, self::$db_name_production);

            if ($db->connect_errno) {
                printf("Connection failed: %s\n", $db->connect_error);
                exit();
            }

            //Set Production Active
            $this->db_host_active = self::$db_host_production;
            $this->db_username_active = self::$db_username_production;
            $this->db_password_active = self::$db_password_production;
            $this->db_port_active = self::$db_port_production;
            $this->db_database_name_active = self::$db_name_production;

            self::$connection = $db;

        } elseif ($_SERVER['HTTP_HOST'] == self::STAGING) {

            ini_set('display_errors', TRUE);
            error_reporting(E_PARSE);

            //Database Connection
            $db = new mysqli(self::$db_host_staging, self::$db_username_staging, self::$db_password_staging, self::$db_name_staging);

            if ($db->connect_errno) {
                printf("Connection failed: %s\n", $db->connect_error);
                exit();
            }

            //Set Staging Active
            $this->db_host_active = self::$db_host_staging;
            $this->db_username_active = self::$db_username_staging;
            $this->db_password_active = self::$db_password_staging;
            $this->db_port_active = self::$db_port_staging;
            $this->db_database_name_active = self::$db_name_staging;

            self::$connection = $db;

        } elseif ($_SERVER['HTTP_HOST'] == self::DEVELOPMENT) {

            ini_set('display_errors', TRUE);
            error_reporting(E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);

            //Database Connection
            $db = new mysqli(self::$db_host_development, self::$db_username_development, self::$db_password_development, self::$db_name_development);

            if ($db->connect_errno) {
                printf("Connection failed: %s\n", $db->connect_error);
                exit();
            }

            //Set Development Active
            $this->db_host_active = self::$db_host_development;
            $this->db_username_active = self::$db_username_development;
            $this->db_password_active = self::$db_password_development;
            $this->db_port_active = self::$db_port_development;
            $this->db_database_name_active = self::$db_name_development;

            self::$connection = $db;

        } else {

            error_reporting(0);
        }

    }
    
    public static function developmentEnvironment() {

        if ($_SERVER['HTTP_HOST'] == self::DEVELOPMENT || $_SERVER['HTTP_HOST'] == self::STAGING) {

            error_reporting(E_ALL | E_WARNING | E_NOTICE);

            echo "<style type='text/css'> .debug {font-size: 12px; background-color: black; color: white; font-family: arial, Helvetica,sans-serif;  padding: 10px;} </style>";

            echo "<div style='background-color: red; color: white; font-weight: bolder; padding: 10px;'>DEVELOPMENT / STAGING ENVIRONMENT</div>";
            ini_set("display_errors", 1);
            echo "<div class='debug'> Author: Evin Weissenberg 2011 - " . date('Y') . ". http://www.evinw.com</div>";
            echo "<div class='debug'>PHP Version: " . PHP_VERSION . "</div>";
            echo "<div class='debug'>Request URI: " . $_SERVER['REQUEST_URI'] . "</div>";
            echo "<div class='debug'>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</div>";
            echo "<div class='debug'>Server IP: " . $_SERVER['SERVER_ADDR'] . "</div>";
            echo "<div class='debug'>My IP: " . $_SERVER['REMOTE_ADDR'] . "</div>";
            echo "<div class='debug'>Request Method: : " . $_SERVER['REQUEST_METHOD'] . "</div>";
            echo "<div class='debug'>Query String: " . $_SERVER['QUERY_STRING'] . "</div>";
            echo "<div class='debug'>Local Port: " . $_SERVER['REMOTE_PORT'] . "</div>";
            echo "<div class='debug'>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</div>";
            echo "<div class='debug'>Contents of the Connection: " . $_SERVER['HTTP_CONNECTION'] . "</div>";
            echo "<div class='debug'>Server Time Zone: " . date_default_timezone_get() . "</div>";

            print('<pre>');
            print_r($_REQUEST);
            print('</pre>');

            return TRUE;

        } else {
            //self::productionEnvironment();
        }
        return true;
    }
}