<?php
$titl = 'users';
$icon = 'dashboard';
include __DIR__ . '/../template/header.php';

$users = $mysqli->query("select * from users order by id")->fetch_all(MYSQLI_ASSOC);
// print_r($users);
?>



<div class="card">
    <div class="content">
        <a href="create.php" class="btn btn-success">create a new user</a>

        <p class="header">
            users:
            <?php echo count($users) ?>
        </p>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width=0>#</th>
                        <th>eamil</th>
                        <th>name</th>
                        <th>role</th>
                        <th width=250>actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?php echo $user['id'] ?>
                            </td>
                            <td>
                                <?php echo $user['email'] ?>
                            </td>
                            <td>
                                <?php echo $user['name'] ?>
                            </td>
                            <td>
                                <?php echo $user['role'] ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?php echo $user['id'] ?>" class="btn btn-wrning">Edit</a>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php

include __DIR__ . '/../template/footer.php'; ?>