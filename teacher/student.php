<?php
require_once('../system/config.php');
if ($code_cv != 2) {
    header("location: /");
    exit();
}
require_once('../system/head.php');

if (!isset($_GET["class_id"])) {
    header('location: /');
    exit();
}
$get_class_id = $_GET["class_id"];
$get_class_code = $_GET["code"];
$check_exist = mysqli_query($db, "SELECT * FROM `class` WHERE `id` = '$get_class_id' AND `code` = '$get_class_code'");
$chech_exist = mysqli_num_rows($check_exist);
if ($chech_exist != 1) {
    header('location: /');
    exit();
}
$teacher_id = $get_user["id_check"];
$check_exist = mysqli_query($db, "SELECT * FROM `class` WHERE `teacher_id` = '$teacher_id' AND `code` = '$get_class_code' AND `id` = '$get_class_id'");
$chech_exist = mysqli_num_rows($check_exist);
if ($chech_exist != 1) {
    header('location: /');
    exit();
}
$get_info_class = mysqli_query($db, "SELECT * FROM `class` WHERE `code` = '$get_class_code' AND `teacher_id` = '$teacher_id' AND `id` = '$get_class_id'");
$get_info_class = mysqli_fetch_assoc($get_info_class);
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Trang Chủ /</span> Danh Sách Sinh Viên Lớp Học <?= $get_info_class["name"]; ?>
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table id="example" class="datatables-basic table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ Và Tên</th>
                        <th>Lớp</th>
                        <th>Sinh Nhật</th>
                        <th>Giới Tính</th>
                        <th>Địa Chỉ</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dem = 0;
                    $teacher_n = $get_user["id_check"];
                    $get = mysqli_query($db, "SELECT * FROM `student` WHERE `class_id` = '$get_class_id' ORDER BY id ASC");
                    while ($row = mysqli_fetch_assoc($get)) {
                        $dem++;
                    ?>
                        <tr>
                            <td><?= $dem; ?></td>
                            <td><?= $row["name"]; ?></td>
                            <td><?= $get_info_class["name"]; ?></td>
                            <td><?= $row["birthday"];; ?></td>
                            <td><?= $row["gender"];; ?></td>
                            <td><?= $row["address"];; ?></td>
                            <td><?= $row["phone_number"];; ?></td>
                            <td><?= $row["email"];; ?></td>
                            <td><a type="submit" class="btn btn-primary waves-effect waves-light" href="subject.php?class_id=<?= $get_class_id; ?>&student_id=<?= $row["id"]; ?>">Xem KQ Học Tập</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Họ Và Tên</th>
                        <th>Lớp</th>
                        <th>Sinh Nhật</th>
                        <th>Giới Tính</th>
                        <th>Địa Chỉ</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>Chức Năng</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
    <!--/ Multilingual -->
</div>
<?php
require_once('../system/end.php');
