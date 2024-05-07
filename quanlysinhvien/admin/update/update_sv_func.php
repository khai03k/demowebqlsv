<?php
include('../../database/config.php');
if (isset($_POST['update_btn'])) {
    $msv_id = $_GET['msv_id'];

    $msv   = $_POST['msv'];
    $holot = $_POST['holot'];
    $ten   = $_POST['ten'];
    $mlcn  = $_POST['mlcn'];
    $sdt   = $_POST['sdt'];
    $email = $_POST['email'];

    $sql = "UPDATE tbl_sinhvien
	        SET
	        	msv='$msv',
	        	holot='$holot',
	        	ten='$ten',
	        	mlcn='$mlcn',
	        	sodidong='$sdt',
	        	email='$email'
	        WHERE msv='$msv_id'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("location:../sinhvien.php");
}
?>