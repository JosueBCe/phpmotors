<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/base.css" media="screen">
    <link rel="stylesheet" href="../css/medium.css" media="screen">
    <link rel="stylesheet" href="../css/large.css" media="screen">


    <title>Account Registration | PHP Motors</title>

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
        <h1>Register</h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/accounts/index.php" method="post">
            <label for="clientFirstname">First Name <span class="required">*</span></label>
            <input type="text" name="clientFirstname" id="clientFirstname" required <?php 
            if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>>

            <label for="clientLastname">Last Name <span class="required">*</span></label>
            <input type="text" id="clientLastname" name="clientLastname" required <?php 
            if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>>

            <label for="clientEmail">Email <span class="required">*</span></label>
            <input type="email" id="clientEmail" name="clientEmail" required <?php 
            if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>>
            <label id="password-requierements">Passwords must be at least 8 characters and contain at least 1 number, 1 cpital letter and 1 special character</label>
            <label for="clientPassword">Password <span class="required">*</span></label>
            <input type="password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"> 
            <button type="button" id="showPassword">Show Password</button>
            <?php
            if (isset($_POST['submit'])) {
                $password = $_POST['password'];
                echo "The password you entered is: " . $password;
            }
            ?>
            <input class="sign-in-up-btn" type="submit" value="Register">
            <input type="hidden" name="action" value="register">

        </form>

    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
    <script src="../library/show_password.js"></script>
</body>

</html>