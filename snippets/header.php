<a href="/phpmotors/index.php"><img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo" id="logo"></a>

<div>

  <p class="my-account">
    <?php 


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    echo  "<a href='/phpmotors/accounts/index.php?action=admin' class='account-link'>$cookieFirstname </a> || <a href='/phpmotors/accounts/index.php?action=Logout' class='account-link'>Logout </a>";
} 
}else {
  echo "<a href='/phpmotors/accounts/index.php' class='account-link'>My Account</a> " ;}
?></p>
</div>