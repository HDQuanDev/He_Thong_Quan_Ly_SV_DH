<?php
require_once("system/config.php");
require_once("system/head.php");
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Trang Chủ /</span> <?php if ($code_cv == '1') {
                                                                    echo 'Thời Khóa Biểu';
                                                                } else {
                                                                    echo 'Danh Sách Lớp Đang Dạy';
                                                                } ?>
    </h4>

    <!-- DataTable with Buttons -->
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <?php if ($code_cv == 1) {
            ?>
                <table id="example" class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Môn</th>
                            <th>Giáo Viên</th>
                            <th>Ngày</th>
                            <th>Vào Lớp</th>
                            <th>Tan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $get = mysqli_query($db, "SELECT * FROM `schedule` WHERE `class_id` = '$user_class_id'");
                        while ($row = mysqli_fetch_assoc($get)) {
                            $subject_id = $row["subject_id"];
                            $get_gv_name = mysqli_query($db, "SELECT * FROM `subject` WHERE `id` = '$subject_id'");
                            $get_gv_name = mysqli_fetch_assoc($get_gv_name);
                            $subject_name = $get_gv_name["name"];
                            $teacher_id = $get_gv_name["teacher_id"];
                            $get_gv_name_2 = mysqli_query($db, "SELECT * FROM `teacher` WHERE `id` = '$teacher_id'");
                            $get_gv_name_2 = mysqli_fetch_assoc($get_gv_name_2);
                            $teacher_name = $get_gv_name_2["name"];
                        ?>
                            <tr>
                                <td><?= $row["id"]; ?></td>
                                <td><?= $subject_name; ?></td>
                                <td><?= $teacher_name; ?></td>
                                <td><?= $row["day"]; ?></td>
                                <td><?= $row["start_time"]; ?></td>
                                <td><?= $row["end_time"]; ?></td>
                            </tr>
                        <?php

                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Môn</th>
                            <th>Giáo Viên</th>
                            <th>Ngày</th>
                            <th>Vào Lớp</th>
                            <th>Tan</th>
                        </tr>
                    </tfoot>
                </table>
            <?php
            } elseif ($code_cv == '2') {
            ?>
                <table id="example" class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Môn Học</th>
                            <th>Lớp</th>
                            <th>Mã Lớp</th>
                            <th>Giáo Viên Dạy</th>
                            <th>Sĩ Số</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dem = 0;
                        $teacher_n = $get_user["id_check"];
                        $get = mysqli_query($db, "SELECT * FROM `subject` WHERE `teacher_id` = '$teacher_n' ORDER BY id ASC");
                        while ($row = mysqli_fetch_assoc($get)) {
                            $dem++;
                            $teacher_id = $row["teacher_id"];
                            $get_gv_name = mysqli_query($db, "SELECT * FROM `teacher` WHERE `id` = '$teacher_id'");
                            $get_gv_name = mysqli_fetch_assoc($get_gv_name);
                            $get_name_gv = $get_gv_name["name"];
                            $get_class_code = $row["code"];
                            $get_class = mysqli_query($db, "SELECT * FROM `class` WHERE `code` = '$get_class_code'");
                            $get_class = mysqli_fetch_assoc($get_class);
                            $get_class_id = $get_class["id"];
                            $get_siso_class = mysqli_query($db, "SELECT * FROM `student` WHERE `class_id` = '$get_class_id'");
                            $get_siso_class = mysqli_num_rows($get_siso_class);
                        ?>
                            <tr>
                                <td><?= $dem; ?></td>
                                <td><?= $row["name"]; ?></td>
                                <td><?= $get_class["name"]; ?></td>
                                <td><?= $row["code"]; ?></td>
                                <td><?= $get_name_gv; ?></td>
                                <td><?= $get_siso_class; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tên Môn Học</th>
                            <th>Lớp</th>
                            <th>Mã Lớp</th>
                            <th>Giáo Viên Dạy</th>
                            <th>Sĩ Số</th>
                        </tr>
                    </tfoot>
                </table>
            <?php
            }
            ?>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
    <!--/ Multilingual -->
</div>

<?php
require_once("system/end.php");
?>