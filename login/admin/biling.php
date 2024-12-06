<?php
include "../service/db.php";

// Inisialisasi variabel
$id_t = $no_rek  = $info_pembayaran = $tanggal_pembayaran = "";

// Proses jika ada parameter 'ubah'
if (isset($_GET['ubah'])) {
    $id_t = $_GET['ubah'];
    $query = "SELECT * FROM pembayaran WHERE id_t = '$id_t'";
    $sql = mysqli_query($conn, $query);

    if ($sql && $result = mysqli_fetch_assoc($sql)) {
        $no_rek = $result['no_rek'];

        $info_pembayaran = $result['info_pembayaran'];
        $tanggal_pembayaran = $result['tanggal_pembayaran'];
    } else {
        echo "Error fetching data: " . mysqli_error($conn);
    }
}

// Proses jika form dikirim
if (isset($_POST['aksi']) && $_POST['aksi'] === "save") {
    $id_t = $_POST['id_t'];
    $no_rek = $_POST['no_rek'];
    $info_pembayaran = $_POST['info_pembayaran'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];

    // Update data
    $query = "UPDATE pembayaran SET 
              no_rek = '$no_rek', 
              info_pembayaran = '$info_pembayaran', 
              tanggal_pembayaran = '$tanggal_pembayaran' 
              WHERE id_t = '$id_t'";

    $sql = mysqli_query($conn, $query);

    if (!$sql) {
        echo "Query error: " . mysqli_error($conn);
        echo "<br>SQL Query: " . $query;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembayaran</title>
    <link rel="stylesheet" href="styles.homeadmin.css">
    <!-- <link rel="stylesheet" href="bilingadmin.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
        <div class="menu-home">
        </div>
    </header>
    <!-- Beranda -->
    <div class="container">
<nav class="beranda">
    <a href="home.php" class="menu-item">
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
    <div class="container">
    <div style=" width: 85vw;; padding: 5px; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
        <div style=" text-align: center;margin-top: 20px;margin-bottom: 20px;margin-left: 0;padding: 20px;width: 85vw; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif;">
    <!-- Tabel Data Pembayaran -->
    <table style="width: 100%; border-collapse: collapse; margin: 20px auto; font-family: Arial, sans-serif; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Edit Biling</h2>
    <thead>
        <tr style="background-color: #f4f4f4; text-align: center; color: #333; font-weight: bold; border-bottom: 2px solid #ddd;">
            <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
            <th style="padding: 10px; border: 1px solid #ddd;">No Rekening</th>
            <th style="padding: 10px; border: 1px solid #ddd;">info pembayaran</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Tanggal Pembayaran</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM pembayaran";
        $sql = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "<tr style='text-align: center;'>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$row['id_t']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$row['no_rek']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$row['info_pembayaran']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>{$row['tanggal_pembayaran']}</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>
                    <a class='edit-btn' href='biling.php?ubah={$row['id_t']}' 
                       style='color: #fff; background-color: green; padding: 5px 10px; text-decoration: none; border-radius: 4px;'>Edit</a>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>

        <style> .edit-btn{ color: white;background-color: green;padding: 5px;border-radius: 4px;text-decoration: none;} </style>
       </div>
        <!-- Form Edit -->
    
    <form action="biling.php" method="POST" style="width: 100%;">
        <input type="hidden" name="id_t" value="<?php echo $id_t; ?>">
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="no_rek" style="display: block; font-weight: bold; margin-bottom: 5px;">No Rekening:</label>
            <input type="text" id="no_rek" name="no_rek" value="<?php echo $no_rek; ?>" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="status_pembayaran" style="display: block; font-weight: bold; margin-bottom: 5px;">info pembayaran:</label>
            <input type="text" id="status_pembayaran" name="info_pembayaran" value="<?php echo $info_pembayaran; ?>" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="tanggal_pembayaran" style="display: block; font-weight: bold; margin-bottom: 5px;">Tanggal Pembayaran:</label>
            <input type="text" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?php echo $tanggal_pembayaran; ?>" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
        </div>
        
        <div class="form-actions" style="text-align: center;">
            <button type="submit" name="aksi" value="save" 
                    style="background: green; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-right: 10px;">
                Save
            </button>
            <a href="home.php" 
               style="background: #002855; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; font-weight: bold;">
                Kembali
            </a>
        </div>
    </form>
    </div>
</div>
    </div>
</div>
<script src="dashboardadmin.js"></script>
</body>
</html>

