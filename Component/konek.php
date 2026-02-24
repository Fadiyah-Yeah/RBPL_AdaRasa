<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "";

$conn = mysqli_connect($host, $user, $pass, $db); 

if($conn->connect_error) {
die('Maaf koneksi gagal: ' . $conn->connect_error);
}
?>