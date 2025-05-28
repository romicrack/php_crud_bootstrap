<?php
// session_start();
include("db.php");

// Inisialisasi variabel
$nama = '';
$id_karyawan = '';
$alamat = '';
$tgl_lahir = '';
$jender = '';
$devisi = '';
$jabatan = '';

// Proses ambil data untuk edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM table_karyawan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = $row["nama"];
        $id_karyawan = $row["id_karyawan"];
        $alamat = $row["alamat"];
        $tgl_lahir = $row["tgl_lahir"];
        $jender = $row["jender"];
        $devisi = $row["devisi"];
        $jabatan = $row["jabatan"];
    }
    $stmt->close();
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $id_karyawan = mysqli_real_escape_string($conn, $_POST['id_karyawan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tgl_lahir = $_POST['tgl_lahir'];
    $jender = $_POST['jender'];
    $devisi = mysqli_real_escape_string($conn, $_POST['devisi']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);

    $query = "UPDATE table_karyawan SET 
              nama=?, id_karyawan=?, alamat=?, tgl_lahir=?, jender=?, devisi=?, jabatan=? 
              WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisssssi", $nama, $id_karyawan, $alamat, $tgl_lahir, $jender, $devisi, $jabatan, $id);


    if ($stmt->execute()) {
        $_SESSION['message'] = 'Update Berhasil';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error;
        $_SESSION['message_type'] = 'danger';
    }

    $stmt->close();
    header('Location: index.php');
    exit();
}

include('include/header.php');
?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card card-body">
                <form action="edit.php?id=<?php echo htmlspecialchars($_GET['id'] ?? ''); ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="nama" class="form-control"
                            value="<?php echo htmlspecialchars($nama); ?>" placeholder="Update Nama" required>
                    </div><br>
                    <div class="form-group">
                        <input type="number" name="id_karyawan" class="form-control"
                            value="<?php echo htmlspecialchars($id_karyawan); ?>" placeholder="Update Id Karyawan"
                            required>
                    </div><br>

                    <div class="form-group">
                        <input type="date" name="tgl_lahir" class="form-control"
                            value="<?php echo htmlspecialchars($tgl_lahir); ?>" placeholder="Update tanggal lahir"
                            required>
                    </div><br>

                    <div class="form-group">
                        <select name="jender" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="laki-laki" <?= $jender == 'laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="perempuan" <?= $jender == 'perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div><br>

                    <div class="form-group">
                        <input type="text" name="devisi" class="form-control"
                            value="<?php echo htmlspecialchars($devisi); ?>" placeholder="Update Devisi" required>
                    </div><br>

                    <div class="form-group">
                        <input type="text" name="jabatan" class="form-control"
                            value="<?php echo htmlspecialchars($jabatan); ?>" placeholder="Update Jabatan" required>
                    </div><br>

                    <div class="form-group">
                        <textarea name="alamat" class="form-control" rows="4" placeholder="Update alamat"
                            required><?php echo htmlspecialchars($alamat); ?></textarea>
                    </div><br>

                    <button type="submit" class="btn btn-success" name="update">Update</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('include/footer.php'); ?>