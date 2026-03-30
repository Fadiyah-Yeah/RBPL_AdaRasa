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
<title>Detail Laporan</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
  margin-bottom: 20px;
}

.back {
  margin-right: 10px;
  font-size: 20px;
}

.title {
  font-weight: bold;
}

.chart-container {
  width: 100%;
  height: 250px;
}

.cards {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-top: 20px;
}

.card {
  background: white;
  border: 1px solid #333;
  border-radius: 10px;
  padding: 10px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.card img {
  width: 40px;
  height: 40px;
}

.btn {
  margin-top: 20px;
  width: 100%;
  padding: 10px;
  border-radius: 20px;
  border: 1px solid #333;
  background: white;
}
</style>
</head>

<body>

<div class="container">
  <div class="header">
    <div class="back">←</div>
    <div class="title">Detail Laporan</div>
  </div>

  <div class="chart-container">
    <canvas id="chart"></canvas>
  </div>

  <div class="cards" id="cards"></div>

  <button class="btn">Detail Analisis</button>
</div>

<script>
fetch('get_laporan.php')
.then(res => res.json())
.then(data => {

    const labels = data.map(item => item.nama_produk);
    const values = data.map(item => item.jumlah);

    // Chart
    const ctx = document.getElementById('chart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
            }]
        }
    });

    // Cards
    const container = document.getElementById('cards');

    data.forEach(item => {
        container.innerHTML += `
            <div class="card">
                <img src="https://via.placeholder.com/40">
                <div>
                    <div>${item.jumlah}</div>
                    <div>${item.nama_produk}</div>
                </div>
            </div>
        `;
    });

});
</script>

</body>
</html>