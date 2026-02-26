<?php
session_start();
require 'functions.php';

function redirectByRole($role) {
    if ($role === "admin") {
        header("location: ../Pages/admin.html");
    } elseif ($role === "dapur") {
        header("location: ../Pages/dapur.html");
    } elseif ($role === "pengantaran") {
        header("location: ../Pages/antar.html");
    } else {
        header("location: ../Pages/not_found.html");
    }
    exit;
}

if (isset($_COOKIE['k']) && isset($_COOKIE['x'])) {

    $idUser = $_COOKIE['k'];
    $kodeUser = $_COOKIE['x'];

    $stmt = mysqli_prepare($conn, "SELECT username, role FROM user WHERE a = ?");
    mysqli_stmt_bind_param($stmt, "i", $idUser);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dataUser = mysqli_fetch_assoc($result);

    if ($dataUser && $kodeUser === hash('sha256', $dataUser['username'])) {
        $_SESSION['login'] = true;
        $_SESSION['role'] = $dataUser['role'];
        redirectByRole($dataUser['role']);
    }
}

if (isset($_SESSION["login"])) {
    redirectByRole($_SESSION['role']);
}

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email    = $_POST["email"];

    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 1) {

        $data = mysqli_fetch_assoc($result);

        if ($email === $data["email"]) {

            if (password_verify($password, $data["password"])) {

                $_SESSION["login"] = true;
                $_SESSION["role"]  = $data["role"];
                $_SESSION["id"]    = $data["a"];

                if (isset($_POST['remember'])) {
                    setcookie('k', $data['a'], time() + 60 * 60, "/", "", false, true);
                    setcookie('x', hash('sha256', $data['username']), time() + 60 * 60, "/", "", false, true);
                }

                redirectByRole($data['role']);
            }
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login UI</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #ffffff; 
    }

    .login-container {
        background: #ffffff;
        padding: 30px;
        width: 320px;
        border: 1px solid #000;
        border-radius: 8px;
    }

    .login-container label {
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin-bottom: 18px;
        border-radius: 6px;
        border: 1px solid #000000;
        background-color: #ffffff;
        outline: none;
        transition: 0.3s;
    }

    .login-container input:focus {
        border-color: #000;
        background-color: #fff;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background-color: #000;
        color: #fff;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
    }

    .login-container button:hover {
        background-color: #959494;
    }
</style>
</head>
<body>

<div class="login-container">
    <form>
        <label>Username</label>
        <input type="text" placeholder="Value">

        <label>Password</label>
        <input type="password" placeholder="Value">

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>