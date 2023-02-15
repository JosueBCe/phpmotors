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
        <br>
        <h2>*Note all Fields are Required</h2>
        <form action="/phpmotors/vehicles/index.php" method="post">
            <?php
            // require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/nav.php'; 
            echo $classificationOptions;
            ?>
                <label for="invMake">Make <span class="required">*</span></label>
                <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){echo "value='$invMake'";}  ?>>

                <label for="invModel">Model <span class="required">*</span></label>
                <input type="text" name="invModel" id="invModel" required <?php if(isset($invModel)){echo "value='$invModel'";}  ?>>

                <label for="invDescription">Description <span class="required">*</span></label>
                <textarea name="invDescription" id="invDescription" required><?php if(isset($invDescription)){echo "$invDescription";} ?></textarea>

                <label for="invImage">Image <span class="required">*</span></label>
                <input type="text" name="invImage" id="invImage" required <?php if(isset($invImage)){echo "value='$invImage'";}  ?>>

                <label for="invThumbnail">Thumbnail <span class="required">*</span></label>
                <input type="text" name="invThumbnail" id="invThumbnail" required <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?>>

                <label for="invPrice">Price <span class="required">*</span></label>
                <input type="number" name="invPrice" id="invPrice" required <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?>>

                <label for="invStock">Stock <span class="required">*</span></label>
                <input type="number" name="invStock" id="invStock" required <?php if(isset($invStock)){echo "value='$invStock'";}  ?>>

                <label for="invColor">Color <span class="required">*</span></label>
                <input type="text" name="invColor" id="invColor" required <?php if(isset($invColor)){echo "value='$invColor'";}  ?>>
            <br>
            <input class="sign-in-up-btn" type="submit" value="Add Vehicle">
            <input type="hidden" name="action" value="register-vehicle">

        </form>

    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
</body>

</html>