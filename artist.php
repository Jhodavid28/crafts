<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all artists
$query = "SELECT * FROM artists";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Artists</title>
    <link rel="stylesheet" href="assets/css/artist.css">
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
        <h1>Our Talented Artists</h1>
        <div class="artist-grid">
            <?php while ($artist = $result->fetch_assoc()): ?>
                <div class="artist-card">
                    <img src="<?php echo $artist['profile_picture']; ?>" alt="<?php echo $artist['name']; ?>">
                    <h3><?php echo $artist['name']; ?></h3>
                    <p><?php echo $artist['products']; ?></p>
                    <button onclick="location.href='artist_products.php?artist_id=<?php echo $artist['artist_id']; ?>'">View Products</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
