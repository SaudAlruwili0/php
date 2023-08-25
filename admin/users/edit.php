<?php
$title = 'edit user';
$icon = 'users';
include __DIR__ . '/../template/header.php';
$email = '';
$name = '';
$role = '';
if (!isset($_GET['id']) || !$_GET['id']) {
    die('missing id paramtr');

}

$st = $mysqli->prepare("select * from users where id =? limit 1");
$st->bind_param('i', $userId);
$userId = $_GET['id'];
$st->execute();
$user = $st->get_result()->fetch_assoc();
print_r($user);
$name = $user['name'];
$email = $user['email'];
$role = $user['role'];
?>

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
        <label for="role">role</label>
        <select name="role" id="role" class="form-control">
            <option value="user" <?php if ($role == 'user')
                echo 'selected' ?>>user</option>
                <option value="admin" <?php if ($role == 'admin')
                echo 'selected' ?>>admin</option>
            </select>
        </div>
        <div class="form-group ">
            <button class="btn btn-success mt-4 ">create!</button>
        </div>


    </form>
<?php include __DIR__ . '/../template/footer.php';