<?php
$title = 'change password';
require_once 'template/header.php';
require_once 'config/Database.php';

if (isset($_SESSION['logged_in'])) {
    header('location: index.php');
}
if (!isset($_GET['token']) || !$_GET['token']) {
    die('token parameter is missing');
}

$now = date('Y-m-d H:i:s');
$stmt = $mysqli->prepare("select * from password_resets where token =? and expires_at> '$now'");
$stmt->bind_param('s', $token);
$token = $_GET['token'];
$stmt->execute();
$result = $stmt->get_result();
// echo $result->num_rows;
if (!$result->num_rows) {
    die('token is not vaild');

}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);
    if (empty($name)) {
        array_push($errors, 'name is required');
    }
    if (empty($password)) {
        array_push($errors, 'password is required');
    }
    if (empty($password_confirmation)) {
        array_push($errors, 'password_confirmation is required');
    }
    if ($password_confirmation != $password) {
        array_push($errors, "password don't match");
    }
}

if (!count($errors)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $userId = $result->fetch_assoc()['user_id'];
    $mysqli->query("update users set password ='$hashed_password' where id ='$userId' ");
    $mysqli->query("delete from password_resets where user_id = '$userId'");
    $_SESSION['success_mesage'] = 'your password has been changed , please log in';
    header('location: login.php');
    die();
}


?>
<div id="password_reset">
    <h4>create a new password</h4>
    <hr>
    <form action="" method="POST">
        <div class="form-group">
            <label for="password">your new password:</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">confirm your new password </label>
            <input class="form-control" type="password_confirmation" name="password_confirmation">
        </div>
        <div class="form-group ">
            <button class="btn btn-primary mt-4 ">change password!</button>
        </div>
    </form>
</div>