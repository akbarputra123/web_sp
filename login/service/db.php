<?php
// Konfigurasi koneksi database
$host = "localhost";  // nama host atau IP
$user = "root";       // username database
$password = "";       // password database (kosong untuk localhost)
$database = "sistem"; // nama database yang sesuai
$port = 8111;         // port MySQL yang digunakan

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database, $port);

// Mengecek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>
