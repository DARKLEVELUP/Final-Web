<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Delete the item
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Reset the IDs
    $sql = "SET @count = 0";
    $conn->query($sql);
    $sql = "UPDATE items SET id = @count:= @count + 1";
    $conn->query($sql);
    $sql = "ALTER TABLE items AUTO_INCREMENT = 1";
    $conn->query($sql);

    $stmt->close();
    $conn->close();

    header("Location: items.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
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
        <h1>Delete Item</h1>
        <form id="deleteForm" method="POST" action="delete_item.php">
            <div class="form-group">
                <label for="id">Item ID:</label>
                <input type="number" id="id" name="id" required>
            </div>
            <button type="submit">Delete Item</button>
        </form>
    </div>
</body>
</html>