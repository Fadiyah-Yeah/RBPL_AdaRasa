<?php
include "konek.php";
session_start();

if(isset($_COOKIE['id']) && isset($_COOKIE['username'])){
    $id = $_COOKIE['id'];
    $username = $_COOKIE['username'];

    $result = mysqli_query($konek, "SELECT * FROM users WHERE id = '$id'");
    $_row = mysqli_fetch_assoc($result);

    if($username === hash('sha256', $row['username']) ){
        $_SESSION['login'] = true;
    }
}

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) == 1){ 
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;

            if(isset($_POST["login"])){
                setcookie('id', $row['id'], time()+120);
                setcookie('username',hash('sha256', $row['username']), time()+120);
            }
            header("Location: Admin.php");
            exit;
        };
    }

    echo "<script>
    alert('username/password salah mint')
</script>";
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