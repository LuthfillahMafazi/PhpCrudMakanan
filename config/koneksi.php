<?php

// Menyiapkan variable yang dibutuhkan untuk koneksi ke database
$server = "localhost";
// jika username blum diapa2kan di phpmyadmin atau defaultnya adalah root
$username = "root";
$password = "";
$database = "makanan";

// Koneksikan dan memilih database uang kita inginkan
$connection = mysqli_connect($server, $username, $password, $database) or die ("Koneksi gagal");

?>