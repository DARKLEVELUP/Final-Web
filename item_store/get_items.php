<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "item_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM items";
$result = $conn->query($sql);

$items = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($items);
?>