<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    if ($file_gambar['error'] == 0) {
        $filename = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/../../gambar/' . $filename;
        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = $filename;
        }
    }

    $sql = "UPDATE data_barang SET ";
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}'";
    if (!empty($gambar)) {
        $sql .= ", gambar = '{$gambar}'";
    }
    $sql .= " WHERE id_barang = '{$id}'";
    
    $result = mysqli_query($conn, $sql);

    if($result) {
        header('location: index.php?page=user/list');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
if (!$result) die('Error: Data tidak tersedia');
$data = mysqli_fetch_array($result);

function is_select($var, $val) {
    if ($var == $val) return 'selected="selected"';
    return false;
}
?>

<h2>Ubah Barang</h2>
<form method="post" action="index.php?page=user/edit" enctype="multipart/form-data">
    <div class="input">
        <label>Nama Barang</label>
        <input type="text" name="nama" value="<?php echo $data['nama'];?>" required />
    </div>
    <div class="input">
        <label>Kategori</label>
        <select name="kategori" required>
            <option <?php echo is_select('Komputer', $data['kategori']);?> value="Komputer">Komputer</option>
            <option <?php echo is_select('Elektronik', $data['kategori']);?> value="Elektronik">Elektronik</option>
            <option <?php echo is_select('Hand Phone', $data['kategori']);?> value="Hand Phone">Hand Phone</option>
        </select>
    </div>
    <div class="input">
        <label>Harga Jual</label>
        <input type="number" name="harga_jual" value="<?php echo $data['harga_jual'];?>" required />
    </div>
    <div class="input">
        <label>Harga Beli</label>
        <input type="number" name="harga_beli" value="<?php echo $data['harga_beli'];?>" required />
    </div>
    <div class="input">
        <label>Stok</label>
        <input type="number" name="stok" value="<?php echo $data['stok'];?>" required />
    </div>
    <div class="input">
        <label>File Gambar</label>
        <input type="file" name="file_gambar" />
        <?php if($data['gambar']): ?>
            <p>Gambar saat ini: <?php echo $data['gambar']; ?></p>
        <?php endif; ?>
    </div>
    <div class="submit">
        <input type="hidden" name="id" value="<?php echo $data['id_barang'];?>" />
        <input type="submit" name="submit" value="Simpan" />
        <a href="index.php?page=user/list" class="btn-batal">Batal</a>
    </div>
</form>