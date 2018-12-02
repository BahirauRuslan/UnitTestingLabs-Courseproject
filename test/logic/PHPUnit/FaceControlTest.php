<?php

require_once "D:\Workspace\UnitTesting\courseproject\model\logic\FaceControl.php";

class FaceControlTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        if (isset($_SESSION["logged_user"]))
        {
            unset($_SESSION["logged_user"]);
        }
    }

    public function testGetOneOfGuestFortyTwo()
    {
        $faceControl = FaceControl::getFaceControl();
        $expected = 42;
        $actual = $faceControl->getOneOf($expected, 1, 2);
        self::assertEquals($expected, $actual);
    }

    public function testGetOneOfUserTwentyOne()
    {
        $faceControl = FaceControl::getFaceControl();
        $_SESSION["logged_user"] = "username";
        $expected = 21;
        $actual = $faceControl->getOneOf(1, $expected, 2);
        self::assertEquals($expected, $actual);
    }

    public function testGetOneOfIsAdminFiftyFive()
    {
        $faceControl = FaceControl::getFaceControl();
        $_SESSION["logged_user"] = "admin";
        $expected = 55;
        $actual = $faceControl->getOneOf(0, 1, $expected);
        self::assertEquals($expected, $actual);
    }
}
