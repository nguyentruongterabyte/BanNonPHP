<?php
$host = "localhost";
$user = "root";
$pass = "123";
$database = "databannon";

$conn = mysqli_connect($host, $user, $pass, $database);

mysqli_set_charset($conn, "utf8");

?>