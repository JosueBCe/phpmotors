<?php
if (!isset($_SESSION['loggedin'])) {
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
    <h1> <?php
    if (isset($currentUser)) {
      echo $currentUser;
    }
    ?></h1>
    <h2>You are logged in.</h2>
    <?php
    if (isset($message)) {
      echo $message;
    }
    ?>
     <h3>Account Management</h3>
    <br>
    <p>Use this link to Update Account Information.</p>
    <br>
    <p><a href="/phpmotors/accounts/index.php?action=user-update">Update Account Information</a></p>
    <br>

  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>