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
    <title>Image Management| PHP Motors</title>
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
        <h1>Add New Vehicle Image</h1>
        <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
        }
        ?>
        <?php
        if (isset($message)) {
            echo $message;
        } ?>

        <form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
            <label for="invItem">Vehicle</label>
            <?php echo $prodSelect; ?>
            <fieldset>
                <label>Is this the main image for the vehicle?</label>
                <label for="priYes" class="pImage">Yes</label>
                <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
                <label for="priNo" class="pImage">No</label>
                <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
            </fieldset>
            <label>Upload Image:</label>
            <input type="file" name="file1">
            <input type="submit" class="regbtn" value="Upload">
            <input type="hidden" name="action" value="upload">
        </form>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
    </footer>
</body>
</html>
<?php unset($_SESSION['message']); ?>