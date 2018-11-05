<?php

require_once "connectDB.php";

function gotoPage($url)
{
    echo "<script>window.location = '$url'</script>";
}

function logout()
{
    unset($_SESSION["logged_user"]);
    gotoPage('http://localhost:63342/courseProject/index.php');
}
