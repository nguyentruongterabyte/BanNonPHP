<?php
include '../../connect.php';

$sql = "SELECT `id`, `username`, `mobile`, `email` FROM user";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$rows = array();
while($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

header("Content-Type: application/json");
echo json_encode($rows);

mysqli_close($conn);
?>
