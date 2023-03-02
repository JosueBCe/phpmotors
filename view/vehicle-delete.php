<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientLevel'] < 2) {
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

    <title><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?> | PHP Motors</title>
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
    <h1><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <br>
        <form action="/phpmotors/vehicles/index.php" method="post">

            <label for="invMake">Make </label>
            <input type="text" name="invMake" id="invMake" readonly <?php if (isset($invMake)) {
                                                                        echo "value='$invMake'";
                                                                    } elseif (isset($invInfo['invMake'])) {
                                                                        echo "value='$invInfo[invMake]'";
                                                                    } ?>>

            <label for="invModel">Model </label>
            <input type="text" name="invModel" id="invModel" readonly <?php if (isset($invModel)) {
                                                                            echo "value='$invModel'";
                                                                        } elseif (isset($invInfo['invModel'])) {
                                                                            echo "value='$invInfo[invModel]'";
                                                                        } ?>>

            <label for="invDescription">Description </label>
            <textarea name="invDescription" id="invDescription" readonly>
            <?php if (isset($invDescription)) {
                echo "$invDescription";
            } elseif (isset($invInfo['invDescription'])) {
                echo "$invInfo[invDescription]";
            } ?>
        </textarea>
            <br>
            <input class="sign-in-up-btn" type="submit" name="submit" value="Delete Vehicle">
          
	<input type="hidden" name="action" value="deleteVehicle">
	<input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
echo $invInfo['invId'];} ?>">


        </form>

    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
</body>

</html>