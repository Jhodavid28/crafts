<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
include 'db.php';

$artist_id = $_GET['artist_id'];

$artist_query = "SELECT * FROM artists WHERE id = ?";
$stmt = $conn->prepare($artist_query);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$artist_result = $stmt->get_result();
$artist = $artist_result->fetch_assoc();

$product_query = "SELECT * FROM products WHERE artist_id = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$product_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $artist['name']; ?> - Details</title>
    <link rel="stylesheet" href="assets/css/artist_details.css">
</head>
<body>
    <div class="side-menu">
        <h2>Handmade Crafts</h2>
        <ul>
            <li><a href="artist.php">Back to Artists</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="artist-box">
            <img src="<?php echo $artist['picture_path']; ?>" alt="Artist Image">
            <div>
                <h2><?php echo $artist['name']; ?></h2>
                <p><?php echo $artist['bio']; ?></p>
            </div>
        </div>
        <h3>Products by <?php echo $artist['name']; ?></h3>
        <div class="product-cards">
            <?php while ($product = $product_result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?php echo $product['picture_path']; ?>" alt="Product Image">
                    <h4><?php echo $product['name']; ?></h4>
                    <p><?php echo $product['description']; ?></p>
                    <p><strong>$<?php echo number_format($product['price'], 2); ?></strong></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
