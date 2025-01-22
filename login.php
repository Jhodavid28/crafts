<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Handmade Crafts</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <script>
        function toggleRegister() {
            const role = document.getElementById('role').value;
            const registerButton = document.getElementById('registerButton');
            const registerMessage = document.getElementById('registerMessage');
            if (role === 'admin') {
                registerButton.style.display = 'none';
                registerMessage.style.display = 'block';
            } else {
                registerButton.style.display = 'block';
                registerMessage.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Login to Handmade Crafts</h1>
        <p>Manage your account and explore unique crafts</p>
    </header>
    <div class="login-container">
        <form action="login_handler.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" onchange="toggleRegister()" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            
            <button type="submit">Login</button>
        </form>
        <p id="registerMessage" style="color: red; display: none;">Admins cannot register.</p>
        <a id="registerButton" href="register.php" class="register-link">Register</a>
    </div>
</body>
</html>
