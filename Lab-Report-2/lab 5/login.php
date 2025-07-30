<?php
// FILE: login.php
require_once 'db_connection.php';
$message = '';

// Check if user is already logged in, if so, redirect to dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = "Username and password are required.";
    } else {
        // Prepare a select statement
        $stmt = $conn->prepare("SELECT id, username, password FROM accounts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Check if username exists
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $hashed_password);
            if ($stmt->fetch()) {
                // Verify password
                if (password_verify($password, $hashed_password)) {
                    // Password is correct, so start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;
                    
                    // Redirect user to dashboard page
                    header("location: dashboard.php");
                    exit();
                } else {
                    $message = "The password you entered was not valid.";
                }
            }
        } else {
            $message = "No account found with that username.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login to Your Account</h1>
        <?php 
        if (!empty($message)) {
            echo '<div class="message error">' . $message . '</div>';
        }
        if (isset($_GET['status']) && $_GET['status'] == 'reg_success') {
            echo '<div class="message success">Registration successful! Please login.</div>';
        }
        ?>
        <form action="login.php" method="post" novalidate>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p style="text-align:center; margin-top:20px;">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>
</body>
</html>