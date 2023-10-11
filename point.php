<?php
require_once("system/config.php");
require_once("system/head.php");
if ($code_cv != 1) {
    header("location: /");
    exit();
}
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Trang Chủ /</span> Kết Quả Học Tập Của <?= $get_id_user["name"]; ?>
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table id="example" class="datatables-basic table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Học Sinh</th>
                        <th>Tên Môn Học</th>
                        <th>Điểm Giữa Kỳ</th>
                        <th>Điểm Cuối Kỳ</th>
                        <th>Điểm Tổng Kết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dem = 0;
                    $student_n = $get_user["id_check"];
                    $get = mysqli_query($db, "SELECT * FROM `grade` WHERE `student_id` = '$student_n'");
                    while ($row = mysqli_fetch_assoc($get)) {
                        $dem++;
                        $student_id = $row["student_id"];
                        $get_student_name = mysqli_query($db, "SELECT * FROM `student` WHERE `id` = '$student_id'");
                        $get_student_name = mysqli_fetch_assoc($get_student_name);
                        $student_name = $get_student_name["name"];
                        $subject_id = $row["subject_id"];
                        $get_subject_info  = mysqli_query($db, "SELECT * FROM `subject` WHERE `id` = '$subject_id'");
                        $get_subject_info = mysqli_fetch_assoc($get_subject_info);
                        $class_code = $get_subject_info["code"];
                        $get_class_info = mysqli_query($db, "SELECT * FROM `class` WHERE `code` = '$class_code'");
                        $get_class_info = mysqli_fetch_assoc($get_class_info);
                        $class_name = $get_class_info["name"];
                    ?>
                        <tr>
                            <td><?= $dem; ?></td>
                            <td><?= $student_name; ?></td>
                            <td><?= $class_name; ?></td>
                            <?php if (!isset($row["midterm_score"])) {
                                echo '<td>No Data</td>';
                            } else {
                                echo '<td>' . $row["midterm_score"] . '';
                            }
                            if (!isset($row["final_score"])) {
                                echo '<td>No Data</td>';
                            } else {
                                echo '<td>' . $row["final_score"] . '';
                            }
                            if (!isset($row["final_score"]) && !isset($row["midterm_score"])) {
                                echo '<td>No Data</td>';
                            } else {
                                $total = ($row["midterm_score"] + $row["final_score"]) / 2;
                                echo '<td>' . $total . '</td>';
                            }
                            ?>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tên Học Sinh</th>
                        <th>Tên Môn Học</th>
                        <th>Điểm Giữa Kỳ</th>
                        <th>Điểm Cuối Kỳ</th>
                        <th>Điểm Tổng Kết</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
    <!--/ Multilingual -->
</div>
<?php
require_once("system/end.php");
?>