<?php

// This is the "Accounts Controller" for the site.

// Get the database connection file
require_once '../library/connections.php';

// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

// Get the accounts model
require_once '../model/accounts-model.php';

// Get the reviews model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';
session_start();
// Get the array of classifications
$carclassifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = navBar($carclassifications);

// $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}
switch ($action) {
  case 'template':
    include '../view/template.php';
    break;
  case 'login':
    include '../view/login.php';
    break;
  case 'registration':
    include '../view/registration.php';
    break;

  default:
    include '../view/login.php';
    break;

  case 'register':
    // Filter and store the data
    $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);


    // Checking if email already exists
    $repeteadEmail = checkExisitingEmail($clientEmail);

    if ($repeteadEmail) {
      $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
      include '../view/login.php';
      exit;
    }



    // Check for missing data
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/registration.php';
      exit;
    }

    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    // Send the data to the model
    $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

    // Check and report the result
    if ($regOutcome === 1) {
      //        cookies name, cookies value, time of life, where it would be avavailable (the entire website because is in the root).

      if (!session_status() === PHP_SESSION_ACTIVE) {
        session_start();
      }


      setcookie("firstname", $clientFirstname, strtotime("+1 year"), "/");

      $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
      include '../view/login.php';
      exit;
    } else {
      $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
      include '../view/registration.php';
      exit;
    }
    break;
  case 'Login':
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    if (empty($clientEmail) || empty($checkPassword)) {
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/login.php';
      exit;
    }

    $user = checkIfClient($clientEmail);

    if ($user && password_verify($clientPassword, $user['clientPassword'])) {
      $clientFirstname = $user['clientFirstname'];
      $clientLastname = $user['clientLastname'];
      $clientEmail = $user['clientEmail'];
      $clientLevel = $user['clientLevel'];
      $clientId = $user['clientId'];

      // Set $_SESSION['loggedin'] to true if login credentials are correct
      $_SESSION['loggedin'] = true;
      $_SESSION['clientFirstname'] = $clientFirstname;
      $_SESSION['clientLastname'] = $clientLastname;
      $_SESSION['clientEmail'] = $clientEmail;
      $_SESSION['clientLevel'] = $clientLevel;
      $_SESSION['clientId'] = $clientId;

      setcookie("firstname", $clientFirstname, strtotime("+1 year"), "/");
      setcookie('mycookie', 'cookievalue', time() + 3600 * 24, '/');
      if (isset($_SESSION['loggedin'])) {

        // $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);

        $currentUser = " {$_SESSION['clientFirstname']} {$_SESSION['clientLastname']}";

        $reviewData = getClientReviews($_SESSION['clientId']);

   
        if (count($reviewData) > 0) {
          // Do something if there is more than one review
          $reviews = buildReviewList($reviewData);
    
        } else {
          // Do something else if there is only one or zero reviews
          $reviews = "<h4>Currently, you don't have any reviews</h4>";
        }
        $message = " 
          <ul>
        <li>First name: $clientFirstname</li>
        <li>Last name: $clientLastname</li>
        <li>Email: $clientEmail </li>
        </ul>";
        if ($clientLevel > 1) {
          include '../view/admin.php';
        } else {
          include '../view/client-view.php';
        }
      }
    } else {
      $message = '<p>The password or the email is not correct</p>';
      include '../view/login.php';
      exit;
    }
    break;
  // default:
  // include '/view/home.php';
  // break;
  case "Logout":
    // Logout script

    // Unset all of the session variables
    $_SESSION = array();

    // If the user is using a session cookie, remove it
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    // Destroy the session

    session_destroy(); // Destroy the session

    // Redirect the user to the specified URL
    header('Location: /phpmotors/index.php');
    // Logout script


    // session_unset(); // Unset all session variables
    // session_destroy(); // Destroy the session
    // include '../view/home';

    exit;
    break;
  case "admin":
    // $ew = filter_input(INPUT_GET, 'admin-reviews', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $currentUser = " {$_SESSION['clientFirstname']} {$_SESSION['clientLastname']}  ";
    $clientFirstname = $_SESSION['clientFirstname'];
    $clientLastname = $_SESSION['clientLastname'];
    $clientEmail = $_SESSION['clientEmail'];
    // get all the info of reviews by the news to olds. 
    $reviewData = getClientReviews($_SESSION['clientId']);

   
    if (count($reviewData) > 0) {
      // Do something if there is more than one review
      $reviews = buildReviewList($reviewData);

    } else {
      // Do something else if there is only one or zero reviews
      $reviews = "<h4>Currently, you don't have any reviews</h4>";
    }


    $message = " 
         <ul>
       <li>First name: $clientFirstname</li>
       <li>Last name: $clientLastname</li>
       <li>Email: $clientEmail </li>
       </ul>";

    if ($_SESSION['clientLevel'] > 1) {
      include '../view/admin.php';
      exit();
    } else {
    
      include '../view/client-view.php';
           exit();
    }


    break;

  case "user-update":
    $userId = $_SESSION['clientId'];
    $userInfo = getUserInfo($userId);

    include '../view/user-update.php';
    break;
  case 'updateUser':

    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    $clientEmail = checkEmail($clientEmail);

    $repeteadEmail = checkExisitingEmail($clientEmail);

    if ($repeteadEmail) {
      $message = "<p class='notice'>That email address already exists. Please Choose another Email</p>";
      include '../view/user-update.php';
      exit;
    }


    // Check for missing data
    if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
      $message = '<p>Please provide information for all empty form fields.</p>';
      include '../view/user-update.php';
      exit;
    }


    // Send the data to the model
    $updateResult = updateUser($clientFirstname, $clientLastname, $clientEmail, $clientId);

    //Check and report the result
    if ($updateResult === 1) {

      if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
      } else {
        $form_data = array();
      }

      $message = "<p> <strong>The $clientFirstname was updated successfully</strong></p>";
      $_SESSION['message'] = $message;
      $_SESSION['clientFirstname'] = $clientFirstname;
      $_SESSION['clientLastname'] = $clientLastname;
      $_SESSION['clientEmail'] = $clientEmail;

      $_SESSION['updated'] = true;
      header('location: /phpmotors/accounts/index.php?action=admin');
      exit;
    } else {

      $message =
        "<p>Sorry, but the user information updating failed. Please try again.</p>";
      include '../view/user-update.php';
      exit;
    }
    break;
  case 'updateUserPassword':
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    $checkPassword = checkPassword($clientPassword);

    // Check for missing data
    if (empty($checkPassword)) {
      $messagePassword = '<p>Please make sure your Password matches the desired pattern.</p>';
      include '../view/user-update.php';
      exit;
    }

    // Hash the checked password
    $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

    // Send the data to the model
    $updateResult = updateUserPassword($hashedPassword, $clientId);

    //Check and report the result
    if ($updateResult === 1) {

      if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
      } else {
        $form_data = array();
      }

      $message = "<p> <u><strong>The Password was updated successfully</strong></u></p>";
      $_SESSION['message'] = $message;

      $_SESSION['updated'] = true;
      header('location: /phpmotors/accounts/index.php?action=admin');
      exit;
    } else {

      $message =
        "<p>Sorry, but the user password information updating failed. Please try again.</p>";
      include '../view/user-update.php';
      exit;
    }
    break;


}
?>