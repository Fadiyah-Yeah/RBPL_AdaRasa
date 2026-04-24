<?php
session_start();
require '../Component/konek.php';

/* ===== API MODE ===== */
if(isset($_GET['action'])){

  if($_GET['action']=='all'){
    $q = $conn->query("
      SELECT id_pemesanan, menu, nama_pelanggan, tanggal_pesan 
      FROM pemesanan 
      ORDER BY id_pemesanan DESC
    ");

    $data=[];
    while($r=$q->fetch_assoc()){
      $data[]=$r;
    }

    echo json_encode($data);
    exit;
  }
}

/* ===== DEFAULT (5 DATA) ===== */
$qPesanan = $conn->query("
SELECT id_pemesanan, menu, nama_pelanggan, tanggal_pesan 
FROM pemesanan 
ORDER BY id_pemesanan DESC 
LIMIT 5
");

$qBahan = $conn->query("
SELECT nama_bahan, jumlah 
FROM bahan_baku
ORDER BY nama_bahan ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html { font-family: 'Aleo', serif; }

body {
    background-color: #ffffff;
    display: flex;
    justify-content: center;
}

.mobile-container {
    width: 100%;
    max-width: 390px;
    padding: 20px;
}

.header {
    text-align: center;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
}

.announcement {
    background: #cce6fd;
    border: 1px solid #000;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    font-size: 13px;
    margin-bottom: 25px;
}

.menu {
    display: flex;
    justify-content: space-between;
    margin-bottom: 25px;
}

.menu-item {
    text-align: center;
    font-size: 11px;
    color: #000;
    text-decoration: none;
}

.menu-icon {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    border: 1px solid #bba9e6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 6px;
    font-size: 20px;
}

/* ===== PESANAN ===== */
.order-card {
    background: #fcfcfc;
    border: 1px solid #bba9e6;
    border-radius: 10px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;

    opacity: 0;
    transform: translateY(-10px);
    transition: all 0.4s ease;
}

.order-card.show {
    opacity: 1;
    transform: translateY(0);
}

.avatar {
    width: 28px;
    height: 28px;
    background: #bba9e6;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
}

.order-info {
    font-size: 12px;
}

.order-info small {
    display: block;
    font-size: 10px;
    color: #666;
}

/* ===== MORE ===== */
.more-wrapper {
    text-align: center;
    margin: 10px 0 25px;
}

.more-btn {
    background: #bba9e6;
    border: 1px solid #7e6fb5;
    border-radius: 15px;
    padding: 4px 20px;
    font-size: 12px;
    cursor: pointer;
}

/* ===== BAHAN ===== */
.section-title {
    font-weight: 600;
    margin-bottom: 10px;
}

.stock-card {
    background: #fff;
    border: 1px solid #000;
    border-radius: 10px;
    padding: 12px;
}

.stock-item {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    margin-bottom: 6px;
}

input[type="checkbox"] {
    accent-color: #6e5ca3;
}
</style>
</head>

<body>

<div class="mobile-container">

<div class="header">Halo ADMIN</div>

<div class="announcement">
    <strong>Pengumuman</strong><br>
    Terdapat <?= $qPesanan->num_rows ?> pesanan terbaru
</div>

<div class="menu">
    <a class="menu-item" href="../Component/Input_BB.php">
        <div class="menu-icon"><i class="fa-solid fa-plus"></i></div>
        Bahan Baku
    </a>

    <a class="menu-item" href="../Component/Input_Pesan.php">
        <div class="menu-icon"><i class="fa-solid fa-clipboard-list"></i></div>
        Pesanan
    </a>

    <a class="menu-item" href="../Pages/laporan.html">
        <div class="menu-icon"><i class="fa-solid fa-chart-line"></i></div>
        Laporan
    </a>

    <a class="menu-item" href="../Pages/Pengaturan.php">
        <div class="menu-icon"><i class="fa-solid fa-user"></i></div>
        Pengaturan
    </a>
</div>

<!-- ===== LIST ===== -->
<div id="orderList">
<?php while($p = $qPesanan->fetch_assoc()) : ?>
<div class="order-card show">
    <div class="avatar"><?= strtoupper(substr($p['nama_pelanggan'],0,1)); ?></div>
    <div class="order-info">
        <?= $p['menu']; ?> - <?= $p['nama_pelanggan']; ?>
        <small><?= date('d/m/Y', strtotime($p['tanggal_pesan'])); ?></small>
    </div>
</div>
<?php endwhile; ?>
</div>

<div class="more-wrapper">
    <button class="more-btn">More</button>
</div>

<div class="section-title">Bahan Baku</div>

<div class="stock-card">
<?php while($b = $qBahan->fetch_assoc()) : ?>
<div class="stock-item">
    <?= $b['nama_bahan']; ?> - <?= $b['jumlah']; ?>
    <input type="checkbox" <?= ($b['jumlah'] > 0 ? 'checked' : '') ?>>
</div>
<?php endwhile; ?>
</div>

</div>

<script>
let expanded = false;
let originalHTML = document.getElementById('orderList').innerHTML;

document.querySelector('.more-btn').addEventListener('click', ()=>{

    const btn = document.querySelector('.more-btn');

    if(!expanded){

        fetch('admin.php?action=all')
        .then(res=>res.json())
        .then(data=>{

            const container = document.getElementById('orderList');
            container.innerHTML = '';

            data.forEach((item, i)=>{

                const el = document.createElement('div');
                el.className = 'order-card';

                el.innerHTML = `
                    <div class="avatar">
                        ${item.nama_pelanggan.charAt(0).toUpperCase()}
                    </div>
                    <div class="order-info">
                        ${item.menu} - ${item.nama_pelanggan}
                        <small>${formatDate(item.tanggal_pesan)}</small>
                    </div>
                `;

                container.appendChild(el);

                setTimeout(()=>{
                    el.classList.add('show');
                }, i * 70);
            });

            btn.innerText = "Show Less";
            expanded = true;
        });

    } else {

        const container = document.getElementById('orderList');

        // animasi hide
        document.querySelectorAll('.order-card').forEach((el, i)=>{
            setTimeout(()=>{
                el.classList.remove('show');
            }, i * 50);
        });

        setTimeout(()=>{
            container.innerHTML = originalHTML;
            btn.innerText = "More";
            expanded = false;
        }, 400);
    }

});

function formatDate(date){
    const d = new Date(date);
    return d.toLocaleDateString('id-ID');
}
</script>

</body>
</html>