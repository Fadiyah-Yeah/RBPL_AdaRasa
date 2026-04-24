<?php
session_start();
require '../Component/konek.php';

/* ===== API MODE ===== */
if(isset($_GET['action'])){

  // 🔹 STEP 3 → AMBIL DATA
  if($_GET['action']=='get'){
    $q = $conn->query("
      SELECT n.id, n.status, n.waktu,
             n.id_pemesanan,
             p.menu, p.jumlah 
      FROM notifikasi n
      JOIN pemesanan p 
      ON n.id_pemesanan = p.id_pemesanan
      ORDER BY n.id DESC
    ");

    $data=[];
    while($r=$q->fetch_assoc()){
      $data[]=$r;
    }

    echo json_encode($data);
    exit;
  }

  // 🔥 STEP 4 → TARUH DI SINI
  if($_GET['action']=='read'){
    $id = $_POST['id'] ?? 0;

    $conn->query("UPDATE notifikasi 
                  SET status='read' 
                  WHERE id=$id");

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

<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
  margin:0;
  font-family: Arial;
  background:#ffffff;
  display:flex;
  justify-content:center;
}

/* FRAME MOBILE */
.app{
  width:100%;
  max-width:390px;
  min-height:100vh;
  position:relative;
}

/* CONTENT */
.container{
  padding:20px;
  padding-bottom:90px;
}

/* TITLE */
.title{
  text-align:center;
  font-size:20px;
  font-weight:600;
  margin-bottom:25px;
}

/* CARD */
.card{
  background:#f1f1f1;
  border:1px solid #ccc;
  border-radius:10px;
  padding:12px;
  margin-bottom:15px;
  cursor:pointer;
  box-shadow:0 2px 4px rgba(0,0,0,0.1);
}

/* UNREAD */
.unread{
  background:#ffffff;
  font-weight:600;
}

/* TEXT */
.judul{
  font-size:14px;
  margin-bottom:5px;
}

.menu{
  font-size:15px;
  margin-bottom:3px;
}

.jumlah{
  font-size:13px;
  color:#444;
}

/* TIME */
.time{
  text-align:right;
  font-size:12px;
  color:#777;
  margin-top:5px;
}

/* NAVBAR */
.navbar{
  position:fixed;
  bottom:0;
  width:100%;
  max-width:390px;
  background:white;
  border-top:1px solid #ddd;
  border-radius:18px 18px 0 0;
  display:flex;
  justify-content:space-around;
  padding:12px 0;
}

.nav-item{
  text-align:center;
  color:#888;
}

.nav-item.active{
  color:black;
}

.nav-item i{
  font-size:20px;
}
</style>
</head>

<body>

<div class="app">

<div class="container">

<div class="title">Notifikasi</div>

<div id="notifList"></div>

</div>

<!-- NAVBAR -->
<div class="navbar">
  <div class="nav-item active" onclick="go('dapur.php')">
    <i class="fa-regular fa-bell"></i>
  </div>
  <div class="nav-item" onclick="go('../Component/pesanan_dapur.php')">
    <i class="fa-regular fa-clipboard"></i>
  </div>
  <div class="nav-item" onclick="go('../Pages/Pengaturan.php')">
    <i class="fa-regular fa-user"></i>
  </div>
</div>

</div>

<script>

function go(page){
  window.location.href = page;
}

fetch('dapur.php?action=get')
.then(res=>res.json())
.then(data=>{

  const container=document.getElementById('notifList');
  container.innerHTML='';

  data.forEach(item=>{

    let waktu = item.waktu;

    container.innerHTML += `
      <div class="card ${item.status==='unread'?'unread':''}" 
           onclick="openPesanan(${item.id}, ${item.id_pesanan})">

        <div class="judul">Ada pesanan baru!</div>
        <div class="menu">${item.menu}</div>
        <div class="jumlah">${item.jumlah}</div>
        <div class="time">${waktu}</div>

      </div>
    `;
  });

});

function openPesanan(id_notif, id_pesanan){

  fetch('dapur.php?action=read',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:`id=${id_notif}`
  });

  window.location.href = `pesanan_dapur.php?highlight=${id_pesanan}`;
}
</script>

</body>
</html>