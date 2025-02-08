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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date_bought = $_POST['date_bought'];
    $check_date = $_POST['check_date'];
    $warranty_years = $_POST['warranty_years'];
    $expiry_date = $_POST['expiry_date'];

    // Update the item in the database
    $sql = "UPDATE items 
            SET name='$name', date_bought='$date_bought', check_date='$check_date', 
                warranty_years=$warranty_years, expiry_date='$expiry_date' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Item updated successfully";
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
    <title>Update Item</title>
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
        <h1>Update Item</h1>
        <form id="updateForm" method="POST" action="update_item.php">
            <input type="hidden" id="id" name="id">
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
            <button type="submit">Update Item</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            const name = urlParams.get('name');
            const date_bought = urlParams.get('date_bought');
            const check_date = urlParams.get('check_date');
            const warranty_years = urlParams.get('warranty_years');
            const expiry_date = urlParams.get('expiry_date');

            if (id && name && date_bought && check_date && warranty_years && expiry_date) {
                document.getElementById('id').value = id;
                document.getElementById('name').value = decodeURIComponent(name);
                document.getElementById('date_bought').value = date_bought;
                document.getElementById('check_date').value = check_date;
                document.getElementById('warranty_years').value = warranty_years;
                document.getElementById('expiry_date').value = expiry_date;
            } else {
                console.error('Missing data in URL parameters. Please ensure all necessary data is passed.');
            }
        });
    </script>
</body>
</html>