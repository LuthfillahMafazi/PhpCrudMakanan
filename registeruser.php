<?php

// Memasukan koneksi.php ke dalam file ini agar nanti bisa mengakses phpmyadmin
include './config/koneksi.php';

// Membuat penampung response array
$response = array();

// Pengecekan metode yang di request oleh user, harus methos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Pengecekan parameter yang dibutuhkan
	if (isset($_POST["username"]) &&
	 isset($_POST["password"]) &&
	  isset($_POST["namauser"]) &&
	  isset($_POST["alamat"]) &&
	    isset($_POST["jenkel"]) &&
	    isset($_POST["notelp"]) && 
	    isset($_POST["level"])) {

		// Memasukan data yang sudah dikirim oleh user di dalam parameter ke variable penampung baru
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
		$namauser = $_POST["namauser"];
		$alamat = $_POST["alamat"];
		$jenkel = $_POST["jenkel"];
		$notelp = $_POST["notelp"];
		$level = $_POST["level"];

	//pengecekean dara username apakah sudah terpakai
	// Membuat query untuk mencari username yang sama di database
		$sql = "SELECT * FROM tb_user WHERE username = '$username'";

		$check = mysqli_fetch_array(mysqli_query($connection, $sql));

		// check data di dalam variable
		if (isset($check)) {
			// Membuat response untuk JSON
			$response["result"] = 0;
			$response["message"] = "Ups!, username sudah terpakai";
			# code...
		}else {
			// Memasukna inputan user ke dalam database menggunakan operasi INSERT
			$sql = "INSERT INTO tb_user(nama_user,alamat,jenkel, no_telp, username, password, level) VALUES(
			'$namauser', '$alamat', '$jenkel','$notelp','$username','$password','$level') ";

			// Melakukan operasi insert dengan perintah yang sudah kita biuat di dalam variable $sql
			// Dan Langsung cek apakah eksekusinya berhasil
			if (mysqli_query($connection, $sql)) {
				// Jika berhasil kirimkan pesan kepada response
				$response["result"] = 1;
				$response["message"] = "Register berhasil";
				# code...
			}else {
				// Jika gagae kirimkan pesan gagar ke response
				$response["result"] = 0;
				$response["message"] = "Register gagal";
			}
		}

		// Menampilkan response dalam gentuk Json
		echo json_encode($response);

	}
	
}

?>