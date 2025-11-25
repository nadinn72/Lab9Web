<?php
require_once 'config/session.php';
require_once 'config/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: index.php?page=dashboard');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $csrf_token = $_POST['csrf_token'];
    
    if (!validateCSRFToken($csrf_token)) {
        $error = 'Invalid security token!';
    } elseif ($password !== $confirm_password) {
        $error = 'Konfirmasi password tidak sesuai!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Check if username/email already exists
        $check_sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = 'Username atau email sudah digunakan!';
        } else {
            // Create new user
            $hashed_password = hashPassword($password);
            $insert_sql = "INSERT INTO users (username, email, password, nama_lengkap, role) VALUES (?, ?, ?, ?, 'user')";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($insert_stmt, "ssss", $username, $email, $hashed_password, $nama_lengkap);
            
            if (mysqli_stmt_execute($insert_stmt)) {
                $success = 'Registrasi berhasil! Silakan login.';
                header('refresh:2;url=index.php?page=auth/login');
            } else {
                $error = 'Terjadi kesalahan saat registrasi!';
            }
        }
    }
}
?>

<div class="content">
    <div class="form-container" style="max-width: 400px; margin: 2rem auto;">
        <div class="text-center mb-lg">
            <h2>Registrasi Akun</h2>
            <p class="text-secondary">Buat akun baru</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert--error mb-md">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert--success mb-md">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php?page=auth/register">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            
            <div class="form-group">
                <label for="nama_lengkap" class="form-label">
                    <i class="fas fa-user"></i> Nama Lengkap
                </label>
                <input 
                    type="text" 
                    id="nama_lengkap" 
                    name="nama_lengkap" 
                    class="form-input" 
                    placeholder="Masukkan nama lengkap"
                    value="<?php echo isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="username" class="form-label">
                    <i class="fas fa-at"></i> Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-input" 
                    placeholder="Masukkan username"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="Masukkan email"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Minimal 6 karakter"
                    required
                >
            </div>

            <div class="form-group">
                <label for="confirm_password" class="form-label">
                    <i class="fas fa-lock"></i> Konfirmasi Password
                </label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    class="form-input" 
                    placeholder="Ulangi password"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn--primary" style="width: 100%;">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            </div>
        </form>

        <div class="text-center mt-lg">
            <p class="text-secondary">
                Sudah punya akun? 
                <a href="index.php?page=auth/login" class="text-accent">Login di sini</a>
            </p>
        </div>
    </div>
</div>