<?php
include 'db.php';

// Get input data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the username or email already exists
$query = "SELECT * FROM users WHERE username = ? OR email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Username or email already exists. Please try again.'); window.location.href='register.php';</script>";
} else {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param('sss', $username, $email, $hashed_password);

    if ($insert_stmt->execute()) {
        echo "<script>alert('Registration successful! Please log in.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Error during registration. Please try again.'); window.location.href='register.php';</script>";
    }
}
?>
