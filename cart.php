<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Get the logged-in user's ID
$user_query = "SELECT id FROM users WHERE username = ?";
$stmt_user = $conn->prepare($user_query);
$stmt_user->bind_param("s", $_SESSION['username']);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

$user_id = $user['id'];

// Fetch cart items
$query_cart = "
    SELECT c.cart_id, c.quantity, p.name AS product_name, p.price, p.picture_path 
    FROM cart c 
    JOIN products p ON c.product_id = p.product_id 
    WHERE c.user_id = ?";
$stmt_cart = $conn->prepare($query_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Cart</title>
    <link rel="stylesheet" href="assets/css/cart.css">
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
        <h1>Your Cart</h1>
        <?php if ($result_cart->num_rows > 0): ?>
            <div class="cart-container">
                <div class="cart-items">
                    <?php while ($cart_item = $result_cart->fetch_assoc()): ?>
                        <div class="cart-item">
                            <img src="<?php echo $cart_item['picture_path']; ?>" alt="<?php echo $cart_item['product_name']; ?>">
                            <div class="cart-item-info">
                                <h3><?php echo $cart_item['product_name']; ?></h3>
                                <p>₹<?php echo number_format($cart_item['price'], 2); ?></p>
                                <div class="quantity-controls">
                                    <button onclick="location.href='update_cart.php?cart_id=<?php echo $cart_item['cart_id']; ?>&action=decrease'">-</button>
                                    <span><?php echo $cart_item['quantity']; ?></span>
                                    <button onclick="location.href='update_cart.php?cart_id=<?php echo $cart_item['cart_id']; ?>&action=increase'">+</button>
                                </div>
                                <button onclick="location.href='remove_from_cart.php?cart_id=<?php echo $cart_item['cart_id']; ?>'" class="remove-btn">Remove</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="cart-summary">
                    <h2>Billing Details</h2>
                    <p>Total Items: <span id="total-items"></span></p>
                    <p>Total Price: ₹<span id="total-price"></span></p>
                    <textarea placeholder="Enter your address here..." rows="4"></textarea>
                    <button class="place-order-btn">Place Delivery</button>
                </div>
            </div>
        <?php else: ?>
            <p>Your cart is empty! Start adding items to your cart.</p>
        <?php endif; ?>
    </div>
    <script>
        // Calculate totals dynamically
        const cartItems = document.querySelectorAll('.cart-item');
        let totalItems = 0, totalPrice = 0;

        cartItems.forEach(item => {
            const quantity = parseInt(item.querySelector('.quantity-controls span').innerText);
            const price = parseFloat(item.querySelector('p').innerText.replace('₹', ''));
            totalItems += quantity;
            totalPrice += quantity * price;
        });

        document.getElementById('total-items').innerText = totalItems;
        document.getElementById('total-price').innerText = totalPrice.toFixed(2);
    </script>
</body>
</html>
