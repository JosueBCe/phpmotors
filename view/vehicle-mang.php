<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientLevel'] < 2) {
  header('Location: /phpmotors/index.php');
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
  <script src="/phpmotors/library/responsive-nav.js"></script>

  <title>Account Manager | PHP Motors</title>
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
    <h1>Add Car Classification</h1>
    <?php
    if (isset($message)) {
      echo $message;
    }
    ?>
    <div>
      <p class="my-account"><a href="index.php?action=add-classification">Add New Classification</a></p>
      <p class="my-account"><a href="index.php?action=add-vehicle">Add Vehicle</a></p>

    </div>

  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>