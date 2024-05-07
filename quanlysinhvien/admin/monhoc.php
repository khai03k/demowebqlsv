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
                        <h2 class="box-title">THÔNG TIN MÔN HỌC</h2>

                        <?php
                        /**
                         * Select info from database tbl_hocphan
                         */

                        $stmt_sl_hp = $pdo->prepare("SELECT * FROM tbl_hocphan");
                        $stmt_sl_hp->execute();
                        $result_sl_hp = $stmt_sl_hp->fetchAll(PDO::FETCH_ASSOC);

                        /**
                         * Add info to database
                         */

                        if (isset($_POST['add_btn'])) {
                            $mhp    = $_POST['mhp'];
                            $thp    = $_POST['thp'];
                            $tinchi = $_POST['tinchi'];

                            $stmt_is_hp = $pdo->prepare("INSERT INTO tbl_hocphan
                                                    	(mhp, tenhocphan, tinchi)
                                                    	VALUES ('$mhp', '$thp', $tinchi)");
                            $stmt_is_hp->execute();
                            echo '<script>location.href="monhoc.php";</script>';
                        }

                        /**
                         * Delete
                         */

                        if (isset($_GET['mhp_id'])) {
                            $mhp_id     = $_GET['mhp_id'];
                            $stmt_dl_hp = $pdo->prepare("DELETE FROM tbl_hocphan WHERE mhp = '$mhp_id'");
                            $stmt_dl_hp->execute();
                            echo '<script>location.href="monhoc.php";</script>';
                        }

                        ?>


                        <form action="" method="POST" class="box-form">

                            <div class="form-group">
                                <label>Mã học phần</label>
                                <input type="text" name="mhp" placeholder="Mã học phần" required>
                            </div>

                            <div class="form-group">
                                <label>Tên học phần</label>
                                <input type="text" name="thp" placeholder="Tên học phần" required>
                            </div>

                            <div class="form-group">
                                <label>Tín chỉ</label>
                                <input type="number" name="tinchi" placeholder="Tín chỉ" required>
                            </div>

                            <button name="add_btn" class="add_btn">Thêm mới</button>
                        </form>


                        <table class="table-content" id="danhsach">
                            <thead>
                                <th>Mã học phần</th>
                                <th>Tên học phần</th>
                                <th>Tín chỉ</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach ($result_sl_hp as $row) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['mhp'] ?>
                                        </td>

                                        <td>
                                            <?= $row['tenhocphan'] ?>
                                        </td>

                                        <td>
                                            <?= $row['tinchi'] ?>
                                        </td>

                                        <td
                                            style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 2rem;">
                                            <a href="#" data-mhp_id=<?= $row['mhp'] ?> id="update-icon"
                                                style="color: orange;"><ion-icon name="pencil-outline"></ion-icon></a>
                                            <a href="?mhp_id=<?= $row['mhp'] ?>" style="color: red;"><ion-icon
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
                var mhp_id = $(this).data("mhp_id");

                $.post("./update/update_hp.php", {
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