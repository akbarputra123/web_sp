<?php
include "../service/db.php";

// Tambahkan data dari tabel KRS ke tabel Jadwal jika belum ada
$queryKRS = "SELECT DISTINCT jam, nama_matakuliah, kelas FROM krs";
$sqlKRS = mysqli_query($conn, $queryKRS);

while ($rowKRS = mysqli_fetch_assoc($sqlKRS)) {
    $jam = $rowKRS['jam'];
    $nama_matakuliah = $rowKRS['nama_matakuliah'];
    $kelas = $rowKRS['kelas'];

    // Cek apakah data ini sudah ada di tabel jadwal
    $checkQuery = "SELECT * FROM jadwal WHERE jam = '$jam' AND nama_matakuliah = '$nama_matakuliah' AND kelas = '$kelas'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $insertQuery = "INSERT INTO jadwal (jam, nama_matakuliah, kelas, hari, ruangan, prodi) 
                        VALUES ('$jam', '$nama_matakuliah', '$kelas', '', '', '')";
        mysqli_query($conn, $insertQuery);
    }
}

$query = 'SELECT * FROM jadwal';
$sql = mysqli_query($conn, $query);

if (isset($_GET['hapus'])) {
    $id_jadwal = $_GET['hapus'];
    $query = "DELETE FROM jadwal WHERE id_jadwal = '$id_jadwal'";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        header('Location: jadwal.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
    <link rel="stylesheet" href="jadwaladmin.css">
    <link rel="stylesheet" href="styles.homeadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
        <div class="menu-home"></div>
    </header>
    <div class="container">
        <nav class="beranda">
            <a href="home.php" class="menu-item">
                <i class="fas fa-home"></i> Beranda
            </a>
            <div class="menu-item-menutup">
                <a href="#" class="menu-item">
                    <i class="fas fa-graduation-cap"></i> Akademik
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <div class="submenu">
                    <a href="jadwal.php" class="submenu-item">
                        <i class="fas fa-calendar-alt"></i> Jadwal Kuliah
                    </a>
                    <a href="krs.php" class="submenu-item">
                        <i class="fas fa-file-alt"></i> KRS
                    </a>
                    <a href="mhs.php" class="submenu-item" onclick="showKRSPage()">
                <i class="fas fa-file-alt"></i>
                Mahasiswa
            </a>
                </div>
            </div>
            <a href="biling.php" class="menu-item billing">
                <i class="fas fa-file-invoice-dollar"></i> Billing SP
            </a>
            <a href="edit.php" class="menu-item edit">
                <i class="fas fa-user-edit"></i> Edit User
            </a>
            <a href="../admin.php" class="menu-item logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
        <div id="jadwalContent" class="jadwal">
    <form action="jadwal.php" method="GET">
        <table class="tabel-jadwal">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Ruangan</th>
                    <th>Prodi</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($sql)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['hari'] . "</td>";
                    echo "<td>" . $row['jam'] . "</td>";
                    echo "<td>" . $row['nama_matakuliah'] . "</td>";
                    echo "<td>" . $row['ruangan'] . "</td>";
                    echo "<td>" . $row['prodi'] . "</td>";
                    echo "<td>" . $row['kelas'] . "</td>";
                    echo "<td>
                            <a href='edit_jadwal.php?ubah=" . $row['id_jadwal'] . "' class='edit-button'>Edit</a> 
                            <a href='jadwal.php?hapus=" . $row['id_jadwal'] . "' class='delete-button' onclick='return confirm(\"Apakah Anda yakin menghapus data ini?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </form>
    <a href="home.php"><button class="back-button">Kembali</button></a>
</div>

<style>
    button {
        color: white;
        background-color: #001F3F;
    }

    .edit-button {
        color: white;
        background-color: green;
        padding: 5px;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    .delete-button {
        background-color: red;
        color: white;
        padding: 5px;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    /* Responsivitas untuk layar dengan lebar maksimal 720px */
    @media (max-width: 720px) {
        .edit-button,
        .delete-button {
            display: block; /* Atur tombol agar tampil vertikal */
            width: 100%; /* Atur tombol memenuhi lebar elemen */
            text-align: center;
        }

        .tabel-jadwal {
            font-size: 12px; /* Kurangi ukuran font */
            width: 100%; /* Tabel menyesuaikan layar */
        }

        .tabel-jadwal th, 
        .tabel-jadwal td {
            padding: 8px; /* Sesuaikan padding */
            text-align: left; /* Ubah teks menjadi rata kiri */
        }

        .jadwal {
            overflow-x: auto; /* Scroll horizontal jika tabel terlalu lebar */
        }
    }
</style>

        </div>
    </div>
    <script src="dashboardadmin.js"></script>
</body>
</html>
