<?php
include 'Component/konek.php';

$id = $_GET['id'];

$query = $conn->query("SELECT * FROM pesanan WHERE id=$id");
$data = $query->fetch_assoc();

echo json_encode($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
  font-family: Arial;
  background: #f5f5f5;
  margin: 0;
  display: flex;
  justify-content: center;
}

.container {
  width: 100%;
  max-width: 400px;
  padding: 20px;
}

.header {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
}

.back {
  margin-right: 10px;
  cursor: pointer;
}

.title {
  font-weight: bold;
}

img {
  width: 100%;
  border-radius: 10px;
  margin-bottom: 15px;
}

.text {
  font-size: 13px;
  margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="container">
  <div class="header">
    <div class="back" onclick="history.back()">←</div>
    <div class="title">Detail Pesanan</div>
  </div>

  <img id="gambar">

  <div class="text"><b>Menu dipesan:</b><br><span id="nama"></span></div>

  <div class="text"><b>Jumlah pesan:</b><br><span id="jumlah"></span></div>

  <div class="text"><b>Catatan:</b><br><span id="catatan"></span></div>

  <div class="text" id="waktu"></div>
</div>

<script>
const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');

fetch(`get_detail.php?id=${id}`)
.then(res => res.json())
.then(data => {

  document.getElementById('gambar').src = "img/" + data.gambar;
  document.getElementById('nama').innerText = data.nama_produk;
  document.getElementById('jumlah').innerText = data.jumlah;
  document.getElementById('catatan').innerText = data.catatan || "-";

  document.getElementById('waktu').innerHTML = `
    Dipesan pada ${data.waktu_pesan}<br>
    Pesanan untuk ${data.waktu_kirim}
  `;
});
</script>

</body>
</html>