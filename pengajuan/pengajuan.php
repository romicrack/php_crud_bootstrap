<?php
// include("../db.php");
?>

<?php
// include("../include/header.php");
global $conn;
?>
<!-- container mt-5 -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Form Pengajuan Kendala</h5>
            </div>
            <div class="card-body">
                <form action="prosess.php" method="POST">
                    <div class="form-group">
                        <label for="pengajuan">Masukkan Teks Pengajuan:</label>
                        <textarea class="form-control" id="pengajuan" name="pengajuan" rows="5" required placeholder="Contoh:
Aplikasi: adakami BNC
Meja: 2129
Kendala: tidak bisa masuk sistem"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Tampilkan data yang sudah ada -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Daftar Pengajuan </h4>
            </div>
            <div class="card-body table-responsive " style="max-height: 450px; overflow-y: auto;">
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Aplikasi</th>
                            <th>Meja</th>
                            <th>Kendala</th>
                            <th>Tanggal Dilaporkan</th>
                            <th>Tindakan</th>
                            <th>Status Pengerjaan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM pengajuan ORDER BY tanggal DESC";
                        $result = mysqli_query($conn, $query);
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo "{$no}"; ?></td>
                                <td><?php echo "{$row['aplikasi']}"; ?></td>
                                <td><?php echo "{$row['meja']}"; ?></td>
                                <td><?php echo "{$row['kendala']}"; ?></td>
                                <td><?php echo "" . date('d/m/Y H:i', strtotime($row['tanggal'])) . ""; ?></td>
                                <td><?php echo "{$row['tindakan']}"; ?></td>
                                <td class="text-center"><?php echo "{$row['t_status']}"; ?></td>
                                <td>

                                    <div class="btn-group" role="group">
                                        <a href="pengajuan_edit.php?id_pengajuan=<?php echo $row['id_pengajuan']; ?>"
                                            class="btn btn-warning">Edit</a>
                                        <div style="margin: 2px;"></div>
                                        <a href="pengajuan_delete.php?id_pengajuan=<?php echo $row['id_pengajuan'] ?>"
                                            class="btn btn-danger">Delete</a>
                                    </div>
                                </td>
                            </tr>

                            <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>