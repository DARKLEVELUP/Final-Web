<?php
$servername = "localhost";
$username = "root"; // Change according to your settings
$password = "";
$dbname = "item_store";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch items from the database
$sql = "SELECT * FROM items ORDER BY date_bought DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Tracker</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="items.html">Item List</a></li>
            <li><a href="add_item.php">Add Item</a></li>
            <li><a href="delete_item.php">Delete Item</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Welcome to the Item Management System</h1>
        <p>ใช้หัวข้อตามด้านบนเพื่อจัดการรายการสินค้า.</p>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php $conn->close(); ?>