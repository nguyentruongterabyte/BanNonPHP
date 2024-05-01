<?php
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
            'success' => true,
            'message' => 'Data deleted successfully'
        ];
    } else {
        // Deletion failed
        $response = [
            'success' => false,
            'message' => 'Failed to delete data'
        ];
    }
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Only DELETE method is allowed for this endpoint"]);
}

?>
