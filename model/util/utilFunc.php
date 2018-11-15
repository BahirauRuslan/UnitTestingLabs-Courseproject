<?php

require_once "session.php";

function gotoPage($url)
{
    echo "<script>window.location = '$url'</script>";
}

function logout()
{
    unset($_SESSION["logged_user"]);
    gotoPage('http://localhost:63342/courseproject/index.php');
}
