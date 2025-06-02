<?php
include("../include/init.php");
include("../include/navbar.php");
?>

<body>


    <main class="">
        <div class="row">
            <div class="col-md-2">
                <!-- message -->
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" id="flashMessage">
                        <?= $_SESSION['message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            // Auto close dengan efek fade out
                            setTimeout(function () {
                                $('#flashMessage').fadeOut('slow', function () {
                                    $(this).alert('close');
                                });
                            }, 2000);

                            // Hapus session via AJAX (opsional)
                            $.get('clear_session.php'); // File untuk unset session
                        });
                    </script>
                    <?php
                    // Tetap hapus session di PHP juga
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                endif; ?>

                <!-- add task form -->

                <div class="card card-body ">
                    <form action="simpan.php" method="POST">
                        <div class="form-group ">
                            <input type="text" name="nama" class="form-control" placeholder="Isi Nama Anda!" autofocus>
                            <br>
                        </div>
                        <div class="form-group">
                            <input type="text" name="id_karyawan" class="form-control"
                                placeholder="Masukkan Id Karyawan Anda">
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="date" name="tanggal_lahir" class="form-control"
                                placeholder="Isi Tanggal Lahir Anda!" autofocus><br>
                        </div>

                        <div class="form-group">
                            <select name="jender" class="form-control" required>
                                <option value="">Jenis Kelamin</option>
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>

                            </select><br>
                        </div>
                        <div class="form-group">
                            <input type="text" name="devisi" class="form-control" placeholder="Isi Devisi Anda!"
                                autofocus>
                            <br>
                        </div>
                        <div class="form-group">
                            <input type="text" name="jabatan" class="form-control" placeholder="Isi Jabatan Anda!"
                                autofocus>
                            <br>
                        </div>
                        <div class="form-group">

                            <textarea name="alamat" class="form-control" rows="4"
                                placeholder="Isikan Alamat"></textarea>
                        </div><br>

                        <input type="submit" name="save_task" class="btn btn-success btn-block" value="Save Task">

                    </form>
                </div>

            </div>


            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>No. </th>
                            <th>Nama</th>
                            <th>No Id Karyawan</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Devisi</th>
                            <th>Jabatan</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM table_karyawan";
                        $result_tasks = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result_tasks)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['nama'] ?></td>
                                <td><?php echo $row['id_karyawan'] ?></td>
                                <td><?php echo $row['tgl_lahir'] ?></td>
                                <td><?php echo $row['jender'] ?></td>
                                <td><?php echo $row['devisi'] ?></td>
                                <td><?php echo $row['jabatan'] ?></td>
                                <td>
                                    <textarea name="" id="" rows="1"><?php echo $row['alamat'] ?></textarea>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="edit.php?id=<?php echo $row['id'] ?>"
                                            class="btn btn-secondary form-control">
                                            <i class="fas fa-marker"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id'] ?>"
                                            class="form-control btn btn-danger">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include_once "../include/footer.php"; ?>