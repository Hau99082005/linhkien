<?php

require_once 'app/model/userModel.php';


class loginController
{
    public function index()
    {
        $error = '';
        if (isset($_POST['submit'])) {
            $phone = $_POST['phone'];

            $user = new userModel();
            $user = $user->getUserByPhone($phone);

            if ($user) {
                if ($user['phone'] == $_POST['phone'] && $user['role'] == 'admin') {
                    $_SESSION['user-admin'] = $user;
                    header('Location: '. APPURL_ADMIN);
                } else {
                    $error = "Bạn không phải là admin";
                }
            } else {
                $error = "Số điên thoại không tồn tại";
            }
        }
        require_once 'views/pages/auth/login.php';
    }
}