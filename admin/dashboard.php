<?php
// require_once '../include/functions.php';
// checkUserAccess('admin');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../include/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Admin Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <h5>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h5>
                        <p>Anda login sebagai: <span class="badge bg-success"><?= getUserType() ?></span></p>
                        <p>Ini adalah dashboard untuk administrator.</p>
                        <div class="mt-4">
                            <h6>Fitur Admin:</h6>
                            <ul>
                                <li>Manajemen User (kecuali IT)</li>
                                <li>Manajemen Konten</li>
                                <li>Laporan Sistem</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>