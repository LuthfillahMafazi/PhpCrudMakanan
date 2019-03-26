<?php 
	
	include './config/koneksi.php';
	// Membuat penampung response
	$response = array();
	// kita cek apakah parameeter yang dikirimkan ada
	if (isset($_POST["username"]) && isset($_POST["password"])) {
		// Memasukan inputan user ke dalam varianble
		$username = $_POST["username"];
		$password = md5($_POST["password"]);

		// Membuat query untuk mengambil detail user
		$sql = "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'";

		// Mengeksekusi query yang berada di dalam variable $sql
		$check = mysqli_query($connection, $sql);

		// cek apakah berhasil
		if (!$check) {
			echo 'Tidak bisa menjalan kan query: ' . mysql_error($connection);
			exit;
			# code...
		}

		// Memasukan datahasil query ke dalam variable
		// Mengambil data baris pertama dari hasil query
		$row = mysqli_fetch_row($check);

		$result_data = array(
			'id_user' => $row[0],
			'nama_user' => $row[1],
			'alamat' => $row[2],
			'jenkel' => $row[3],
			'no_telp' => $row[4],
			'username' => $row[5],
			'password' => $row[6],
			'level' => $row[7]
		);

		// Mengecek data apakah ada 
		if (mysqli_num_rows($check) > 0) {
			// Mengisi pesan berhasil ke response
			$response['result'] = 1;
			$response['message'] = "Berhasil login!";
			$response['data'] = $result_data;
			# code...
		}else {
			// Kita tampilkan pesan gagal ke response
			$response['result'] = 0;
			$response['message'] = "Gagal Login!";

		}

		// Mengubah response menjadi JSON
		echo json_encode($response); 

		// Membuat hasil dimasukan ke dalam array

		# code...
	}

 ?>