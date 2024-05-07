<?php
include('../../database/config.php');

if (isset($_POST['mlcn_id'])) {

    $mlcn_id     = $_POST['mlcn_id'];
    $stmt_sl_lcn = $pdo->prepare("SELECT * FROM tbl_lopchuyennghanh WHERE mlcn = '$mlcn_id'");
    $stmt_sl_lcn->execute();
    $result_sl_lcn = $stmt_sl_lcn->fetch(PDO::FETCH_ASSOC);
    $mlcn_old      = $result_sl_lcn['mlcn'];
    $tenlop_old    = $result_sl_lcn['tenlop'];
    $nienkhoa_old  = $result_sl_lcn['nienkhoa'];
    $siso_old      = $result_sl_lcn['siso'];
    $mk_old        = $result_sl_lcn['mk'];


    /**
     * Select ma khoa
     */

    $stmt_sl_khoa = $pdo->prepare("SELECT * FROM tbl_khoa");
    $stmt_sl_khoa->execute();
    $result_sl_khoa = $stmt_sl_khoa->fetchAll(PDO::FETCH_ASSOC);

}

?>

<div class="card-update">
    <form action="./update/update_lcn_func.php?mlcn_id=<?= $mlcn_id ?>" method="POST" class="box-form">
        <div class="form-group">
            <label>Mã lớp CN</label>
            <input type="text" value="<?= $mlcn_old ?>" name="mlcn" placeholder="Mã lớp CN" required>
        </div>

        <div class="form-group">
            <label>Tên lớp</label>
            <input type="text" value="<?= $tenlop_old ?>" name="tl" placeholder="Tên lớp" required>
        </div>

        <div class="form-group">
            <label>Niên khóa</label>
            <input type="text" value="<?= $nienkhoa_old ?>" name="nk" placeholder="Niên khóa" required>
        </div>

        <div class="form-group">
            <label>Sĩ số</label>
            <input type="text" value="<?= $siso_old ?>" name="siso" placeholder="Sĩ số" required>
        </div>

        <div class="form-group">
            <label>Mã khoa</label>
            <select name="makhoa">
                <?php foreach ($result_sl_khoa as $row) { ?>
                    <option value="<?= $row['mk'] ?>" <?= ($row['mk'] == $mk_old) ? 'selected' : '' ?>>
                        <?= $row['mk'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-btn">
            <a href="lop.php" class="return_btn" id="return_btn">Quay lai</a>
            <button name="update_btn" class="add_btn">Update</button>
        </div>
    </form>
</div>