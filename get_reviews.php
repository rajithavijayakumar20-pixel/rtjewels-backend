<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db.php';

$sql = "SELECT * FROM reviews ORDER BY id DESC";
$result = $conn->query($sql);

$reviews = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

echo json_encode($reviews);
$conn->close();
?>
