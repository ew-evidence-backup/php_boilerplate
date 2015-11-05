<?php

require_once 'Random_File_Name.php';


/**
 * @author Evin Weissenberg
 */

//PHP INI
//    * session.gc_maxlifetime
//    * max_input_time
//    * max_execution_time
//    * upload_max_filesize
//    * post_max_size

//In .htaccess:
//-----------------------------------------------------------
//php_value session.gc_maxlifetime 10800
//php_value max_input_time         10800
//php_value max_execution_time     10800
//php_value upload_max_filesize    110M
//php_value post_max_size          120M
//    -----------------------------------------------------------
//    <Directory /var/www/MyProgram>
//    AllowOverride Options
//    </Directory>

class Upload_file {

    private $folder = 'uploads/'; //must contain trailing slash
    private $field_name = 'upload_file';
    private $upload_size_limit = 350000;
    private $saved_file_name;

    function setFolder($folder) {

        $this->folder = (string)$folder;
        return $this;

    }

    function setFieldName($field_name) {

        $this->field_name = (string)$field_name;
        return $this;

    }

    function upload_single_file(Random_File_Name_Generator $r) {


        print_r($_FILES);

        if ($_FILES[$this->field_name]['size'] > $this->upload_size_limit) {

            echo 'File size is larger than ' . $this->displayFileSize($_FILES[$this->field_name]['size']);

            return false;

        } elseif ($_FILES[$this->field_name]['type'] == 'text/php') {


            echo 'Can\'t upload ' . $_FILES[$this->field_name]['type'] . ' type';

            return false;

        }

        //Strip string noise
        $clean = str_replace('_', '', $_FILES[$this->field_name]['name']);
        $clean = str_replace('-', '', $clean);
        $clean = str_replace(' ', '', $clean);
        $clean = str_replace('@', '', $clean);


        //new name
        $this->saved_file_name = $r->generate() . strtolower($clean);

        $target = $this->folder . basename($this->saved_file_name);


        if (move_uploaded_file($_FILES[$this->field_name]['tmp_name'], $target)) {

            return true;

        } else {

            echo 'Failed';

            return false;
        }
    }

    function getSavedFileName() {

        return $this->saved_file_name;

    }

    function displayFileSize($file_size) {

        if (is_numeric($file_size)) {
            $dec = 1024;
            $step = 0;
            $prefix = array('Byte', 'KB', 'MB', 'GB', 'TB', 'PB');

            while (($file_size / $dec) > 0.9) {
                $file_size = $file_size / $dec;
                $step++;
            }
            return round($file_size, 2) . ' ' . $prefix[$step];
        } else {

            return 'NaN';
        }

    }

}

//Usage
//$obj = new Upload_file();
//$obj->setFolder('uploads/')->setFieldName('upload_file')->upload_single_file(new Random_File_Name_Generator());

?>

<!--<form enctype="multipart/form-data" action="Upload_File.php" method="POST">-->
<!--    Please choose a file: <input name="upload_file" type="file"/><br/>-->
<!--    <input type="submit" value="Upload"/>-->
<!--</form>-->