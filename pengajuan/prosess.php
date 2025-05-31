<?php
include('../db.php');
// session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['pengajuan'];

    $aplikasi = '';
    $meja = '';
    $kendala = '';
    $tindakan = '';
    $t_status = '';
    $possible_kendala = [];

    $lines = explode("\n", $text);
    $lines = array_filter(array_map('trim', $lines)); // hapus baris kosong & trim

    foreach ($lines as $line) {
        // Deteksi Aplikasi
        if (preg_match('/^(Aplikasi|App|Nama Aplikasi|System|Sistem)[:\s]*(.*)/i', $line, $matches)) {
            $aplikasi = trim($matches[2]);
        }
        // Deteksi Meja
        elseif (preg_match('/^(Nomor Meja|No Meja|Meja|Meja Nomor)[:\s]*(.*)/i', $line, $matches)) {
            $meja = trim(preg_replace('/[^0-9]/', '', $matches[2]));
        }
        // Deteksi Kendala eksplisit
        elseif (preg_match('/^(Kendala|Masalah|Issue|Permasalahan|Problem)[:\s]*(.*)/i', $line, $matches)) {
            $kendala = trim($matches[2]);
        }
        // Deteksi kendala berdasarkan isi kalimat
        elseif (stripos($line, 'tidak bisa') !== false || stripos($line, 'mohon bantuan') !== false || stripos($line, 'tolong') !== false || stripos($line, 'error') !== false) {
            $possible_kendala[] = $line;
        }
        // Tambahkan baris lain sebagai kemungkinan kendala
        else {
            $possible_kendala[] = $line;
        }
    }

    // Fallback: gunakan possible_kendala jika kendala belum terisi
    if (empty($kendala) && !empty($possible_kendala)) {
        $kendala = implode(" ", $possible_kendala);
    }

    // Default fallback
    if (empty($aplikasi))
        $aplikasi = 'Tidak Diketahui';
    if (empty($meja))
        $meja = '0000';
    if (empty($tindakan))
        $tindakan = '';
    if (empty($t_status))
        $t_status = 'open';

    // Simpan ke database
    $query = "INSERT INTO pengajuan (aplikasi, meja, kendala, tindakan, t_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $aplikasi, $meja, $kendala, $tindakan, $t_status);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = 'Pengajuan berhasil disimpan!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menyimpan pengajuan: ' . mysqli_error($conn);
        $_SESSION['message_type'] = 'danger';
    }

    mysqli_stmt_close($stmt);
}



header('Location: pengajuan.php');
exit();
?>