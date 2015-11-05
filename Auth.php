<?php

/**
 * @author Evin Weissenberg
 */
class Auth {

    private $user_id;
    private $username;
    private $password;
    private $email;
    private $permission; // 1=read, 2={read,edit}, 3={read,edit,delete}
    private $type;
    private $user_object = array();
    private $user_object_json = array();
    private $redirect_url;
    private $check_box;
    private $post_field;

    function __construct() {

    }

    /**
     * @param $user_id
     * @return Auth
     */
    function setUserId($user_id) {
        $this->user_id = (string)$user_id;
        return $this;
    }

    /**
     * @param $user_object
     * @return Auth
     */
    function setUserObject($user_object) {
        $this->user_object = $user_object;
        return $this;
    }

    /**
     * @param $user_object_json
     * @return Auth
     */
    function setUserObjectJson($user_object_json) {
        $this->user_object_json = $user_object_json;
        return $this;
    }

    /**
     * @param $redirect_url
     * @return Auth
     */
    function setRedirectUrl($redirect_url) {
        $this->redirect_url = $redirect_url;
        return $this;
    }

    /**
     * @param $username
     * @return Auth
     */
    function setUser($username) {
        $this->username = (string)$username;
        return $this;
    }

    /**
     * @param $password
     * @return Auth
     */
    function setPassword($password) {
        $this->password = (string)$password;
        return $this;
    }

    /**
     * @param $email
     * @return Auth
     */
    function setEmail($email) {
        $this->email = (string)$email;
        return $this;
    }

    /**
     * @param $permission
     * @return Auth
     */
    function setPermission($permission) {
        $this->permission = (string)$permission;
        return $this;
    }

    /**
     * @param $type
     * @return Auth
     */
    function setType($type) {
        $this->type = (string)$type;
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
    function loginSession() {

        session_start();
        $_SESSION['user_object'] = $this->user_object;
        $_SESSION['user_object_json'] = json_encode($this->user_object_json);
        $_SESSION['time'] = time();

        //set_cookie("user_id", $this->user_id, time() + 3600);

        return true;

    }

    /**
     *
     */
    function redirect() {

        flush();
        header('Location: ' . $this->redirect_url);
        exit();

    }

    /**
     * @return bool
     */
    function logout() {

        //session_start(); <-- add to logout page
        session_destroy();
        return true;

    }

    /**
     * @param $session_token
     * @return bool
     */
    function authenticatePage($session_token) {

        if (!isset($_SESSION[$session_token]) || empty($_SESSION[$session_token])) {

            return false;

        } else {

            return true;

        }

    }

    /**
     * @param Insert $i
     * @param Validation $v
     * @return bool
     */
    function register(Insert $i, Validation $v) {

        $i->setTable('')->setKey('')->setValue('')->insert();

        return true;

    }

    /**
     * @param Query $q
     * @param $user_id
     */
    function deleteUser(Query $q, $user_id) {

        $q->setQuery('Delete user')->run();

    }

    /**
     * @param $checkbox
     * @return Auth
     */
    function setCheckBox($checkbox) {

        $this->check_box = (array)$checkbox;

        return $this;

    }

}