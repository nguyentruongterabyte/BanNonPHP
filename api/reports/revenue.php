<?php 
include "../../connect.php";
if (isset($_GET["year"])) {
  $year = $_GET["year"];

  $year = mysqli_real_escape_string($conn, $year);

  $query = "SELECT months.thang, COALESCE(SUM(dh.tongTien), 0) AS tong\n"
    . "FROM (\n"
    . "    SELECT 1 AS thang UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION\n"
    . "    SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12\n"
    . ") AS months\n"
    . "LEFT JOIN donhang AS dh ON months.thang = MONTH(dh.ngayTao) AND YEAR(dh.ngayTao) = $year\n"
    . "GROUP BY months.thang\n"
    . "ORDER BY months.thang;";

  $data = mysqli_query($conn, $query);
  $result = array();

  while ($row = mysqli_fetch_assoc($data)) {
    $result[] = $row;
  }

  if (!empty($result)) {
    $response = [
      'status' => 200, 
      'message' => 'Lấy báo cáo thành công',
      'result' => $result
    ];
  } else {
    $response = [
      'status' => 201,
      'message' => 'Không có dữ liệu'
    ];
  }
  header("Content-Type: application/json");
  echo json_encode($response);
} else {
  http_response_code(400); // Bad Request
  echo json_encode(["message" => "year parameter is required"]);
}
?>