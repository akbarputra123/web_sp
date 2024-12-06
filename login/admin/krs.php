<?php
include "../service/db.php";

$query = 'SELECT * FROM krs';
$sql = mysqli_query($conn, $query);

if (isset($_GET['hapus'])) {
    $id_krs = $_GET['hapus'];

    // Ambil nama_matakuliah terkait dari tabel krs
    $query_krs = "SELECT nama_matakuliah FROM krs WHERE id_krs = '$id_krs'";
    $result_krs = mysqli_query($conn, $query_krs);

    if ($result_krs) {
        $row = mysqli_fetch_assoc($result_krs);
        $nama_matakuliah = $row['nama_matakuliah'];

        // Hapus data di tabel jadwal yang terkait
        $query_jadwal = "DELETE FROM jadwal WHERE nama_matakuliah = '$nama_matakuliah'";
        mysqli_query($conn, $query_jadwal);

        // Hapus data di tabel krs
        $query_krs_delete = "DELETE FROM krs WHERE id_krs = '$id_krs'";
        $sql = mysqli_query($conn, $query_krs_delete);

        if ($sql) {
            header('location: krs.php');
        } else {
            echo "Error menghapus data di tabel krs: " . mysqli_error($conn);
        }
    } else {
        echo "Error mengambil data nama_matakuliah: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Rencana Studi (KRS)</title>
    <link rel="stylesheet" href="krsadmin.css">
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
        <div id="KRSContent" class="KRS">
            <form action="krs.php" method="GET">
                <table class="tabel-KRS">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode MK</th>
                            <th>Mata Kuliah</th>
                            <th>B/U</th>
                            <th>Kelas</th>
                            <th>jam</th>
                            <th>SKS</th>
                            <th class="aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($result = mysqli_fetch_assoc($sql)) {
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $result['kode_matakuliah']; ?></td>
                                <td><?php echo $result['nama_matakuliah']; ?></td>
                                <td><?php echo $result['b_u']; ?></td>
                                <td><?php echo $result['kelas']; ?></td>
                                <td><?php echo $result['jam']; ?></td>
                                <td><?php echo $result['sks']; ?></td>
                                <td>
                                    <a href="edit_krs.php?ubah=<?php echo $result['id_krs']; ?>" class="edit1">Edit</a>
                                    <style>
                                        .edit1 {
                                            background-color: green;
                                            color: white;
                                            padding: 5px;
                                            border-radius: 5px;
                                            text-decoration: none;
                                        }
                                    </style>
                                    <a href="krs.php?hapus=<?php echo $result['id_krs']; ?>" class="hapus" onclick="return confirm('Apakah Anda yakin menghapus?')">Hapus</a>
                                    <style>
                                        .hapus {
                                            background-color: red;
                                            color: white;
                                            padding: 10px;
                                            border-radius: 5px;
                                            text-decoration: none;
                                            padding: 5px;
                                        }
                                    </style>
                                    <style>
                                        @media (max-width: 720px) {
                                            .tabel-KRS td .edit1, .tabel-KRS td .hapus {
                                                display: block;
                                                width: 100%;
                                                margin-bottom: 5px;
                                                text-align: center;
                                            }
                                            .tabel-KRS td {
                                                padding: 5px;
                                            }
                                        }
                                    </style>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
            <a href="edit_krs.php"><button>Tambah Matakuliah</button></a>
            <a href="home.php"><button onclick="showDashboard()">Kembali</button></a>
        </div>
    </div>
    <script src="dashboardadmin.js"></script>
</body>
</html>
