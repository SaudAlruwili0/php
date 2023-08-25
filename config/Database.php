<?php

$connection = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'database' => 'aps',
];
$mysqli = new mysqli($connection['host'], $connection['user'], $connection['password'], $connection['database']);

if ($mysqli->connect_error) {
    die("error connecting to database" . $mysqli->connect_error);
} else {
    // $mysqli->close();
}