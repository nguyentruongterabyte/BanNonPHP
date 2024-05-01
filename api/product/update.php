<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    // Retrieve data from POST request
    $maSanPham = $_PUT['maSanPham'];
    $tenSanPham = $_PUT['tenSanPham'];
    $soLuong = $_PUT['soLuong'];
    $gioiTinh = $_PUT['gioiTinh'];
    $mauSac = $_PUT['mauSac'];
    $hinhAnh = $_PUT['hinhAnh'];
    $giaSanPham = $_PUT['giaSanPham'];

    // Sanitize data to prevent SQL injection
    $tenSanPham = mysqli_real_escape_string($conn, $tenSanPham);
    $soLuong = mysqli_real_escape_string($conn, $soLuong);
    $gioiTinh = mysqli_real_escape_string($conn, $gioiTinh);
    $mauSac = mysqli_real_escape_string($conn, $mauSac);
    $hinhAnh = mysqli_real_escape_string($conn, $hinhAnh);
    $giaSanPham = mysqli_real_escape_string($conn, $giaSanPham);

    // SQL UPDATE statement
    $query = "UPDATE sanpham 
            SET tenSanPham = '$tenSanPham', 
                soLuong = '$soLuong', 
                gioiTinh = '$gioiTinh', 
                mauSac = '$mauSac', 
                hinhAnh = '$hinhAnh', 
                giaSanPham = '$giaSanPham' 
            WHERE maSanPham = '$maSanPham'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the update was successful
    if ($result) {
        // Update successful
        $response = [
            'success' => true,
            'message' => 'Data updated successfully'
        ];
    } else {
        // Update failed
        $response = [
            'success' => false,
            'message' => 'Failed to update data'
        ];
    }

} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
