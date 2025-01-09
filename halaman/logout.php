<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user confirmed the logout
if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    session_unset();
    session_destroy();
    header("Location: ../login.php/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Toko Sepatu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function confirmLogout() {
            let confirmation = confirm("Apakah Anda yakin ingin logout?");
            if (confirmation) {
                // Redirect to logout page with confirmation
                window.location.href = 'logout.php?confirm=yes';
            } else {
                // Stay on the current page
                window.location.href = 'dashboard.php';
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Apakah Anda yakin ingin logout?</h2>
        <button class="btn btn-danger" onclick="confirmLogout()">Logout</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
