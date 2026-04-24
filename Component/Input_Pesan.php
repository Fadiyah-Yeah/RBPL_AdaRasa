<?php
session_start();
require 'konek.php';

if(isset($_POST['submit'])){

    $nama = $_POST['nama_pelanggan'];
    $menu = $_POST['menu'];
    $jumlah = $_POST['jumlah'];

    $tgl_pesan = $_POST['thn_pesan']."-".$_POST['bln_pesan']."-".$_POST['tgl_pesan'];
    $tgl_kirim = $_POST['thn_kirim']."-".$_POST['bln_kirim']."-".$_POST['tgl_kirim'];

    $pengiriman = $_POST['pengiriman'];
    $tambahan = $_POST['tambahan'];

    mysqli_query($conn, "INSERT INTO pemesanan 
    (nama_pelanggan, menu, jumlah, tanggal_pesan, tanggal_kirim, metode_pengiriman, tambahan)
    VALUES 
    ('$nama','$menu','$jumlah','$tgl_pesan','$tgl_kirim','$pengiriman','$tambahan')
    ");

    if(mysqli_affected_rows($conn) > 0){

        // ambil id pesanan terakhir
        $id = mysqli_insert_id($conn);

        // 🔥 TAMBAHKAN INI (NOTIFIKASI)
        mysqli_query($conn, "INSERT INTO notifikasi (id_pemesanan) 
        VALUES ('$id')");

        // simpan ke session
        $_SESSION['id_pemesanan'] = $id;
        $_SESSION['jumlah'] = $jumlah;

        header("Location: input_Pesan2.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Input Pemesanan</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      margin: 0;
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
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
      font-size: 20px;
      margin-right: 10px;
      cursor: pointer;
    }

    .title {
      font-size: 18px;
      font-weight: bold;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 16px;
      border: 1px solid #ddd;
    }

    .form-group {
      margin-bottom: 12px;
    }

    label {
      display: block;
      font-size: 12px;
      margin-bottom: 5px;
      color: #333;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 12px;
    }

    .date-group {
      display: flex;
      gap: 8px;
    }

    .date-group input {
      flex: 1;
      text-align: center;
    }

    textarea {
      resize: none;
      height: 60px;
    }

    .btn {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #333;
      background: white;
      cursor: pointer;
      font-size: 14px;
    }

    .btn:hover {
      background: #eee;
    }

    @media (max-width: 480px) {
      .container {
        padding: 15px;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="header">
      <a class="back" href="../Pages/admin.php">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
      <div class="title">INPUT PEMESANAN</div>
    </div>

    <form method="POST">

      <div class="card">

        <div class="form-group">
          <label>Nama Pelanggan</label>
          <input type="text" name="nama_pelanggan" placeholder="Value" required>
        </div>

        <div class="form-group">
          <label>Pesan Apa</label>
          <select name="menu" required>
            <option value="">Pilih Menu</option>
            <option value="Nastar">Nastar</option>
            <option value="Nastar Spesial">Nastar Spesial</option>
            <option value="Kastengel">Kastengel</option>
            <option value="Putri Salju">Putri Salju</option>
            <option value="Kue Kacang">Kue Kacang</option>
            <option value="Choco Chip">Choco Chip</option>
            <option value="Brown Sugar">Brown Sugar</option>
            <option value="Bolu Pisang">Bolu Pisang</option>
            <option value="Nasi Box Ayam Panggang Dada">Nasi Box Ayam Panggang Dada</option>
            <option value="Nasi Box Ayam Panggang Paha">Nasi Box Ayam Panggang Paha</option>
            <option value="Nasi Box Ayam Goreng">Nasi Box Ayam Goreng</option>
            <option value="Nasi Kuning">Nasi Kuning</option>
          </select>
        </div>

        <div class="form-group">
          <label>Jumlah</label>
          <input type="number" name="jumlah" placeholder="Value" required>
        </div>

        <div class="form-group">
          <label>Tanggal Pemesanan</label>
          <div class="date-group">
            <input type="text" name="tgl_pesan" placeholder="DD" required>
            <input type="text" name="bln_pesan" placeholder="MM" required>
            <input type="text" name="thn_pesan" placeholder="YYYY" required>
          </div>
        </div>

        <div class="form-group">
          <label>Pengiriman</label>
          <select name="pengiriman" required>
            <option value="">Pilih Metode</option>
            <option value="Ambil Sendiri">Ambil Sendiri</option>
            <option value="Jasa Kirim Internal">Jasa Kirim Internal</option>
            <option value="Kurir Eksternal">Kurir Eksternal</option>
          </select>
        </div>

        <div class="form-group">
          <label>Tanggal Pengiriman</label>
          <div class="date-group">
            <input type="text" name="tgl_kirim" placeholder="DD" required>
            <input type="text" name="bln_kirim" placeholder="MM" required>
            <input type="text" name="thn_kirim" placeholder="YYYY" required>
          </div>
        </div>

        <div class="form-group">
          <label>Tambahan</label>
          <textarea name="tambahan" placeholder="Value"></textarea>
        </div>

      </div>

      <button class="btn" type="submit" name="submit">Next</button>

    </form>

  </div>

</body>

</html>