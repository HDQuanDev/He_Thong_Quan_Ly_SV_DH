<?php
switch ($_GET["act"]) {
    case 'login':
        $page = 'login';
        require_once('../system/config.php');
        $json = [];
        $u = mysqli_real_escape_string($db, $_POST['user']);
        $p = mysqli_real_escape_string($db, $_POST['pass']);
        if (empty($u)) {
            $json["status"] = 'error';
            $json["msg"] = 'Vui lòng nhập tên tài khoản!';
        } elseif (empty($p)) {
            $json["status"] = 'error';
            $json["msg"] = 'Vui lòng nhập mật khẩu!';
        } elseif ($u && $p) {
            $p = md5($p);
            $query = "SELECT * FROM user WHERE username='$u' AND password='$p'";
            $results = mysqli_query($db, $query);
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['u'] = $u;
                $_SESSION['p'] = $p;
                $json["status"] = 'success';
                $json["msg"] = 'Đăng nhập thành công!';
            } else {
                $json["status"] = 'error';
                $json["msg"] = 'Tài khoản hoặc mật khẩu không chính xác!';
            }
        }
        echo json_encode($json);
        break;

    default:
        # code...
        break;
}
