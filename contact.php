<?php
$title = 'contact';
require_once 'template/header.php';
require_once 'includes/uploader.php';
require 'classes/Service.php';
require_once 'config/Database.php';

if (isset($_SESSION['contact_form'])) {
    print_r($_SESSION['contact_form']);
}

$services = $mysqli->query("select id,name ,price from services order by name")->fetch_all(MYSQLI_ASSOC);
?>


<h1>contact us
    <?php isset($_SESSION['sender_name']) ? $sender = $_SESSION['sender_name'] : $sender = '' ?>
    <?php echo $sender ?>
</h1>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">enter your name</label>
        <input type="text" name="name" value="<?php if (isset($_SESSION['contact_form']['name']))
            echo $_SESSION['contact_form']['name'] ?>" id="" class="form-control" placeholder="your name">
            <span class="text-danger">
            <?php echo $nameError ?>
        </span>
    </div>
    <div class="form-group">
        <label for="email">enter your email</label>
        <input type="email" name="email" value="<?php if (isset($_SESSION['contact_form']['email']))
            echo $_SESSION['contact_form']['email'] ?>" id="" class="form-control" placeholder="your email">
            <span class="text-danger">
            <?php echo $emailError ?>
        </span>
    </div>
    <div class="form-group">
        <label for="document"> your document</label>
        <input type="file" name="document" id="">
        <span class="text-danger">
            <?php echo $documentError ?>
        </span>
    </div>
    <div class="form-group">
        <label for="services"> services</label>
        <select name="service_id" id="services" class="form-control">
            <?php foreach ($services as $service) { ?>
                <option value="<?php echo $service['id'] ?>"><?php echo $service['name'] . ' (' . $service['price'] . ')' . 'SAR' ?></option>
            <?php } ?>


        </select>
        <span class="text-danger">
            <?php echo $documentError ?>
        </span>
    </div>
    <div class="form-group">
        <label for="message">enter your message</label>
        <textarea name="message" id="" class="form-control" placeholder="your document"> <?php if (isset($_SESSION['contact_form']['message']))
            echo $_SESSION['contact_form']['message'] ?></textarea>
            <span class="text-danger">
            <?php echo $messageError ?>
        </span>
    </div>
    <button class="btn btn-primary">send</button>
</form>
<?php
require_once 'template/footer.php' ?>