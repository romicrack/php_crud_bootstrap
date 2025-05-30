<?php
include("../db.php");
// session_start();

// Ambil data berdasarkan ID
if (isset($_GET['id_pengajuan'])) {
    $id = $_GET['id_pengajuan'];
    $query = "SELECT * FROM pengajuan WHERE id_pengajuan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id_pengajuan'];
    $tindakan = mysqli_real_escape_string($conn, $_POST['tindakan']);
    $t_status = $_POST['t_status'];

    $query = "UPDATE pengajuan SET tindakan = ?, t_status = ? WHERE id_pengajuan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $tindakan, $t_status, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Data pengajuan berhasil diupdate!';
        $_SESSION['message_type'] = 'success';
        header('Location: pengajuan.php');
        exit();
    } else {
        $_SESSION['message'] = 'Error: ' . $stmt->error;
        $_SESSION['message_type'] = 'danger';
    }

    $stmt->close();
}
?>

<?php include('../include/header.php'); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Edit Penyelesaian Pengajuan</h4>
                </div>
                <div class="card-body">
                    <form action="pengajuan_edit.php" method="POST">
                        <input type="hidden" name="id_pengajuan" value="<?php echo $row['id_pengajuan']; ?>">

                        <!-- Data yang hanya ditampilkan -->
                        <div class="mb-3">
                            <label class="form-label">Aplikasi</label>
                            <input type="text" class="form-control"
                                value="<?php echo htmlspecialchars($row['aplikasi']); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meja</label>
                            <input type="text" class="form-control"
                                value="<?php echo htmlspecialchars($row['meja']); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kendala</label>
                            <textarea class="form-control" rows="3"
                                readonly><?php echo htmlspecialchars($row['kendala']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Laporan</label>
                            <input type="text" class="form-control"
                                value="<?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?>" readonly>
                        </div>

                        <!-- Form yang bisa diedit -->
                        <div class="mb-3">
                            <label for="tindakan" class="form-label">Tindakan Penyelesaian</label>
                            <textarea class="form-control" id="tindakan" name="tindakan" rows="5" required
                                placeholder="Jelaskan proses penyelesaian masalah..."><?php echo htmlspecialchars($row['tindakan'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="t_status" class="form-label">Status Pengerjaan</label>
                            <select class="form-select" id="t_status" name="t_status" required>
                                <option value="open" <?php echo ($row['t_status'] ?? '') === 'open' ? 'selected' : ''; ?>>
                                    Open</option>
                                <option value="onproses" <?php echo ($row['t_status'] ?? '') === 'onproses' ? 'selected' : ''; ?>>On Proses</option>
                                <option value="close" <?php echo ($row['t_status'] ?? '') === 'close' ? 'selected' : ''; ?>>Close</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="pengajuan.php" class="btn btn-secondary me-md-2">Kembali</a>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>