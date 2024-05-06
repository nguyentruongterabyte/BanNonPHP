<?php
$host = "localhost";
$user = "root";
$pass = "123";
$database = "databannon";

$conn = mysqli_connect($host, $user, $pass, $database);
$BASE_URL = 'http://192.168.1.18/';

mysqli_set_charset($conn, "utf8");

?>