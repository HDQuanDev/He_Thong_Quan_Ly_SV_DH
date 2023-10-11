<?php
require_once('../system/config.php');
if ($code_cv != 2) {
    header("location: /");
    exit();
}
switch ($_GET["act"]) {
    case 'create':
        $get_class_id = $_POST["class_id"];
        $get_student_id = $_POST["student_id"];
        $get_subject_id = $_POST["subject_id"];
        if (!isset($_POST["class_id"]) && !isset($_POST["student_id"]) && !isset($_POST["subject_id"])) {
            echo '{"status":"error","msg":"Bug cái cc!!!"}';
            exit();
        }
        $check_exist = mysqli_query($db, "SELECT * FROM `grade` WHERE `student_id` = '$get_student_id' AND `subject_id` = '$get_subject_id'");
        $check_exist = mysqli_num_rows($check_exist);
        if ($check_exist == 0) {
            $create = mysqli_query($db, "INSERT INTO `grade`(`student_id`, `subject_id`, `term`, `year`, `midterm_score`, `final_score`) VALUES ('$get_student_id','$get_subject_id','','','0','0')");
            if ($create) {
                echo '{"status":"success","msg":"Tạo điểm mới thành công vui lòng load lại trang để tải lại dữ liệu!!"}';
            } else {
                echo '{"status":"error","msg":"Đã xảy ra lỗi khi tạo điểm mới, vui lòng thử lại!!!"}';
            }
        } else {
            echo '{"status":"error","msg":"Bảng điểm sinh viên này đã tồn tại, vui lòng không tạo thêm"}';
        }
        break;
    case 'update':
        $get_class_id = $_POST["class_id"];
        $get_student_id = $_POST["student_id"];
        $get_subject_id = $_POST["subject_id"];
        if (!isset($_POST["class_id"]) && !isset($_POST["student_id"]) && !isset($_POST["subject_id"])) {
            echo '{"status":"error","msg":"Bug cái cc!!!"}';
            exit();
        }
        $check_exist = mysqli_query($db, "SELECT * FROM `grade` WHERE `student_id` = '$get_student_id' AND `subject_id` = '$get_subject_id'");
        $check_exist = mysqli_num_rows($check_exist);
        if ($check_exist == 1) {
            if (isset($_POST["midterm_score"])) {
                $score = $_POST["midterm_score"];
                $update = mysqli_query($db, "UPDATE `grade` SET `midterm_score`='$score' WHERE `student_id` = '$get_student_id' AND `subject_id` = '$get_subject_id'");
                if ($update) {
                    echo '{"status":"success","msg":"Cập nhật điểm giữa kỳ thành công!!"}';
                } else {
                    echo '{"status":"error","msg":"Đã xảy ra lỗi khi cập nhật điểm giữa kỳ, vui lòng thử lại!!"}';
                }
            } elseif (isset($_POST["final_score"])) {
                $score = $_POST["final_score"];
                $update = mysqli_query($db, "UPDATE `grade` SET `final_score`='$score' WHERE `student_id` = '$get_student_id' AND `subject_id` = '$get_subject_id'");
                if ($update) {
                    echo '{"status":"success","msg":"Cập nhật điểm cuối kỳ thành công!!"}';
                } else {
                    echo '{"status":"error","msg":"Đã xảy ra lỗi khi cập nhật điểm cuối kỳ, vui lòng thử lại!!"}';
                }
            } else {
                echo '{"status":"error","msg":"Mày đang làm cái gì thế cu!!"}';
            }
        } else {
            echo '{"status":"error","msg":"Dữ liệu điểm của sinh viên này chưa tồn tại trong hệ thống, vui lòng tạo điểm trước!!"}';
        }
        break;
    default:
        require_once('../system/head.php');

        if (!isset($_GET["class_id"]) && !isset($_GET["student_id"])) {
            header('location: /');
            exit();
        }
        $get_class_id = $_GET["class_id"];
        $get_student_id = $_GET["student_id"];
        $teacher_id = $get_user["id_check"];
        $check_user_id = mysqli_query($db, "SELECT * FROM `student` WHERE `id` = '$get_student_id'");
        $check_user_id = mysqli_fetch_assoc($check_user_id);
        $get_user_id = $check_user_id["class_id"];
        $check_class = mysqli_query($db, "SELECT * FROM `class` WHERE `teacher_id` = '$teacher_id' AND `id` = '$get_class_id' AND `id` = '$get_user_id' ");
        $check_class_n = mysqli_num_rows($check_class);
        if ($check_class_n != 1) {
            header('location: /');
            exit();
        }
        $get_class_info = mysqli_fetch_assoc($check_class);
        $class_code = $get_class_info["code"];
        $get_info_subject = mysqli_query($db, "SELECT * FROM `subject` WHERE `code` = '$class_code' AND `teacher_id` = '$teacher_id'");
        $get_info_subject = mysqli_fetch_assoc($get_info_subject);
?>
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Trang Chủ /</span> Danh Sách Danh Sách Môn Học Sinh Viên <?= $check_user_id["name"]; ?>
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
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $dem = 0;
                            $teacher_n = $get_user["id_check"];
                            $get = mysqli_query($db, "SELECT * FROM `subject` WHERE `code` = '$class_code' AND `teacher_id` = '$teacher_id'");
                            while ($row = mysqli_fetch_assoc($get)) {
                                $dem++;
                                $subject_id = $row["id"];
                                $get_grade_student = mysqli_query($db, "SELECT * FROM `grade` WHERE `student_id` = '$get_student_id' AND `subject_id` = '$subject_id'");
                                $get_grade_student = mysqli_fetch_assoc($get_grade_student);                    ?>
                                <tr>
                                    <td><?= $dem; ?></td>
                                    <td><?= $check_user_id["name"]; ?></td>
                                    <td><?= $row["name"]; ?></td>
                                    <?php if (!isset($get_grade_student["midterm_score"])) {
                                        echo '<td>No Data</td>';
                                    } else {
                                        echo '<td><form><div class="mb-3"><input id="midterm_score" type="number" value ="' . $get_grade_student["midterm_score"] . '" class="form-control"></div>
                                        <button type="button" id="button_midterm_score" onclick="update_midterm_score();" class="btn btn-primary waves-effect waves-light">Cập Nhật</button></form></td>';
                                    }
                                    if (!isset($get_grade_student["final_score"])) {
                                        echo '<td>No Data</td>';
                                    } else {
                                        echo '<td><form><div class="mb-3"><input id="final_score" type="number" value ="' . $get_grade_student["final_score"] . '"" class="form-control"></div>
                                        <button type="button" id="button_final_score" onclick="update_final_score();" class="btn btn-primary waves-effect waves-light">Cập Nhật</button></form></td>';
                                    }
                                    if (!isset($get_grade_student["final_score"]) && !isset($get_grade_student["midterm_score"])) {
                                        echo '<td>No Data</td>';
                                    } else {
                                        $total = ($get_grade_student["midterm_score"] + $get_grade_student["final_score"]) / 2;
                                        echo '<td>' . $total . '</td>';
                                    }
                                    ?>
                                    <?php
                                    if (!isset($get_grade_student["final_score"]) && !isset($get_grade_student["midterm_score"])) {
                                    ?><td>
                                            <from>
                                                <button type="button" id="button" onclick="create();" class="btn btn-primary waves-effect waves-light">Tạo Điểm</button>
                                                </form>

                                        </td>

                                    <?php
                                    } else {
                                        echo '<td>No Control</td>';
                                    }
                                    ?>
                                </tr>
                                <script>
                                    function create() {
                                        var subject_id = <?= $subject_id; ?>;
                                        var student_id = <?= $get_student_id; ?>;
                                        var class_id = <?= $get_class_info["id"]; ?>;
                                        $('#button')['html']('Đang tạo...');
                                        $("#button")
                                            .prop("disabled", true);
                                        $.ajax({
                                            url: "?act=create",
                                            type: "post",
                                            dataType: "json",
                                            data: {
                                                subject_id,
                                                student_id,
                                                class_id,
                                            },
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    swal('Hệ Thống!', response.msg, 'success');
                                                    setTimeout(function() {
                                                        window.location = "";
                                                    }, 3000);
                                                } else {
                                                    swal('Hệ Thống!', response.msg, 'warning');
                                                }
                                                $('#button')['html']('Tạo Điểm');
                                                $("#button")
                                                    .prop("disabled", false)

                                            }
                                        });
                                    }

                                    function update_midterm_score() {
                                        var subject_id = <?= $subject_id; ?>;
                                        var student_id = <?= $get_student_id; ?>;
                                        var class_id = <?= $get_class_info["id"]; ?>;
                                        var midterm_score = $('#midterm_score').val();
                                        $('#button_midterm_score')['html']('Đang cập nhật...');
                                        $("#button_midterm_score")
                                            .prop("disabled", true);
                                        $.ajax({
                                            url: "?act=update",
                                            type: "post",
                                            dataType: "json",
                                            data: {
                                                subject_id,
                                                student_id,
                                                class_id,
                                                midterm_score,
                                            },
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    swal('Hệ Thống!', response.msg, 'success');
                                                    setTimeout(function() {
                                                        window.location = "";
                                                    }, 3000);
                                                } else {
                                                    swal('Hệ Thống!', response.msg, 'warning');
                                                }
                                                $('#button_midterm_score')['html']('Tạo Điểm');
                                                $("#button_midterm_score")
                                                    .prop("disabled", false)

                                            }
                                        });
                                    }

                                    function update_final_score() {
                                        var subject_id = <?= $subject_id; ?>;
                                        var student_id = <?= $get_student_id; ?>;
                                        var class_id = <?= $get_class_info["id"]; ?>;
                                        var final_score = $('#final_score').val();
                                        $('#button_final_score')['html']('Đang tạo...');
                                        $("#button_final_score")
                                            .prop("disabled", true);
                                        $.ajax({
                                            url: "?act=update",
                                            type: "post",
                                            dataType: "json",
                                            data: {
                                                subject_id,
                                                student_id,
                                                class_id,
                                                final_score,
                                            },
                                            success: function(response) {
                                                if (response.status === 'success') {
                                                    swal('Hệ Thống!', response.msg, 'success');
                                                    setTimeout(function() {
                                                        window.location = "";
                                                    }, 3000);
                                                } else {
                                                    swal('Hệ Thống!', response.msg, 'warning');
                                                }
                                                $('#button_final_score')['html']('Tạo Điểm');
                                                $("#button_final_score")
                                                    .prop("disabled", false)

                                            }
                                        });
                                    }
                                </script>
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
        break;
}
