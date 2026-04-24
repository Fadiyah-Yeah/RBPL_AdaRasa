<?php
session_start();
require 'konek.php';

/* ===== API MODE ===== */
if (isset($_GET['action'])) {

  // ambil data
  if ($_GET['action'] == 'get') {
    $status = $_GET['status'] ?? '';

    $q = $conn->query("
      SELECT p.id_pemesanan, b.nama_bahan, dbp.jumlah
FROM detail_bahan_pemesanan dbp
JOIN bahan_baku b ON dbp.id_bahan = b.id
JOIN pemesanan p ON dbp.id_pemesanan = p.id_pemesanan
WHERE p.id_pemesanan = '$id'
    ");

    $data = [];
    while ($r = $q->fetch_assoc()) {
      $data[] = $r;
    }

    echo json_encode($data);
    exit;
  }

  // update status
  if ($_GET['action'] == 'update') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $conn->query("UPDATE pemesanan 
                  SET status='$status' 
                  WHERE id_pemesanan=$id");

    echo "success";
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ICON -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      margin: 0;
      background: #ffffff;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
    }

    .app {
      width: 100%;
      max-width: 390px;
      min-height: 100vh;
      background: #ffffff;
    }

    .container {
      padding: 20px;
      padding-bottom: 90px;
    }

    .header {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 18px;
    }

    .tabs {
      display: flex;
      gap: 25px;
      margin-bottom: 15px;
    }

    .tab {
      font-size: 14px;
      cursor: pointer;
    }

    .tab.active {
      border-bottom: 2px solid black;
      padding-bottom: 3px;
    }

    .tanggal {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 12px;
      margin-bottom: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
      border: 1px solid #e5e5e5;
      cursor: pointer;
    }

    .left {
      display: flex;
      gap: 12px;
    }

    .card img {
      width: 60px;
      height: 60px;
      border-radius: 10px;
      object-fit: cover;
    }

    .text {
      display: flex;
      flex-direction: column;
    }

    .menu {
      font-size: 14px;
      font-weight: 600;
    }

    .detail {
      font-size: 12px;
      color: #444;
    }

    .time {
      font-size: 11px;
      color: #888;
    }

    .btn {
      background: black;
      color: white;
      border: none;
      border-radius: 20px;
      padding: 5px 12px;
      font-size: 12px;
    }

    .navbar {
      position: fixed;
      bottom: 0;
      width: 100%;
      max-width: 390px;
      background: white;
      border-top: 1px solid #ddd;
      border-radius: 18px 18px 0 0;
      display: flex;
      justify-content: space-around;
      padding: 12px 0;
    }

    .nav-item {
      color: #888;
    }

    .nav-item.active {
      color: black;
    }
  </style>
</head>

<body>

  <div class="app">

    <div class="container">

      <div class="header">Pesanan</div>

      <div class="tabs">
        <div class="tab active" onclick="loadData('diterima', this)">Diterima</div>
        <div class="tab" onclick="loadData('diproses', this)">Diproses</div>
        <div class="tab" onclick="loadData('selesai', this)">Selesai</div>
      </div>

      <div id="list"></div>

    </div>

    <!-- NAVBAR -->
    <div class="navbar">
      <div class="nav-item" onclick="go('../Pages/dapur.php')">
        <i class="fa-regular fa-bell"></i>
      </div>

      <div class="nav-item active">
        <i class="fa-regular fa-clipboard"></i>
      </div>

      <div class="nav-item" onclick="go('../Pages/pengaturan.php')">
        <i class="fa-regular fa-user"></i>
      </div>
    </div>

  </div>

  <script>
    let currentTab = 'diterima';

    function go(page) {
      window.location.href = page;
    }

    function setTab(el) {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      el.classList.add('active');
    }

    /* ===== GAMBAR ===== */
    function getGambar(menu) {

      menu = menu.toLowerCase();

      if (menu === 'nastar') return 'Nastar.jpg';
      if (menu === 'nastar spesial') return 'Nastar_Spesial.jpg';
      if (menu === 'kastengel') return 'Kastengel.jpg';
      if (menu === 'putri salju') return 'putri_salju.jpg';
      if (menu === 'kue kacang') return 'kue_kacang.jpg';
      if (menu === 'choco chip') return 'choco_chip.jpg';
      if (menu === 'brown sugar') return 'brown_sugar.jpg';
      if (menu === 'bolu pisang') return 'Bolu_Pisang.jpg';
      if (menu === 'nasi box ayam panggang paha') return 'Nasi_Box_Ayam_Panggang_Paha.png';
      if (menu === 'nasi box ayam panggang dada') return 'Nasi_Box_Ayam_Panggang_Dada.jpg';
      if (menu === 'nasi box ayam goreng') return 'ayam_goreng.jpg';
      if (menu === 'nasi kuning') return 'nasi_kuning.jpg';

      return 'default.png';
    }

    /* ===== LOAD DATA ===== */
    function loadData(status, el) {
      currentTab = status;
      setTab(el);

      fetch(`pesanan_dapur.php?action=get&status=${status}`)
        .then(res => res.json())
        .then(data => {

          const container = document.getElementById('list');
          container.innerHTML = '';

          if (data.length === 0) {
            container.innerHTML = "<div>Tidak ada pesanan</div>";
            return;
          }

          let tgl = new Date(data[0].tanggal_pesan).toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long'
          });

          container.innerHTML += `<div class="tanggal">${tgl}</div>`;

          data.forEach(item => {

            let jam = new Date(item.tanggal_pesan)
              .toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
              });

            container.innerHTML += `
      <div class="card" onclick="openDetail(${item.id_pemesanan})">

        <div class="left">
          <img src="../asset/${getGambar(item.menu)}" 
               onerror="this.src='../asset/default.png'">

          <div class="text">
            <div class="menu">${item.menu}</div>
            <div class="detail">${item.jumlah}</div>
            <div class="time">${jam}</div>
          </div>
        </div>

        <select class="btn" 
          onclick="event.stopPropagation()" 
          onchange="updateStatus(${item.id_pemesanan}, this.value)">
          <option selected disabled>${item.status}</option>
          ${getOptions(item.status)}
        </select>

      </div>
      `;
          });

        });
    }

    /* ===== OPTIONS ===== */
    function getOptions(status) {
      if (status === 'diterima') return `<option value="diproses">Diproses</option>`;
      if (status === 'diproses') return `<option value="selesai">Selesai</option>`;
      if (status === 'selesai') return `<option value="diantar">Diantar</option>`;
      return '';
    }

    /* ===== UPDATE ===== */
    function updateStatus(id, status) {
      fetch('pesanan_dapur.php?action=update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${id}&status=${status}`
        })
        .then(() => loadData(currentTab, document.querySelector('.tab.active')));
    }

    /* ===== DETAIL ===== */
    function openDetail(id) {
      window.location.href = `deskripsiPesan_dapur.php?id=${id}`;
    }

    /* LOAD AWAL */
    loadData('diterima', document.querySelector('.tab'));
  </script>

</body>

</html>