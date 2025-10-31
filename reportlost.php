<?php
session_start();
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $name = $_POST['item_name'];
    $desc = $_POST['description'];
    $cat = $_POST['category'];
    $loc = $_POST['location'];
    $uid = $_SESSION['user_id'];

    $query = "INSERT INTO items (item_name, description, category, location, status, date_reported, reporter_id)
              VALUES ('$name', '$desc', '$cat', '$loc', 'lost', NOW(), '$uid')";
    mysqli_query($conn, $query);
    echo "<script>alert('Lost item reported successfully');</script>";
}
?>
<form method="POST">
    <h2>Report Lost Item</h2>
    <input type="text" name="item_name" placeholder="Item Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="text" name="category" placeholder="Category" required><br>
    <input type="text" name="location" placeholder="Last Seen Location" required><br>
    <button name="submit">Submit</button>
</form>
