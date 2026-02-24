<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ganti Username</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        height: 100vh;
        background-color: #ffffff; 
    }

    .wrapper {
        max-width: 400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* Header */
    .header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 40px;
        color: #333;
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
        padding: 25px;
        border: 1px solid #000000;
        border-radius: 8px;
    }

    .card label {
        font-size: 14px;
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    .card input {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #000000;
        background-color: #ffffff;
        margin-bottom: 20px;
        outline: none;
        transition: 0.3s;
    }

    .card input:focus {
        background-color: #fff;
        border-color: #999;
    }

    .card button {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: none;
        background-color: #000000;
        color: #fff;
        cursor: pointer;
        transition: 0.3s;
    }

    .card button:hover {
        background-color: #959494;
    }
</style>

</head>
<body>

<div class="wrapper">

    <div class="header">
        <div class="back">&#8592;</div>
        <div class="title">Ganti Username</div>
    </div>

    <div class="card">
        <form>
            <label>Username</label>
            <input type="text" placeholder="Value">
            <button type="submit">Save</button>
        </form>
    </div>

</div>

</body>
</html>