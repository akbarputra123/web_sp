<?php
session_start(); // Memulai sesi

include "service/db.php"; // Menyertakan file koneksi database

$login_pesan = "";
$show_error = false;

if (isset($_POST["login"])) {
    // Mengambil data input dari form dan menghapus spasi ekstra
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Menyiapkan query SQL untuk mengecek username di tabel admin
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Debugging: menampilkan hasil query
    if ($result === false) {
        die("Query gagal: " . $stmt->error);  // Menampilkan error jika query gagal
    }

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        print_r($data); // Debugging, menampilkan data yang diambil dari database

        // Membandingkan password yang dimasukkan dengan yang ada di database
        if ($password == $data['password']) {  
            // Menyimpan id_admin dalam session
            $_SESSION['id_admin'] = $data['id_admin']; // Simpan id_admin dalam session

            // Mengarahkan ke halaman admin/home.php
            header("Location: admin/home.php");
            exit;
        } else {
            $login_pesan = "Password salah";
            $show_error = true;
        }
    } else {
        $login_pesan = "Username salah";
        $show_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="styleslogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <form id="loginForm" action="admin.php" method="POST">
            <div class="form-group">
                <h2 class="login">Login Admin</h2>
            </div>
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <?php if ($show_error): ?>
                    <i style="color: red;"><?= $login_pesan ?></i>
                <?php endif; ?>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input name="username" class="form-input" id="username" type="text" placeholder="Username" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <div class="password-container">
                    <div class="input-with-icon">
                        <i class="fas fa-lock"></i>
                        <input name="password" class="form-input" id="password" type="password" placeholder="Password" required>
                    </div>
                    <span class="toggle-password">
                        <i class="fas fa-eye show-icon"></i>
                        <i class="fas fa-eye-slash hide-icon" style="display: none;"></i>
                    </span>
                </div>
            </div>
            <div class="form-actions">
                <button class="login-button" type="submit" name="login">Login</button>
                <a class="forgot-password" href="lupa.php">Lupa Password?</a>
            </div>
        </form>
    </div>
    <script src="login.js"></script>
</body>
</html>