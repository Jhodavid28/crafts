<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$product_id = $_GET['id'];

// Fetch product details
$query_product = "
    SELECT p.*, a.name AS artist_name, a.artist_id 
    FROM products p 
    JOIN artists a ON p.artist_id = a.artist_id 
    WHERE p.product_id = ?";
$stmt_product = $conn->prepare($query_product);
$stmt_product->bind_param("i", $product_id);
$stmt_product->execute();
$result_product = $stmt_product->get_result();
$product = $result_product->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $product['name']; ?> - Details</title>
    <link rel="stylesheet" href="assets/css/product_details.css">
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
    <div class="product-details">
        <div class="product-image">
            <img src="<?php echo $product['picture_path']; ?>" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="product-info">
            <h1><?php echo $product['name']; ?></h1>
            <p><?php echo $product['description']; ?></p>
            <p>Price: ₹<?php echo number_format($product['price'], 2); ?></p>
            <p>This craft has been made by: 
                <strong><?php echo $product['artist_name']; ?></strong>
            </p>
            <button onclick="location.href='add_to_cart.php?id=<?php echo $product['product_id']; ?>'">Add to Cart</button>
            <button onclick="location.href='artist_products.php?artist_id=<?php echo $product['artist_id']; ?>'">View Artist</button>
        </div>
    </div>
</body>
</html>
