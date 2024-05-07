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
                        <h2 class="box-title">THÔNG TIN LỚP CN</h2>

                        <?php
                        /**
                         * Add info to tbl_lopchuyennghanh
                         */

                        if (isset($_POST['add_btn'])) {
                            $mlcn   = $_POST['mlcn'];
                            $tl     = $_POST['tl'];
                            $nk     = $_POST['nk'];
                            $siso   = $_POST['siso'];
                            $makhoa = $_POST['makhoa'];

                            $stmt_insert = $pdo->prepare("INSERT INTO tbl_lopchuyennghanh
                                                       	(mlcn, tenlop, nienkhoa, siso, mk)
                                                       	VALUES ('$mlcn', '$tl', '$nk', $siso, '$makhoa')");
                            $stmt_insert->execute();
                            echo '<script>location.href="lop.php";</script>';
                        }


                        /**
                         * Delete tbl_lopchuyennghanh
                         */

                        if (isset($_GET['mlcn_id'])) {
                            $mlcn_id     = $_GET['mlcn_id'];
                            $stmt_delete = $pdo->prepare("DELETE FROM tbl_lopchuyennghanh WHERE mlcn='$mlcn_id'");
                            $stmt_delete->execute();
                            echo '<script>location.href="lop.php";</script>';
                        }
                        ?>

                        <form action="" method="POST" class="box-form">
                            <div class="form-group">
                                <label>Mã lớp CN</label>
                                <input type="text" name="mlcn" placeholder="Mã lớp CN" required>
                            </div>

                            <div class="form-group">
                                <label>Tên lớp</label>
                                <input type="text" name="tl" placeholder="Tên lớp" required>
                            </div>

                            <div class="form-group">
                                <label>Niên khóa</label>
                                <input type="text" name="nk" placeholder="Niên khóa" required>
                            </div>
                            <div class="form-group">
                                <label>Sĩ số</label>
                                <input type="text" name="siso" placeholder="Sĩ số" required>
                            </div>

                            <?php
                            /**
                             * Select mk from database
                             */

                            $stmt_sl_khoa = $pdo->prepare("SELECT * FROM tbl_khoa");
                            $stmt_sl_khoa->execute();
                            $result_sl_khoa = $stmt_sl_khoa->fetchAll(PDO::FETCH_ASSOC);
                            ?>

                            <div class="form-group">
                                <label>Mã khoa</label>
                                <select name="makhoa">
                                    <?php foreach ($result_sl_khoa as $row) { ?>
                                        <option value="<?= $row['mk'] ?>">
                                            <?= $row['mk'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <button name="add_btn" class="add_btn">Thêm mới</button>
                        </form>


                        <?php
                        /**
                         * Select lop_chuyen_nganh data from database
                         */

                        $stmt_sl_lcn = $pdo->prepare("SELECT * FROM tbl_lopchuyennghanh");
                        $stmt_sl_lcn->execute();
                        $result_sl_lcn = $stmt_sl_lcn->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <table class="table-content" id="danhsach">
                            <thead>
                                <th>Mã lớp CN</th>
                                <th>Tên lớp</th>
                                <th>Niên khóa</th>
                                <th>Sĩ số</th>
                                <th>Mã khoa</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach ($result_sl_lcn as $row) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['mlcn'] ?>
                                        </td>
                                        <td>
                                            <?= $row['tenlop'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nienkhoa'] ?>
                                        </td>
                                        <td>
                                            <?= $row['siso'] ?>
                                        </td>
                                        <td>
                                            <?= $row['mk'] ?>
                                        </td>
                                        <td
                                            style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 2rem;">
                                            <a href="#" id="update-icon" data-mlcn_id=<?= $row['mlcn'] ?>
                                                style="color: orange;"><ion-icon name="pencil-outline"></ion-icon></a>
                                            <a href="?mlcn_id=<?= $row['mlcn'] ?>" style="color: red;"><ion-icon
                                                    name="trash-outline"></ion-icon></a>
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
                var mlcn_id = $(this).data("mlcn_id");

                $.post("./update/update_lcn.php", {
                    mlcn_id: mlcn_id,
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