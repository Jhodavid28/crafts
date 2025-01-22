<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'db.php';

$artist_id = $_GET['artist_id'];

// Fetch artist details
$query_artist = "SELECT * FROM artists WHERE artist_id = ?";
$stmt_artist = $conn->prepare($query_artist);
$stmt_artist->bind_param("i", $artist_id);
$stmt_artist->execute();
$result_artist = $stmt_artist->get_result();
$artist = $result_artist->fetch_assoc();

// Fetch products by the artist
$query_products = "SELECT * FROM products WHERE artist_id = ?";
$stmt_products = $conn->prepare($query_products);
$stmt_products->bind_param("i", $artist_id);
$stmt_products->execute();
$result_products = $stmt_products->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $artist['name']; ?>'s Products</title>
    <link rel="stylesheet" href="assets/css/artist_products.css">
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
        <h1>Products by <?php echo $artist['name']; ?></h1>
        <div class="product-grid">
            <?php while ($product = $result_products->fetch_assoc()): ?>
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
