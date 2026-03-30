<?php
include 'Component/konek.php';

$status = $_GET['status'];

$query = $conn->query("SELECT * FROM pesanan WHERE status='$status' ORDER BY tanggal DESC");

$data = [];

while($row = $query->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail</title>

<style>
* {
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

body {
  margin: 0;
  background: #f5f5f5;
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
  margin-bottom: 10px;
}

.back {
  margin-right: 10px;
  font-size: 20px;
}

.title {
  font-weight: bold;
}

/* TAB */
.tabs {
  display: flex;
  background: #eee;
  border-radius: 20px;
  overflow: hidden;
  margin: 15px 0;
}

.tab {
  flex: 1;
  padding: 8px;
  text-align: center;
  cursor: pointer;
  font-size: 13px;
}

.tab.active {
  background: #8BC34A;
  color: white;
}

/* LIST */
.list {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.card {
  background: white;
  border: 1px solid #333;
  border-radius: 10px;
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.text {
  font-size: 13px;
}

.sub {
  font-size: 11px;
  color: #555;
}

.card img {
  width: 50px;
  height: 50px;
  border-radius: 8px;
  object-fit: cover;
}
</style>
</head>

<body>

<div class="container">
  <div class="header">
    <div class="back">←</div>
    <div class="title">Detail</div>
  </div>

  <div class="tabs">
    <div class="tab active" onclick="loadData('produk', this)">Pesanan</div>
    <div class="tab" onclick="loadData('pelanggan', this)">Pelanggan</div>
  </div>

  <div class="list" id="list"></div>
</div>

<script>
function setActiveTab(el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}

function loadData(type, el) {
  setActiveTab(el);

  fetch(`get_data.php?type=${type}`)
    .then(res => res.json())
    .then(data => {

      const container = document.getElementById('list');
      container.innerHTML = '';

      data.forEach(item => {
        container.innerHTML += `
          <div class="card">
            <div>
              <div class="text">${item.nama}</div>
              <div class="sub">${item.deskripsi || item.alamat}</div>
            </div>
            <img src="img/${item.gambar}">
          </div>
        `;
      });

    });
}

// load default
loadData('produk', document.querySelector('.tab'));
</script>

</body>
</html>

