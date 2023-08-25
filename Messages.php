<?php
require 'template/header.php';
require 'config/Database.php';

// $mysqli = new mysqli;
$st = $mysqli->prepare("SELECT * , m.id as message_id ,s.id as service_id from messages m LEFT JOIN services s 
    ON m.service_id = s.id order by m.id limit ?;");
if (isset($_POST['message_id'])) {
    $st = $mysqli->prepare("delete from messages where id =?");
    $st->bind_param('i', $messageId);
    $messageId = $_POST['message_id'];
    $st->execute;
}
if (!isset($_GET['id'])) {
    $query = "SELECT * , m.id as message_id ,s.id as service_id from messages m LEFT JOIN services s 
    ON m.service_id = s.id order by m.id limit ?;";

    $st->bind_param('i', $limit);
    isset($_GET['limit']) ? $limit = $_GET['limit'] : $limit = 5;
    $st->execute();
    // var_dump($st->get_result());
    // exit;
    $messages = $st->get_result()->fetch_all(MYSQLI_ASSOC);

    die($messages);
    // echo "<pre>";
    // var_dump($messages);
    // echo "</pre>";
    // die();
    // $messages = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);

    ?>
    <h2>recived messages</h2>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>contact_name</th>
                    <th>email</th>
                    <th>service</th>
                    <th>document</th>
                    <th>action</th>

                </tr>
            </thead>


            <?php foreach ($messages as $message) { ?>

                <tr>
                    <td>
                        <?php echo $message['message_id'] ?>
                    </td>
                    <td>
                        <?php echo $message['contact_name'] ?>
                    </td>
                    <td>
                        <?php echo $message['name'] ?>
                    </td>
                    <td>
                        <?php echo $message['email'] ?>
                    </td>
                    <td>
                        <?php echo $message['document'] ?>
                    </td>
                    <td> <a href="?id=<?php echo $message['message_id'] ?>" class="btn btn-primary">view</a>
                        <form action="" style="display:inline-block" method="post">
                            <input type="hidden" name="message_id" value="<?php echo $message['message_id'] ?>">
                            <button class="btn btn-danger">delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>

        </table>
    </div>

<?php } else {
    $messageQuery = "select * from messages where id=" . $_GET['id'];
    $message = $mysqli->query($messageQuery)->fetch_array(MYSQLI_ASSOC);
    ?>
    <div class="card">
        <div class="card-header">
            <h5>message from:
                <?php echo $message['contact_name'] ?>
            </h5>
            <div class="small">
                <?php echo $message['email'] ?>
            </div>
        </div>
        <div class="card-body">
            <?php echo $message['message'] ?>
        </div>
    </div>

    <?php
}
if (isset($_POST['message_id'])) {
    // $mysqli->query("delete from messages where id=" . $_POST['message_id']);

    $st = $mysqli->prepare("delete from messages where id= ?");
    $st->bind_param('i', $messageId);
    $st->execute;
    echo "<script> location.href ='messages.php' </script>";
}
require 'template/footer.php';
?>