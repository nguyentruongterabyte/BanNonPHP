<?php 
 
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, OPTIONS"); // Allow the GET, POST, and OPTIONS methods
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); // Allow the specified headers
include "../../connect.php";
require('C:\Users\Administrator\vendor\autoload.php');
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$serviceAccountPath = '../../serviceAccountKey.json';
// tạo một factory 
$factory = (new Factory)
	-> withServiceAccount($serviceAccountPath);
	// Tạo một storage firebase từ factory 
	$storage = $factory -> createStorage();
	$storageBucket = $storage -> getBucket();


$targetDir = "../../images/product/";

// Save the download URL to your database
$maSanPham = isset($_POST['maSanPham']) ? $_POST['maSanPham'] : -1;


// Xóa hình ảnh cũ trong firebase
if ($maSanPham != -1) {
	$query = "SELECT hinhAnh FROM `sanpham` WHERE `maSanPham` = $maSanPham";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	if ($row) {
		// Lấy đường dẫn hình ảnh thật từ db
		$publicUrl = $row['hinhAnh'];

		// tách path thành object gồm
		//"scheme":"https",
	  //"host":"...",
		//"path":"\/v0\/b\/hatshop-75393.appspot.com\/o\/663857bbe4a8e.jpg"
		//"query":"..."}
		$urlParts = parse_url($publicUrl);
		
		// Lấy phần tử path trong urlParts
		$pathParts = explode('/', $urlParts['path']);
		
		// Lấy phần cuối của đường link 
		$objectName = urldecode(end($pathParts));

		$object = $storageBucket -> object($objectName);

		// Kiểm tra ảnh có tồn tại trên fire base không
		// Nếu có thì thực hiện xóa khỏi fire base 
		if ($object -> exists()) {
			$object -> delete();
		}
	}
	
}

// Tải hình ảnh mới lên file base
if (isset($_FILES['file'])) {
		// Tạo ra một tên duy nhất cho file để upload lên firebase
    $filename = uniqid() . '.jpg';

		$object = $storageBucket -> upload(
			file_get_contents($_FILES["file"]["tmp_name"]), 
			[
				'name' => $filename
			]
		);

		// Lấy đường link của hình ảnh
		$downloadUrl = $object -> signedUrl(new \Datetime('+10 years'));
		$response = [
			'status' => 200,
			'message' => "Thành công",
			'result' => $downloadUrl 
		];
		
} else {
    $response = [
        'status' => 400,
        'message' => "Chưa có file"
    ];
}

// Send JSON response
header("Content-Type: application/json");
echo json_encode($response);

?>