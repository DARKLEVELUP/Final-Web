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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$itemsPerPage = isset($_GET['itemsPerPage']) ? (int)$_GET['itemsPerPage'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$sql = "SELECT * FROM items WHERE name LIKE '%$search%' LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($sql);

$items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

// Get total number of items for pagination
$sqlTotal = "SELECT COUNT(*) as total FROM items WHERE name LIKE '%$search%'";
$resultTotal = $conn->query($sqlTotal);
$totalItems = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

$conn->close();

header('Content-Type: application/json');

echo json_encode(['items' => $items, 'totalPages' => $totalPages]);
exit();
?>