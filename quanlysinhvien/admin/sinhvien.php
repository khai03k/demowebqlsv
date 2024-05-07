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
                        <h2 class="box-title">THÔNG TIN SINH VIÊN</h2>

                        <?php
                        /**
                         * Select info from database tbl_sinhvien
                         */

                        $stmt_sl_sv = $pdo->prepare("SELECT * FROM tbl_sinhvien");
                        $stmt_sl_sv->execute();
                        $result_sl_sv = $stmt_sl_sv->fetchAll(PDO::FETCH_ASSOC);

                        /**
                         * Select mlcn from database
                         */

                        $stmt_sl_mlcn = $pdo->prepare("SELECT mlcn FROM tbl_lopchuyennghanh");
                        $stmt_sl_mlcn->execute();
                        $result_sl_mlcn = $stmt_sl_mlcn->fetchAll(PDO::FETCH_ASSOC);


                        /**
                         * Add info to database
                         */

                        if (isset($_POST['add_btn'])) {
                            $msv   = $_POST['msv'];
                            $holot = $_POST['holot'];
                            $ten   = $_POST['ten'];
                            $mlcn  = $_POST['mlcn'];
                            $sdt   = $_POST['sdt'];
                            $email = $_POST['email'];

                            $stmt_is_sv = $pdo->prepare("INSERT INTO tbl_sinhvien
                                                    	(msv, holot, ten, mlcn, sodidong, email)
                                                    	VALUES ('$msv', '$holot', '$ten', '$mlcn', '$sdt', '$email')");
                            $stmt_is_sv->execute();
                            echo '<script>location.href="sinhvien.php";</script>';

                        }

                        /**
                         * Delete 
                         */
                        if (isset($_GET['msv_id'])) {
                            $msv_id     = $_GET['msv_id'];
                            $stmt_dl_sv = $pdo->prepare("DELETE FROM tbl_sinhvien WHERE msv='$msv_id'");
                            $stmt_dl_sv->execute();
                            echo '<script>location.href="sinhvien.php";</script>';
                        }

                        ?>

                        <form action="" method="POST" class="box-form">

                            <div class="form-group">
                                <label>Mã sinh viên</label>
                                <input type="number" name="msv" placeholder="Mã sinh viên" required>
                            </div>

                            <div class="form-group">
                                <label>Họ lot</label>
                                <input type="text" name="holot" placeholder="Họ lot" required>
                            </div>

                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="ten" placeholder="Tên" required>
                            </div>

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
                                <label>Số điện thoại</label>
                                <input type="number" name="sdt" placeholder="Số điện thoại" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Email" required>
                            </div>

                            <button name="add_btn" class="add_btn">Thêm mới</button>
                        </form>




                        <table class="table-content" id="danhsach">
                            <thead>
                                <th>Mã sinh viên</th>
                                <th>Tên</th>
                                <th>Mã lớp CN</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach ($result_sl_sv as $row) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['msv'] ?>
                                        </td>
                                        <td>
                                            <?= $row['holot'] . ' ' . $row['ten'] ?>
                                        </td>
                                        <td>
                                            <?= $row['mlcn'] ?>
                                        </td>
                                        <td>
                                            <?= $row['sodidong'] ?>
                                        </td>
                                        <td>
                                            <?= $row['email'] ?>
                                        </td>
                                        <td
                                            style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 2rem;">
                                            <a href="#" data-msv_id=<?= $row['msv'] ?> id="update-icon"
                                                style="color: orange;"><ion-icon name="pencil-outline"></ion-icon></a>
                                            <a href="?msv_id=<?= $row['msv'] ?>" style="color: red;"><ion-icon
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
                var msv_id = $(this).data("msv_id");

                $.post("./update/update_sv.php", {
                    msv_id: msv_id,
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