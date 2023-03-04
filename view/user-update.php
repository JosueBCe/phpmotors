<?php
if (!isset($_SESSION['loggedin'])) {
    header('Location: /phpmotors/index.php');
    exit();
}
/* if (isset($userInfo['clientFirstname']) && isset($userInfo['clientLastname'])) {
    echo "Modify $userInfo[clientFirstname] $userInfo[clientLastname]";
} elseif (isset($clientFirstname) && isset($clientLastname)) {
    echo "{$_SESSION['clientFirstname']} {$_SESSION['clientLastname']}";
} */

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

    <title><?php if (isset($userInfo['clientFirstname']) && isset($userInfo['clientLastname'])) {
                echo "Modify $userInfo[clientFirstname] $userInfo[clientLastname]";
            } elseif (isset($clientFirstname) && isset($clientLastname)) {
                echo "Modify $clientFirstname $clientLastname";
            } ?> | PHP Motors</title>

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
        <h1>Update Account</h1>

        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <br>
        <h2>*Note all Fields are Required</h2>
      

        <form action="/phpmotors/accounts/index.php" method="post">
    
            <label for="clientFirstname">First Name <span class="required">*</span></label>
            <input type="text" name="clientFirstname" id="clientFirstname" required  <?php if (isset($clientFirstname)) {
                                                                            echo "value='$clientFirstname'";
                                                                        } elseif (isset($userInfo['clientFirstname'])) {
                                                                            echo "value='$userInfo[clientFirstname]'";
                                                                        } elseif(!isset($userInfo['clientFirstname']) && !isset($clientFirstname))
                                                                        {
                                                                         echo "value='{$_SESSION['clientFirstname']}'";   
                                                                        }
                                                                        
                                                                        
                                                                        ?>>
            <label for="clientLastname">Last Name <span class="required">*</span></label>
            <input type="text" id="clientLastname" name="clientLastname" required <?php if (isset($clientLastname)) {
                                                                            echo "value='$clientLastname'";
                                                                        } elseif (isset($userInfo['clientLastname'])) {
                                                                            echo "value='$userInfo[clientLastname]'";
                                                                        } elseif(!isset($userInfo['clientLastname']) && !isset($clientFirstname))
                                                                        {
                                                                         echo "value='{$_SESSION['clientLastname']}'";   
                                                                        } ?>>
            <label for="clientEmail">Email <span class="required">*</span></label>
            <input type="email" id="clientEmail" name="clientEmail" required <?php if (isset($clientEmail)) {
                                                                            echo "value='$clientEmail'";
                                                                        } elseif (isset($userInfo['clientEmail'])) {
                                                                            echo "value='$userInfo[clientEmail]'";
                                                                        } elseif(!isset($userInfo['clientEmail']) && !isset($clientFirstname))
                                                                        {
                                                                         echo "value='{$_SESSION['clientEmail']}'";   
                                                                        }?>>
           <br>
            <input name="submit" class="sign-in-up-btn" type="submit" value="Update Info">
            <input type="hidden" name="action" value="updateUser">
            <input type="hidden" name="clientId" value="
                <?php if (isset($userInfo['clientId'])) {
                    echo $userInfo['clientId'];
                } elseif (isset($clientId)) {
                    echo $clientId;
                } ?>
                ">
        </form>

        <h3>Update Password</h3>
        
        <?php
        if (isset($messagePassword)) {
            echo $messagePassword;
        }
        ?>
        <form action="/phpmotors/accounts/index.php" method="post">
        <p  id="password-requierements">Passwords must be at least 8 characters and contain at least 1 number, 1 cpital letter and 1 special character</p>
            
            <label for="clientPassword">Password <span class="required">*</span></label>
            <input type="password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"> 
            <button type="button" id="showPassword">Show Password</button>
            <?php
            if (isset($_POST['submit']) && isset($_POST['password']) ) {
                $password = $_POST['password'];
                echo "The password you entered is: " . $password;
            }
            ?>
            <br>
            <input name="submit" class="sign-in-up-btn" type="submit" value="Update Password">
            <input type="hidden" name="action" value="updateUserPassword">
            <input type="hidden" name="clientId" value="
                <?php if (isset($userInfo['clientId'])) {
                    echo $userInfo['clientId'];
                } elseif (isset($clientId)) {
                    echo $clientId;
                } ?>
                ">
      

        </form>

    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
        <script src="../library/show_password.js"></script>
</body>

</html>