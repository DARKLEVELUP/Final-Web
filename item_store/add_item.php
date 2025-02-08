<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "item_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $date_bought = $_POST['date_bought'];
    $check_date = $_POST['check_date'];
    $warranty_years = $_POST['warranty_years'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "INSERT INTO items (name, date_bought, check_date, warranty_years, expiry_date)
            VALUES ('$name', '$date_bought', '$check_date', $warranty_years, '$expiry_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New item added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("Location: items.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
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
        <h1>Add Item</h1>
        <form id="addForm" method="POST" action="add_item.php">
            <div class="form-group">
                <label for="name">Item Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="date_bought">Date Bought:</label>
                <input type="date" id="date_bought" name="date_bought" required>
            </div>
            <div class="form-group">
                <label for="check_date">Check Date:</label>
                <input type="date" id="check_date" name="check_date" required>
            </div>
            <div class="form-group">
                <label for="warranty_years">Warranty (Years):</label>
                <input type="number" id="warranty_years" name="warranty_years" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" >
            </div>
            <button type="submit">Add Item</button>
        </form>
    </div>
</body>
</html>