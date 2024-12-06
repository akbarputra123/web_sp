<?php
session_start(); // Mulai session untuk mengakses variabel session

// Pastikan pengguna sudah login dan id_user tersedia dalam session
if (isset($_SESSION['id_admin'])) {
    $id_admin = $_SESSION['id_admin']; // Ambil id_user dari session
} else {
    // Jika pengguna belum login dan tidak ada session id_user, cek form login
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Pastikan koneksi ke database sudah dilakukan sebelumnya
        include "../service/db.php";

        // Ambil username dan password yang dimasukkan oleh pengguna
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query untuk memeriksa apakah username dan password sesuai di database
        $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
        $sql = mysqli_query($conn, $query);

        // Jika data ditemukan, simpan id_user dalam session
        if (mysqli_num_rows($sql) > 0) {
            $result = mysqli_fetch_assoc($sql);
            $_SESSION['id_admin'] = $result['id_admin']; // Simpan id_user dalam session
            $id_admin = $result['id_admin']; // Ambil id_user
        } else {
            // Jika username atau password tidak cocok
            echo "Username atau password salah.";
            exit();
        }
    } else {
        // Jika belum login dan tidak ada data login yang dikirim
        header("Location: ../user.php"); // Arahkan ke halaman login
        exit();
    }
}

// Pastikan koneksi ke database sudah dilakukan sebelumnya
include "../service/db.php";

// Ambil data pengguna berdasarkan id_user yang ada dalam session
$query = 'SELECT * FROM admin WHERE id_admin = ' . $id_admin ;
$sql = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit.css">
    <link rel="stylesheet" href="styles.homeadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="menu-home">
        </div>
    </header>
    <div class="container">
        <!-- Beranda -->
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

        <div id="edituserContent" class="edituser">
            <h1>Edit Profile</h1>
            <form class="edit-user-form" action="edit.php" method="GET">
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" id="Username" name="username" value="<?php echo $result['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Nama">Nama</label>
                    <input type="text" id="Nama" name="nama" value="<?php echo $result['nama'];?>" required>
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" id="Password" name="password" required>
                </div>
                <div class="form-actions">
                </div>
            </form> 
            <a href="edit_admin.php?ubah=<?php echo $result['id_admin']; ?>"><button type="button" class="save-button">Edit</button></a>  
        </div>
    </div>
    <script src="dashboardadmin.js"></script>
</body>
</html>
