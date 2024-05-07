<?php
include('./database/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BOOTSTRAP  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- LINK CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="./assets/imgs/favicon.ico" type="image/x-icon">

    <!-- FONT -->
    <link href="https://fonts.cdnfonts.com/css/sf-pro-display" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div class="container">
            <a href="index.php" class="logo">
                <img src="./assets/imgs/logo.png" alt="">
            </a>

            <ul class="category-list">
                <li class="category-item">
                    <a href="index.php" class="category_name">Thống kê</a>
                </li>

                <li class="category-item">
                    <a href="hocphan.php" class="category_name">Học phần</a>
                </li>

                <li class="category-item">
                    <a href="lopchuyennganh.php" class="category_name">Lớp chuyên ngành</a>
                </li>

                <li class="category-item">
                    <a href="khoa.php" class="category_name">Khoa</a>
                </li>

                <li class="category-item">
                    <a href="svxuatxac.php" class="category_name">Sinh viên xuất xắc</a>
                </li>

            </ul>

            <!-- user -->
            <div class="user">
                <div class="user-outline">
                    <ion-icon name="person-circle-outline"></ion-icon>
                    <span>Tài khoản</span>
                    <ion-icon name="caret-down-outline"></ion-icon>
                </div>

                <ul class="user-detail_list">
                    <li class="user-detail_item">
                        <a href="login.php">Đăng nhập</a>
                    </li>
                </ul>
            </div>

        </div>
    </header>

    <main class="content">
        <article>
            <div class="box-parent">
                <?php
                /**
                 * Select info from tbl_hocphan
                 */
                if (isset($_POST['search_btn'])) {
                    $search_content = $_POST['search_content'];
                    $sql_select     = "SELECT * FROM tbl_khoa WHERE mk LIKE '%$search_content%'";
                } else {
                    $sql_select = "SELECT * FROM tbl_khoa";
                }

                $stmt_select = $pdo->prepare($sql_select);
                $stmt_select->execute();
                $result_select = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <div class="container">
                    <div class="box">
                        <div class="header-content">
                            <h3>Khoa</h3>
                        </div>

                        <div class="body-content">
                            <form action="" method="POST" class="search-content">
                                <span>Mã khoa</span>
                                <input type="text" name="search_content" placeholder="Nhập mã khoa">
                                <button name="search_btn" class="search_btn">Tìm kiếm</button>
                            </form>

                            <table class="table-content">
                                <thead>
                                    <th>Mã Khoa</th>
                                    <th>Tên Khoa</th>
                                    <th>Điện Thoại</th>
                                </thead>

                                <tbody>
                                    <?php foreach ($result_select as $row) { ?>
                                        <tr>
                                            <td>
                                                <?= $row['mk'] ?>
                                            </td>
                                            <td>
                                                <?= $row['tenkhoa'] ?>
                                            </td>
                                            <td>
                                                <?= $row['dienthoai'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>

    <!-- ion-icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>