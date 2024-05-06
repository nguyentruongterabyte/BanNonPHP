<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: DELETE, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $maSanPham = $_DELETE['maSanPham'];

    // Sanitize maSanPham to prevent SQL injection
    $maSanPham = mysqli_real_escape_string($conn, $maSanPham);

    // SQL DELETE statement
    $query = "DELETE FROM sanpham WHERE maSanPham = '$maSanPham'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the deletion was successful
    if ($result) {
        // Deletion successful
        $response = [
            'status' => 200,
            'message' => 'Xóa dữ liệu thành công'
        ];
    } else {
        // Deletion failed
        $response = [
            'status' => 409,
            'message' => 'Sản phẩm đã có đơn mua, không thể xóa'
        ];
    }
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Only DELETE method is allowed for this endpoint"]);
}

?>
