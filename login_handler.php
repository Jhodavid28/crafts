<?php
session_start();
include 'db.php'; // Database connection

$username = $_POST['username'];
$password = md5($_POST['password']); // MD5 encrypt password
$role = $_POST['role'];

// SQL queries based on role
if ($role === 'admin') {
    $query = "SELECT * FROM admins WHERE admin_name = ? AND password = ?";
} else {
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
}

// Prepare and execute the statement
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Successful login
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

    if ($role === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
} else {
    // Failed login
    echo "<script>alert('Invalid login credentials. Please try again.');window.location.href='login.php';</script>";
}
?>
