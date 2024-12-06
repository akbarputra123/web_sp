<?php
include "../service/db.php";

// Query untuk menampilkan data mahasiswa
$query = 'SELECT * FROM mahasiswa'; // Pastikan tabel `mahasiswa` memiliki kolom `npm`, `nama`, dan `status_pendaftaran`
$sql = mysqli_query($conn, $query);

// Tangani permintaan perubahan status melalui AJAX
if (isset($_POST['updateStatus'])) {
    $npm = $_POST['npm'];
    $status = $_POST['status']; // Menggunakan langsung string status dari POST

    // Update query untuk menyimpan status
    $updateQuery = "UPDATE mahasiswa SET status_pendaftaran = '$status' WHERE npm = '$npm'";
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="mhs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Daftar Mahasiswa</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; // Inisialisasi nomor urut
                while ($result = mysqli_fetch_assoc($sql)) {
                    $npm = $result['npm'];
                    $nama = $result['nama'];
                    $status_pendaftaran = $result['status_pendaftaran']; // Ambil status dari database
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $npm; ?></td>
                        <td><?php echo $nama; ?></td>
                        <td>
                            <select 
                                class="status-dropdown" 
                                data-npm="<?php echo $npm; ?>" 
                                data-current-status="<?php echo $status_pendaftaran; ?>">
                                <option value="Terdaftar" <?php echo $status_pendaftaran === 'Terdaftar' ? 'selected' : ''; ?>>Terdaftar</option>
                                <option value="Tidak Terdaftar" <?php echo $status_pendaftaran === 'Tidak Terdaftar' ? 'selected' : 'selected'; ?>>Tidak Terdaftar</option>
                            </select>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="home.php"><button onclick="showDashboard()">Kembali</button></a>
    </div>

    <script>
        // Gunakan AJAX untuk memperbarui status secara dinamis
        $(document).ready(function () {
            $('.status-dropdown').on('change', function () {
                const npm = $(this).data('npm');
                const status = $(this).val(); // Ambil status dari dropdown

                $.ajax({
                    url: '', // Arahkan ke script yang sama
                    type: 'POST',
                    data: {
                        updateStatus: true,
                        npm: npm,
                        status: status
                    },
                    success: function (response) {
                        const res = JSON.parse(response);
                        if (res.success) {
                            alert(res.message);
                        } else {
                            alert('Gagal memperbarui status.');
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat mengupdate data.');
                    }
                });
            });
        });
    </script>
</body>
</html>
