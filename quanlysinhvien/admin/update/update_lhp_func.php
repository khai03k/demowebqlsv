<?php
include('../../database/config.php');
if (isset($_POST['update_btn'])) {
    $mlcn_id = $_GET['mlcn_id'];
    $mhp_id  = $_GET['mhp_id'];

    $mlcn   = $_POST['mlcn'];
    $mhp    = $_POST['mhp'];
    $nhom   = $_POST['nhom'];
    $hocky  = $_POST['hocky'];
    $namhoc = $_POST['namhoc'];



    $sql = "UPDATE tbl_lophocphan
        	SET
        		mlcn='$mlcn',
        		mhp='$mhp',
        		nhom='$nhom',
        		hocki='$hocky',
        		namhoc='$namhoc'
        	WHERE mlcn='$mlcn_id' AND mhp='$mhp_id'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("location:../lophp.php");
}
?>