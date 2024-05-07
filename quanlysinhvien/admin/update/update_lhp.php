<?php
include('../../database/config.php');

if (isset($_POST['mlcn_id']) && isset($_POST['mhp_id'])) {

    $mlcn_id = $_POST['mlcn_id'];
    $mhp_id  = $_POST['mhp_id'];

    $stmt_sl_lhp = $pdo->prepare("SELECT * FROM tbl_lophocphan WHERE mlcn = '$mlcn_id' AND mhp = '$mhp_id'");
    $stmt_sl_lhp->execute();
    $result_sl_lhp = $stmt_sl_lhp->fetch(PDO::FETCH_ASSOC);

    $mlcn_old   = $result_sl_lhp['mlcn'];
    $mhp_old    = $result_sl_lhp['mhp'];
    $nhom_old   = $result_sl_lhp['nhom'];
    $hocky_old  = $result_sl_lhp['hocki'];
    $namhoc_old = $result_sl_lhp['namhoc'];


    /**
     * Select mlcn from database
     */

    $stmt_sl_mlcn = $pdo->prepare("SELECT mlcn FROM tbl_lopchuyennghanh");
    $stmt_sl_mlcn->execute();
    $result_sl_mlcn = $stmt_sl_mlcn->fetchAll(PDO::FETCH_ASSOC);


    /**
     * Select mhp from database
     */
    $stmt_sl_mhp = $pdo->prepare("SELECT mhp FROM tbl_hocphan");
    $stmt_sl_mhp->execute();
    $result_sl_mhp = $stmt_sl_mhp->fetchAll(PDO::FETCH_ASSOC);

}

?>

<div class="card-update">
    <form action="./update/update_lhp_func.php?mlcn_id=<?= $mlcn_id ?>&mhp_id=<?= $mhp_id ?>" method="POST"
        class="box-form">
        <div class="form-group">
            <label>Mã lớp CN</label>
            <select name="mlcn" id="">
                <?php foreach ($result_sl_mlcn as $row) { ?>
                    <option value="<?= $row['mlcn'] ?>" <?= ($row['mlcn'] == $mlcn_old) ? 'selected' : '' ?>>
                        <?= $row['mlcn'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Mã học phần</label>
            <select name="mhp" id="">
                <?php foreach ($result_sl_mhp as $row) { ?>
                    <option value="<?= $row['mhp'] ?>" <?= ($row['mhp'] == $mhp_old) ? 'selected' : '' ?>>
                        <?= $row['mhp'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nhóm</label>
            <input type="number" value="<?= $nhom_old ?>" name="nhom" placeholder="Nhóm" required>
        </div>

        <div class="form-group">
            <label>Học kỳ</label>
            <input type="number" value="<?= $hocky_old ?>" name="hocky" placeholder="Học kỳ" required>
        </div>

        <div class="form-group">
            <label>Năm học</label>
            <input type="text" value="<?= $namhoc_old ?>" name="namhoc" placeholder="Năm học" required>
        </div>

        <div class="form-btn">
            <a href="lophp.php" class="return_btn" id="return_btn">Quay lai</a>
            <button name="update_btn" class="add_btn">Update</button>
        </div>
    </form>
</div>