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
                        <h2 class="box-title">THÔNG TIN LỚP HỌC PHẦN</h2>
                        <?php
                        /**
                         * Add info to database tbl_lophocphan
                         */

                        if (isset($_POST['add_btn'])) {
                            $mlcn   = $_POST['mlcn'];
                            $mhp    = $_POST['mhp'];
                            $nhom   = $_POST['nhom'];
                            $hocky  = $_POST['hocky'];
                            $namhoc = $_POST['namhoc'];

                            $stmt_insert_lhp = $pdo->prepare("INSERT INTO tbl_lophocphan
	                                                         (mlcn, mhp, nhom, hocki, namhoc)
	                                                         VALUES ('$mlcn', '$mhp', '$nhom', '$hocky', '$namhoc')");
                            $stmt_insert_lhp->execute();
                            echo '<script>location.href="lophp.php";</script>';
                        }


                        /**
                         * Select mlcn from database
                         */

                        $stmt_sl_mlcn = $pdo->prepare("SELECT mlcn FROM tbl_lopchuyennghanh");
                        $stmt_sl_mlcn->execute();
                        $result_sl_mlcn = $stmt_sl_mlcn->fetchAll(PDO::FETCH_ASSOC);


                        /**
                         * Select mhp from database
                         */
                        $stmt_sl_mhp = $pdo->prepare("SELECT mhp FROM tbl_hocphan");
                        $stmt_sl_mhp->execute();
                        $result_sl_mhp = $stmt_sl_mhp->fetchAll(PDO::FETCH_ASSOC);

                        /**
                         * Delete 
                         */
                        if (isset($_GET['mlcn_id']) && isset($_GET['mhp_id'])) {
                            $mlcn_id     = $_GET['mlcn_id'];
                            $mhp_id      = $_GET['mhp_id'];
                            $stmt_dl_lhp = $pdo->prepare("DELETE FROM tbl_lophocphan WHERE mlcn='$mlcn_id' AND mhp='$mhp_id'");
                            $stmt_dl_lhp->execute();
                            echo '<script>location.href="lophp.php";</script>';
                        }

                        ?>

                        <form action="" method="POST" class="box-form">
                            <div class="form-group">
                                <label>Mã lớp CN</label>
                                <select name="mlcn" id="">
                                    <?php foreach ($result_sl_mlcn as $row) { ?>
                                        <option value="<?= $row['mlcn'] ?>">
                                            <?= $row['mlcn'] ?>
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
                                <label>Nhóm</label>
                                <input type="number" name="nhom" placeholder="Nhóm" required>
                            </div>

                            <div class="form-group">
                                <label>Học kỳ</label>
                                <input type="number" name="hocky" placeholder="Học kỳ" required>
                            </div>

                            <div class="form-group">
                                <label>Năm học</label>
                                <input type="text" name="namhoc" placeholder="Năm học" required>
                            </div>

                            <button name="add_btn" class="add_btn">Thêm mới</button>
                        </form>


                        <?php
                        /**
                         * Select lop_hp data from database
                         */

                        $stmt_sl_lhp = $pdo->prepare("SELECT * FROM tbl_lophocphan");
                        $stmt_sl_lhp->execute();
                        $result_sl_lhp = $stmt_sl_lhp->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <table class="table-content" id="danhsach">
                            <thead>
                                <th>Mã lớp CN</th>
                                <th>Mã học phần</th>
                                <th>Nhóm</th>
                                <th>Học kỳ</th>
                                <th>Năm học</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach ($result_sl_lhp as $row) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['mlcn'] ?>
                                        </td>
                                        <td>
                                            <?= $row['mhp'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nhom'] ?>
                                        </td>
                                        <td>
                                            <?= $row['hocki'] ?>
                                        </td>
                                        <td>
                                            <?= $row['namhoc'] ?>
                                        </td>
                                        <td
                                            style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 2rem;">
                                            <a href="#" data-mlcn_id=<?= $row['mlcn'] ?> data-mhp_id=<?= $row['mhp'] ?>
                                                id="update-icon" style="color: orange;"><ion-icon
                                                    name="pencil-outline"></ion-icon></a>
                                            <a href="?mlcn_id=<?= $row['mlcn'] ?>&mhp_id=<?= $row['mhp'] ?>"
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
                var mlcn_id = $(this).data("mlcn_id");
                var mhp_id = $(this).data("mhp_id");

                $.post("./update/update_lhp.php", {
                    mlcn_id: mlcn_id,
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