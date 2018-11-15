<?php

$mysqli = new mysqli('localhost', 'mysql', 'mysql', 'e_shop');

if ($mysqli->connect_error) {
    die($mysqli->connect_errno);
}
