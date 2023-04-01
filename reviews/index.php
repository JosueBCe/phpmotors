<?php




// 1) Continue Reviews Register : choose folloing the way of register images or the register vehicles 
// 2) Getting by Id: as images way or register by Id 
// 

// This is the "Reviews Controller" for the site.

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../model/reviews-model.php';
require_once '../library/functions.php';
// Get the accounts model

// Starts session of Registrating 
session_start();

// Get the array of classifications
$carclassifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = navBar($carclassifications);

$classificationsIdAndClassification = getIdAndClassification();



$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
}


switch ($action) {

  // Registering Vehicle 
  case "add-review":

    $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $reviewDate = date('j F Y');
    $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);



    // $vehicle = getVehicleById($invId);
    // Check for missing data
    if (empty($reviewText) || empty($clientId) || empty($invId)) {
      $_SESSION["messageReview"] = "<p>Please provide all the required information to add a review.</p>";
      header('Location: /phpmotors/vehicles/?action=single-vehicle&invId=' . "urlencode($invId)");
      exit;
    }
    // $dv .= "<a href='/phpmotors/vehicles/?action=single-vehicle&invId="
    // . urlencode($vehicle['invId']) .
    // "' title='View our $vehicle[invMake] $vehicle[invModel]'>";

    $addOutcomeReview = addReview($reviewText, $reviewDate, $clientId, $invId);

    // Check and report the result
    if ($addOutcomeReview === 1) {
      $_SESSION["messageReview"] = "<p>Thanks for submitting your review!</p>";
      header('Location: /phpmotors/vehicles/?action=single-vehicle&invId=' . "urlencode($invId)");
      exit;
    } else {
      $_SESSION["messageReview"] = "<p>Sorry, but the review could not be added. Please try again.</p>";

      header('Location: /phpmotors/vehicles/?action=single-vehicle&invId=' . "urlencode($invId)");
      exit;
    }
    break;
  case 'mod':
    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);

    $invInfo = getReviewAndInventoryInfo($reviewId);
    $dates = '<strong>Reviewed on ' . date('F j, Y', strtotime($invInfo['reviewDate'])) . '</strong>';
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/review-update.php';
    exit;
    break;
  case 'updateReview':

    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
    $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    // Check for missing data
    if (empty($reviewText) || empty($reviewId)) {
      $message = '<p>Please provide all the required information to update the review.</p>';
      include '../view/review-update.php';
      exit;
    }

    // Send the data to the model
    $updateResult = updateReviewText($reviewText, $reviewId);

    // Check and report the result
    if ($updateResult === 1) {
      if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
      } else {
        $form_data = array();
      }
      $message = "<p><strong>The review was updated successfully</strong></p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/accounts/index.php?action=admin&reviews=admin-review');
      exit;
    } else {
      $message = "<p>Sorry, but the review updating failed. Please try again.</p>";
      include '../view/review-update.php';
      exit;
    }
  case 'del':

    $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
    $invInfo = getReviewAndInventoryInfo($reviewId);

    $dates = '<strong>Reviewed on ' . date('F j, Y', strtotime($invInfo['reviewDate'])) . '</strong>';
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/review-delete.php';
    exit;
    break;

  case 'deleteReview':
    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

    $deleteResult = deleteReview($reviewId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations, the review was successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/accounts/index.php?action=admin&reviews=admin-review');
      exit; 
    } else {
      $message = "<p class='notice'>Error: the review was not deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/accounts/index.php?action=admin&reviews=admin-review');
      exit;
    }
    break;
  case 'classification':
    $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vehicles = getVehiclesByClassification($classificationName);
    if (!count($vehicles)) {
      $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
      $vehicleDisplay = buildVehiclesDisplay($vehicles);
    }

    include '../view/classification.php';
    break;
  case 'single-vehicle':

    $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
    $vehicle = getVehicleById($invId);
    $thumbImages = getVehicleImagesById($invId);
    $invMake = $vehicle['invMake'] . " " . $vehicle['invModel'];
    if (!count($vehicle)) {
      $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
    } else {
      $vehicleDisplay = buildVehicleDisplay($vehicle);

      $extraImages = buildExtraImagesDisplay($thumbImages);


    }

    include '../view/single-vehicle.php';
    break;
}

?>