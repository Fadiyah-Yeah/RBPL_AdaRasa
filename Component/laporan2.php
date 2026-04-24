<?php
session_start();
require 'konek.php';

/* ===== AMBIL PERIODE ===== */
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

/* ===== PRODUK ===== */
$qProduk = $conn->query("
SELECT menu, SUM(jumlah) as total
FROM pemesanan
WHERE $filter
GROUP BY menu
");

/* ===== PELANGGAN ===== */
$qPelanggan = $conn->query("
SELECT nama_pelanggan, COUNT(*) as total_order
FROM pemesanan
WHERE $filter
GROUP BY nama_pelanggan
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<title>Detail</title>

<style>
*{box-sizing:border-box;font-family:'Aleo',serif;}

body{
  margin:0;
  background:#ffffff;
  display:flex;
  justify-content:center;
}

.container{
  width:100%;
  max-width:400px;
  padding:20px;
}

.header{
  display:flex;
  align-items:center;
  margin-bottom:15px;
}

.back{
  margin-right:10px;
  font-size:20px;
  cursor:pointer;
}

.title{
  font-weight:600;
  font-size:16px;
}

/* TOP BAR */
.top-bar{
  border:1px solid #333;
  border-radius:12px;
  padding:10px;
  margin-bottom:15px;
}

.label-row{
  display:flex;
  align-items:center;
  justify-content:space-between;
}

/* SORT */
.sort{
  cursor:pointer;
  font-size:12px;
}

/* TOGGLE */
.toggle{
  display:flex;
  border:1px solid #333;
  border-radius:20px;
  overflow:hidden;
}

.toggle div{
  padding:6px 15px;
  font-size:12px;
  cursor:pointer;
}

.active{
  background:#8BC34A;
  color:white;
}

/* LIST */
.list{
  display:flex;
  flex-direction:column;
  gap:12px;
}

.card{
  background:white;
  border:1px solid #333;
  border-radius:12px;
  padding:12px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.text{font-size:14px;}
.sub{font-size:12px;color:#555;}

.card img{
  width:60px;
  height:60px;
  border-radius:10px;
  object-fit:cover;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
  <div class="back" onclick="history.back()">
    <i class="fa-solid fa-arrow-left"></i>
  </div>
  <div class="title">Detail</div>
</div>

<div class="top-bar">
  <div class="label-row">
    <div class="sort" onclick="toggleSort()">
      <i class="fa-solid fa-sort"></i> Urutkan
    </div>

    <div class="toggle">
      <div id="tabProduk" class="active" onclick="showProduk()">Pesanan</div>
      <div id="tabPelanggan" onclick="showPelanggan()">Pelanggan</div>
    </div>
  </div>
</div>

<div class="list" id="list"></div>

</div>

<script>

/* ===== DATA ===== */
const produk = [
<?php while($p = $qProduk->fetch_assoc()): ?>
{
  nama:"<?= $p['menu'] ?>",
  total:<?= $p['total'] ?>,
  gambar:"<?= strtolower(str_replace(' ','_',$p['menu'])) ?>.jpg"
},
<?php endwhile; ?>
];

const pelanggan = [
<?php while($p = $qPelanggan->fetch_assoc()): ?>
{
  nama:"<?= $p['nama_pelanggan'] ?>",
  total:<?= $p['total_order'] ?>,
  gambar:"user.png"
},
<?php endwhile; ?>
];

let current = "produk";
let asc = false;

/* ===== RENDER ===== */
function render(){
  const container = document.getElementById('list');
  container.innerHTML='';

  let data = current === "produk" ? [...produk] : [...pelanggan];

  data.sort((a,b)=> asc ? a.total - b.total : b.total - a.total);

  data.forEach(item=>{
    container.innerHTML += `
    <div class="card">
      <div>
        <div class="text">${item.nama}</div>
        <div class="sub">${item.total} ${current==="produk"?"pesanan":"order"}</div>
      </div>
      <img src="../asset/${item.gambar}" onerror="this.src='../asset/default.png'">
    </div>
    `;
  });
}

/* ===== SWITCH ===== */
function showProduk(){
  current="produk";
  document.getElementById('tabProduk').classList.add('active');
  document.getElementById('tabPelanggan').classList.remove('active');
  render();
}

function showPelanggan(){
  current="pelanggan";
  document.getElementById('tabPelanggan').classList.add('active');
  document.getElementById('tabProduk').classList.remove('active');
  render();
}

/* ===== SORT ===== */
function toggleSort(){
  asc = !asc;
  render();
}

/* DEFAULT */
render();

</script>

</body>
</html>