<?php
include('../../database/config.php');

if (isset($_POST['msv_id'])) {
    $msv_id = $_POST['msv_id'];

    $stmt_sl_sv = $pdo->prepare("SELECT * FROM tbl_sinhvien WHERE msv = '$msv_id'");
    $stmt_sl_sv->execute();
    $result_sl_sv = $stmt_sl_sv->fetch(PDO::FETCH_ASSOC);

    $msv_old   = $result_sl_sv['msv'];
    $holot_old = $result_sl_sv['holot'];
    $ten_old   = $result_sl_sv['ten'];
    $mlcn_old  = $result_sl_sv['mlcn'];
    $sdt_old   = $result_sl_sv['sodidong'];
    $email_old = $result_sl_sv['email'];


    /**
     * Select mlcn from database
     */

    $stmt_sl_mlcn = $pdo->prepare("SELECT mlcn FROM tbl_lopchuyennghanh");
    $stmt_sl_mlcn->execute();
    $result_sl_mlcn = $stmt_sl_mlcn->fetchAll(PDO::FETCH_ASSOC);

}

?>

<div class="card-update">
    <form action="./update/update_sv_func.php?msv_id=<?= $msv_id ?>" method="POST" class="box-form">
        <div class="form-group">
            <label>Mã sinh viên</label>
            <input type="number" value="<?= $msv_old ?>" name="msv" placeholder="Mã sinh viên" required>
        </div>

        <div class="form-group">
            <label>Họ lot</label>
            <input type="text" value="<?= $holot_old ?>" name="holot" placeholder="Họ lot" required>
        </div>

        <div class="form-group">
            <label>Tên</label>
            <input type="text" value="<?= $ten_old ?>" name="ten" placeholder="Tên" required>
        </div>

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
            <label>Số điện thoại</label>
            <input type="number" value="<?= $sdt_old ?>" name="sdt" placeholder="Số điện thoại" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?= $email_old ?>" name="email" placeholder="Email" required>
        </div>

        <div class="form-btn">
            <a href="sinhvien.php" class="return_btn" id="return_btn">Quay lai</a>
            <button name="update_btn" class="add_btn">Update</button>
        </div>
    </form>
</div>