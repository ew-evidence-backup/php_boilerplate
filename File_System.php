<?php
/**
 * @author Evin Weissenberg
 */
class File_System {

    private $path;
    private $url;

    /**
     * @param $path
     * @return File_System
     */
    function setPath($path) {

        $this->path = (string)$path;
        return $this;

    }

    /**
     * @param $path
     * @return bool
     */
    function deleteFolderRecursive($path) {
        if (is_dir($path)) {
            if (version_compare(PHP_VERSION, '5.0.0') < 0) {
                $entries = array();
                if ($handle = opendir($path)) {
                    while (false !== ($file = readdir($handle))) $entries[] = $file;
                    closedir($handle);
                }
            } else {
                $entries = scandir($path);
                if ($entries === false) $entries = array();
            }

            foreach ($entries as $entry) {
                if ($entry != '.' && $entry != '..') {
                    deleteFolderRecursive($path . '/' . $entry);
                }
            }

            return rmdir($path);
        } else {
            return unlink($path);
        }
    }

    /**
     * @param $url
     * @return File_System
     */
    function setUrl($url) {

        $this->url = (string)$url;
        return $this;


    }

    /**
     * @param $url
     * @param $save_file
     * @return int
     */
    function curlImageDownload($url, $save_file) {

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_REFERER, $url); // need to fake a referer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "curl_cookie");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "curl_cookie");
        $tmp = curl_exec($ch);
        if (curl_errno($ch) == 0) {
            file_put_contents($this->path, $tmp);
        }
        curl_close($ch);

        return curl_errno($ch);
    }

    /**
     * @param $src
     * @param $dst
     */
    function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
