<?php
include('../../database/config.php');

if (isset($_POST['mhp_id']) && isset($_POST['msv_id'])) {
    $msv_id = $_POST['msv_id'];
    $mhp_id = $_POST['mhp_id'];

    $stmt_sl_dhp = $pdo->prepare("SELECT * FROM tbl_diemhocphan WHERE msv= '$msv_id' AND mhp = '$mhp_id'");
    $stmt_sl_dhp->execute();
    $result_sl_dhp = $stmt_sl_dhp->fetch(PDO::FETCH_ASSOC);

    $msv_old   = $result_sl_dhp['msv'];
    $mhp_old   = $result_sl_dhp['mhp'];
    $diema_old = $result_sl_dhp['A'];
    $diemb_old = $result_sl_dhp['B'];
    $diemc_old = $result_sl_dhp['C'];


    /**
     * Select info from database tbl_sinhvien
     */

    $stmt_sl_sv = $pdo->prepare("SELECT * FROM tbl_sinhvien");
    $stmt_sl_sv->execute();
    $result_sl_sv = $stmt_sl_sv->fetchAll(PDO::FETCH_ASSOC);


    /**
     * Select mhp from database
     */
    $stmt_sl_mhp = $pdo->prepare("SELECT mhp 
                                  FROM tbl_hocphan
                                  WHERE NOT EXISTS(
                                  SELECT 1 
                                  FROM tbl_diemhocphan
                                  WHERE tbl_diemhocphan.mhp = tbl_hocphan.mhp);");
    $stmt_sl_mhp->execute();
    $result_sl_mhp = $stmt_sl_mhp->fetchAll(PDO::FETCH_ASSOC);

}

?>

<div class="card-update">
    <form action="./update/update_dhp_func.php?mhp_id=<?= $mhp_id ?>&msv_id=<?= $msv_id ?>" method="POST"
        class="box-form">
        <div class="form-group">
            <label>Mã sinh viên</label>

            <select name="msv" id="">
                <?php foreach ($result_sl_sv as $row) { ?>
                    <option value="<?= $row['msv'] ?>" <?= ($row['msv'] == $msv_old) ? 'selected' : '' ?>>
                        <?= $row['msv'] ?>
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
            <label>A</label>
            <input type="number" value="<?= $diema_old ?>" name="diema" placeholder="Điểm A" min="0" max="10" required>
        </div>

        <div class="form-group">
            <label>B</label>
            <input type="number" value="<?= $diemb_old ?>" name="diemb" placeholder="Điểm B" min="0" max="10" required>
        </div>

        <div class="form-group">
            <label>C</label>
            <input type="number" value="<?= $diemc_old ?>" name="diemc" placeholder="Điểm C" min="0" max="10" required>
        </div>

        <div class="form-btn">
            <a href="bangdiem.php" class="return_btn" id="return_btn">Quay lai</a>
            <button name="update_btn" class="add_btn">Update</button>
        </div>
    </form>
</div>