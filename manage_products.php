<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include 'db.php';

// Fetch all products
$query = "SELECT p.id, p.name, p.price, p.description, p.picture_path, a.name AS artist_name 
          FROM products p 
          JOIN artists a ON p.artist_id = a.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Products - Handmade Crafts</title>
    <link rel="stylesheet" href="assets/css/manage_products.css">
</head>
<body>
    <button class="menu-toggle">☰ Menu</button>
    <div class="popup-menu">
        <div class="menu-header">Admin Navigation</div>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="view_reports.php">View Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <main class="manage-products">
        <h1>Manage Products</h1>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Artist</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <img src="<?php echo $product['picture_path']; ?>" alt="Product Image">
                            <span><?php echo $product['name']; ?></span>
                        </td>
                        <td><?php echo $product['artist_name']; ?></td>
                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td>
                            <button onclick="deleteProduct(<?php echo $product['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
    <script>
        function deleteProduct(id) {
            if (confirm("Are you sure you want to delete this product?")) {
                location.href = `delete_product.php?id=${id}`;
            }
        }
    </script>
    <script src="assets/js/script.js"></script>
</body>
</html>
