<?php
include "../service/db.php";
session_start();

// Inisialisasi variabel
$id_user = $nama = $npm = $username = $password = "";

// Periksa jika ada parameter 'ubah' di URL
if (isset($_GET['ubah'])) {
    $id_user = $_GET['ubah'];  // Ambil id_user dari URL

    // Ambil data pengguna berdasarkan id_user
    $query = "SELECT * FROM mahasiswa WHERE id_user = '$id_user'";
    $sql = mysqli_query($conn, $query);

    // Jika data ditemukan, masukkan ke dalam variabel
    if ($result = mysqli_fetch_assoc($sql)) {
        $nama = $result['nama'];
        $npm = $result['npm'];
        $username = $result['username'];
        $password = $result['password'];
    } else {
        echo "Data tidak ditemukan atau query gagal.";
        exit;
    }
} else {
    // Jika tidak ada parameter 'ubah', arahkan kembali ke halaman edit.php
    header('location: edit.php');
    exit;
}

// Proses jika form dikirim
if (isset($_POST['aksi']) && $_POST['aksi'] == "edit") {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Periksa apakah data sudah lengkap
    if (empty($nama) || empty($username) || empty($password)) {
        echo "Semua data harus diisi!";
        exit;
    }

    // Update data pengguna di tabel mahasiswa
    $query = "UPDATE mahasiswa SET 
              nama = '$nama', 
              username = '$username', 
              password = '$password' 
              WHERE id_user = '$id_user'";
    
    $sql = mysqli_query($conn, $query);
    
    if ($sql) {
        // Perbaiki query update mahasiswa
        $query_update_mahasiswa = "UPDATE mahasiswa SET nama = '$nama' WHERE id_user = '$id_user'";
        $sql_update_mahasiswa = mysqli_query($conn, $query_update_mahasiswa);

        if ($sql_update_mahasiswa) {
            // Redirect setelah berhasil
            header('location: edit.php');
            exit;  // Hentikan eksekusi kode setelah redirect
        } else {
            echo "Error updating mahasiswa: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating users: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit_user.css">
    <link rel="stylesheet" href="styles.homeuser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div id="edituserContent" class="edituser">
    <h1>Edit Profile</h1>
    <form class="edit-user-form" action="edit_user.php<?php echo $id_user ? '?ubah=' . $id_user : ''; ?>" method="POST">
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
        
        <!-- Tidak menampilkan input untuk npm -->
        <div class="form-group">
            <label for="npm">NPM</label>
            <input type="text" id="npm" name="npm" value="<?php echo htmlspecialchars($npm); ?>" disabled>
            <!-- Anda juga bisa menampilkan npm sebagai teks biasa jika ingin lebih jelas -->
            <!-- <p><?php echo htmlspecialchars($npm); ?></p> -->
        </div>

        <div class="form-actions">
            <!-- Tambahkan aksi jika perlu -->
        </div>
        <button type="submit" class="save-button" name="aksi" value="edit">
            Save
        </button>
    </form>   

    <a href="edit.php"><button onclick="showDashboard()">Kembali</button></a>
    <style> button[onclick="showDashboard()"]{background-color: #001F3F;margin-top: 10px}</style>
</div>

<script src="dashboarduser.js"></script>
<script src="../login.js"></script>

</body>
</html>
