<?php

header("Content-Type: application/json; charset=UTF-8");
include './config/koneksi.php';

	// Membuat nama folder upload image
	$upload_path = 'uploads/';

	// Mengambil ip server
	$server_ip = gethostbyname(gethostname());

	// Membuat url upload
	$upload_url = 'http://'.$server_ip.'/makanan/'.$upload_path;

	// Membuat folder upload apabila folder tidak ada
	if (!is_dir($upload_url)) {
		# code...
		// Perintah membuat folder
		// 0775 berarti kita bisa ngebuat bisa melihat dll
		mkdir("uploads",0775, true);

	}
	// Membuat response array
	$response = array();

	// cek method POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		# code...
		$iduser = $_POST['iduser'];
		$idkategori = $_POST['idkategori'];
		$namamakanan = $_POST['namamakanan'];
		$descmakanan = $_POST['descmakanan'];
		$timeinsert = $_POST['timeinsert'];

		// Membuat try and catch agar menciba menyimpan ke direktori dengan aman
		try {
			// Mengambil nama extensinya
			// explode berguna untuk menghilangkna kata sebelum titik
			$temp = explode(".", $_FILES["image"]["name"]);
			// Menggabungkan nama baru dengan extension
			$newfilename = round(microtime(true)) . '.'. end($temp);

			// Memasukan file ke dalam folder
			move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $newfilename);

			// Mengupdate di database
			$query = "INSERT INTO tb_makanan (id_user, id_kategori, nama_makanan, desc_makanan, foto_makanan, insert_time) VALUES ('$iduser','$idkategori','$namamakanan','$descmakanan','$newfilename','$timeinsert')";

			// Mengeksekusi query dan langsung mengcek apakah berhasil atau tidak 
			if (mysqli_query($connection, $query)) {
				# code...
				$response['result'] = 1;
				$response['message'] = "upload berhasil";
				// nama nya menggabungkan dari variable upload_url & newfilename
				$response['url'] = $upload_url . $newfilename;
				$response['name'] = $namamakanan;
			}else {
				$response['result'] = 0;
				$response['message'] = "upload gagal";
			}
			
		} catch (Exception $e) {
			$response['result'] = 0;
			$response['message'] = $e->getMessage();
		}
		// displaying the response
		echo json_encode($response);

		// closing the connection
		mysqli_close($connection);
	}

?>