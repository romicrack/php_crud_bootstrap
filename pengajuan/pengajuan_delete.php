<?php
include("../db.php");

if (isset($_GET['id_pengajuan'])) {
    $id = $_GET['id_pengajuan'];
    $query = "DELETE FROM pengajuan WHERE id_pengajuan='$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query Failed");
        # code...
    }


    $_SESSION['message'] = "Delete Berhasil";
    $_SESSION['message_type'] = "danger";
    header("Location: pengajuan.php");
    # code...
}

?>