<?php
include('../../database/config.php');
if (isset($_POST['update_btn'])) {
    $mlcn_id = $_GET['mlcn_id'];
    $mlcn    = $_POST['mlcn'];
    $tl      = $_POST['tl'];
    $nk      = $_POST['nk'];
    $siso    = $_POST['siso'];
    $makhoa  = $_POST['makhoa'];

    $sql  = "UPDATE tbl_lopchuyennghanh
	         SET
	         	mlcn='$mlcn',
	         	tenlop='$tl',
	         	nienkhoa='$nk',
	         	siso=$siso,
	         	mk='$makhoa'
	         WHERE mlcn='$mlcn_id'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("location:../lop.php");
}
?>