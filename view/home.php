<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/phpmotors/css/base.css" media="screen">
  <link rel="stylesheet" href="/phpmotors/css/medium.css" media="screen">
  <link rel="stylesheet" href="/phpmotors/css/large.css" media="screen">
  <title>Home | PHP Motors</title>
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
  <main>
    <h1>Welcome to PHP Motors!</h1>
    <div class="hero">
      <div class="hero-text">
        <h2>DMC Delorean</h2>
        <p>3 Cup holders</p>
        <p>Superman doors</p>
        <p>Fuzzy dice!</p>
        <div class="btn">
          <button class="buy">Own Today</button>
        </div>
      </div>

      <div class="hero-image">
        <img src="images/delorean.jpg" alt="Delorean Car">
      </div>

    </div>
    <div class="reviews">
      <h1>DMC Delorean Rebiews</h1>
      <ul>
        <li>"So fast its almost like traveling in time." (4/5)</li>
        <li>"Coolest ride on the road." (4/5)</li>
        <li>"I'm feeling Marty McFly" (5/5)</li>
        <li>"The most futuristic ride of our day" (4.5/5)</li>
        <li>"80's livin and I love it!" (5/5)</li>
      </ul>
    </div>

    <div class="upgrades">
      <h1>Delorean Upgrades</h1>
      <div class="upgrade"><img src="images/upgrades/flux-cap.png" alt="">
        <p><a href="">Flux Capacitor</a></p>
      </div>
      <div class="upgrade"><img src="images/upgrades/flame.jpg" alt="">
        <p><a href="">Flux Capacitor</a></p>
      </div>
      <div class="upgrade"><img src="images/upgrades/bumper_sticker.jpg" alt="">
        <p><a href="">Flux Capacitor</a></p>
      </div>
      <div class="upgrade"><img src="images/upgrades/hub-cap.jpg" alt="">
        <p><a href="">Flux Capacitor</a></p>
      </div>
    </div>
  </main>
  <footer>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
  </footer>
</body>

</html>