<?php

if (!isset($_SESSION['loggedin'])) {
  header('Location: /phpmotors/index.php');
  exit();
}
if ($_SESSION['clientLevel'] < 3) {
  header('Location: /phpmotors/view/client-view.php');
  exit();
}
if (isset($_SESSION['message'])) {
    $message .= $_SESSION['message'];
    $message .= '<br /><br />';
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
  <h1>
  <?php if (isset($userInfo['clientFirstname']) && isset($userInfo['clientLastname'])) {
                echo "Modify $userInfo[clientFirstname] $userInfo[clientLastname]";
            } elseif (isset($clientFirstname) && isset($clientLastname)) {
                echo "{$_SESSION['clientFirstname']} {$_SESSION['clientLastname']}";
            } ?>
            
          </h1>
          <?php
    if (isset($message)) {
      echo $message;
    } else {
      echo "<p>You are logged in.</p>";
    }
    ?>
        <hr>
    <h3>Account Management</h3>
    <br>
    <p>Use this link to Update Account Information.</p>
    <br>
    <p><a href="/phpmotors/accounts/index.php?action=user-update">Update Account Information</a></p>
    <br>
    <br>
    <hr>
    <h3>Manage Your Products Reviews</h3>

    <?php
        if (isset($reviews)) {
            echo$reviews ;
        }
        ?>
      <hr>
    <h3>Inventory Management</h3>
    <br>
    <p>Use this link to manage the inventory.</p>
    <br>
    <p><a href="/phpmotors/vehicles/index.php">Vehicle Management</a></p>
  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>

</body>

</html>
<?php unset($_SESSION['message']); ?>