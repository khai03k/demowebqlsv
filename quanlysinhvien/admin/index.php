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
</head>

<body>

    <!-- INCLUDE HEADER -->
    <?php include('./header.php') ?>

    <main>
        <article>

            <?php
            /**
             * select all from khoa table in database
             */

            $sql_select_khoa  = "SELECT * FROM tbl_khoa";
            $stmt_select_khoa = $pdo->prepare($sql_select_khoa);
            $stmt_select_khoa->execute();

            $result_khoa = $stmt_select_khoa->fetchAll(PDO::FETCH_ASSOC);

            /**
             * Add khoa 
             */

            if (isset($_POST['add_btn'])) {
                $ma_khoa  = $_POST['makhoa'];
                $ten_khoa = $_POST['tenkhoa'];

                $sql_insert_khoa  = "INSERT INTO tbl_khoa
                                  	(mk, tenkhoa)
                                  	VALUES ('$ma_khoa', '$ten_khoa')";
                $stmt_insert_khoa = $pdo->prepare($sql_insert_khoa);
                $stmt_insert_khoa->execute();
                echo '<script>location.href="index.php";</script>';

            }

            ?>

            <!-- CONTENT -->
            <div class="box-parent">
                <div class="container">
                    <div class="box">
                        <h2 class="box-title">THÔNG TIN KHOA</h2>

                        <form action="" method="POST" class="box-form">
                            <div class="form-group">
                                <label>Mã khoa</label>
                                <input type="text" name="makhoa" placeholder="Mã khoa" required>
                            </div>

                            <div class="form-group">
                                <label>Tên khoa</label>
                                <input type="text" name="tenkhoa" placeholder="Tên khoa" required>
                            </div>

                            <button name="add_btn" class="add_btn">Thêm mới</button>
                        </form>

                        <!-- TABLE -->
                        <table class="table-content" style="text-align: center;">
                            <thead>
                                <th>Mã khoa</th>
                                <th>Tên khoa</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach ($result_khoa as $row) { ?>
                                    <tr>
                                        <td>
                                            <?= $row['mk'] ?>
                                        </td>
                                        <td>
                                            <?= $row['tenkhoa'] ?>
                                        </td>
                                        <td
                                            style="display: flex; align-items: center; justify-content: center; gap: 1.5rem; font-size: 2rem;">
                                            <a href="#" data-khoa_id=<?= $row['mk'] ?> id="update-icon"
                                                style="color: orange;"><ion-icon name="pencil-outline"></ion-icon></a>
                                            <a href="?khoa_id=<?= $row['mk'] ?>" style="color: red;"><ion-icon
                                                    name="trash-outline"></ion-icon></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php
            /**
             * Delete khoa
             */

            if (isset($_GET['khoa_id'])) {
                $khoa_id     = $_GET['khoa_id'];
                $sql_delete  = "DELETE FROM tbl_khoa WHERE mk='$khoa_id'";
                $stmt_delete = $pdo->prepare($sql_delete);
                $stmt_delete->execute();
                echo '<script>location.href="index.php";</script>';
            }
            ?>



            <div class="box-update" id="box-update">

            </div>
        </article>
    </main>



    <!-- ion-icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        $("td").on("click", "#update-icon", function (e) {
            e.preventDefault();
            $("#box-update").css("display", "grid");
            var mk_id = $(this).data("khoa_id");

            $.post("./update/update_khoa.php", {
                khoa_id: mk_id,
            },
                function (result) {
                    $("#box-update").html(result);
                }
            );
        })
    </script>

</body>

</html>