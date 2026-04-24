<?php
session_start();
require 'konek.php';

$periode = $_GET['periode'] ?? 'hari';

/* ===== FILTER ===== */
switch($periode){
  case 'hari':
    $filter = "DATE(tanggal_pesan)=CURDATE()";
    break;
  case 'minggu':
    $filter = "YEARWEEK(tanggal_pesan,1)=YEARWEEK(CURDATE(),1)";
    break;
  case 'bulan':
    $filter = "MONTH(tanggal_pesan)=MONTH(CURDATE()) AND YEAR(tanggal_pesan)=YEAR(CURDATE())";
    break;
  case 'tahun':
    $filter = "YEAR(tanggal_pesan)=YEAR(CURDATE())";
    break;
  default:
    $filter = "1=1";
}

/* ===== DATA ===== */
$query = $conn->query("
SELECT menu AS nama_produk, SUM(jumlah) AS total
FROM pemesanan
WHERE $filter
GROUP BY menu
");

$data = [];
while($row = $query->fetch_assoc()){
  $data[] = $row;
}

/* ===== GAMBAR + WARNA ===== */
function getAsset($menu){
  $menu = strtolower($menu);

  if($menu=='nastar') return ['Nastar.jpg','#d4a373'];
  if($menu=='nastar spesial') return ['Nastar_Spesial.jpg','#c08457'];
  if($menu=='kastengel') return ['Kastengel.jpg','#e9c46a'];
  if($menu=='putri salju') return ['putri_salju.jpg','#e0e0e0'];
  if($menu=='kue kacang') return ['kue_kacang.jpg','#bc6c25'];
  if($menu=='choco chip') return ['choco_chip.jpg','#6d4c41'];
  if($menu=='brown sugar') return ['brown_sugar.jpg','#8d6e63'];
  if($menu=='bolu pisang') return ['Bolu_Pisang.jpg','#f4a261'];
  if($menu=='nasi kuning') return ['Nasi_Kuning.jpg','#fdd835'];
  if($menu=='nasi box ayam panggang dada') return ['Nasi_Box_Ayam_Panggang_Dada.jpg','#ef5350'];
  if($menu=='nasi box ayam panggang paha') return ['Nasi_Box_Ayam_Panggang_Paha.jpg','#ef5350'];
  if($menu=='nasi box ayam goreng') return ['Nasi_Box_Ayam_Goreng.jpg','#ff7043'];

  return ['default.png','#999999'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{box-sizing:border-box;font-family:'Aleo',serif;}

body{
  margin:0;
  background:#ffffff;
  display:flex;
  justify-content:center;
  align-content: center;
}

.container{
  width:100%;
  max-width:400px;
  padding:20px;
}

.header{
  display:flex;
  align-items:center;
  margin-bottom:20px;
}

.back{
  margin-right:10px;
  font-size:20px;
  cursor:pointer;
}

.title{font-weight:bold;}

.chart-container{
  width:100%;
  height:260px;
}

.cards{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:12px;
  margin-top:20px;
}

.card{
  background:white;
  border:1px solid #333;
  border-radius:10px;
  padding:10px;
  display:flex;
  align-items:center;
  gap:10px;
}

.card img{
  width:60px;
  height:60px;
  object-fit:cover;
  border-radius:8px;
}

.btn{
  margin-top:20px;
  width:100%;
  padding:10px;
  border-radius:20px;
  border:1px solid #333;
  background:white;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
 <a class="back" href="../Pages/laporan.html">
        <i class="fa-solid fa-arrow-left"></i>
     </a>
  <div class="title">Detail Laporan</div>
</div>

<div class="chart-container">
  <canvas id="chart"></canvas>
</div>

<div class="cards">
<?php foreach($data as $d): 
  $asset = getAsset($d['nama_produk']);
?>
  <div class="card">
    <img src="../asset/<?= $asset[0] ?>" onerror="this.src='../asset/default.png'">
    <div>
      <div><?= $d['total'] ?></div>
      <div><?= $d['nama_produk'] ?></div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<button class="btn" onclick="goDetail()">Detail Analisis</button>

</div>

<script>
const rawData = <?= json_encode($data) ?>;

const labels = rawData.map(d => d.nama_produk);
const values = rawData.map(d => d.total);

/* ===== WARNA DINAMIS ===== */
function getColor(menu){
  menu = menu.toLowerCase();

  if(menu=='nastar') return '#d4a373';
  if(menu=='nastar spesial') return '#c08457';
  if(menu=='kastengel') return '#e9c46a';
  if(menu=='putri salju') return '#e0e0e0';
  if(menu=='kue kacang') return '#bc6c25';
  if(menu=='choco chip') return '#6d4c41';
  if(menu=='brown sugar') return '#8d6e63';
  if(menu=='bolu pisang') return '#f4a261';
  if(menu=='nasi kuning') return '#fdd835';
  if(menu=='nasi box ayam panggang dada') return '#ef5350';
  if(menu=='nasi box ayam panggang paha') return '#ef5350';
  if(menu=='nasi box ayam goreng') return '#ff7043';

  return '#999';
}

const colors = labels.map(getColor);

/* ===== CHART ===== */
new Chart(document.getElementById('chart'),{
  type:'doughnut',
  data:{
    labels:labels,
    datasets:[{
      data:values,
      backgroundColor:colors
    }]
  },
  options:{
    cutout:'70%',
    plugins:{
      legend:{display:false}
    }
  }
});

function goDetail(){
  const periode = "<?= $periode ?>";
  window.location.href = `laporan2.php?periode=${periode}`;
}
</script>

</body>
</html>