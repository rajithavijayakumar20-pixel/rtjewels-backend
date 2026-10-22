<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data['gold_22k']) && !empty($data['gold_18k']) && !empty($data['silver_rate'])) {
    $gold_22k = $data['gold_22k'];
    $gold_18k = $data['gold_18k'];
    $silver_rate = $data['silver_rate'];

    // ஏற்கனவே உள்ளதைக் আপডেট செய்ய (Single Row Table)
    $sql = "UPDATE gold_rates SET gold_22k = '$gold_22k', gold_18k = '$gold_18k', silver_rate = '$silver_rate' WHERE id = 1";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Gold rates updated successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating rates: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
}

$conn->close();
?>