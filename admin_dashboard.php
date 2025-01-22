<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all artists
$query_artists = "SELECT * FROM artists";
$result_artists = $conn->query($query_artists);

// Fetch all products
$query_products = "SELECT p.*, a.name AS artist_name FROM products p JOIN artists a ON p.artist_id = a.artist_id";
$result_products = $conn->query($query_products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
</head>
<body>
    <header>
        <h1>Welcome, Admin <?php echo $_SESSION['username']; ?>!</h1>
        <p>Manage artists and their products.</p>
    </header>
    <div class="admin-content">
        <h2>Artists</h2>
        <div class="admin-grid">
            <?php while ($artist = $result_artists->fetch_assoc()): ?>
                <div class="admin-card">
                    <h3><?php echo $artist['name']; ?></h3>
                    <p><?php echo $artist['products']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <h2>Products</h2>
        <div class="admin-grid">
            <?php while ($product = $result_products->fetch_assoc()): ?>
                <div class="admin-card">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>₹<?php echo number_format($product['price'], 2); ?></p>
                    <p>Created by: <?php echo $product['artist_name']; ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
