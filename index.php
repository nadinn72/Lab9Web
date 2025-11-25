<?php
session_start();

// Include konfigurasi database
include("config/database.php");

// Debug session
error_log("Session status: " . (isset($_SESSION['user_logged_in']) ? 'Logged in' : 'Not logged in'));

// Routing sederhana
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Debug page request
error_log("Page requested: " . $page);

// Daftar halaman yang tidak memerlukan login
$public_pages = ['auth/login', 'auth/logout'];

// Cek apakah user sudah login
$logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;

// Debug login status
error_log("User logged in: " . ($logged_in ? 'Yes' : 'No'));

// Redirect ke login jika belum login dan mengakses halaman terproteksi
if (!$logged_in && !in_array($page, $public_pages)) {
    error_log("Redirecting to login");
    header('location: index.php?page=auth/login');
    exit;
}

// Redirect ke dashboard jika sudah login dan mengakses halaman login
if ($logged_in && $page === 'auth/login') {
    error_log("Redirecting to dashboard");
    header('location: index.php?page=dashboard');
    exit;
}

// Daftar halaman yang diizinkan
$allowed_pages = [
    'dashboard',
    'user/list',
    'user/add', 
    'user/edit',
    'user/delete',
    'auth/login',
    'auth/logout'
];

// Validasi halaman
if (!in_array($page, $allowed_pages)) {
    error_log("Page not allowed, redirecting to dashboard");
    $page = 'dashboard';
}

// Untuk halaman login, tidak perlu include header/footer biasa
if ($page === 'auth/login') {
    $page_path = "modules/" . $page . ".php";
    if (file_exists($page_path)) {
        include($page_path);
    } else {
        echo "<p>Halaman login tidak ditemukan.</p>";
        error_log("Login page not found: " . $page_path);
    }
    exit;
}

// Include header untuk halaman lainnya
include("views/header.php");

// Load halaman yang diminta
$page_path = "modules/" . $page . ".php";
error_log("Loading page: " . $page_path);

if (file_exists($page_path)) {
    include($page_path);
} else {
    echo "<p>Halaman tidak ditemukan: " . $page_path . "</p>";
    error_log("Page not found: " . $page_path);
}

// Include footer
include("views/footer.php");
?>