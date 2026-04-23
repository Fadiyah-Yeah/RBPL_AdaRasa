<?php
session_start();
require 'konek.php';

// ambil data dropdown
$menu = mysqli_query($conn, "SELECT DISTINCT menu FROM bahan_baku WHERE menu IS NOT NULL");
$vendor = mysqli_query($conn, "SELECT DISTINCT nama_vendor, alamat_vendor FROM bahan_baku WHERE nama_vendor IS NOT NULL");
$bahan = mysqli_query($conn, "SELECT DISTINCT nama_bahan, harga_satuan FROM bahan_baku");

// simpan data
if (isset($_POST['submit'])) {

    $nama_bahan = $_POST['nama_bahan'];
    $menu_val = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $pakai = $_POST['pakai'];
    $tanggal = $_POST['tanggal'];
    $nama_vendor = $_POST['nama_vendor'];
    $alamat_vendor = $_POST['alamat_vendor'];
    $harga = $_POST['harga_satuan'];
    $total = $_POST['total'];

    mysqli_query($conn, "INSERT INTO bahan_baku 
    (nama_bahan, menu, jumlah, pakai, tanggal, nama_vendor, alamat_vendor, harga_satuan, total)
    VALUES 
    ('$nama_bahan','$menu_val','$jumlah','$pakai','$tanggal','$nama_vendor','$alamat_vendor','$harga','$total')
    ");

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Data berhasil ditambahkan');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
<title>Input Bahan Baku</title>

<style>
/* === CSS ASLI (TIDAK DIUBAH) === */
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Aleo', serif; }
body { background-color: #ffffff; display: flex; justify-content: center; }
.mobile-container { width: 100%; max-width: 390px; padding: 20px; }
.header { display: flex; align-items: center; gap: 12px; margin-bottom: 25px; }
.back { font-size: 22px; cursor: pointer; color: #000000; text-decoration: none; }
.title { flex: 1; text-align: center; font-weight: 600; letter-spacing: 1px; }
.card { background: #ffffff; border: 1px solid #000; border-radius: 10px; padding: 18px; }
label { font-size: 13px; margin-bottom: 6px; display: block; }
input, select {
    width: 100%; padding: 8px 10px; border-radius: 7px;
    border: 1px solid #ccc; background: #ffffff;
    margin-bottom: 14px; font-size: 13px; outline: none;
}
.row { display: flex; gap: 10px; }
.row .col { flex: 1; }
.date-row { display: flex; gap: 8px; }
.date-row input { flex: 1; text-align: center; }
.btn-wrapper { display: flex; justify-content: center; margin-top: 25px; }
.btn {
    padding: 8px 40px; border-radius: 20px; border: 1px solid #000;
    background: #ffffff; cursor: pointer; font-size: 14px;
}
.btn:hover { background: #ddd; }
</style>
</head>

<body>

<div class="mobile-container">

    <div class="header">
        <a class="back" href="../Pages/admin.html">&#8592;</a>
        <div class="title">INPUT BAHAN BAKU</div>
    </div>

    <div class="card">
        <form method="POST">

            <label>Nama bahan</label>
            <input type="text" name="nama_bahan" id="nama_bahan" required>

            <label>Untuk bahan baku apa</label>
            <select name="menu">
                <option value="">Value</option>
                <?php while($m = mysqli_fetch_assoc($menu)) : ?>
                    <option value="<?= $m['menu']; ?>"><?= $m['menu']; ?></option>
                <?php endwhile; ?>
            </select>

            <div class="row">
                <div class="col">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" required>
                </div>
                <div class="col">
                    <label>Brp kali pakai</label>
                    <input type="number" name="pakai">
                </div>
            </div>

            <label>Tanggal Beli</label>
            <input type="date" name="tanggal" required>

            <label>Nama Vendor</label>
            <select name="nama_vendor" id="vendor">
                <option value="">Value</option>
                <?php while($v = mysqli_fetch_assoc($vendor)) : ?>
                    <option value="<?= $v['nama_vendor']; ?>" data-alamat="<?= $v['alamat_vendor']; ?>">
                        <?= $v['nama_vendor']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Alamat Vendor</label>
            <input type="text" name="alamat_vendor" id="alamat_vendor">

            <div class="row">
                <div class="col">
                    <label>Total harga</label>
                    <input type="number" name="total" id="total" readonly>
                </div>
                <div class="col">
                    <label>Harga satuan</label>
                    <input type="number" name="harga_satuan" id="harga">
                </div>
            </div>

        </div>

        <div class="btn-wrapper">
            <button class="btn" type="submit" name="submit">Tambahkan</button>
        </div>

        </form>

</div>

<script>
// data bahan
let bahanData = {
<?php 
mysqli_data_seek($bahan, 0);
while($b = mysqli_fetch_assoc($bahan)) {
    echo "'".$b['nama_bahan']."': ".$b['harga_satuan'].",";
}
?>
};

// auto alamat vendor
document.getElementById("vendor").addEventListener("change", function() {
    let alamat = this.options[this.selectedIndex].getAttribute("data-alamat");
    document.getElementById("alamat_vendor").value = alamat || "";
});

// auto harga
document.getElementById("nama_bahan").addEventListener("input", function() {
    let harga = bahanData[this.value] || "";
    document.getElementById("harga").value = harga;
    hitungTotal();
});

// hitung total
document.getElementById("jumlah").addEventListener("input", hitungTotal);
document.getElementById("harga").addEventListener("input", hitungTotal);

function hitungTotal() {
    let jumlah = document.getElementById("jumlah").value || 0;
    let harga = document.getElementById("harga").value || 0;
    document.getElementById("total").value = jumlah * harga;
}
</script>

</body>
</html>