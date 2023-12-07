<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$host = "localhost";
$db_user = "root";
$db_pass = null;
$db_name = "e-commerce_db";

$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("" . $mysqli->connect_error);
} else {
    echo 'HELLOOO MOSHAAAAAA';
}