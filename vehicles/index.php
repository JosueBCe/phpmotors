<?php 

// This is the "Accounts Controller" for the site.

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
// Get the accounts model

// Starts session of Registrating 
session_start();
// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = '<ul class="nav-list">';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
 $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

$classificationsIdAndClassification = getIdAndClassification();
$classificationOptions  = '<label for="classification">Choose a Option:</label>
<select name="classificationId" id="classification">
<option value="" disabled selected>Choose One Classification</option>';

$classificationsIdAndClassification = getIdAndClassification();



foreach ($classificationsIdAndClassification as $classification) {
  $classificationOptions  .= "<option value=$classification[classificationId]>$classification[classificationName]</option>";
 }
$classificationOptions .= '</select>';


$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 } 


switch ($action){
 
  default:
  include '../view/vehicle-mang.php';
  break;
  case 'add-classification':
  include '../view/add-classification.php';
  break;
  case 'add-vehicle':
  include '../view/add-vehicle.php';
  break;
    

  
// Registering Vehicle 
case 'register-vehicle':
  
  $invMake = filter_input(INPUT_POST, 'invMake');
  $invModel = filter_input(INPUT_POST, 'invModel');
  $invDescription = filter_input(INPUT_POST, 'invDescription');
  $invImage = filter_input(INPUT_POST, 'invImage');
  $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
  $invPrice = filter_input(INPUT_POST, 'invPrice');
  $invStock = filter_input(INPUT_POST, 'invStock');
  $invColor = filter_input(INPUT_POST, 'invColor');
  $classificationId = filter_input(INPUT_POST,  'classificationId');
  // Check for missing data
  if(empty($invMake) || empty($invModel) || empty($invDescription) || 
     empty($invImage) || empty($invThumbnail) || empty($invPrice) || 
     empty($invStock) || empty($invColor) || empty($classificationId) ){
    $message = '<p>Please provide all the required information to register a new vehicle.</p>';
    include '../view/add-vehicle.php';
    exit;
  }

  // Send the data to the model
  $regOutcomeVehicles = regVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

  //Check and report the result
  if($regOutcomeVehicles === 1){
    //$message = "<p>Thanks for registering the vehicle. You'll see it in the vehicle management page.</p>";
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
    $message = "<p>Sorry, but the vehicle registration failed. Please try again.</p>";
    include '../view/add-vehicle.php';
    exit;
  }
  break;
}


