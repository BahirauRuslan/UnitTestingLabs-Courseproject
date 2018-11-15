<?php

require_once "utilFunc.php";
require_once "D:\Workspace\UnitTesting\courseproject\model\logic\FaceControl.php";

if (!FaceControl::getFaceControl()->isAdmin())
{
    gotoPage('http://localhost:63342/courseproject/index.php');
}
