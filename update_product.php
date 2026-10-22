<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$id = $_POST['id'] ?? '';
$title = $_POST['title'] ?? '';
$main_category = $_POST['main_category'] ?? 'Gold';
$sub_category = $_POST['sub_category'] ?? 'Necklace';
$purity = $_POST['purity'] ?? '22K Gold (916)';
$price = $_POST['price'] ?? '';

if (!empty($id) && !empty($title) && !empty($price)) {
    // Puthiya image upload panniyirundhal mattum image path-ai maatruvadhu
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $image_path = 'http://localhost/jewellery/back-end/uploads/' . $newFileName;
            $stmt = $conn->prepare("UPDATE products SET title=?, main_category=?, sub_category=?, purity=?, price=?, image=? WHERE id=?");
            $stmt->bind_param("ssssssi", $title, $main_category, $sub_category, $purity, $price, $image_path, $id);
        }
    } else {
        // Image maattapadavillai endral pazhaya image-aye vaithu kollenisuvadhu
        $stmt = $conn->prepare("UPDATE products SET title=?, main_category=?, sub_category=?, purity=?, price=? WHERE id=?");
        $stmt->bind_param("sssssi", $title, $main_category, $sub_category, $purity, $price, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Product updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update product."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid parameters."]);
}

$conn->close();
?>