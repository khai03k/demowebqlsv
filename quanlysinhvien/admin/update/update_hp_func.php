<?php
include('../../database/config.php');
if (isset($_POST['update_btn'])) {
    $mhp_id = $_GET['mhp_id'];

    $mhp    = $_POST['mhp'];
    $thp    = $_POST['thp'];
    $tinchi = $_POST['tinchi'];

    $sql = "UPDATE tbl_hocphan
        	SET
        		mhp='$mhp',
        		tenhocphan='$thp',
        		tinchi=$tinchi
        	WHERE mhp='$mhp_id'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("location:../monhoc.php");
}
?>