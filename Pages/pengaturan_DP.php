<?php
include 'Component/konek.php';

// contoh ambil user dapur (bisa pakai session nanti)
$query = $conn->query("SELECT * FROM users WHERE role='dapur' LIMIT 1");
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

.title {
  text-align: center;
  font-weight: bold;
  margin-bottom: 20px;
}

/* PROFILE CARD */
.profile {
  background: white;
  border: 1px solid #333;
  border-radius: 10px;
  padding: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 20px;
}

.profile-icon {
  width: 50px;
  height: 50px;
  border: 2px solid black;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
}

/* SECTION */
.section-title {
  font-size: 13px;
  margin-bottom: 10px;
}

.menu {
  background: white;
  border-radius: 10px;
  padding: 10px;
}

.menu-item {
  display: flex;
  justify-content: space-between;
  padding: 10px 5px;
  border-bottom: 1px solid #ddd;
  cursor: pointer;
  font-size: 13px;
}

.menu-item:last-child {
  border-bottom: none;
}

.menu-item:hover {
  background: #eee;
}
</style>
</head>

<body>

<div class="container">
  <div class="title">Akun</div>

  <div class="profile">
    <div class="profile-icon">👤</div>
    <div id="username">Loading...</div>
  </div>

  <div class="section-title">Pengaturan Akun</div>
  <div class="menu">
    <div class="menu-item" onclick="go('username')">Ganti Username <span>›</span></div>
    <div class="menu-item" onclick="go('password')">Ganti Password <span>›</span></div>
    <div class="menu-item" onclick="go('edit')">Edit Profil <span>›</span></div>
    <div class="menu-item" onclick="logout()">Log Out <span>›</span></div>
  </div>

  <div class="section-title" style="margin-top:20px;">Info Lainnya</div>
  <div class="menu">
    <div class="menu-item">Tentang Aplikasi <span>›</span></div>
    <div class="menu-item">Kebijakan Privasi <span>›</span></div>
  </div>
</div>

<script>
// ambil data user
fetch('get_user.php')
.then(res => res.json())
.then(data => {
  document.getElementById('username').innerText = data.username;
});

// navigasi
function go(type){
  if(type === 'username'){
    alert("Halaman ganti username");
  }
  if(type === 'password'){
    alert("Halaman ganti password");
  }
  if(type === 'edit'){
    alert("Halaman edit profil");
  }
}

// logout
function logout(){
  alert("Logout berhasil");
  window.location.href = "login.html";
}
</script>

</body>
</html>