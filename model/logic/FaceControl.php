<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\util\session.php";

class FaceControl
{
    private static $faceControl;

    private function __construct(){}

    public static function getFaceControl()
    {
        if (self::$faceControl === null)
        {
            self::$faceControl = new self();
        }
        return self::$faceControl;
    }

    public function isAdmin()
    {
        return isset($_SESSION['logged_user'])
            && $_SESSION['logged_user'] == 'admin';
    }

    public function getOneOf($if_guest, $if_user, $if_admin=null)
    {
        if (!isset($_SESSION['logged_user']))
        {
            return $if_guest;
        }
        else if ($_SESSION['logged_user'] == 'admin')
        {
            return $if_admin;
        }
        else
        {
            return $if_user;
        }
    }
}