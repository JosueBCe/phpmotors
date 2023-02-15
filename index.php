<?php 

// This is the main controller for the site.

// This is the main controller for the site.

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
require_once 'library/functions.php';



// Get the array of classifications
$carclassifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = navBar($carclassifications);


$action = filter_input(INPUT_POST, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_GET, 'action');
 } 

 switch ($action){
 case 'template':
  include './view/template.php';
  break;
  case 'login':
  include './view/login.php';
  break;
  case '500':
    include './view/500.php';
    break;
    

 default:
  include './view/home.php';
  break;
}





?>