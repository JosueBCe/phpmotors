<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/phpmotors/css/base.css" media="screen">
  <link rel="stylesheet" href="/phpmotors/css/medium.css" media="screen">
  <link rel="stylesheet" href="/phpmotors/css/large.css" media="screen">
  <script src="/phpmotors/library/responsive-nav.js"></script>

  <title><?php echo $invMake ?> | PHP Motors</title>
</head>

<body>
  <header>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
  </header>
  <nav>
    <?php
    echo $navList;
    ?>
  </nav>
  <main class="main-vehicle">
    <h1><?php echo $invMake ?></h1>
    
   
    <?php if (isset($vehicleDisplay)){
        echo $vehicleDisplay;
    }
    ?> 
     <?php if (isset($extraImages)){
        echo $extraImages;
    } ?>
    
  </main>
  <hr>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>