<?php

if (!isset($_SESSION['loggedin'])) {
  header('Location: /phpmotors/index.php');
  exit();
}
if ( $_SESSION['clientLevel'] < 3) {
  header('Location: /phpmotors/view/client-view.php');
  exit();
} 

?><!DOCTYPE html>
<html lang="en"> 
      
       

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/base.css" media="screen">
  <link rel="stylesheet" href="../css/medium.css" media="screen">
  <link rel="stylesheet" href="../css/large.css" media="screen">
  <title>Account Login | PHP Motors</title>
</head>

<body>
  <header>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
  </header>
  <nav>
    <?php
    // require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/nav.php'; 
    echo $navList;
    ?>
  </nav>
  <main class="main-form">
    <h1>Admin User</h1>
    <h2>You are logged in.</h2>
    <?php
    if (isset($message)) {
      echo $message;
    }
    ?>
    <h2>Inventory Management</h2>
    <h3>Use this link to manage the inventory.</h3>
   <p><a href="/phpmotors/vehicles/index.php">Vehicle Management</a></p>
  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>