<?php
include('../../database/config.php');
if (isset($_POST['update_btn'])) {
    $khoa_id  = $_GET['khoa_id'];
    $ma_khoa  = $_POST['makhoa'];
    $ten_khoa = $_POST['tenkhoa'];
    $sql      = "UPDATE tbl_khoa
	             SET
	             	mk='$ma_khoa',
	             	tenkhoa='$ten_khoa',
	             	dienthoai=''
	             WHERE mk='$khoa_id'";
    $stmt     = $pdo->prepare($sql);
    $stmt->execute();
    header("location:../index.php");
}
?>