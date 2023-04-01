<?php
if (!isset($_SESSION['loggedin']) ) {
    header('Location: /phpmotors/index.php');
    exit();
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

    <title><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "$invInfo[invMake] $invInfo[invModel] Review";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "$invMake $invModel Review";
            } else {
                echo " $_SESSION[invMake]
                $_SESSION[invModel] Review";
            }?> | PHP Motors</title>

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
        <h1><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "$invInfo[invMake] $invInfo[invModel] Review";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "$invMake $invModel Review";
            }else {
                echo " $_SESSION[invMake]
                $_SESSION[invModel] Review";
            } ?></h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
           <?php
        if (isset($dates)) {
            echo $dates;
        }
        ?>
        <br>
        <hr>
        <form action="/phpmotors/reviews/index.php" method="post">
          
            <label for="reviewText">Review Text <span class="required">*</span></label>
            <textarea name="reviewText" id="reviewText" required>
            <?php if (isset($reviewText) && !isset($restoredText)) {
                echo "$reviewText";
            } elseif (isset($invInfo['reviewText']) && !isset($restoredText)) {
                echo "$invInfo[reviewText]";
            } else {
                echo $restoredText;
            }?>
        </textarea>
           <br>
            <input class="sign-in-up-btn" type="submit" name="submit" value="Update Review">
            <input type="hidden" name="action" value="updateReview">
            <input type="hidden" name="reviewId" value="
                <?php if (isset($invInfo['reviewId'])) {
                    echo $invInfo['reviewId'];
                } elseif (isset($reviewId)) {
                    echo $reviewId;
                } ?>
                ">

        </form>

    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
</body>

</html>