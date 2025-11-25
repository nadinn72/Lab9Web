<?php
// DEBUG: Tampilkan pesan untuk memastikan file terload
echo "<!-- File list.php di-load -->";

// Include koneksi database - pastikan path benar
include(__DIR__ . "/../../config/database.php");

// Check koneksi
if (!$conn) {
    die("Koneksi database gagal");
}

// Query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);

// Debug query
if (!$result) {
    echo "Error query: " . mysqli_error($conn);
    exit;
}

$row_count = mysqli_num_rows($result);
echo "<!-- Jumlah data: $row_count -->";
?>

<h2>Data Barang</h2>
<a href="index.php?page=user/add" class="btn-tambah">Tambah Barang</a>

<?php if($row_count > 0): ?>
<table>
    <tr>
        <th>Gambar</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Harga Jual</th>
        <th>Harga Beli</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_array($result)): ?>
    <tr>
        <td>
            <?php if(!empty($row['gambar'])): ?>
                <img src="assets/gambar/<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>" width="100">
            <?php else: ?>
                <span>No Image</span>
            <?php endif; ?>
        </td>
        <td><?= $row['nama']; ?></td>
        <td><?= $row['kategori']; ?></td>
        <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
        <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
        <td><?= $row['stok']; ?></td>
        <td>
            <a href="index.php?page=user/edit&id=<?= $row['id_barang']; ?>" class="btn-ubah">Ubah</a>
            <a href="index.php?page=user/delete&id=<?= $row['id_barang']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php else: ?>
    <p>Belum ada data barang. <a href="index.php?page=user/add">Tambah barang pertama</a></p>
<?php endif; ?>