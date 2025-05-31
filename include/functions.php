<?php
function redirect($url)
{
    header("Location: $url");
    exit();
}

function isLoggedIn()
{
    return $_SESSION['id_login'];
}

function getUserType()
{
    return $_SESSION['user_type'] ?? null;
}

function sanitizeInput($data)
{
    global $conn;
    return htmlspecialchars(stripslashes(trim($conn->real_escape_string($data))));
}

function checkUserAccess($requiredType)
{
    $userType = getUserType();
    $accessLevels = ['user' => 1, 'admin' => 2, 'it' => 3];

    if (!isset($accessLevels[$userType])) {
        $_SESSION['error'] = "Tipe user tidak valid";
        redirect('../login.php');
    }

    if ($accessLevels[$userType] < $accessLevels[$requiredType]) {
        $_SESSION['error'] = "Anda tidak memiliki akses ke halaman ini";
        redirect('../login.php');
    }
}

// Pastikan session_start() hanya dipanggil sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}