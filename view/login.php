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
    <h1>Sign in</h1>
    <?php
    if (isset($message)) {
      echo $message;
    }
    ?>
    <form method="post">
      <label for="clientEmail">Email <span class="required">*</span> </label>
      <input type="email" id="clientEmail" name="clientEmail" required <?php 
            if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>>

      <label id="password-requierements">Passwords must be at least 8 characters and contain at least 1 number, 1 cpital letter and 1 special character</label>
      <label for="clientPassword">Password <span class="required">*</span></label>
      <input type="password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"> 
      <br>
      <input type="hidden" name="action" value="Login">
      <input class="sign-in-up-btn" type="submit" value="Sign in">
    </form>
    <div>
      <p class="my-account"><a href="index.php?action=registration">Not Registered Yet?</a></p>
    </div>
  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>