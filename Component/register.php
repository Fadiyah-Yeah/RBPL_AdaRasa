<?php
include "konek.php";

if(isset($_POST["register"])) {

    $username  = strtolower(trim($_POST["username"]));
    $password  = $_POST["password"];
    $password2 = $_POST["password2"];
    $role      = $_POST["role"];

    if($password != $password2){
        echo "<script>alert('Konfirmasi password tidak sesuai');</script>";
    } else {

        // cek username sudah ada atau belum
        $cek = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
        if(mysqli_num_rows($cek) > 0){
            echo "<script>alert('Username sudah digunakan');</script>";
        } else {

            // hash password
            $password = password_hash($password, PASSWORD_DEFAULT);

            // insert ke database
            $query = "INSERT INTO users (username, password, role) 
                      VALUES ('$username', '$password', '$role')";
            $q = mysqli_query($conn, $query);

            if($q) {
                echo "<script>
                        alert('User berhasil ditambahkan');
                        window.location='login.php';
                      </script>";
            } else {
                echo "<script>alert('User gagal ditambahkan');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Akun</title>
</head>
<body>

<form method="post">
    <h1>Registrasi Akun</h1>

    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <label>Konfirmasi Password</label><br>
    <input type="password" name="password2" required><br><br>

    <label>Role</label><br>
    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="dapur">Dapur</option>
        <option value="pengantaran">Pengantaran</option>
    </select><br><br>

    <input type="submit" name="register" value="Register">
</form>

</body>
</html>