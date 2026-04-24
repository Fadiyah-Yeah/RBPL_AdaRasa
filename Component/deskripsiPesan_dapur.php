<?php
session_start();
require 'konek.php';

$id = $_GET['id'] ?? 0;

/* ===== AMBIL DATA PEMESANAN ===== */
$p = $conn->query("
SELECT * FROM pemesanan 
WHERE id_pemesanan = $id
")->fetch_assoc();

/* ===== AMBIL DETAIL ===== */
$d = $conn->query("
SELECT * FROM detail_pemesanan 
WHERE id_pemesanan = $id
");

/* ===== FUNCTION GAMBAR ===== */
function getGambar($menu){
  $menu = strtolower($menu);

  if($menu === 'nastar') return 'Nastar.jpg';
  if($menu === 'nastar spesial') return 'Nastar_Spesial.png';
  if($menu === 'kastengel') return 'Kastenger.jpg';
  if($menu === 'putri salju') return 'putri_salju.jpg';
  if($menu === 'kue kacang') return 'kue_kacang.jpg';
  if($menu === 'choco chip') return 'choco_chip.jpg';
  if($menu === 'brown sugar') return 'brown_sugar.jpg';
  if($menu === 'bolu pisang') return 'Bolu_Pisang.jpg';
  if($menu === 'nasi box ayam panggang paha') return 'Nasi_Box_Ayam_Panggang_Paha.png';
  if($menu === 'nasi box ayam panggang dada') return 'Nasi_Box_Ayam_Panggang_Dada.jpg';
  if($menu === 'nasi box ayam goreng') return 'ayam_goreng.jpg';
  if($menu === 'nasi kuning') return 'nasi_kuning.png';

  return 'default.png';
}

$gambar = getGambar($p['menu']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
  margin:0;
  background:#ffffff;
  font-family: Arial;
  display:flex;
  justify-content:center;
}

.container{
  width:100%;
  max-width:390px;
  padding:20px;
}

/* HEADER */
.header{
  display:flex;
  align-items:center;
  gap:10px;
  margin-bottom:20px;
}

.back{
  font-size:18px;
  cursor:pointer;
}

.title{
  font-size:18px;
  font-weight:600;
}

/* IMAGE */
.image{
  width:100%;
  height:160px;
  border-radius:12px;
  overflow:hidden;
  margin-bottom:15px;
}

.image img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* TEXT */
.label{
  font-weight:600;
  margin-top:10px;
}

.text{
  margin-bottom:10px;
}
</style>
</head>

<body>

<div class="container">

  <!-- HEADER -->
  <div class="header">
    <div class="back" onclick="history.back()">←</div>
    <div class="title">Detail Pesanan</div>
  </div>

  <!-- IMAGE -->
  <div class="image">
    <img src="../asset/<?= $gambar ?>" onerror="this.src='../asset/default.png'">
  </div>

  <!-- DATA -->
  <div class="label">Menu dipesan:</div>
  <div class="text"><?= $p['menu'] ?></div>

  <div class="label">Jumlah pesan:</div>
  <div class="text"><?= $p['jumlah'] ?> box</div>

  <div class="label">Catatan:</div>
  <div class="text"><?= $p['tambahan'] ?: '-' ?></div>

  <div class="label">Bahan:</div>
  <div class="text">
    <?php while($row = $d->fetch_assoc()) : ?>
      <?= $row['bahan'] ?><br>
    <?php endwhile; ?>
  </div>

  <div class="label">Dipesan pada:</div>
  <div class="text">
    <?= date('d/m/Y H:i', strtotime($p['tanggal_pesan'])) ?>
  </div>

  <div class="label">Pesanan untuk:</div>
  <div class="text">
    <?= date('d/m/Y H:i', strtotime($p['tanggal_kirim'])) ?>
  </div>

</div>

</body>
</html>