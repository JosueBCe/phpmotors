<?php

// This is the "Accounts Controller" for the site.

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
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

  default:

    $classificationList = buildClassificationList($classificationsIdAndClassification);
    include '../view/vehicle-mang.php';
    break;
  case 'getInventoryItems':
    // Get the classificationId 
    $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
    // Fetch the vehicles by classificationId from the DB 
    $inventoryArray = getInventoryByClassification($classificationId);
    // Convert the array to a JSON object and send it back 
    echo json_encode($inventoryArray);
    break;
  case 'add-classification':
    include '../view/add-classification.php';
    break;
  case 'add-vehicle':
    include '../view/add-vehicle.php';
    break;

  case 'register-classification':

    $classificationName = filter_input(INPUT_POST, 'classificationName');

    // Check for missing data
    if (empty($classificationName)) {
      $message = '<p>Please provide a New Name for a Car Classification.</p>';
      include '../view/add-classification.php';
      exit;
    }

    // Send the data to the model
    $regOutcome = regClassification($classificationName);

    //Check and report the result
    if ($regOutcome === 1) {
      //  $message = "<p>Thanks for registering $classificationName. You'll see in the NavBar the new Classification.</p>";
      include '../view/vehicle-mang.php';


      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['form_data'] = $_POST;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
      }

      if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
      } else {
        $form_data = array();
      }
      exit;
    } else {
      $message = "<p>Sorry $classificationName, but the Classification registration failed. Please try again.</p>";
      include '../view/add-classification.php';
      exit;
    }
    break;


    // Registering Vehicle 
  case 'register-vehicle':

    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $classificationId = filter_input(INPUT_POST,  'classificationId', FILTER_SANITIZE_NUMBER_INT);
    // Check for missing data
    if (
      empty($invMake) || empty($invModel) || empty($invDescription) ||
      empty($invImage) || empty($invThumbnail) || empty($invPrice) ||
      empty($invStock) || empty($invColor) || empty($classificationId)
    ) {
      $message = '<p>Please provide all the required information to register a new vehicle.</p>';
      include '../view/add-vehicle.php';
      exit;
    }

    // Send the data to the model
    $regOutcomeVehicles = regVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

    //Check and report the result
    if ($regOutcomeVehicles === 1) {
      //$message = "<p>Thanks for registering the vehicle. You'll see it in the vehicle management page.</p>";


      // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //   $_SESSION['form_data'] = $_POST;
      //   header('Location: ' . $_SERVER['REQUEST_URI']);
      //   exit;
      // }

      if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
      } else {
        $form_data = array();
      }
      $message = "<p> <strong>The $invMake was added successfully</strong></p>";
      include '../view/add-vehicle.php';
    } else {
      $message = "<p>Sorry, but the vehicle registration failed. Please try again.</p>";
      include '../view/add-vehicle.php';
      exit;
    }
    break;
  case 'mod':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-update.php';
    exit;
    break;
  case 'updateVehicle':
    $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
    $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
    $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $classificationId = filter_input(INPUT_POST,  'classificationId', FILTER_SANITIZE_NUMBER_INT);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    // Check for missing data
    if (
      empty($invMake) || empty($invModel) || empty($invDescription) ||
      empty($invImage) || empty($invThumbnail) || empty($invPrice) ||
      empty($invStock) || empty($invColor) || empty($classificationId)
    ) {
      $message = '<p>Please provide all the required information to register a new vehicle.</p>';
      include '../view/vehicle-update.php';
      exit;
    }

    // Send the data to the model
    $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);

    //Check and report the result
    if ($updateResult === 1) {

      if (isset($_SESSION['form_data'])) {
        $form_data = $_SESSION['form_data'];
        unset($_SESSION['form_data']);
      } else {
        $form_data = array();
      }
      $message = "<p> <strong>The $invMake was updated successfully</strong></p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $message =
        "<p>Sorry, but the vehicle updating failed. Please try again.</p>";
      include '../view/vehicle-update.php';
      exit;
    }
    break;
  case 'del':
    $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
    $invInfo = getInvItemInfo($invId);
    if (count($invInfo) < 1) {
      $message = 'Sorry, no vehicle information could be found.';
    }
    include '../view/vehicle-delete.php';
    exit;
    break;

  case 'deleteVehicle':
    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

    $deleteResult = deleteVehicle($invId);
    if ($deleteResult) {
      $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    } else {
      $message = "<p class='notice'>Error: $invMake $invModel was not
          deleted.</p>";
      $_SESSION['message'] = $message;
      header('location: /phpmotors/vehicles/');
      exit;
    }
    break;
    case 'classification':
      $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $vehicles = getVehiclesByClassification($classificationName);
      if(!count($vehicles)){
       $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
      } else {
       $vehicleDisplay = buildVehiclesDisplay($vehicles);
      }
  
      include '../view/classification.php';
      break;
      case 'single-vehicle':
        
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $vehicle = getVehicleById($invId);
        $thumbImages =  getVehicleImagesById($invId); 
        $invMake = $vehicle['invMake'] . " " .$vehicle['invModel'];
        if(!count($vehicle)){
         $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
        $vehicleDisplay = buildVehicleDisplay($vehicle);
        
        $extraImages = buildExtraImagesDisplay($thumbImages);
       
      
      }
    
        include '../view/single-vehicle.php';
        break;
}
