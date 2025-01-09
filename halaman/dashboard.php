<?php
include('../koneksi.php/koneksi.php');
$sql = "SELECT * FROM sepatu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">
 
<body>

<?php
include("header.php");
?>

    <!-- Dashboard Cards -->
    <div class="container mt-5">
        <div class="row">
            <!-- Card 1: Jumlah Produk -->
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Produk</h5>
                        <p class="card-text">100</p>
                    </div>
                </div>
            </div>
            <!-- Card 2: Total Penjualan -->
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Penjualan</h5>
                        <p class="card-text">Rp 5.000.000</p>
                    </div>
                </div>
            </div>
            <!-- Card 3: Pesanan Baru -->
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Pesanan Baru</h5>
                        <p class="card-text">12</p>
                    </div>
                </div>
            </div>
            <!-- Card 4: Stok Habis -->
            <div class="col-md-3 mb-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">Stok Habis</h5>
                        <p class="card-text">5</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Produk -->
        <h2 class="mt-4">Daftar Sepatu</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Sepatu</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
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
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
