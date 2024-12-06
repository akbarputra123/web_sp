<?php
include "../service/db.php";
session_start(); // Mulai session untuk mengakses variabel session

// Pastikan pengguna sudah login dan id_user tersedia dalam session
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user']; // Ambil id_user dari session
} else {
    // Jika pengguna belum login dan tidak ada session id_user, cek form login
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Pastikan koneksi ke database sudah dilakukan sebelumnya
        include "../service/db.php";

        // Ambil username dan password yang dimasukkan oleh pengguna
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query untuk memeriksa apakah username dan password sesuai di database
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $sql = mysqli_query($conn, $query);

        // Jika data ditemukan, simpan id_user dalam session
        if (mysqli_num_rows($sql) > 0) {
            $result = mysqli_fetch_assoc($sql);
            $_SESSION['id_user'] = $result['id_user']; // Simpan id_user dalam session
            $id_user = $result['id_user']; // Ambil id_user
        } else {
            // Jika username atau password tidak cocok
            echo "Username atau password salah.";
            exit();
        }
    } else {
        // Jika belum login dan tidak ada data login yang dikirim
        header("Location: ../login.php"); // Arahkan ke halaman login
        exit();
    }
}

// Query untuk mengambil data mahasiswa berdasarkan id_user
$queryMahasiswa = "SELECT * FROM mahasiswa WHERE id_user = '$id_user'"; // Ganti tabel ke mahasiswa
$sqlMahasiswa = mysqli_query($conn, $queryMahasiswa);

// Cek apakah data mahasiswa ditemukan
if (mysqli_num_rows($sqlMahasiswa) > 0) {
    $mahasiswa = mysqli_fetch_assoc($sqlMahasiswa); // Ambil data mahasiswa yang sesuai dengan id_user
} else {
    echo "Data mahasiswa tidak ditemukan.";
    exit();
}

// Query untuk mengambil data KRS (Kartu Rencana Studi)
$queryKrs = 'SELECT * FROM krs_belanja';
$sqlKrs = mysqli_query($conn, $queryKrs);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="jadwaluser.css">
    <link rel="stylesheet" href="krsuser.css">
    <link rel="stylesheet" href="styles.homeuser.css">
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
            <a href="../user.php" class="menu-item logout" onclick="showLogout()">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </nav>
        <div id="jadwalContent" class="jadwal">
            <h1>Kartu Rencana Studi(KRS)</h1>
            <h2>Nama: <?php echo $mahasiswa['nama']; ?></h2>
            <h3>NPM: <?php echo $mahasiswa['npm']; ?> </h3>
            <h3>Status: <?php echo $mahasiswa['status_pendaftaran']; ?> </h3> <!-- Status mahasiswa yang sesuai dengan id_user -->
            <a href="belanja.php"><button>Belanja</button></a>

            <table class="tabel-jadwal">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Kode MK</th>
                        <th>Mata Kuliah</th>
                        <th>B/U</th>
                        <th>Kelas</th>
                        <th>Jam</th>
                        <th>SKS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($resultKrs = mysqli_fetch_assoc($sqlKrs)) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $resultKrs['kode_matakuliah']; ?></td>
                            <td><?php echo $resultKrs['nama_matakuliah']; ?></td>
                            <td><?php echo $resultKrs['b_u']; ?></td>
                            <td><?php echo $resultKrs['kelas']; ?></td>
                            <td><?php echo $resultKrs['jam']; ?></td>
                            <td><?php echo $resultKrs['sks']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <a href="home.php"><button onclick="showDashboard()">Kembali</button></a>
        </div>
    </div>
    <script src="dashboarduser.js"></script>
</body>
</html>
