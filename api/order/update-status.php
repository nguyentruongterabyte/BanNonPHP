<?php
include "../../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
// Get the maDonHang and trangThai values from the request
    $maDonHang = $_PUT['maDonHang'];
    $trangThai = $_PUT['trangThai'];

    // Ensure data safety before executing the query
    $maDonHang = mysqli_real_escape_string($conn, $maDonHang);
    $trangThai = mysqli_real_escape_string($conn, $trangThai);

    // Create the SQL UPDATE query
    $query = "UPDATE donhang SET trangThai = '$trangThai' WHERE maDonHang = '$maDonHang'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Query executed successfully
        $response = [
            'status' => 200,
            'message' => 'Cập nhật trạng thái đơn hàng thành công'
        ];
    } else {
        // Query failed
        $response = [
            'status' => 400,
            'message' => 'Cập nhật trạng thái đon hàng thất bại'
        ];
    }

} else {
    $response = [
        'status' => 405,
        'message' => 'Invalid request method'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);

?>