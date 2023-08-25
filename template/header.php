<?php
session_start();
require_once __DIR__ . '/../config/app.php'; ?>

<!DOCTYPE html>
<html lang="<?php echo $config['lang'] ?>" dir="<?php echo $config['dir'] ?>">

<head>
  <title>
    <?php echo $config['app_name'] . ' | ' . $title ?>
  </title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary ">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
        <?php echo $config['app_name'] ?>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="<?php echo $config['app_url'] ?>/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $config['app_url'] ?>/contact.php">contact</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if (!isset($_SESSION['logged_in'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $config['app_url'] ?>/login.php">login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $config['app_url'] ?>/register.php">register</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="">
                <?php echo $_SESSION['user_name'] ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php $config['app_url'] ?>logout.php">logout</a>
            </li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">

    <?php include 'message.php'; ?>