<?php
$title = 'password reset ';
require_once 'template/header.php';
require_once 'config/Database.php';

if (isset($_SESSION['logged_in'])) {
    header('location: index.php');
}

$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    if (empty($email)) {
        array_push($errors, "email is required");
    }
    if (!count($errors)) {

        $userExists = $mysqli->query("select id,email from users where email = '$email' limit 1");
        if ($userExists->num_rows) {
            $userId = $userExists->fetch_assoc()['id'];
            $tokenExists = $mysqli->query("delete from password_resets where user_id = '$userId'");
            $token = bin2hex(random_bytes(16));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 day'));
            $mysqli->query("insert into password_resets (user_id,token,expires_at)
            values('$userId','$token','$expires_at');");

        }
        $_SESSION['success_message'] = 'please check your email for password reset link';
        header('location: password_reset.php');
    }

}
?>
<div id="password_reset">
    <h4>password reset</h4>
    <h5 class="text-info">fill in yur email to reset your password</h5>
    <hr>
    <form action="" method="POST">
        <div class="form-group">
            <label for="email">your email:</label>
            <input class="form-control" type="email" name="email" value="<?php echo $email ?>">
        </div>
        <div class="form-group ">
            <button class="btn btn-primary mt-4 ">reset password!</button>
        </div>
    </form>
</div>