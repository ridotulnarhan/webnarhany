<?php
include('../koneksi.php/koneksi.php');
require('../fpdf186/fpdf.php'); // Pastikan path ke fpdf.php sudah benar

// Mendapatkan data sepatu dari database
$sql_sepatu = "SELECT * FROM sepatu";
$result_sepatu = $conn->query($sql_sepatu);

// Proses pembelian
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pembeli = $_POST['nama_pembeli'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $id_sepatu = $_POST['id_sepatu'];
    $jumlah = $_POST['jumlah'];

    // Mendapatkan harga sepatu yang dibeli
    $sql_harga = "SELECT harga, nama FROM sepatu WHERE id = $id_sepatu";
    $result_harga = $conn->query($sql_harga);
    $row_harga = $result_harga->fetch_assoc();
    $harga = $row_harga['harga'];
    $nama_sepatu = $row_harga['nama'];

    // Menghitung total harga
    $total_harga = $harga * $jumlah;

    // Menyimpan data pembelian ke database
    $sql_pembelian = "INSERT INTO pembelian (nama_pembeli, alamat, telepon, id_sepatu, jumlah, total_harga) 
                      VALUES ('$nama_pembeli', '$alamat', '$telepon', '$id_sepatu', '$jumlah', '$total_harga')";
    
    if ($conn->query($sql_pembelian) === TRUE) {
        // Membuat PDF dengan FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('Arial', 'B', 16);
        
        // Menambah judul dan informasi pembelian
        $pdf->Cell(200, 10, 'Struk Pembelian Sepatu', 0, 1, 'C');
        $pdf->Ln(10); // Jarak baris
        $pdf->SetFont('Arial', '', 12);
        
        $pdf->Cell(50, 10, 'Nama Pembeli: ' . $nama_pembeli, 0, 1);
        $pdf->Cell(50, 10, 'Alamat: ' . $alamat, 0, 1);
        $pdf->Cell(50, 10, 'Telepon: ' . $telepon, 0, 1);
        $pdf->Cell(50, 10, 'Sepatu: ' . $nama_sepatu, 0, 1);
        $pdf->Cell(50, 10, 'Jumlah: ' . $jumlah, 0, 1);
        $pdf->Cell(50, 10, 'Total Harga: Rp ' . number_format($total_harga, 2, ',', '.'), 0, 1);
        
        // Output PDF ke browser
        $pdf->Output('I', 'struk_pembelian.pdf'); // 'I' berarti tampilkan di browser
    } else {
        echo "Error: " . $sql_pembelian . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Pembelian Sepatu</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
            <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>
        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" required>
        </div>
        <div class="mb-3">
            <label for="id_sepatu" class="form-label">Sepatu</label>
            <select class="form-control" id="id_sepatu" name="id_sepatu" required>
                <option value="">Pilih Sepatu</option>
                <?php while ($row = $result_sepatu->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?> - Rp <?php echo number_format($row['harga'], 2, ',', '.'); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1">
        </div>
        <button type="submit" class="btn btn-primary">Beli Sekarang</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
