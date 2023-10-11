<?php
require_once('../system/config.php');
if ($code_cv != 2) {
    header("location: /");
    exit();
}
require_once('../system/head.php');
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Trang Chủ /</span> Lớp Học
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table id="example" class="datatables-basic table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lớp</th>
                        <th>Mã Lớp</th>
                        <th>Giáo Viên Chủ Nhiệm</th>
                        <th>Sĩ Số</th>
                        <th>Chức Năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dem = 0;
                    $teacher_n = $get_user["id_check"];
                    $get = mysqli_query($db, "SELECT * FROM `class` WHERE `teacher_id` = '$teacher_n' ORDER BY id ASC");
                    while ($row = mysqli_fetch_assoc($get)) {
                        $dem++;
                        $teacher_id = $row["teacher_id"];
                        $get_gv_name = mysqli_query($db, "SELECT * FROM `teacher` WHERE `id` = '$teacher_id'");
                        $get_gv_name = mysqli_fetch_assoc($get_gv_name);
                        $get_name_gv = $get_gv_name["name"];
                        $get_class_id = $row["id"];
                        $get_siso_class = mysqli_query($db, "SELECT * FROM `student` WHERE `class_id` = '$get_class_id'");
                        $get_siso_class = mysqli_num_rows($get_siso_class);
                    ?>
                        <tr>
                            <td><?= $dem; ?></td>
                            <td><?= $row["name"]; ?></td>
                            <td><?= $row["code"]; ?></td>
                            <td><?= $get_name_gv; ?></td>
                            <td><?= $get_siso_class; ?></td>
                            <td><a type="submit" class="btn btn-primary waves-effect waves-light" href="student.php?class_id=<?= $row["id"]; ?>&code=<?= $row["code"]; ?>">Xem DS</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Lớp</th>
                        <th>Mã Lớp</th>
                        <th>Giáo Viên Chủ Nhiệm</th>
                        <th>Sĩ Số</th>
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
