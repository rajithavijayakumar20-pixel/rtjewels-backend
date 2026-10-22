<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['action']) && isset($data['id'])) {
    $id = $data['id'];
    $action = $data['action'];

    if ($action === 'delete') {
        // நீக்குவதற்கு (Delete)
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);
    } else {
        // ஸ்டேட்டஸ் மாற்ற (Approve / Reject)
        $status = $data['status'];
        $stmt = $conn->prepare("UPDATE reviews SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Operation successful."]);
    } else {
        echo json_encode(["success" => false, "message" => "Operation failed."]);
    }
    $stmt->close();
}

$conn->close();
?>