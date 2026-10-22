<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$sql = "SELECT * FROM gold_rates ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["gold_22k" => "7,500", "gold_18k" => "6,200", "silver_rate" => "88"]);
}

$conn->close();
?>