<?php 
header("Content-Type: application/json; charset=UTF-8");
	// Memasukan koneksi untuk menggunakan connection
include './config/koneksi.php';

// Membuat nama folder upload image
	$upload_path = 'uploads/';

	// Mengambil ip server
	$server_ip = gethostbyname(gethostname());

	// Membuat url upload
	$upload_url = 'http://'.$server_ip.'/makanan/'.$upload_path;

// membuat penampung respinse
$response = array();

// kita cek method POST atau bukan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// kita cek paranmeter inputan user
if (isset($_POST["idmakanan"]) &&
	isset($_POST["idkategori"]) &&
	isset($_POST["namamakanan"]) &&
	isset($_POST["descmakanan"]) &&
	isset($_POST["fotomakanan"]) &&
	isset($_POST["inserttime"])) {
		// Memasukan inputan user ke dalam variable
	$idmakanan = $_POST["idmakanan"];
	$idkategori = $_POST["idkategori"];
	$namamakanan = $_POST["namamakanan"];
	$descmakanan = $_POST["descmakanan"];
	$inserttime = $_POST["inserttime"];
	$fotomakanan = $_POST["fotomakanan"];
	$image = $_FILES["image"]['tmp_name'];

	if (isset($image)) {
		// Menghapus image sebelumnya
		unlink("./uploads/" . $fotomakanan);

		// Menghilangkan nama dan mengambil extention file
		$temp = explode(".", $_FILES["image"]["name"]);
		// menggabungkan nama baru dengan extention
		$newfilename = round(microtime(true)) . '.' . end($temp);
		// memasukan file ke dalam folder
		move_uploaded_file($image, $upload_path . $newfilename);
		// Memasukan inputan user ke dalam datanase menggunakan operasi INSERT
		$sql = "UPDATE tb_makanan SET id_kategori = '$idkategori', nama_makanan = '$namamakanan', desc_makanan = '$descmakanan', insert_time = '$inserttime', foto_makanan = '$newfilename' WHERE id_makanan = '$idmakanan'";
	}else {
		// mengisi variabel $newfilename denagan nama file yang sebelumnya
		$newfilename = $fotomakanan;

		// membuat query update tanpa update kolom foto
		$sql = "UPDATE tb_makanan SET id_kategori = '$idkategori', nama_makanan = '$namamakanan', desc_makanan = '$descmakanan', insert_time = '$inserttime' WHERE id_makanan = '$idmakanan'";
	}

	// Mengeksekusi query yang sudah di buat dan langsung mencek apakah berhasil atau tidak
	if (mysqli_query($connection, $sql)) {
		// Apabila berhasil hita tampilkan response berhasil
		$response["result"] = 1;
		$response["message"] = "update berhasil";
		$response['url'] = $upload_url . $newfilename;
		$response['name'] = $namamakanan;
	}else {
		// Menampilkan pesan gagal
		$response["result"] = 0;
		$response["message"] = "update gagal";
	}
	// Merubah respinse menhadi Json
	}else {
		$response["result"] = 0;
		$response["message"] = "Update gagal, data kurang";
	}

		echo json_encode($response);

}
 ?>