<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'db.php';

$product_id = $_GET['id'];

// Get user ID
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt_user = $conn->prepare($user_query);
$stmt_user->bind_param("s", $_SESSION['username']);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$user_id = $user['id'];

// Add product to cart
$query_add = "INSERT INTO cart (user_id, product_id, price) SELECT ?, ?, price FROM products WHERE product_id = ?";
$stmt_add = $conn->prepare($query_add);
$stmt_add->bind_param("iii", $user_id, $product_id, $product_id);

if ($stmt_add->execute()) {
    echo "<script>alert('Product added to cart!');window.location.href='user_dashboard.php';</script>";
} else {
    echo "<script>alert('Failed to add product to cart.');window.location.href='user_dashboard.php';</script>";
}
?>
