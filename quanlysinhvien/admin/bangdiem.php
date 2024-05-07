<?php
include('../database/config.php');
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo '<script>location.href="../index.php";</script>';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>

    <!-- FONT -->
    <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>


    <style>
        .dataTables_filter {
            margin-bottom: 10px;
        }

        .box {
            padding-inline: 5rem;
        }
    </style>
</head>

<body>

    <!-- INCLUDE HEADER -->
    <?php include('./header.php') ?>

    <main>
        <article>
            <!-- CONTENT -->
            <div class="box-parent">
                <div class="container">
                    <div class="box">
                        <h2 class="box-title">THÔNG TIN BẢNG ĐIỂM</h2>

                        <?php

                        /**
                         * Select info from tbl_diemhocphan
                         */
                        $stmt_sl_dhp = $pdo->prepare("SELECT * FROM tbl_diemhocphan");
                        $stmt_sl_dhp->execute();
                        $result_sl_dhp = $stmt_sl_dhp->fetchAll(PDO::FETCH_ASSOC);


                        /**
                         * Select info from database tbl_sinhvien
                         */

                        $stmt_sl_sv = $pdo->prepare("SELECT * FROM tbl_sinhvien");
                        $stmt_sl_sv->execute();
                        $result_sl_sv = $stmt_sl_sv->fetchAll(PDO::FETCH_ASSOC);


                        /**
                         * Select mhp from database
                         */
                        $stmt_sl_mhp = $pdo->prepare("SELECT mhp 
                                                      FROM tbl_hocphan
                                                      WHERE NOT EXISTS(
                                                          SELECT 1 
                                                          FROM tbl_diemhocphan
                                                          WHERE tbl_diemhocphan.mhp = tbl_hocphan.mhp
                                                      );
                                                      ");
                        $stmt_sl_mhp->execute();
                        $result_sl_mhp = $stmt_sl_mhp->fetchAll(PDO::FETCH_ASSOC);


                        /**
                         * Add info to database tbl_diemhocphan
                         */

                        if (isset($_POST['add_btn'])) {
                            $msv   = $_POST['msv'];
                            $mhp   = $_POST['mhp'];
                            $diema = $_POST['diema'];
                            $diemb = $_POST['diemb'];
                            $diemc = $_POST['diemc'];

                            $stmt_is_dhp = $pdo->prepare("INSERT INTO tbl_diemhocphan
	                                                      (msv, mhp, A, B, C)
	                                                      VALUES ('$msv', '$mhp', $diema, $diemb, $diemc)");
                            $stmt_is_dhp->execute();
                            echo '<script>location.href="bangdiem.php";</script>';
                        }

                        /**
                         * Delete
                         */

                        if (isset($_GET['msv_id']) && isset($_GET['mhp_id'])) {
                            $msv_id = $_GET['msv_id'];
                            $mhp_id = $_GET['mhp_id'];

                            $stmt_dl_dhp = $pdo->prepare("DELETE FROM tbl_diemhocphan WHERE msv='$msv_id' AND mhp='$mhp_id'");
                            $stmt_dl_dhp->execute();
                            echo '<script>location.href="bangdiem.php";</script>';
                        }

                        ?>

                        <form action="" method="POST" class="box-form">

                            <div class="form-group">
                                <label>Mã sinh viên</label>

                                <select name="msv" id="">
                                    <?php foreach ($result_sl_sv as $row) { ?>
                                        <option value="<?= $row['msv'] ?>">
                                            <?= $row['msv'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Mã học phần</label>
                                <select name="mhp" id="">
                                    <?php foreach ($result_sl_mhp as $row) { ?>
                                        <option value="<?= $row['mhp'] ?>">
                                            <?= $row['mhp'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>A</label>
                                <input type="number" name="diema" placeholder="Điểm A" min="0" max="10" required>
                            </div>

                            <div class="form-group">
                                <label>B</label>
                                <input type="number" name="diemb" placeholder="Điểm B" min="0" max="10" required>
                            </div>

                            <div class="form-group">
                                <label>C</label>
                                <input type="number" name="diemc" placeholder="Điểm C" min="0" max="10" required>
                            </div>

                            <button name="add_btn" class="add_btn">Thêm mới</button>
                        </form>


                        <table class="table-content" id="danhsach">
                            <thead>
                                <th>Mã sinh viên</th>
                                <th>Mã học phần</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach ($result_sl_dhp as $row) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['msv'] ?>
                                        </td>

                                        <td>
                                            <?= $row['mhp'] ?>
                                        </td>

                                        <td>
                                            <?= $row['A'] ?>
                                        </td>

                                        <td>
                                            <?= $row['B'] ?>
                                        </td>


                                        <td>
                                            <?= $row['C'] ?>
                                        </td>

                                        <td
                                            style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 2rem;">
                                            <a href="#" data-msv_id=<?= $row['msv'] ?> data-mhp_id=<?= $row['mhp'] ?>
                                                id="update-icon" style="color: orange;"><ion-icon
                                                    name="pencil-outline"></ion-icon></a>
                                            <a href="?msv_id=<?= $row['msv'] ?>&mhp_id=<?= $row['mhp'] ?>"
                                                style="color: red;"><ion-icon name="trash-outline"></ion-icon></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


            <div class="box-update" id="box-update">

            </div>
        </article>
    </main>


    <!-- ion-icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        $(document).ready(function () {
            $('#danhsach').DataTable({
                "bLengthChange": false
            });


            $("#danhsach").on("click", "#update-icon", function (e) {
                e.preventDefault();
                $("#box-update").css("display", "grid");
                var msv_id = $(this).data("msv_id");
                var mhp_id = $(this).data("mhp_id");

                $.post("./update/update_dhp.php", {
                    msv_id: msv_id,
                    mhp_id: mhp_id,
                },
                    function (result) {
                        $("#box-update").html(result);
                    }
                );

            })
        });
    </script>
</body>

</html>