<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['client_name']) && !empty($data['client_phone'])) {
    $order_id = "RT-" . date("Y") . "-" . sprintf("%03d", rand(1, 999));
    $client_name = $data['client_name'];
    $client_phone = $data['client_phone'];
    $design_title = $data['design_title'] ?? 'Custom Jewelry';
    $budget = $data['budget'] ?? 'As per requirement';
    $order_date = date("M d, Y");
    $status = 'Pending Approval';
    $notes = $data['notes'] ?? 'None';

    $stmt = $conn->prepare("INSERT INTO custom_orders (order_id, client_name, client_phone, design_title, budget, order_date, status, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $order_id, $client_name, $client_phone, $design_title, $budget, $order_date, $status, $notes);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Custom order submitted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit order."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Required fields missing."]);
}

$conn->close();
?>