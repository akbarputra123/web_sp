<?php
include "../service/db.php";

if (isset($_POST['belanja'])) {
    // Ambil data yang dipilih dari checkbox
    $selectedIds = isset($_POST['pilih']) ? $_POST['pilih'] : []; // Gunakan array kosong jika tidak ada yang dipilih

    // Debug untuk memastikan ID yang dipilih
    echo "Selected IDs: ";
    print_r($selectedIds);
    echo "<br>";

    // Hapus data yang tidak terpilih
    if (!empty($selectedIds)) {
        // Buat query DELETE dengan implode yang benar
        $deleteQuery = "DELETE FROM krs_belanja WHERE id_krs NOT IN ('" . implode("','", $selectedIds) . "')";
    } else {
        // Jika tidak ada data yang dipilih, hapus semua data di krs_belanja
        $deleteQuery = "DELETE FROM krs_belanja";
    }

    // Debug query DELETE untuk memastikan query bekerja dengan benar
    echo "Delete Query: " . $deleteQuery . "<br>";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "Data yang tidak terpilih berhasil dihapus.<br>";
    } else {
        echo "Error menghapus data: " . mysqli_error($conn) . "<br>";
    }

    // Masukkan data yang dipilih ke dalam krs_belanja jika belum ada
    foreach ($selectedIds as $id_krs) {
        // Periksa apakah ID sudah ada di tabel krs_belanja
        $checkQuery = "SELECT * FROM krs_belanja WHERE id_krs = '$id_krs'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) == 0) {
            // Ambil data dari tabel krs berdasarkan id_krs
            $query = "SELECT * FROM krs WHERE id_krs = '$id_krs'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            // Masukkan data ke dalam tabel krs_belanja
            $kode_matakuliah = $row['kode_matakuliah'];
            $nama_matakuliah = $row['nama_matakuliah'];
            $b_u = $row['b_u'];
            $kelas = $row['kelas'];
            $jam = $row['jam'];
            $sks = $row['sks'];

            $insertQuery = "INSERT INTO krs_belanja (id_krs, kode_matakuliah, nama_matakuliah, b_u, kelas, jam, sks) 
                            VALUES ('$id_krs', '$kode_matakuliah', '$nama_matakuliah', '$b_u', '$kelas', '$jam', '$sks')";
            mysqli_query($conn, $insertQuery);
        }
    }

    // Redirect setelah belanja berhasil
    header('Location: krs.php');
    exit;
}

// Query untuk menampilkan data dari krs
$query = 'SELECT * FROM krs';
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belanja KRS</title>
    <link rel="stylesheet" href="belanjakrs.css">
    <link rel="stylesheet" href="styles.homeuser.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="menu-home">
            <i class="fas fa-bars"></i>
        </div>
    </header>
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
                <a href="jadwal.php" class="submenu-item">
                    <i class="fas fa-calendar-alt"></i> 
                    Jadwal Kuliah
                </a>
                <a href="krs.php" class="submenu-item">
                    <i class="fas fa-file-alt"></i> 
                    KRS
                </a>
            </div>
        </div>
        <a href="biling.php" class="menu-item billing">
            <i class="fas fa-money-bill-wave"></i> 
            Billing SP
        </a>
        <a href="edit.php" class="menu-item edit">
            <i class="fas fa-user-edit"></i> 
            Edit User
        </a>
        <a href="../user.php" class="menu-item logout">
            <i class="fas fa-sign-out-alt"></i> 
            Logout
        </a>
    </nav>

    <div id="KRSContent" class="KRS">
        <form action="belanja.php" method="POST">
            <h1>Belanja KRS</h1>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Mk</th>
                        <th>Mata Kuliah</th>
                        <th>B/U</th>
                        <th>Kelas</th>
                        <th>Jam</th>
                        <th>SKS</th>
                        <th>Pilih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1; // Inisialisasi nomor urut
                    while ($result = mysqli_fetch_assoc($sql)) {
                        // Periksa apakah id_krs sudah ada di krs_belanja (tercentang)
                        $id_krs = $result['id_krs'];
                        $checkQuery = "SELECT * FROM krs_belanja WHERE id_krs = '$id_krs'";
                        $checkResult = mysqli_query($conn, $checkQuery);
                        $isChecked = mysqli_num_rows($checkResult) > 0 ? 'checked' : '';
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $result['kode_matakuliah']; ?></td>
                            <td><?php echo $result['nama_matakuliah']; ?></td>
                            <td><?php echo $result['b_u']; ?></td>
                            <td><?php echo $result['kelas']; ?></td>
                            <td><?php echo $result['jam']; ?></td>
                            <td><?php echo $result['sks']; ?></td>
                            <td><input type="checkbox" name="pilih[]" value="<?php echo $result['id_krs']; ?>" <?php echo $isChecked; ?>></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <button name="belanja" type="submit">Belanja</button>
            <a href="krs.php"><button onclick="showDashboard()">Kembali</button></a>
        </form>
    </div>
</div>

<script src="dashboarduser.js"></script>
</body>
</html>
