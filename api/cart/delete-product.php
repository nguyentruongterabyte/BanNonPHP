<?php 
include "../../connect.php";

// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse the request body to get the parameters
    parse_str(file_get_contents("php://input"), $_DELETE);
    $maSanPham = $_DELETE['maSanPham'];
    $userId = $_DELETE['userId'];

    // Sanitize the input data
    $maSanPham = mysqli_real_escape_string($conn, $maSanPham);
    $userId = mysqli_real_escape_string($conn, $userId);

    // Create the DELETE query
    $query = "DELETE FROM `giohang` WHERE `userId` = $userId AND `maSanPham` = $maSanPham";

    // Execute the query
    $data = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($data) {
        // Handle success response
        $response['success'] = true;
        $response['message'] = "Thành công";
    } else {
        // Handle failure response
        $response['success'] = false;
        $response['message'] = "Không thể thực hiện được truy vấn";
    }

    // Send JSON response
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // If the request method is not DELETE, return an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Only DELETE method is allowed for this endpoint"]);
}
?>