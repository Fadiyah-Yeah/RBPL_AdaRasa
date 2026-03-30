<?php
include 'Component/konek.php';

$query = $conn->query("
SELECT n.*, p.nama_produk, p.jumlah 
FROM notifikasi n
JOIN pesanan p ON n.id_pesanan = p.id
ORDER BY n.id DESC
");

$data = [];

while($row = $query->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>

<?php
include 'Component/konek.php';

$id = $_POST['id'];

$conn->query("UPDATE notifikasi SET status='read' WHERE id=$id");

echo "ok";
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

.title {
  text-align: center;
  font-weight: bold;
  margin-bottom: 20px;
}

.card {
  background: white;
  border: 1px solid #333;
  border-radius: 10px;
  padding: 10px;
  margin-bottom: 10px;
  cursor: pointer;
}

.unread {
  font-weight: bold;
}

.time {
  float: right;
  font-size: 11px;
  color: #555;
}
</style>
</head>

<body>

<div class="container">
  <div class="title">Notifikasi</div>

  <div id="notifList"></div>
</div>

<script>
fetch('get_notifikasi.php')
.then(res=>res.json())
.then(data=>{
  const container = document.getElementById('notifList');

  data.forEach(item=>{
    container.innerHTML += `
      <div class="card ${item.status === 'unread' ? 'unread' : ''}"
           onclick="openPesanan(${item.id}, ${item.id_pesanan})">
        <div>Ada pesanan baru</div>
        <div>${item.nama_produk}</div>
        <div>${item.jumlah}</div>
        <div class="time">${item.waktu}</div>
      </div>
    `;
  });
});

function openPesanan(id_notif, id_pesanan){

  // tandai sudah dibaca
  fetch('read_notif.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:`id=${id_notif}`
  });

  // redirect ke halaman pesanan + fokus ke item
  window.location.href = `pesanan.html?highlight=${id_pesanan}`;
}
</script>

</body>
</html>