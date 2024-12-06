<?php
include "../service/db.php";

// Inisialisasi variabel
$id_krs = $kode_matakuliah = $nama_matakuliah = $b_u = $kelas = $jam = $sks = "";
$error_message = ""; // Menyimpan pesan error

// Proses jika ada parameter 'ubah'
if (isset($_GET['ubah'])) {
    $id_krs = $_GET['ubah'];
    $query = "SELECT * FROM krs WHERE id_krs = '$id_krs'";
    $sql = mysqli_query($conn, $query);

    if ($result = mysqli_fetch_assoc($sql)) {
        $kode_matakuliah = $result['kode_matakuliah'];
        $nama_matakuliah = $result['nama_matakuliah'];
        $b_u = $result['b_u'];
        $kelas = $result['kelas'];
        $jam = $result['jam'];
        $sks = $result['sks'];
    }
}

// Proses jika form dikirim
if (isset($_POST['aksi'])) {
    $kode_matakuliah = $_POST['kode_matakuliah'];
    $nama_matakuliah = $_POST['nama_matakuliah'];
    $b_u = $_POST['b_u'];
    $kelas = $_POST['kelas'];
    $jam = $_POST['jam'];
    $sks = $_POST['sks'];

    if ($_POST['aksi'] == "add") {
        // Cek apakah kode mata kuliah sudah ada di database
        $check_query = "SELECT COUNT(*) as count FROM krs WHERE kode_matakuliah = '$kode_matakuliah'";
        $check_result = mysqli_query($conn, $check_query);
        $check_row = mysqli_fetch_assoc($check_result);

        if ($check_row['count'] > 0) {
            // Jika kode sudah ada, tampilkan pesan error dan tidak lanjutkan
            $error_message = "Kode Mata Kuliah sudah terdaftar! Data Invalid.";
        } else {
            $query = "INSERT INTO krs (kode_matakuliah, nama_matakuliah, b_u, kelas, jam, sks) 
                      VALUES ('$kode_matakuliah', '$nama_matakuliah', '$b_u', '$kelas', '$jam', '$sks')";
            $sql = mysqli_query($conn, $query);
            if ($sql) {
                header('location: krs.php');
            } else {
                echo mysqli_error($conn);
            }
        }
    } elseif ($_POST['aksi'] == "edit") {
        $query = "UPDATE krs SET 
                  kode_matakuliah = '$kode_matakuliah', 
                  nama_matakuliah = '$nama_matakuliah', 
                  b_u = '$b_u', 
                  kelas = '$kelas', 
                  jam = '$jam', 
                  sks = '$sks' 
                  WHERE id_krs = '$id_krs'";
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            header('location: krs.php');
        } else {
            echo mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rencana Studi</title>
    <link rel="stylesheet" href="editkrsadmin.css">
    <link rel="stylesheet" href="styles.homeadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
    <div class="menu-home">
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

    <div id="KRSContent" class="KRS">
        <h1><?php echo $id_krs ? "Edit" : "Tambah"; ?> Kartu Rencana Studi</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color: red; font-weight: bold;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <form id="editKRSForm" action="edit_krs.php<?php echo $id_krs ? '?ubah=' . $id_krs : ''; ?>" method="POST">
            <label for="kodeMK">Kode Mata Kuliah:</label>
            <input type="text" id="kodeMK" name="kode_matakuliah" value="<?php echo htmlspecialchars($kode_matakuliah); ?>" required>

            <label for="mataKuliah">Mata Kuliah:</label>
            <input type="text" id="mataKuliah" name="nama_matakuliah" value="<?php echo htmlspecialchars($nama_matakuliah); ?>" required>

            <label for="bu">B/U:</label>
            <select id="bu" name="b_u">
                <option value="b" <?php echo $b_u == 'B' ? 'selected' : ''; ?>>B</option>
                <option value="u" <?php echo $b_u == 'U' ? 'selected' : ''; ?>>U</option>
            </select>

            <label for="kelas">Kelas:</label>
            <input type="text" id="kelas" name="kelas" value="<?php echo htmlspecialchars($kelas); ?>" required>

            <label for="jadwal">Jam:</label>
            <input type="text" id="jadwal" name="jam" value="<?php echo htmlspecialchars($jam); ?>" required>

            <label for="sks">SKS:</label>
            <input type="number" id="sks" name="sks" value="<?php echo htmlspecialchars($sks); ?>" min="1" max="4" required>

            <button class="add" type="submit" name="aksi" value="<?php echo $id_krs ? 'edit' : 'add'; ?>">
                <?php echo $id_krs ? "Simpan Perubahan" : "Tambahkan"; ?>
            </button>
            <a href="krs.php"><button type="button">Kembali</button></a>
            <style>
                button[type="button"] {
                    background-color: #001F3F;
                }
            </style>
        </form>
    </div>
</div>
<script src="dashboardadmin.js"></script>
</body>
</html>
