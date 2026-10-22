<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['name']) && !empty($data['review'])) {
    $name = $data['name'];
    $role = !empty($data['role']) ? $data['role'] : 'Verified Client';
    $review = $data['review'];
    $rating = !empty($data['rating']) ? $data['rating'] : 5;
    $status = 'Pending'; // புதிய ரிவ்யூ அட்மின் ஒப்புதலுக்காக Pending-ல் இருக்கும்

    $stmt = $conn->prepare("INSERT INTO reviews (name, role, review, rating, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $role, $review, $rating, $status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Review submitted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to save review."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data."]);
}

$conn->close();
?>
