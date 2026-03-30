<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Input Pemesanan</title>
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

    input, select, textarea {
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

    /* Responsive */
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
    <div class="title">INPUT PEMESANAN</div>
  </div>

  <div class="card">
    <div class="form-group">
      <label>Nama Pelanggan</label>
      <input type="text" placeholder="Value">
    </div>

    <div class="form-group">
      <label>Pesan Apa</label>
      <select>
        <option>Value</option>
      </select>
    </div>

    <div class="form-group">
      <label>Jumlah</label>
      <input type="number" placeholder="Value">
    </div>

    <div class="form-group">
      <label>Tanggal Pemesanan</label>
      <div class="date-group">
        <input type="text" placeholder="DD">
        <input type="text" placeholder="MM">
        <input type="text" placeholder="YYYY">
      </div>
    </div>

    <div class="form-group">
      <label>Pengiriman</label>
      <select>
        <option>Value</option>
      </select>
    </div>

    <div class="form-group">
      <label>Tanggal Pengiriman</label>
      <div class="date-group">
        <input type="text" placeholder="DD">
        <input type="text" placeholder="MM">
        <input type="text" placeholder="YYYY">
      </div>
    </div>

    <div class="form-group">
      <label>Tambahan</label>
      <textarea placeholder="Value"></textarea>
    </div>
  </div>

  <button class="btn">Next</button>
</div>

</body>
</html>