<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Aleo:wght@300;400;600;700&display=swap" rel="stylesheet">
<title>Input Bahan Baku</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Aleo', serif;
}

body {
    background-color: #ffffff;
    display: flex;
    justify-content: center;
}

.mobile-container {
    width: 100%;
    max-width: 390px;
    padding: 20px;
}

/* Header */
.header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
}

.back {
    font-size: 22px;
    cursor: pointer;
    color: #000000;
    text-decoration: none;
}

.title {
    flex: 1;
    text-align: center;
    font-weight: 600;
    letter-spacing: 1px;
}

/* Card */
.card {
    background: #ffffff;
    border: 1px solid #000;
    border-radius: 10px;
    padding: 18px;
}

label {
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
}

input, select {
    width: 100%;
    padding: 8px 10px;
    border-radius: 7px;
    border: 1px solid #ccc;
    background: #ffffff;
    margin-bottom: 14px;
    font-size: 13px;
    outline: none;
}

/* Row 2 column */
.row {
    display: flex;
    gap: 10px;
}

.row .col {
    flex: 1;
}

/* Tanggal */
.date-row {
    display: flex;
    gap: 8px;
}

.date-row input {
    flex: 1;
    text-align: center;
}

/* Button outside card */
.btn-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 25px;
}

.btn {
    padding: 8px 40px;
    border-radius: 20px;
    border: 1px solid #000;
    background: #ffffff;
    cursor: pointer;
    font-size: 14px;
    transition: 0.2s;
}

.btn:hover {
    background: #ddd;
}
</style>
</head>

<body>

<div class="mobile-container">

    <div class="header">
        <a class="back" href="../Pages/admin.html">&#8592;</a>
        <div class="title">INPUT BAHAN BAKU</div>
    </div>

    <div class="card">
        <form>

            <label>Nama bahan</label>
            <input type="text" placeholder="Value">

            <label>Untuk bahan baku apa</label>
            <select>
                <option>Value</option>
            </select>

            <div class="row">
                <div class="col">
                    <label>Jumlah</label>
                    <input type="text" placeholder="Value">
                </div>
                <div class="col">
                    <label>Brp kali pakai</label>
                    <input type="text" placeholder="Value">
                </div>
            </div>

            <label>Tanggal Beli</label>
            <div class="date-row">
                <input type="text" placeholder="DD">
                <input type="text" placeholder="MM">
                <input type="text" placeholder="YYYY">
            </div>

            <label>Nama Vendor</label>
            <input type="text" placeholder="Value">

            <label>Alamat Vendor</label>
            <input type="text" placeholder="Value">

            <div class="row">
                <div class="col">
                    <label>Total harga</label>
                    <input type="text" placeholder="Value">
                </div>
                <div class="col">
                    <label>Harga satuan</label>
                    <input type="text" placeholder="Value">
                </div>
            </div>

        </form>
    </div>

    <div class="btn-wrapper">
        <button class="btn">Tambahkan</button>
    </div>

</div>

</body>
</html>