<?php 
	// Memasukan koneksi untuk menggunakan connection
include './config/koneksi.php';

// membuat penampung respinse
$response = array();

// kita cek method POST atau bukan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// kita cek paranmeter inputan user
if (isset($_POST["iduser"]) &&
	isset($_POST["namauser"]) &&
	isset($_POST["alamat"]) &&
	isset($_POST["jenkel"]) &&
	isset($_POST["notelp"])) {
		// Memasukan inputan user ke dalam variable
	$iduser = $_POST["iduser"];
	$namauser = $_POST["namauser"];
	$alamat = $_POST["alamat"];
	$jenkel = $_POST["jenkel"];
	$notelp = $_POST["notelp"];

	// Membuat query untuk mengupdate data ke database
	$query = "UPDATE tb_user SET nama_user = '$namauser', alamat = '$alamat', jenkel = '$jenkel', no_telp = '$notelp' WHERE id_user = '$iduser'";

	// Mengeksekusi query yang sudah di buat dan langsung mencek apakah berhasil atau tidak
	if (mysqli_query($connection, $query)) {
		// Apabila berhasil hita tampilkan response berhasil
		$response["result"] = 1;
		$response["message"] = "update berhasil";
	}else {
		// Menampilkan pesan gagal
		$response["result"] = 0;
		$response["message"] = "update gagal";
	}
	// Merubah respinse menhadi Json
	echo json_encode($response);
	}
}
 ?>