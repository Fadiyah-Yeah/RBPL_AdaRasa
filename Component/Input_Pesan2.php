<?php
session_start();
require 'konek.php';

if (!isset($_SESSION['id_pemesanan']) || !isset($_SESSION['jumlah'])) {
  header("Location: input_pesan.php");
  exit;
}

$id_pemesanan = $_SESSION['id_pemesanan'];
$jumlah = $_SESSION['jumlah'];

$bahan = mysqli_query($conn, "
    SELECT nama_bahan, SUM(jumlah) as jumlah 
    FROM bahan_baku 
    GROUP BY nama_bahan
");

if (isset($_POST['submit'])) {

  $bahan_lama = $_POST['bahan'] ?? [];
  $bahan_baru = $_POST['bahan_baru'] ?? [];
  $jumlah_baru = $_POST['jumlah_baru'] ?? [];

  $gabung = [];

  foreach ($bahan_lama as $b) {
    $gabung[] = $b;
  }

  for ($i = 0; $i < count($bahan_baru); $i++) {
    if ($bahan_baru[$i] != "") {
      $gabung[] = $bahan_baru[$i] . " (" . $jumlah_baru[$i] . ")";
    }
  }

  $bahan_pilih = implode(", ", $gabung);

  $packing = $_POST['packing'];
  $takaran = $_POST['takaran'];

  mysqli_query($conn, "INSERT INTO detail_pemesanan 
    (id_pemesanan, jumlah_pesanan, bahan, packing, takaran)
    VALUES 
    ('$id_pemesanan','$jumlah','$bahan_pilih','$packing','$takaran')
    ");
}
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
      font-size: 16px;
      font-weight: bold;
    }

    .card {
      background: #ffffff;
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

    input,
    select {
      width: 100%;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 12px;
    }

    /*FIX CHECKBOX*/
    .checkbox-item {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px;
    }

    .nama {
      flex: 1;
    }

    .jumlah {
      min-width: 40px;
      text-align: right;
    }

    /*INPUT TAMBAHAN*/
    .input-baru {
      display: flex;
      gap: 10px;
      margin-top: 5px;
    }

    .input-nama {
      flex: 1;
    }

    .input-jumlah {
      width: 60px;
    }

    /*TAMBAH*/
    .tambah {
      text-align: center;
      font-size: 12px;
      margin-top: 10px;
      color: #333;
      cursor: pointer;
    }

    /*ROW*/
    .row {
      display: flex;
      gap: 10px;
    }

    .row .form-group {
      flex: 1;
    }

    /*BUTTON*/
    .btn {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #333;
      background: #ffffff;
      cursor: pointer;
      font-size: 14px;
    }

    .btn:hover {
      background: #eee;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="header">
      <a class="back" href="Input_Pesan.php">&#8592;</a>
      <div class="title">BAHAN YANG DIPERLUKAN</div>
    </div>

    <form method="POST">

      <div class="card">

        <div class="form-group">
          <label>Jumlah Pesanan</label>
          <input type="number" value="<?= $jumlah ?>" readonly>
        </div>

        <div class="form-group">
          <label>Bahan Yang diperlukan</label>

          <div id="bahanContainer">

            <?php while ($b = mysqli_fetch_assoc($bahan)) : ?>
              <div class="checkbox-item">
                <input type="checkbox" name="bahan[]" value="<?= $b['nama_bahan']; ?>">
                <span class="nama"><?= $b['nama_bahan']; ?></span>
                <span class="jumlah"><?= $b['jumlah'] * $jumlah; ?></span>
              </div>
            <?php endwhile; ?>

          </div>

          <div class="tambah" onclick="tambahBahan()">+ Tambah Bahan</div>

        </div>

        <div class="row">
          <div class="form-group">
            <label>Packing</label>
            <select name="packing" id="packing">
              <option value="">Value</option>
              <option>Toples Kotak</option>
              <option>Toples Bulat</option>
              <option>Toples Tabung</option>
              <option>Kotak Kardus</option>
              <option>Rice Bowl</option>
            </select>
          </div>

          <div class="form-group">
            <label>Takaran / packing</label>
            <select name="takaran" id="takaran">
              <option value="">Value</option>
              <option>250 gr</option>
              <option>500 gr</option>
              <option>800 gr</option>
              <option>1000 gr</option>
            </select>
          </div>
        </div>

      </div>

      <button class="btn" name="submit">Save</button>

    </form>
  </div>

  <script>
    function tambahBahan() {
      let container = document.getElementById("bahanContainer");

      let div = document.createElement("div");
      div.className = "checkbox-item";

      div.innerHTML = `
    <input type="checkbox" checked>
    <input type="text" name="bahan_baru[]" placeholder="Nama bahan" class="input-nama">
    <input type="number" name="jumlah_baru[]" placeholder="0" class="input-jumlah">
  `;

      container.appendChild(div);
    }

    // takaran logic
    document.getElementById("packing").addEventListener("change", function() {
      let val = this.value;
      let takaran = document.getElementById("takaran");

      if (val.includes("Toples")) {
        takaran.disabled = false;
      } else {
        takaran.value = "";
        takaran.disabled = true;
      }
    });
  </script>

</body>

</html>