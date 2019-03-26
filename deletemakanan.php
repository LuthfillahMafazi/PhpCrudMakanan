<?php 
header("Content-Type: application/json; charset=UTF-8");
	// Memasukan koneksi untuk menggunakan connection
include './config/koneksi.php';

// membuat penampung respinse
$response = array();

// kita cek method POST atau bukan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// kita cek paranmeter inputan user
if (isset($_POST["idmakanan"]) &&
	isset($_POST["fotomakanan"])) {

	// Memasukan inputan user ke dalam variable
	$idmakanan = $_POST["idmakanan"];
	$fotomakanan = $_POST["fotomakanan"];

	// membuat query untuk delete data
	$query = "DELETE FROM tb_makanan WHERE id_makanan = '$idmakanan'";
	// Mengeksekusi query delete dan langsung mengecek apakah berhasil atau tidak
	if (mysqli_query($connection, $query)) {
		// mengisi respon dengan pesan berhasil			// Menghapus image sebelumnya
		unlink("./uploads/" . $fotomakanan);

		$response['result'] = 1;
		$response['message'] = "Data makanan berhasil di hapus";
	}else {
		// apabila gagal maka melakukan query gagal
		$response['result'] = 0;
		$response['message'] = "Maaf! menghapus data gagal";
	}

	}else {
		$response['result'] = 0;
		$response['message'] = "Data kurang";
	}
	// merubah response menjadi Json
	echo json_encode($response);

	mysqli_close($connection);
}
?>