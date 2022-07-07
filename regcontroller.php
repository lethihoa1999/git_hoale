<?php
session_start();
require_once "connect.php";
function exist_param($fieldname)
{
    return array_key_exists($fieldname, $_REQUEST);
}

function setFlashSuccess($message)
{
    $_SESSION['flash'] = $message;
}

function setFlashError($message)
{
    $_SESSION['flash'] = $message;
}
extract($_REQUEST);
$errors = array();
$pattern = ['name' => '', 'phone' => '', 'mail' => '', 'password' => '', 'address' => ''];
$pattern['name'] = "/^[a-zA-Z]{6,200}$/";
$pattern['mail'] = "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{1,251})+$/";
$pattern['phone'] = "/^[0-9]{10,20}$/i";
$pattern['password'] = "/^[0-9]{6,100}$/";
$pattern['address'] = "/^[a-zA-Z0-9]{5,255}$/i";
if (exist_param("btn_login")) {
    if (isset($_POST) & !empty($_POST)) {
        $sql = "SELECT *FROM `sampleDB`.`users` where `users`.`mail`='$mail';";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_ASSOC);
        if (preg_match($pattern['mail'], $mail) == 0) {
            $errors['mail'] = "Mail is wrong format !";
        }
        if (preg_match($pattern['password'], $password) == 0) {
            $errors['password'] = "Password length from 6 to 100 characters !";
        }
        if ($users == false) {
            $errors['login'] = "Mail or password is incorrect!";
        } else if (password_verify($password, $users['password']) == false) {
            $errors['login'] = "Mail or password is incorrect!";
        } else {
            $_SESSION["user"] = $users;
            if (isset($remember) && !empty($remember)) {
                $cookie_value = json_encode($users);
                setcookie("user", $cookie_value, time() + (86400 * 30), "/");
            }
            setFlashSuccess("Logged in successfully");
            header("Location: LoginSuccessPdo.php");
        }
        if (!empty($errors)) {
            setFlashError($errors);
            header("Location: LoginPdo.php");
        }
    }
} elseif (exist_param("btnRegister")) {
    if (isset($_POST) & !empty($_POST)) {
        if (preg_match($pattern['name'], $name) == 0) {
            $errors['name'] = "Username length from 6 to 200 characters !";
        }
        if (preg_match($pattern['phone'], $phone) == 0) {
            $errors['phone'] = "Phone number length from 10 to 20 characters !";
        }
        if (preg_match($pattern['mail'], $mail) == 0) {
            $errors['mail'] = "Mail is wrong format !";
        }
        if (preg_match($pattern['address'], $address) == 0) {
            $errors['address'] = "Address cannot be empty !";
        }
        if (preg_match($pattern['password'], $password) == 0) {
            $errors['password'] = "Password length from 6 to 100 characters !";
        } elseif ($password != $RepeatPassword) {
            $errors['RepeatPassword'] = "Confirmation password is incorrect";
        }
        $sql = "SELECT *FROM `users` where `mail`='$mail'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($users)) {
            $errors['mail'] = "Mail already exists !";
        }
        if (empty($errors)) {
            $created_at = date("Y-m-d H:i:s");
            $updated_at = date("Y-m-d H:i:s");
            $password = password_hash($password, PASSWORD_DEFAULT);
            try {
                $sql = "INSERT INTO `users`(`mail`,`name`,`password`,`phone`,`address`,`created_at`,`updated_at`)
                        VALUES ('$mail','$name','$password','$phone','$address','$created_at','$updated_at')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            } catch (Exception $exc) {
                $MESSAGE = "Thêm mới thất bại!" . $exc->getMessage();
                echo $MESSAGE;
            }
            header("Location: LoginPdo.php");
        } else {
            setFlashError($errors);
            header("Location: RegisterPdo.php");
        }
    }
}