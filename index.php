<?php
$title = 'home page';
require_once 'template/header.php';
require 'classes/Service.php';
require_once 'config/Database.php';

$service = new Service;

$_SESSION['sender_name'] = 'saud';
setcookie('username', 'saud', time() + 30 * 24 * 60 * 60);

// $mysqli->close();
if (isset($_COOKIE['username']))
    echo 'hello ' . $_COOKIE['username'];

?>


<h1>welcome to our site</h1>
<?php $products = $mysqli->query("select * from products")->fetch_all(MYSQLI_ASSOC); ?>

<div class="row">
    <?php foreach ($products as $product) { ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <?php echo $product['name'] ?>
                </div>
                <div class="card-body">
                    <img class="img-fluid" src="<?php echo $config['app_url'] . $product['image'] ?>" alt="www">
                    <div>price:
                        <?php echo $product['price'] ?>
                    </div>
                    <div>descrption:
                        <?php echo $product['description'] ?>
                    </div>
                </div>
            </div>
        </div>




    <?php } ?>
    <?php require_once 'template/footer.php' ?>