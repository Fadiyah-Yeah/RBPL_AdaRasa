<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ganti Profil</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
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
    margin-bottom: 30px;
}

.back {
    font-size: 22px;
    cursor: pointer;
}

.title {
    font-size: 18px;
    font-weight: 500;
}

/* Card */
.card {
    background: #fff;
    border: 1px solid #000000;
    border-radius: 10px;
    padding: 20px;
}

label {
    font-size: 13px;
    margin-bottom: 6px;
    display: block;
    color: #333;
}

input, textarea {
    width: 100%;
    padding: 9px 10px;
    border-radius: 7px;
    border: 1px solid #000000;
    background-color: #ffffff;
    margin-bottom: 16px;
    font-size: 13px;
    outline: none;
    transition: 0.2s;
}

input:focus, textarea:focus {
    background-color: #fff;
    border-color: #999;
}

textarea {
    resize: none;
    height: 70px;
}

/* Button */
button {
    width: 100%;
    padding: 10px;
    border-radius: 7px;
    border: none;
    background-color: #2f2f2f;
    color: #fff;
    font-size: 14px;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    background-color: #959494;
}
</style>
</head>

<body>

<div class="mobile-container">

    <div class="header">
        <div class="back">&#8592;</div>
        <div class="title">Ganti Profil</div>
    </div>

    <div class="card">
        <form>

            <label>Nama Depan</label>
            <input type="text" placeholder="Value">

            <label>Nama Belakang</label>
            <input type="text" placeholder="Value">

            <label>Email</label>
            <input type="email" placeholder="Value">

            <label>Foto Profil</label>
            <textarea placeholder="Value"></textarea>

            <button type="submit">Save</button>

        </form>
    </div>

</div>

</body>
</html>