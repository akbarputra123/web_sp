<?php
include "../service/db.php";

// Inisialisasi variabel
$id_admin = $nama = $username = $password = "";

// Periksa jika ada parameter 'ubah' di URL
if (isset($_GET['ubah'])) {
    $id_admin = $_GET['ubah'];  // Ambil id_user dari URL

    // Ambil data pengguna berdasarkan id_user
    $query = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
    $sql = mysqli_query($conn, $query);

    // Jika data ditemukan, masukkan ke dalam variabel
    if ($result = mysqli_fetch_assoc($sql)) {
        $nama = $result['nama'];
        $username = $result['username'];
        $password = $result['password'];
    }
} else {
    // Jika tidak ada parameter 'ubah', arahkan kembali ke halaman edit.php
    header('location: edit.php');
    exit;
}

// Proses jika form dikirim
if (isset($_POST['aksi'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Pastikan aksi hanya 'edit' jika ada id_user
    if ($_POST['aksi'] == "edit" && isset($_GET['ubah'])) {
        // Proses untuk mengedit data yang ada
        $query = "UPDATE admin SET 
                  nama = '$nama', 
                  username = '$username', 
                  password = '$password' 
                  WHERE id_admin = '$id_admin'";
        
        $sql = mysqli_query($conn, $query);
        if ($sql) {
            // Redirect setelah berhasil
            header('location: edit.php');
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
    <title>Edit User</title>
    <link rel="stylesheet" href="edit_admin.css">
    <link rel="stylesheet" href="styles.homeadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

        <div id="edituserContent" class="edituser">
            <h1 style="margin-left: 10px;">Edit Profile</h1>
            <form class="edit-user-form" action="edit_admin.php<?php echo $id_admin ? '?ubah=' . $id_admin : ''; ?>" method="POST">
                <div class="form-group">
                    <label for="Username">Username</label>
                    <input type="text" id="Username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="form-group">
                    <label for="Nama">Nama</label>
                    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
                </div>
                <div class="form-group">
                    <label for="Password">Password</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
                    <span class="toggle-password">
                        <i class="fas fa-eye show-icon"></i>
                        <i class="fas fa-eye-slash hide-icon" style="display: none;"></i>
                    </span>
                </div>
                <div class="form-actions">
                    <!-- Tambahkan aksi jika perlu -->
                </div>
                <button type="submit" class="save-button" name="aksi" value="edit">
            Save
        </button>
            </form>   
           
            <a href="edit.php"><button onclick="showDashboard()">Kembali</button></a>
            <style> button[onclick="showDashboard()"]{background-color: #001F3F;margin-left: 10px;margin-top: 10px;}</style>
        </div>
    </div>
    <script src="dashboarduser.js"></script>
     <script src="../login.js"></script>

</body>
</html>

