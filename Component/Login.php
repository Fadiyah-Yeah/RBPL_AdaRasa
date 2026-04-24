<?php
session_start();

require 'konek.php';

// cek apakah ada cookie
if (isset($_COOKIE['k']) && isset($_COOKIE['x'])) {
    $a = $_COOKIE['k'];
    $x = $_COOKIE['x'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE a = $a");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($x === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

// cek apakah sudah login ga usah balik ke login
if (isset($_SESSION["login"])) {
    if ($_SESSION['role'] == 'admin') {
        header("location:../Pages/admin.html");
    } else if ($_SESSION['role'] == 'dapur') {
        header("location:../Pages/dapur.php");
    } else if ($_SESSION['role'] == 'pengantaran') {
        header("location:../Pages/antar.php");
    }
}

// cek apakah tombol login sudah diklik
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users 
    WHERE username = '$username'");

    // cek apakah username ada di database
    // menghitung ada berapa baris dari fungsi select
    // jika ada maka bernilai 1, jika tidak ada maka 0
    if (mysqli_num_rows($result) === 1) {
        
        $row = mysqli_fetch_assoc($result); // dalam row akan sudah ada datanya
        if ($username === $row["username"]) {
            // cek string sama atau tidak dengan hash nya
            if (password_verify($password, $row["password"])) {
                // set session
                $_SESSION["login"] = true;
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username']; 

                if ($row['role'] == 'admin') {
                    header("location:../Pages/admin.html");
                } else if ($row['role'] == 'dapur') {
                    header("location:../Pages/dapur.html");
                } else if ($row['role'] == 'pengantaran') {
                    header("location:../Pages/antar.html");
                }
                exit;

                // cek cookies remember me
                if (isset($_POST['remember'])) {
                    setcookie('k', $row['a'], time() + 60 * 60);
                    setcookie('x', hash('sha256', $row['username']), time() + 60 * 60);
                }
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
<title>Login</title>

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
    background-color: #f5f5f5;
}

.login-container {
    background: #ffffff;
    padding: 30px;
    width: 320px;
    border: 1px solid #ddd;
    border-radius: 8px;
}

.login-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.login-container label {
    font-size: 14px;
    margin-bottom: 6px;
    display: block;
}

.login-container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 18px;
    border-radius: 6px;
    border: 1px solid #ccc;
    outline: none;
}

.login-container input:focus {
    border-color: #000;
}

.login-container button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 6px;
    background-color: #000;
    color: #fff;
    cursor: pointer;
}

.login-container button:hover {
    background-color: #444;
}

.error {
    color: red;
    margin-bottom: 15px;
    font-size: 14px;
    text-align: center;
}
</style>
</head>

<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if (isset($error)) : ?>
        <div class="error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</div>

</body>
</html>