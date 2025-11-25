<?php
// Tambahkan di paling atas untuk suppress notice
error_reporting(E_ALL & ~E_NOTICE);

session_start();

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('location: index.php?page=dashboard');
    exit;
}

// Proses login
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Validasi sederhana
    $valid_username = 'admin';
    $valid_password = 'admin123';
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        header('location: index.php?page=dashboard');
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Data Barang</title>
    
    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="login-card">
            <h1>Login Sistem</h1>
            <p class="login-subtitle">Sistem Manajemen Data Barang</p>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="index.php?page=auth/login" class="login-form">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required 
                        placeholder="Masukkan username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required 
                        placeholder="Masukkan password">
                </div>
                
                <button type="submit" name="submit" class="login-btn">Login</button>
            </form>
            
            <div class="login-info">
                <p><strong>Default Login:</strong></p>
                <p>Username: <code>admin</code></p>
                <p>Password: <code>admin123</code></p>
            </div>
        </div>
    </div>
</body>
</html>