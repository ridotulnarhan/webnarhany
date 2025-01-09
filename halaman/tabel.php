<?php
include('../koneksi.php/koneksi.php'); // Menghubungkan ke file koneksi.php

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the related records in the pembelian table (if any)
    $delete_related_sql = "DELETE FROM pembelian WHERE id_sepatu = ?";
    $stmt = $conn->prepare($delete_related_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    // Then, delete the product from the sepatu table
    $delete_sql = "DELETE FROM sepatu WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        // Success, redirect or alert
        echo "<script>alert('Produk berhasil dihapus'); window.location.href = 'dashboard.php';</script>";
    } else {
        // Failure, show error
        echo "<script>alert('Gagal menghapus produk');</script>";
    }
}

// Query untuk mengambil data produk
$sql = "SELECT * FROM sepatu";
$result = $conn->query($sql); // Gunakan $conn yang didefinisikan dalam koneksi.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
include('header.php');
?>

<div class="container mt-5">
    <h1 class="text-center">Toko Sepatu</h1>

    <!-- Tabel Menampilkan Produk -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sepatu</th>
                <th>Ukuran</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th> <!-- Added column for delete action -->
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = $result->fetch_assoc()): 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['ukuran']; ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?= $row['deskripsi']; ?></td>
                <td>
                    <img src="../assets/img/<?= $row['gambar']; ?>" width="100" alt="<?= $row['nama']; ?>">
                </td>
                <td>
                    <!-- Add delete button with confirmation -->
                    <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Semua pesanan terkait akan dihapus!');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Pastikan untuk menutup koneksi
?>
