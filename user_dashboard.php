<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all products
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/css/user_dashboard.css">
</head>
<body>
    <div class="side-menu">
        <h2>Handmade Crafts</h2>
        <ul>
            <li><a href="user_dashboard.php">Home</a></li>
            <li><a href="artist.php">Artists</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Explore our curated selection of handmade crafts.</p>
        <div class="product-grid">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?php echo $product['picture_path']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>₹<?php echo number_format($product['price'], 2); ?></p>
                    <button onclick="location.href='product_details.php?id=<?php echo $product['product_id']; ?>'">View Product</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
