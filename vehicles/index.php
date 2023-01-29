<?php 

// This is the "Accounts Controller" for the site.

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model


// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = '<ul class="nav-list">';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
 $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

// $clientFirstname = filter_input(INPUT_POST, 'clientFirstname');

$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 } 
 switch ($action){
  case 'add-classification.php':
  include '../view/add-classification.php';
  break;
  default:
  include '../view/add-classification.php';
  break;


//   case 'login':
//   include '../view/login.php';
//   break;
//   case 'registration':
//   include '../view/registration.php';
//   break;
//   case 'register':
// // Filter and store the data
  
$classificationName = filter_input(INPUT_POST, 'classificationName');
//   $clientLastname = filter_input(INPUT_POST, 'clientLastname');
//   $clientEmail = filter_input(INPUT_POST, 'clientEmail');
//   $clientPassword = filter_input(INPUT_POST, 'clientPassword');

// Check for missing data
if(empty($classificationName) ){
    $message = '<p>Please provide information for all empty form fields.</p>';
    include '../view/add-classification.php';
    exit;
}

// Send the data to the model
$regOutcome = regClassification($classificationName);

 //Check and report the result
 if($regOutcome === 1){
   $message = "<p>Thanks for registering $classificationName. You'll see in the NavBar the new Classification.</p>";
   include '../view/add-classification.php';
   exit;
 } else {
   $message = "<p>Sorry $classificationName, but the Classification registration failed. Please try again.</p>";
   include '../view/add-classification.php';
   exit;
 }
 break;
}
  // default:
  // include '/view/home.php';
  // break;

