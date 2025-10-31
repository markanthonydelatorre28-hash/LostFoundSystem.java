<?php

session_start();

// Simulated database arrays
$users = [
    ['user_id' => 1, 'name' => 'Admin', 'email' => 'admin@mail.com', 'password' => password_hash('1234', PASSWORD_DEFAULT), 'role' => 'admin'],
];
$items = [];

// Simple routing simulation
$action = $_GET['action'] ?? 'home';

function headerLine() {
    echo "<hr><a href='?action=home'>🏠 Home</a> | 
          <a href='?action=register'>📝 Register</a> | 
          <a href='?action=login'>🔐 Login</a> | 
          <a href='?action=report'>📦 Report Item</a> | 
          <a href='?action=view'>👀 View Items</a><hr>";
}

echo "<h2>Lost & Found Item Management (Demo)</h2>";
headerLine();

// SESSION USER
if (isset($_SESSION['user'])) {
    echo "Logged in as: <b>" . $_SESSION['user']['name'] . "</b> (" . $_SESSION['user']['role'] . ")<br>";
}

// ========== HOME ==========
if ($action == 'home') {
    echo "<p>Welcome to the Lost & Found Item Management demo. Use the links above to test each function.</p>";
}

// ========== REGISTER ==========
if ($action == 'register') {
    if (isset($_POST['register'])) {
        global $users;
        $newUser = [
            'user_id' => count($users) + 1,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => 'user'
        ];
        $users[] = $newUser;
        echo "<p style='color:green'>Registration successful! You can now login.</p>";
    }
    ?>
    <form method="POST">
        <h3>Register</h3>
        <input name="name" placeholder="Full Name" required><br>
        <input name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="register">Register</button>
    </form>
    <?php
}

// ========== LOGIN ==========
if ($action == 'login') {
    global $users;
    if (isset($_POST['login'])) {
        foreach ($users as $user) {
            if ($user['email'] == $_POST['email'] && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                echo "<p style='color:green'>Login successful!</p>";
                break;
            }
        }
        if (!isset($_SESSION['user'])) {
            echo "<p style='color:red'>Invalid credentials!</p>";
        }
    }
    ?>
    <form method="POST">
        <h3>Login</h3>
        <input name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="login">Login</button>
    </form>
    <?php
}

// ========== REPORT LOST ITEM ==========
if ($action == 'report') {
    if (!isset($_SESSION['user'])) {
        echo "<p style='color:red'>Please login first!</p>";
    } else {
        if (isset($_POST['submit'])) {
            global $items;
            $newItem = [
                'item_id' => count($items) + 1,
                'item_name' => $_POST['item_name'],
                'category' => $_POST['category'],
                'status' => $_POST['status'],
                'location' => $_POST['location'],
                'reporter' => $_SESSION['user']['name'],
                'date' => date('Y-m-d')
            ];
            $items[] = $newItem;
            echo "<p style='color:green'>Item reported successfully!</p>";
        }
        ?>
        <form method="POST">
            <h3>Report Lost/Found Item</h3>
            <input name="item_name" placeholder="Item Name" required><br>
            <input name="category" placeholder="Category" required><br>
            <input name="location" placeholder="Location" required><br>
            <select name="status">
                <option value="lost">Lost</option>
                <option value="found">Found</option>
            </select><br>
            <button name="submit">Submit</button>
        </form>
        <?php
    }
}

// ========== VIEW ITEMS ==========
if ($action == 'view') {
    global $items;
    echo "<h3>Reported Items</h3>";
    if (empty($items)) {
        echo "<p>No items reported yet.</p>";
    } else {
        echo "<table border='1' cellpadding='5'>
              <tr><th>ID</th><th>Name</th><th>Category</th><th>Status</th><th>Location</th><th>Reporter</th><th>Date</th></tr>";
        foreach ($items as $i) {
            echo "<tr>
                    <td>{$i['item_id']}</td>
                    <td>{$i['item_name']}</td>
                    <td>{$i['category']}</td>
                    <td>{$i['status']}</td>
                    <td>{$i['location']}</td>
                    <td>{$i['reporter']}</td>
                    <td>{$i['date']}</td>
                  </tr>";
        }
        echo "</table>";
    }
}
?>
