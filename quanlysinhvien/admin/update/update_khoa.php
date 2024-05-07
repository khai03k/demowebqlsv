<?php
include('../../database/config.php');

if (isset($_POST['khoa_id'])) {

    $khoa_id  = $_POST['khoa_id'];
    $sql      = "SELECT * FROM tbl_khoa WHERE mk = $khoa_id";
    $stmt_sql = $pdo->prepare($sql);
    $stmt_sql->execute();

    $result = $stmt_sql->fetch(PDO::FETCH_ASSOC);
    $mk_old = $result['mk'];
    $tk_old = $result['tenkhoa'];
}

?>

<div class="card-update">
    <form action="./update/update_khoa_func.php?khoa_id=<?= $khoa_id ?>" method="POST" class="box-form">
        <div class="form-group">
            <label>Mã khoa</label>
            <input type="text" value="<?= $mk_old ?>" name="makhoa" placeholder="Mã khoa">
        </div>

        <div class="form-group">
            <label>Tên khoa</label>
            <input type="text" value="<?= $tk_old ?>" name="tenkhoa" placeholder="Tên khoa">
        </div>

        <div class="form-btn">
            <a href="index.php" class="return_btn" id="return_btn">Quay lai</a>
            <button name="update_btn" type="submit" class="add_btn">Update</button>
        </div>
    </form>
</div>