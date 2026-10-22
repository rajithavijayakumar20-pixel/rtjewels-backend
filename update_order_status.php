<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['id']) && !empty($data['status'])) {
    $id = $data['id'];
    $status = $data['status'];

    $stmt = $conn->prepare("UPDATE custom_orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Status updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update status."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid parameters."]);
}

$conn->close();
?>