<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM table_karyawan WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query Failed.");
        # code...
    }

    $_SESSION['message'] = 'Delete Berhasil';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
}
?>