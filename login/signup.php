<?php
require_once '../include/functions.php';

// if (isLoggedIn()) {
//     redirect('dashboard.php');
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../include/auth.php';

    $username = $_POST['username'] ?? '';
    $idlogin_karyawan = $_POST['idlogin_karyawan'] ?? '';
    $type_user = $_POST['type_user'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (registerUser($username, $email, $password, $confirm_password, $idlogin_karyawan, $type_user)) {
        $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
        redirect('login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-center">Sign Up</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['errors'])): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach;
                                    unset($_SESSION['errors']); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'];
                            unset($_SESSION['error']); ?></div>
                        <?php endif; ?>

                        <form action="signup.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" maxlength="30"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="idlogin_karyawan " class="form-label">ID Karyawan</label>
                                <input type="number" class="form-control" id="idlogin_karyawan" name="idlogin_karyawan"
                                    maxlength="30" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" maxlength="50"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" maxlength="20"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" maxlength="20" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>