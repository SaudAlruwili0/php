<?php
$title = 'Register ';
require_once 'template/header.php';
require_once 'config/Database.php';
$errors = [];
$email = '';
$name = '';
if (isset($_SESSION['logged_in'])) {
    header('location: index.php');

}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);
    if (empty($email)) {
        array_push($errors, 'Email is rquired');
    }
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
if (!count($errors) && !empty($email)) {
    $userExists = $mysqli->query("select id,email from users where email = '$email' limit 1");
    if ($userExists->num_rows) {
        array_push($errors, "email already registered");

    }
}

if (!count($errors)) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "insert into users (email,name,password) values('$email','$name','$password')";
    $mysqli->query($query);
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $mysqli->insert_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['success_message'] = "$name welcome back";
    header('location: index.php');
    print_r($_SESSION['logged_in']);
    print_r($_SESSION['user_id']);
}

?>
<div class="register">
    <h4>welcom to our website</h4>
    <h5 class="text-info">please fill in the form below to register a new account</h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">your email:</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email ?>">
        </div>
        <div class="form-group">
            <label for="name">your name:</label>
            <input class="form-control" type="text" name="name" value="<?php echo $name ?>">
        </div>
        <div class="form-group">
            <label for="password">your password:</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">your confirm password:</label>
            <input class="form-control" type="password" name="password_confirmation">
        </div>
        <div class="form-group ">
            <button class="btn btn-success mt-4 ">register!</button>
        </div>
    </form>
</div>