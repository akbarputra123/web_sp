<?php
include "service/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validasi data
    if (empty($username) || empty($new_password) || empty($confirm_password)) {
        echo "<script>alert('Semua kolom wajib diisi!');</script>";
    } elseif ($new_password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    } else {
        // Cek apakah username ada di database
        $query_check = "SELECT * FROM mahasiswa WHERE username = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param('s', $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            // Username ditemukan, lanjutkan dengan update password
            $query_update = "UPDATE mahasiswa SET password = ? WHERE username = ?";
            $stmt_update = $conn->prepare($query_update);
            $stmt_update->bind_param('ss', $new_password, $username);

            if ($stmt_update->execute()) {
                header('location: user.php');
            } else {
                echo "<script>alert('Terjadi kesalahan saat memperbarui password!');</script>";
            }

            $stmt_update->close();
        } else {
            // Username tidak ditemukan
            echo "<script>alert('Username tidak ditemukan!');</script>";
        }

        $stmt_check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="stylespassword.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Forgot Password</h2>
            <form action="" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username" required>
                
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password" name="new_password" placeholder="Masukkan Password Baru" required>
                
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                
                <button type="submit">Reset Password</button>
            </form>
            <div class="back-link">
                <a href="login.php">kembali ke Halaman Login</a>
            </div>
        </div>
    </div>
</body>
</html>
