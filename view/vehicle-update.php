<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['clientLevel'] < 2) {
    header('Location: /phpmotors/index.php');
    exit();
}


// Build the classifications option list
$classifList = '<select name="classificationId" id="classificationId">';
$classifList .= "<option>Choose a Car Classification</option>";
foreach ($classificationsIdAndClassification as $classification) {
    $classifList .= "<option value='$classification[classificationId]'";
    if (isset($classificationId)) {
        if ($classification['classificationId'] === $classificationId) {
            $classifList .= ' selected ';
        }
    } elseif (isset($invInfo['classificationId'])) {
        if ($classification['classificationId'] === $invInfo['classificationId']) {
            $classifList .= ' selected ';
        }
    }
    $classifList .= ">$classification[classificationName]</option>";
}
$classifList .= '</select>';

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
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify $invMake $invModel";
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
        <h1><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify $invMake $invModel";
            } ?></h1>
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
            echo $classifList;
            ?>
            <label for="invMake">Make <span class="required">*</span></label>
            <input type="text" name="invMake" id="invMake" required <?php if (isset($invMake)) {
                                                                        echo "value='$invMake'";
                                                                    } elseif (isset($invInfo['invMake'])) {
                                                                        echo "value='$invInfo[invMake]'";
                                                                    } ?>>

            <label for="invModel">Model <span class="required">*</span></label>
            <input type="text" name="invModel" id="invModel" required <?php if (isset($invModel)) {
                                                                            echo "value='$invModel'";
                                                                        } elseif (isset($invInfo['invModel'])) {
                                                                            echo "value='$invInfo[invModel]'";
                                                                        } ?>>

            <label for="invDescription">Description <span class="required">*</span></label>
            <textarea name="invDescription" id="invDescription" required>
            <?php if (isset($invDescription)) {
                echo "$invDescription";
            } elseif (isset($invInfo['invDescription'])) {
                echo "$invInfo[invDescription]";
            } ?>
        </textarea>
            <label for="invImage">Image <span class="required">*</span></label>
            <input type="text" name="invImage" id="invImage" required <?php if (isset($invImage)) {
                                                                            echo "value='$invImage'";
                                                                        } elseif (isset($invInfo['invImage'])) {
                                                                            echo "value='$invInfo[invImage]'";
                                                                        } ?>>

            <label for="invThumbnail">Thumbnail <span class="required">*</span></label>
            <input type="text" name="invThumbnail" id="invThumbnail" required <?php if (isset($invThumbnail)) {
                                                                                    echo "value='$invThumbnail'";
                                                                                } elseif (isset($invInfo['invThumbnail'])) {
                                                                                    echo "value='$invInfo[invThumbnail]'";
                                                                                } ?>>

            <label for="invPrice">Price <span class="required">*</span></label>
            <input type="number" name="invPrice" id="invPrice" required <?php if (isset($invPrice)) {
                                                                            echo "value='$invPrice'";
                                                                        } elseif (isset($invInfo['invPrice'])) {
                                                                            echo "value='$invInfo[invPrice]'";
                                                                        } ?>>

            <label for="invStock">Stock <span class="required">*</span></label>
            <input type="number" name="invStock" id="invStock" required <?php if (isset($invStock)) {
                                                                            echo "value='$invStock'";
                                                                        } elseif (isset($invInfo['invStock'])) {
                                                                            echo "value='$invInfo[invStock]'";
                                                                        } ?>>

            <label for="invColor">Color <span class="required">*</span></label>
            <input type="text" name="invColor" id="invColor" required <?php if (isset($invColor)) {
                                                                            echo "value='$invColor'";
                                                                        } elseif (isset($invInfo['invColor'])) {
                                                                            echo "value='$invInfo[invColor]'";
                                                                        } ?>> <br>
            <input class="sign-in-up-btn" type="submit" name="submit" value="Update Vehicle">
            <input type="hidden" name="action" value="updateVehicle">
            <input type="hidden" name="invId" value="
                <?php if (isset($invInfo['invId'])) {
                    echo $invInfo['invId'];
                } elseif (isset($invId)) {
                    echo $invId;
                } ?>
                ">

        </form>

    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
</body>

</html>