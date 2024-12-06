<?php
session_start(); // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard SPSP UNKHAIR</title>
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
            <a href="#" class="menu-item" onclick="showDashboard()">
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
                <i class="fas fa-money-bill-wave"></i> 
                 Billing SP
            </a>
            <a href="edit.php" class="menu-item edit" onclick="showEditUserPage()">
                <i class="fas fa-user-edit"></i> 
                Edit User
            </a>
            <a href="../user.php" class="menu-item logout">
                <i class="fas fa-sign-out-alt"></i> 
                Logout
            </a>
        </nav>
        <!-- Dashboard -->
        <main id="mainContent" class="main-content">
            <div id="dashboardContent" class="content-dashboard">
                <h1>DASHBOARD SISTEM PENDAFTARAN SEMESTER PENDEK</h1>
                <div class="dashboard-grid">
                    <a href="krs.php" class="dashboard-card krs" onclick="showKRSPage()">
                        <i class="fas fa-file-alt"></i>
                        <span>Kartu Rencana Studi(KRS)</span>
                    </a>
                    <a href="jadwal.php" class="dashboard-card jadwal" onclick="showJadwalPage()">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Jadwal Kuliah</span>
                    </a>
                    <a href="biling.php" class="dashboard-card biling" onclick="showBillingSPPage()">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Billing SP</span>
                    </a>
                    <a href="edit.php" class="dashboard-card edit" onclick="showEditUserPage()">
                        <i class="fas fa-user-cog"></i>
                        <span>Edit User</span>
                    </a>
                </div>
            </div>
        </main>
    </div>
    <script src="dashboarduser.js"></script>
</body>
</html>
