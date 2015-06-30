<?php
/**
 * Created by PhpStorm.
 * User: sanmadjack
 * Date: 6/28/2015
 * Time: 12:34 PM
 */

class Auth {
    public static $SESSION_USER_ID = "USER_ID";

    public static function authenticate() {
        $auth = new RedditAuth();
        $auth->authenticate();
    }

    public static function processAuth() {
        $auth = new RedditAuth();
        $auth->processAuthResponse();
    }

    public static function checkIfAuthenticated() {
        return isset($_SESSION[self::$SESSION_USER_ID]);
    }

    public static function getCurrentUser() {
        if(self::checkIfAuthenticated()) {
            $query = new UserQuery();
            $user = $query->findPk($_SESSION[self::$SESSION_USER_ID]);
            return $user;
        } else {
            return null;
        }
    }

}