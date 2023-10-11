<?php
ob_start();
session_start();
$db = mysqli_connect('localhost', 'hdqfile_school', '7wVT0iA%)@Pf', 'hdqfile_school');
if (!$db) {
    die("Không thể kết nối cơ sở dữ liệu: " . mysqli_connect_error());
}
mysqli_set_charset($db, "utf8");
if (isset($_SESSION["u"])) {
    $login = $_SESSION["u"];
    $get_user = mysqli_query($db, "SELECT * FROM `user` WHERE `username` = '$login'");
    $get_user = mysqli_fetch_assoc($get_user);
    if ($get_user["rule"] == 1) {
        $chucvu = "Sinh Viên";
        $code_cv = '1';
        $sv_id = $get_user["id_check"];
        $get_id_user = mysqli_query($db, "SELECT * FROM `student` WHERE `id` = '$sv_id'");
        $get_id_user = mysqli_fetch_assoc($get_id_user);
        $user_class_id = $get_id_user['class_id'];
    } elseif ($get_user["rule"] == 2) {
        $chucvu = "Giáo Viên";
        $code_cv = '2';
        $sv_id = $get_user["id_check"];
        $get_id_user = mysqli_query($db, "SELECT * FROM `teacher` WHERE `id` = '$sv_id'");
        $get_id_user = mysqli_fetch_assoc($get_id_user);
        $get_id_teacher = $get_id_user["id"];
        $get_id_class = mysqli_query($db, "SELECT * FROM `class` WHERE `teacher_id` = '$get_id_teacher'");
        $get_id_class = mysqli_fetch_assoc($get_id_class);
    }
}
if ($page !== 'login') {
    if (!isset($_SESSION["u"])) {
        header("location: /login.php");
    }
}
