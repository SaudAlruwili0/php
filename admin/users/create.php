<?php
$titl = 'create user';
$icon = 'users';
include __DIR__ . '/../template/header.php';
$errors = [];
$email = '';
$name = '';
$role = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $password = mysqli_real_escape_string($mysqli, $_POST['password']);
    $role = mysqli_real_escape_string($mysqli, $_POST['role']);
    if (empty($email)) {
        array_push($errors, 'Email is rquired');
    }
    if (empty($name)) {
        array_push($errors, 'name is required');
    }
    if (empty($password)) {
        array_push($errors, 'password is required');
    }
    if (!count($errors)) {
        $userExists = $mysqli->query("select id,email from users where email = '$email' limit 1");
        if ($userExists->num_rows) {
            array_push($errors, "email already registered");

        }
    }

    if (!count($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "insert into users (email,name,password,role) values('$email','$name','$password','$role')";
        $mysqli->query($query);

        // if ($mysqli->error) {
        //     array_push($errors, $mysqli->error);
        // } else {
        //     echo "<script> location.href = 'index.php </script>";
        // }
        // try {
        //     // هنا راح يتنفذ الاستعلام لو سليم بيشتغل تمام ولو فيه مشكلة راح يشتغل الكود التالي في catch
        //     $mysqli->query($query);
        // } catch (Exception $e) {
        //     // في حال حدوث خطا تقدر تلتقط الخطا هذا من المتغير $e
        //     array_push($errors, $e->getMessage());
        // }

    }
}

?>
<?php include '../../template/errors.php' ?>
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
    <?php
            include __DIR__ . '/../template/footer.php'; ?>