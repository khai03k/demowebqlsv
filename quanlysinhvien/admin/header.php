<?php
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    echo '<script>location.href="/quanlysinhvien/index.php"</script>';
}
?>

<header class="header">
    <div class="container">
        <nav class="navbar">
            <ul class="navbar-list">
                <li class="navbar-item">
                    <a href="index.php" class="navbar-link">Thông tin khoa</a>
                </li>

                <li class="navbar-item">
                    <a href="lop.php" class="navbar-link">Thông tin lớp CN</a>
                </li>

                <li class="navbar-item">
                    <a href="lophp.php" class="navbar-link">Thông tin lớp học phần</a>
                </li>

                <li class="navbar-item">
                    <a href="sinhvien.php" class="navbar-link">Thông tin sinh viên</a>
                </li>

                <li class="navbar-item">
                    <a href="monhoc.php" class="navbar-link">Thông tin môn học</a>
                </li>

                <li class="navbar-item">
                    <a href="bangdiem.php" class="navbar-link">Quản lý bảng điểm sinh viên</a>
                </li>

                <li class="navbar-item">
                    <a href="?logout" class="navbar-link">Đăng xuất</a>
                </li>
            </ul>
        </nav>
    </div>
</header>