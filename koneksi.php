<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');
header('Content-Type: application/json; charset=utf8');
// Konfigurasi koneksi database
$host = 'localhost';  
$user = 'root';  
$password = '';  
$database = 'db_eletronik';  
// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Memeriksa apakah koneksi berhasil atau tidak
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Mendapatkan data dari API
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    $query = "SELECT * FROM tb_eletronik";  

    // Menjalankan query
    $result = mysqli_query($koneksi, $query);

    // Membuat array kosong untuk menyimpan data
    $data = array();

    // Mengambil data hasil query dan menyimpannya dalam array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Mengembalikan data sebagai respon JSON
    echo json_encode($data);
}

// Menambahkan data melalui API
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data yang dikirim melalui body request
    $nama_barang = $_POST['nama_barang'];
    $Harga = $_POST['Harga'];

    // Query untuk menambahkan data ke database
    $query = "INSERT INTO tb_eletronik (nama_barang, Harga) VALUES ('$nama_barang', '$Harga')"; 

    // Menjalankan query
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah data berhasil ditambahkan atau tidak
    if ($result) {
        echo json_encode(array('message' => 'Data berhasil ditambahkan'));
    } else {
        echo json_encode(array('message' => 'Gagal menambahkan data'));
    }
}
// Mengupdate data di api
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Mendapatkan data yang dikirim
    parse_str(file_get_contents("php://input"), $putData);
    $id_barang = $putData['id_barang'];
    $nama_barang = $putData['nama_barang'];
    $Harga = $putData['Harga'];

    // Query untuk mengupdate data di database
    $query = "UPDATE tb_eletronik SET nama_barang ='$nama_barang', Harga='$Harga' WHERE id_barang='$id_barang'";

    // Menjalankan query
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah data berhasil diupdate atau tidak
    if ($result) {
        echo json_encode(array('message' => 'Data berhasil diupdate'));
    } else {
        echo json_encode(array('message' => 'Gagal mengupdate data'));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    $id_barang = $_GET['id_barang'];

   
    $query = "DELETE FROM tb_eletronik WHERE id_barang = '$id_barang'";

  
    $result = mysqli_query($koneksi, $query);

   
    if ($result) {
        echo json_encode(array('message' => 'Data berhasil dihapus'));
    } else {
        echo json_encode(array('message' => 'Gagal menghapus data'));
    }
}

?>