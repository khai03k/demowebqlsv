<?php
include('../../database/config.php');

if (isset($_POST['mhp_id'])) {
    $mhp_id = $_POST['mhp_id'];

    $stmt_sl_hp = $pdo->prepare("SELECT * FROM tbl_hocphan WHERE mhp = '$mhp_id'");
    $stmt_sl_hp->execute();
    $result_sl_hp = $stmt_sl_hp->fetch(PDO::FETCH_ASSOC);

    $mhp_old    = $result_sl_hp['mhp'];
    $thp_old    = $result_sl_hp['tenhocphan'];
    $tinchi_old = $result_sl_hp['tinchi'];

}

?>

<div class="card-update">
    <form action="./update/update_hp_func.php?mhp_id=<?= $mhp_id ?>" method="POST" class="box-form">
        <div class="form-group">
            <label>Mã học phần</label>
            <input type="text" value="<?= $mhp_old ?>" name="mhp" placeholder="Mã học phần" required>
        </div>

        <div class="form-group">
            <label>Tên học phần</label>
            <input type="text" value="<?= $thp_old ?>" name="thp" placeholder="Tên học phần" required>
        </div>

        <div class="form-group">
            <label>Tín chỉ</label>
            <input type="number" value="<?= $tinchi_old ?>" name="tinchi" placeholder="Tín chỉ" required>
        </div>

        <div class="form-btn">
            <a href="monhoc.php" class="return_btn" id="return_btn">Quay lai</a>
            <button name="update_btn" class="add_btn">Update</button>
        </div>
    </form>
</div>