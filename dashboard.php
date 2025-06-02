<?php
// Gunakan path relatif yang benar
include_once("db.php");
require_once 'include/functions.php';
// require_once 'db.php';
// !$_SESSION['id_login']

if (empty($_SESSION['id_login'])) {
    redirect('/login/login.php');
}

$userType = getUserType();

// Jika user adalah admin atau IT, tampilkan dashboard khusus mereka
if ($userType === 'admin' || $userType === 'it') {
    // Verifikasi akses
    checkUserAccess($userType);

    // Tampilkan dashboard sesuai role
    if ($userType === 'admin') {
        require_once '/admin/dashboard.php';
    } else {
        require_once '/it/dashboard.php';
    }
    exit();
}

// Jika bukan admin/IT, tampilkan dashboard user biasa
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'include/navbar.php'; ?>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>User Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <h5>Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h5>
                        <p>Anda login sebagai: <span class="badge bg-primary"><?= $userType ?></span></p>
                        <p>Ini adalah dashboard untuk user biasa.</p>
                        <?php
                        // include_once 'pengajuan/pengajuan.php';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    include('include/footer.php');
    ?>

</body>


</html>