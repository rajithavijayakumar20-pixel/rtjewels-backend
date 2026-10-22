<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$title = $_POST['title'] ?? '';
$main_category = $_POST['main_category'] ?? 'Gold';
$sub_category = $_POST['sub_category'] ?? 'Necklace';
$purity = $_POST['purity'] ?? '22K Gold (916)';
$price = $_POST['price'] ?? '';
$image_path = '';
// ஃபைல் அப்லோட் கையாளும் பகுதி
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = $_FILES['image']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // ஃபைல் பெயர் திரும்ப வராமல் இருக்க Unique Name உருவாக்குதல்
    $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);
    $uploadFileDir = './uploads/';
    $dest_path = $uploadFileDir . $newFileName;

    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true);
    }

    if (move_uploaded_file($fileTmpPath, $dest_path)) {
        $image_path = 'http://localhost/jewellery/back-end/uploads/' . $newFileName;
    }
}

if (!empty($title) && !empty($price)) {
    $stmt = $conn->prepare("INSERT INTO products (title, main_category, sub_category, purity, price, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $main_category, $sub_category, $purity, $price, $image_path);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product added successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add product."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid data."]);
}

$conn->close();
?>