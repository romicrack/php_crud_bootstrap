<?php
require_once 'functions.php';
include_once '../db.php';

function loginUser($username, $password)
{
    global $conn;

    $username = sanitizeInput($username);

    $sql = "SELECT id_login, username, password, type_user FROM login WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Validasi password (diasumsikan password disimpan sebagai plaintext dalam contoh ini)
        // Dalam produksi, gunakan password_verify() untuk password yang di-hash
        if ($password === $user['password']) {
            $_SESSION['id_login'] = $user['id_login'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['type_user'] = $user['type_user'];

            return true;
        }
    }

    $_SESSION['error'] = "Username/email atau password salah";
    return false;
}

function registerUser($username, $email, $password, $confirm_password, $idlogin_karyawan, $type_user = 'user')
{
    global $conn;

    // Paksa nilai default jika kosong
    if (empty($type_user)) {
        $type_user = 'user';
    }

    // Validasi input
    $errors = [];

    if (empty($username)) {
        $errors[] = "Username harus diisi";
    } elseif (strlen($username) > 30) {
        $errors[] = "Username maksimal 30 karakter";
    }

    if (empty($email)) {
        $errors[] = "Email harus diisi";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    } elseif (strlen($email) > 50) {
        $errors[] = "Email maksimal 50 karakter";
    }

    if (empty($password)) {
        $errors[] = "Password harus diisi";
    } elseif (strlen($password) > 20) {
        $errors[] = "Password maksimal 20 karakter";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Password dan konfirmasi password tidak sama";
    }

    // Cek username/email sudah ada
    $sql = "SELECT id_login FROM login WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Username atau email sudah terdaftar";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        return false;
    }

    // Simpan user baru
    $sql = "INSERT INTO login (username, email, password, type_user, idlogin_karyawan) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $email, $password, $type_user, $idlogin_karyawan);

    if ($stmt->execute()) {
        return true;
    } else {
        $_SESSION['error'] = "Gagal mendaftar: " . $conn->error;
        return false;
    }
}


// function registerUser($username, $email, $password, $confirm_password, $idlogin_karyawan, $type_user = 'user')
// {
//     global $conn;

//     // Validasi input
//     $errors = [];

//     if (empty($username)) {
//         $errors[] = "Username harus diisi";
//     } elseif (strlen($username) > 30) {
//         $errors[] = "Username maksimal 30 karakter";
//     }

//     if (empty($email)) {
//         $errors[] = "Email harus diisi";
//     } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors[] = "Format email tidak valid";
//     } elseif (strlen($email) > 50) {
//         $errors[] = "Email maksimal 50 karakter";
//     }

//     if (empty($password)) {
//         $errors[] = "Password harus diisi";
//     } elseif (strlen($password) > 20) {
//         $errors[] = "Password maksimal 20 karakter";
//     } elseif ($password !== $confirm_password) {
//         $errors[] = "Password dan konfirmasi password tidak sama";
//     }

//     // Cek username/email sudah ada
//     $sql = "SELECT id_login FROM login WHERE username = ? OR email = ?";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ss", $username, $email);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $errors[] = "Username atau email sudah terdaftar";
//     }

//     if (!empty($errors)) {
//         $_SESSION['errors'] = $errors;
//         return false;
//     }

//     // Simpan user baru
//     $sql = "INSERT INTO login (username, email, password, type_user, idlogin_karyawan) VALUES (?, ?, ?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("ssssi", $username, $email, $password, $type_user, $idlogin_karyawan);

//     if ($stmt->execute()) {
//         return true;
//     } else {
//         $_SESSION['error'] = "Gagal mendaftar: " . $conn->error;
//         return false;
//     }
// }


?>