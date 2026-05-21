<?php
session_start();
require '../Component/konek.php';

/* ================= API ================= */
if (isset($_GET['action'])) {

  // ambil notif
  if ($_GET['action'] == 'get') {

   $q = $conn->query("
SELECT n.*, p.menu as nama_produk, p.jumlah
FROM notifikasi n
JOIN pemesanan p ON n.id_pemesanan = p.id_pemesanan
WHERE LOWER(TRIM(n.tipe))='antar'
ORDER BY n.id DESC
");

    $data = [];
    while ($r = $q->fetch_assoc()) {
      $data[] = $r;
    }

    echo json_encode($data);
    exit;
  }

  // read notif
  if ($_GET['action'] == 'read') {
    $id = $_POST['id'];
    $conn->query("UPDATE notifikasi SET status='read' WHERE id=$id");
    echo "ok";
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <title>Notifikasi</title>

  <style>
    * {
      box-sizing: border-box;
      font-family: 'Aleo', serif;
    }

    body {
      margin: 0;
      background: #ffffff;
      display: flex;
      justify-content: center;
    }

    .container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
    }

    .title {
      text-align: center;
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .card {
      background: white;
      border: 1px solid #333;
      border-radius: 10px;
      padding: 12px;
      margin-bottom: 12px;
      cursor: pointer;
    }

    .card.read {
      background: #f0f0f0;
      color: #999;
      border-color: #ccc;
    }

    .card .sub {
      font-size: 13px;
    }

    .time {
      float: right;
      font-size: 11px;
      color: #555;
    }

    /* NAVBAR */
    .navbar {
      position: fixed;
      bottom: 0;
      width: 100%;
      max-width: 400px;
      background: white;
      border-top: 1px solid #333;
      display: flex;
      justify-content: space-around;
      padding: 10px 0;
    }

    .nav-item {
      font-size: 20px;
      color: #999;
    }

    .nav-item.active {
      color: black;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="title">Notifikasi</div>
    <div id="list"></div>
  </div>

  <div class="navbar">
    <div class="nav-item active" onclick="go('antar.php')"><i class="fa-regular fa-bell"></i></div>
    <div class="nav-item" onclick="go('../Component/antar_work.php')"><i class="fa-solid fa-truck"></i></div>
    <div class="nav-item" onclick="go('../Pages/Pengaturan.php')"><i class="fa-regular fa-user"></i></div>
  </div>

  <script>
    function go(page) {
      window.location.href = page;
    }
    /* ===== GET DATA ===== */
    fetch('notif_pengantaran.php?action=get')
      .then(res => res.json())
      .then(data => {

        const container = document.getElementById('list');

        data.forEach(item => {
          container.innerHTML += `
      <div class="card ${item.status==='read'?'read':''}" 
           onclick="openPesanan(${item.id}, ${item.id_pesanan})">

        <div><b>Ada pesanan siap diantar!</b></div>
        <div class="sub">${item.nama_produk}</div>
        <div class="sub">${item.jumlah}</div>
        <div class="time">${formatTime(item.waktu)}</div>
      </div>
    `;
        });

      });

    /* ===== FORMAT JAM ===== */
    function formatTime(time) {
      let d = new Date(time);
      return d.getHours().toString().padStart(2, '0') + '.' +
        d.getMinutes().toString().padStart(2, '0');
    }

    /* ===== CLICK ===== */
    function openPesanan(id_notif, id_pesanan) {

      fetch('action=read', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id_notif}`
      });

      window.location.href = `detail_pesanan.php?id=${id_pemesanan}`;
    }
  </script>

</body>

</html>