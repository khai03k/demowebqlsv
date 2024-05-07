<?php
include('../../database/config.php');
if (isset($_POST['update_btn'])) {
    $msv_id = $_GET['msv_id'];
    $mhp_id = $_GET['mhp_id'];

    $msv   = $_POST['msv'];
    $mhp   = $_POST['mhp'];
    $diema = $_POST['diema'];
    $diemb = $_POST['diemb'];
    $diemc = $_POST['diemc'];

    $sql = "UPDATE tbl_diemhocphan
	        SET
	        	msv='$msv',
	        	mhp='$mhp',
	        	A=$diema,
	        	B=$diemb,
	        	C=$diemc
	        WHERE msv='$msv_id' AND mhp='$mhp_id'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("location:../bangdiem.php");
}
?>