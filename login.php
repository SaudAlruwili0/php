<?php
$title = 'login ';
require_once 'template/header.php';
require_once 'config/Database.php';
$errors = [];
$email = '';
// print_r($_SESSION);
// die();
if (isset($_SESSION['logged_in'])) {
    header('location: index.php');


}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    if (empty($email)) {
        array_push($errors, 'Email is rquired');
    }
    if (empty($password)) {
        array_push($errors, 'password is required');
    }

}
if (!count($errors)) {
    // die("$email");
    $userExists = $mysqli->query("select id,email,password,name from users where email = '$email' limit 1");

    if (!$userExists->num_rows) {
        array_push($errors, "your email , $email does not exists in our records");

    } else {
        $found_user = $userExists->fetch_assoc();

        if (password_verify($password, $found_user['password'])) {

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $found_user['id'];
            $_SESSION['user_name'] = $found_user['name'];
            $_SESSION['success_message'] = "welcome back, $found_user[name]";
            header('location: index.php');
        } else {

            array_push($errors, 'wrong credentials');
        }
    }
}

// die('saud');

?>
<div id="login">
    <h4>welcom back</h4>
    <h5 class="text-info">please fill in the form below to login</h5>
    <hr>
    <?php include 'template/errors.php' ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">your email:</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email ?>">
        </div>

        <div class="form-group">
            <label for="password">your password:</label>
            <input class="form-control" type="password" name="password">
        </div>

        <div class="form-group ">
            <button class="btn btn-success mt-4 ">login!</button>
        </div>
    </form>
</div>