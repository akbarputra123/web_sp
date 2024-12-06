<?php
include "../service/db.php";

// Inisialisasi variabel
$id_jadwal = $hari = $jam = $nama_matakuliah = $ruangan = $prodi = $kelas = "";

// Periksa jika ada parameter 'ubah' di URL
if (isset($_GET['ubah'])) {
    $id_jadwal = $_GET['ubah'];  // Ambil id_user dari URL

    // Ambil data pengguna berdasarkan id_user
    $query = "SELECT * FROM jadwal WHERE id_jadwal = '$id_jadwal'";
    $sql = mysqli_query($conn, $query);

    // Jika data ditemukan, masukkan ke dalam variabel
    if ($result = mysqli_fetch_assoc($sql)) {
        $hari = $result['hari'];
        $jam = $result['jam'];
        $nama_matakuliah = $result['nama_matakuliah'];
        $ruangan = $result['ruangan'];
        $prodi = $result['prodi'];
        $kelas = $result['kelas'];
    }
} else {
    // Jika tidak ada parameter 'ubah', arahkan kembali ke halaman edit.php
    header('location: jadwal.php');
    exit;
}

// Proses jika form dikirim
if (isset($_POST['aksi'])) {
    // Ambil data dari form
    $hari= $_POST['hari'];
    $jam = $_POST['jam'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $ruangan = $_POST['ruangan'];
    $prodi = $_POST['prodi'];
    $kelas = $_POST['kelas'];

    // Pastikan aksi hanya 'edit' jika ada id_user
    if ($_POST['aksi'] == "edit" && isset($_GET['ubah'])) {
        // Proses untuk mengedit data yang ada
        $query = "UPDATE jadwal SET 
                  hari = '$hari', 
                  jam = '$jam', 
                  nama_matakuliah = '$nama_matakuliah', 
                  ruangan = '$ruangan',
                  prodi = '$prodi',
                  kelas = '$kelas' 
                  WHERE id_jadwal = '$id_jadwal'";
        
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            // Redirect setelah berhasil
            header('location: jadwal.php');
            exit;  // Hentikan eksekusi kode setelah redirect
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal Perkuliahan</title>
    <link rel="stylesheet" href="editjadwaladmin.css">
    <link rel="stylesheet" href="styles.homeadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
    <div class="menu-home">
        <i class="fas fa-bars"></i>
    </div>
</header>
<!-- Beranda -->
<div class="container">
<nav class="beranda">
<a href="home.php" class="menu-item" onclick="showDashboard()">
    <i class="fas fa-home"></i>
    Beranda
</a>
<div class="menu-item-menutup">
    <a href="#" class="menu-item">
        <i class="fas fa-graduation-cap"></i>
        Akademik
        <i class="fas fa-chevron-right arrow"></i>
    </a>
    <div class="submenu">
        <a href="jadwal.php" class="submenu-item" onclick="showJadwalPage()">
            <i class="fas fa-calendar-alt"></i>
            Jadwal Kuliah
        </a>
        <a href="krs.php" class="submenu-item" onclick="showKRSPage()">
            <i class="fas fa-file-alt"></i>
            KRS
        </a>
        <a href="mhs.php" class="submenu-item" onclick="showKRSPage()">
                <i class="fas fa-file-alt"></i>
                Mahasiswa
            </a>
    </div>
</div>
<a href="biling.php" class="menu-item billing" onclick="showBillingSPPage()">
    <i class="fas fa-file-invoice-dollar"></i>
    Billing SP
</a>
<a href="edit.php" class="menu-item edit" onclick="showEditUserPage()">
    <i class="fas fa-user-edit"></i>
    Edit User
</a>
<a href="../admin.php" class="menu-item logout" onclick="showLogout()">
    <i class="fas fa-sign-out-alt"></i>
    Logout
</a>
</nav>
   

        <div id="jadwalContent" class="jadwal">
            <h1>Edit Jadwal Perkuliahan</h1>
            <form id="editJadwalForm" action="edit_jadwal.php<?php echo $id_jadwal ? '?ubah=' . $id_jadwal : ''; ?>" method="POST">
                <label for="mataKuliah">hari:</label>
                <input type="text" id="mataKuliah" name="hari" value="<?php echo htmlspecialchars($hari); ?>" required>

                <label for="hari">jam:</label>
                <input type="text" id="hari" name="jam" value="<?php echo htmlspecialchars($jam); ?>" required>

                <label for="ruangan">mata kuliah:</label>
                <input type="text" id="ruangan" name="nama_matakuliah" value="<?php echo htmlspecialchars($nama_matakuliah); ?>" required>

                <label for="jamMulai">ruangan:</label>
                <input type="text" id="jamMulai" name="ruangan" value="<?php echo htmlspecialchars($ruangan); ?>" required>

                <label for="jamSelesai">prodi:</label>
                <input type="text" id="jamSelesai" name="prodi" value="<?php echo htmlspecialchars($prodi); ?>" required>

                <label for="jamSelesai">kelas:</label>
                <input type="text" id="jamSelesai" name="kelas" value="<?php echo htmlspecialchars($kelas); ?>" required>
                <button type="submit" class="save-button" name="aksi" value="edit">simpan perubahan</button>
                
            </form>
            <a href="jadwal.php"><button onclick="showDashboard()">Kembali</button></a>
        </div>
    </div>
    <script src="dashboardadmin.js"></script>
</body>
</html>
