<?php
session_start();
require 'konek.php';

if (!isset($_SESSION['id_pemesanan']) || !isset($_SESSION['jumlah'])) {
  header("Location: input_pesan.php");
  exit;
}

$id_pemesanan = $_SESSION['id_pemesanan'];
$jumlah = $_SESSION['jumlah'];

$bahan = mysqli_query($conn, "SELECT id, nama_bahan, jumlah FROM bahan_baku");

if (isset($_POST['submit'])) {

  $bahan_lama = $_POST['bahan'] ?? [];
  $bahan_baru = $_POST['bahan_baru'] ?? [];
  $jumlah_baru = $_POST['jumlah_baru'] ?? [];

  $gabung = [];

  /* ===== FITUR LAMA ===== */
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

  /* ===== RELASI ===== */
  foreach ($bahan_lama as $nama) {
    $nama = strtolower(trim($nama));

    $cek = $conn->query("SELECT id FROM bahan_baku WHERE LOWER(nama_bahan)='$nama'");
    if ($data = $cek->fetch_assoc()) {
      $conn->query("INSERT INTO detail_bahan_pemesanan 
      (id_pemesanan, id_bahan, jumlah)
      VALUES ('$id_pemesanan', '{$data['id']}', '$jumlah')");
    }
  }

  for ($i = 0; $i < count($bahan_baru); $i++) {
    if ($bahan_baru[$i] != "") {

      $nama = strtolower(trim($bahan_baru[$i]));
      $jml  = $jumlah_baru[$i] ?: 0;

      $cek = $conn->query("SELECT id FROM bahan_baku WHERE LOWER(nama_bahan)='$nama'");
      if ($cek->num_rows == 0) {
        $conn->query("INSERT INTO bahan_baku (nama_bahan, jumlah) VALUES ('$nama',0)");
      }

      $get = $conn->query("SELECT id FROM bahan_baku WHERE LOWER(nama_bahan)='$nama'");
      $data = $get->fetch_assoc();

      $conn->query("INSERT INTO detail_bahan_pemesanan 
      (id_pemesanan, id_bahan, jumlah)
      VALUES ('$id_pemesanan', '{$data['id']}', '$jml')");
    }
  }

  header("Location: ../Pages/admin.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<title>Bahan</title>

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
  max-width:390px;
  padding:20px;
}

.header{
  display:flex;
  align-items:center;
  margin-bottom:20px;
}

.back{font-size:20px;margin-right:10px;}
.title{font-weight:600;}

.card{
  background:white;
  border:1px solid #333;
  border-radius:14px;
  padding:16px;
}

.form-group{margin-bottom:16px;}

label{font-size:13px;margin-bottom:6px;display:block;}

input,select{
  width:100%;
  padding:10px;
  border-radius:10px;
  border:1px solid #ccc;
  font-size:13px;
}

/* CHECKBOX */
.checkbox-item{
  display:flex;
  align-items:center;
  gap:12px;
  margin-bottom:12px;
}

.checkbox-item input[type="checkbox"]{
  appearance:none;
  width:16px;
  height:16px;
  border:2px solid #999;
  border-radius:50%;
  cursor:pointer;
}

.checkbox-item input[type="checkbox"]:checked{
  background:#000;
}

.info{flex:1;}

.nama{font-size:14px;}
.jumlah{font-size:12px;color:#777;}

/* INPUT BARU */
.input-nama{flex:1;}
.input-jumlah{width:60px;}

/* HAPUS */
.hapus{
  background:none;
  border:none;
  cursor:pointer;
  font-size:16px;
  color:#888;
}
.hapus:hover{color:red;}

.tambah{
  text-align:center;
  font-size:13px;
  cursor:pointer;
}

/* ROW */
.row{display:flex;gap:10px;}
.row .form-group{flex:1;}

.btn{
  margin-top:25px;
  width:100%;
  padding:12px;
  border-radius:25px;
  border:1px solid #333;
  background:white;
}

.btn:hover{
  background:#333;
  color:white;
  transition:0.3s;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
<a href="../Pages/admin.php" class="back">
<i class="fa-solid fa-arrow-left"></i>
</a>
<div class="title">BAHAN YANG DIPERLUKAN</div>
</div>

<form method="POST">

<div class="card">

<div class="form-group">
<label>Jumlah Pesanan</label>
<input type="number" value="<?= $jumlah ?>" readonly>
</div>

<div class="form-group">
<label>Bahan</label>

<div id="bahanContainer">

<?php while($b = mysqli_fetch_assoc($bahan)): ?>
<div class="checkbox-item">
  <input type="checkbox" name="bahan[]" value="<?= $b['nama_bahan'] ?>">

  <div class="info">
    <div class="nama"><?= $b['nama_bahan'] ?></div>
    <div class="jumlah"><?= $b['jumlah'] ?></div>
  </div>
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
<select name="takaran" id="takaran" disabled>
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
function tambahBahan(){
  let div = document.createElement("div");
  div.className = "checkbox-item";

  div.innerHTML = `
    <div class="bahan-row">
      <input type="checkbox" checked>

      <input type="text" name="bahan_baru[]" placeholder="Nama bahan" class="input-nama">

      <input type="number" name="jumlah_baru[]" placeholder="0" class="input-jumlah">

      <button type="button" class="hapus" onclick="hapusBahan(this)">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  `;

  document.getElementById("bahanContainer").appendChild(div);
}

function hapusBahan(el){
  el.parentElement.remove();
}

document.getElementById("packing").addEventListener("change",function(){
  let val=this.value.toLowerCase();
  let takaran=document.getElementById("takaran");

  if(val.includes("toples")){
    takaran.disabled=false;
  }else{
    takaran.value="";
    takaran.disabled=true;
  }
});
</script>

</body>
</html>