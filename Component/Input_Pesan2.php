<?php
include 'Component/konek.php';

// insert pesanan
$conn->query("INSERT INTO pesanan (nama_produk, jumlah, waktu, tanggal, gambar, status)
VALUES ('$nama', '$jumlah', '$waktu', CURDATE(), '$gambar', 'diterima')");

// ambil id terakhir
$id_pesanan = $conn->insert_id;

// buat notifikasi ke dapur
$conn->query("INSERT INTO notifikasi (id_pesanan, judul, waktu)
VALUES ($id_pesanan, 'Ada pesanan baru', '$waktu')");
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bahan yang Diperlukan</title>

  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      margin: 0;
      background-color: #f5f5f5;
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
      font-size: 16px;
      font-weight: bold;
    }

    .card {
      background: white;
      border-radius: 12px;
      padding: 16px;
      border: 1px solid #ddd;
    }

    .form-group {
      margin-bottom: 14px;
    }

    label {
      display: block;
      font-size: 12px;
      margin-bottom: 5px;
      color: #333;
    }

    input, select {
      width: 100%;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 12px;
    }

    .checkbox-group {
      margin-top: 8px;
    }

    .checkbox-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 8px;
      font-size: 12px;
    }

    .checkbox-item input {
      margin-right: 8px;
      margin-top: 3px;
    }

    .checkbox-text {
      line-height: 1.3;
    }

    .tambah {
      text-align: center;
      font-size: 12px;
      margin: 10px 0;
      color: #333;
      cursor: pointer;
    }

    .row {
      display: flex;
      gap: 10px;
    }

    .row .form-group {
      flex: 1;
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
    <div class="back">←</div>
    <div class="title">BAHAN YANG DIPERLUKAN</div>
  </div>

  <div class="card">
    <div class="form-group">
      <label>Jumlah Pesanan</label>
      <input type="number" placeholder="Value">
    </div>

    <div class="form-group">
      <label>Bahan Yang diperlukan</label>

      <div class="checkbox-group">
        <div class="checkbox-item">
          <input type="checkbox">
          <div class="checkbox-text">
            Nama Bahan <br> Jumlah
          </div>
        </div>

        <div class="checkbox-item">
          <input type="checkbox">
          <div class="checkbox-text">
            Nama Bahan <br> Jumlah
          </div>
        </div>

        <div class="checkbox-item">
          <input type="checkbox">
          <div class="checkbox-text">
            Nama Bahan <br> Jumlah
          </div>
        </div>

        <div class="checkbox-item">
          <input type="checkbox">
          <div class="checkbox-text">
            Nama Bahan <br> Jumlah
          </div>
        </div>

        <div class="checkbox-item">
          <input type="checkbox">
          <div class="checkbox-text">
            Nama Bahan <br> Jumlah
          </div>
        </div>
      </div>

      <div class="tambah">Tambah</div>
    </div>

    <div class="row">
      <div class="form-group">
        <label>Packing</label>
        <select>
          <option>Value</option>
        </select>
      </div>

      <div class="form-group">
        <label>Takaran / packing</label>
        <select>
          <option>Value</option>
        </select>
      </div>
    </div>
  </div>

  <button class="btn">Save</button>
</div>

</body>
</html>

