<?php 
include "../../connect.php";

$query = "SELECT * FROM `toado` ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
    // Now $row contains the last row of your table
  
  $response = [
    'status' => 200,
    'message' => 'Lấy tọa độ thành công',
    'result' => $row
  ];

} else {
    // No rows found or query failed
  $response = [
    'status' => 201,
    'message' => 'Không có tọa độ nào'
  ];
}
header('Content-Type: application/json');
echo json_encode($response);
?>