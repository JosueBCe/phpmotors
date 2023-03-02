<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientLevel'] < 2) {
  header('Location: /phpmotors/');
  exit();
}

if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
 }


?>
<!DOCTYPE html>
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
    <div>
      <p class="my-account"><a href="index.php?action=add-classification">Add New Classification</a></p>
      <p class="my-account"><a href="index.php?action=add-vehicle">Add Vehicle</a></p>

    </div>
    <h1>Add Car Classification</h1>
    <?php
    if (isset($message)) {
      echo $message;
    }
    if (isset($classificationList)) {
      echo '<h2>Vehicles By Classification</h2>';
      echo '<p>Choose a classification to see those vehicles</p>';
      echo $classificationList;
    }
    ?>
    <noscript>
      <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>
    <table id="inventoryDisplay"></table>
  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
  <script src="../js/inventory.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>