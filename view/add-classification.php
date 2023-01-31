<!DOCTYPE html>
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
    <h1>Add Car Classification</h1>
    <?php
    if (isset($message)) {
      echo $message;
    }
    ?>
    <form action="/phpmotors/vehicles/index.php" method="post">
      <label for="classificationName">Classification Name </label>
      <input type="text" id="classificationName" name="classificationName">
      <br>
      <input class="sign-in-up-btn" type="submit" value="Add Classification">
       <input type="hidden" name="action" value="register-classification">
    </form>
  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>