<?php
include("db.php");

if (isset($_POST['save_task'])) {
    // Validasi nama tidak kosong
    if (empty($_POST['nama'])) {
        $_SESSION['message'] = 'Nama tidak boleh kosong!';
        $_SESSION['message_type'] = 'danger';
        header('Location: index.php');
        exit();
    }

    // Cek duplikat nama
    $stmt = $conn->prepare("SELECT id FROM table_karyawan WHERE nama = ?");
    $stmt->bind_param("s", $_POST['nama']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = 'Nama karyawan sudah terdaftar!';
        $_SESSION['message_type'] = 'danger';
    } else {
        // Simpan data
        $insert = $conn->prepare("INSERT INTO table_karyawan 
                                (nama, id_karyawan, tgl_lahir, alamat, devisi, jender, jabatan) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param(
            "sisssss",
            $_POST['nama'],
            $_POST['id_karyawan'],
            $_POST['tanggal_lahir'],
            $_POST['alamat'],
            $_POST['devisi'],
            $_POST['jender'],
            $_POST['jabatan']
        );

        if ($insert->execute()) {
            $_SESSION['message'] = 'Data berhasil disimpan';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error: ' . $insert->error;
            $_SESSION['message_type'] = 'danger';
        }
        $insert->close();
    }

    $stmt->close();
    header('Location: index.php');
    exit();
}
?>