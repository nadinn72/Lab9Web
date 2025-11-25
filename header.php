<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/script.js" defer></script>
    <title>Data Barang</title>
</head>
<body>
    <div class="container">
        <header>
            <div class="header-top">
                <h1>Data Barang</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?></span>
                    <a href="index.php?page=auth/logout" class="logout-btn">Logout</a>
                </div>
            </div>
            <nav>
                <a href="index.php?page=dashboard">Dashboard</a>
                <a href="index.php?page=user/list">Data Barang</a>
                <a href="index.php?page=user/add">Tambah Barang</a>
            </nav>
        </header>
        <div class="main">