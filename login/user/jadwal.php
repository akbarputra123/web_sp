<?php
include "../service/db.php";
session_start();
$query = 'SELECT * FROM jadwal';
$sql = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="jadwaluser.css">
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
    <h1>Jadwal Perkuliahan</h1>
    <table class="tabel-jadwal">
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Kuliahn</th>
                <th>Ruangan</th>
                <th>Prodi</th>
                <th>kelas</th>
    
            </tr>
        </thead>
        <tbody>
        <?php
                    $no = 1; // Inisialisasi nomor urut
                    while ($result = mysqli_fetch_assoc($sql)) {
                    ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $result['hari']; ?></td>
                <td><?php echo $result['jam']; ?></td>
                <td><?php echo $result['nama_matakuliah']; ?></td>
                <td><?php echo $result['ruangan']; ?></td>
                <td><?php echo $result['prodi']; ?></td>
                <td><?php echo $result['kelas']; ?></td>

            </tr>
        </tbody>
        <?php
                    }
        ?>
    </table>
    <a href="home.php"><button onclick="showDashboard()">Kembali</button></a>
    </div>
</div>
    <script src="dashboarduser.js"></script>
</body>
</html>
