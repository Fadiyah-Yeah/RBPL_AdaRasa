<?php
session_start();
require '../Component/konek.php';

/* DEFAULT */
$back = '../Pages/login.html';

/* CEK ROLE */
if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin'){
        $back = '../Pages/admin.php';
    }
    else if($_SESSION['role'] == 'dapur'){
        $back = 'dapur.php'; 
    }
    else if($_SESSION['role'] == 'pengantaran'){
        $back = 'antar.php';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan Akun</title>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">

<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    margin: 0;
    font-family: 'Aleo', serif;
    background: #ffffff;
    display: flex;
    justify-content: center;
}

/* MOBILE FRAME */
.container {
    width: 100%;
    max-width: 390px;
    padding: 20px;
}

/* HEADER */
.header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.back {
    font-size: 18px;
    color: black;
    text-decoration: none;
}

.title {
    font-size: 18px;
    font-weight: 600;
}

/* SECTION */
.section-title {
    margin-top: 25px;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 15px;
}

/* MENU */
.menu-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
}

.menu-left {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    color: black;
}

.icon {
    width: 22px;
    text-align: center;
}

.menu-text {
    font-size: 14px;
}

.arrow {
    color: #555;
}
</style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <a class="back" href="<?= $back ?>">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="title">Pengaturan Akun</div>
    </div>

    <!-- MENU -->
    <div class="menu-item">
        <a class="menu-left" href="../Component/ganti_UN.php">
            <div class="icon"><i class="fa-regular fa-user"></i></div>
            <div class="menu-text">Ganti Username</div>
        </a>
        <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
    </div>

    <div class="menu-item">
        <a class="menu-left" href="../Component/ganti_PW.php">
            <div class="icon"><i class="fa-solid fa-key"></i></div>
            <div class="menu-text">Ganti Password</div>
        </a>
        <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
    </div>

    <div class="menu-item">
        <a class="menu-left" href="../Component/ganti_Profil.php">
            <div class="icon"><i class="fa-regular fa-pen-to-square"></i></div>
            <div class="menu-text">Edit Profil</div>
        </a>
        <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
    </div>

    <a href="../Component/Logout.php" style="text-decoration:none; color:inherit;">
        <div class="menu-item">
            <div class="menu-left">
                <div class="icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                <div class="menu-text">Log Out</div>
            </div>
            <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
        </div>
    </a>

    <!-- INFO -->
    <div class="section-title">Info Lainnya</div>

    <div class="menu-item">
        <div class="menu-left">
            <div class="icon"><i class="fa-solid fa-circle-info"></i></div>
            <div class="menu-text">Tentang</div>
        </div>
        <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
    </div>

    <div class="menu-item">
        <div class="menu-left">
            <div class="icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="menu-text">Kebijakan Privasi</div>
        </div>
        <div class="arrow"><i class="fa-solid fa-chevron-right"></i></div>
    </div>

</div>

</body>
</html>