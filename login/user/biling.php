<?php
include "../service/db.php";

$query = 'SELECT * FROM pembayaran';
$sql = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing SP</title>
    <link rel="stylesheet" href="billinguser.css">
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
    <a href="../login.php" class="menu-item logout" onclick="showLogout()">
        <i class="fas fa-sign-out-alt"></i>
        Logout
    </a>
</nav>
    <div id="billingSPContent" class="biling">
        <div class="b">
    <?php
                ($result = mysqli_fetch_assoc($sql))
                ?>
               <div class="b" style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <p style="margin: 0; font-size: 16px;">
        <span style="font-weight: bold;">No Rek:</span> <?php echo $result['no_rek']; ?>, 
        <span style="font-weight: bold;">info Pembayaran:</span> <?php echo $result['info_pembayaran']; ?>, 
        <span style="font-weight: bold;">Tanggal Pembayaran:</span> <?php echo $result['tanggal_pembayaran']; ?>.
        </p>
        </div>


                </div>
    
    <a href="home.php"><button onclick="showDashboard()">Kembali</button></a>
    </div>
</div>
     <script src="dashboarduser.js"></script>
</body>
</html>
