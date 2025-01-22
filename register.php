<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Encrypt password
    $name = $_POST['name'];

    // Validate input
    if (empty($username) || empty($email) || empty($password) || empty($name)) {
        echo "<script>alert('All fields are required. Please fill out the form completely.');window.location.href='register.php';</script>";
        exit;
    }

    // Insert user into the database
    $query = "INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $username, $password, $name, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.');window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Username or email already exists.');window.location.href='register.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Handmade Crafts</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <header>
        <h1>Register for Handmade Crafts</h1>
        <p>Create an account to explore beautiful crafts.</p>
    </header>
    <div class="register-container">
        <form action="register.php" method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
