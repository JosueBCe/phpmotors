<?php
function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
   }

// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
function checkPassword($clientPassword){
 $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
 return preg_match($pattern, $clientPassword);
}


function navBar($carclassifications){
// Build a navigation bar using the $classifications array
$nav = '<div class="nav-list" id="nav-bar">';
$nav .= "<a href='/phpmotors/' title='View the PHP Motors home page'>Home</a>";
foreach ($carclassifications as $classification) {
  $nav .= "<a href='/phpmotors/vehicles/?action=classification&classificationName="
  .urlencode($classification['classificationName']).
  "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a>";
}
$nav .= " <a class='icon' onclick='displayNav()'>
<img src='/phpmotors/images/nav-icon.png' alt='icon'>
</a>
</div>";
return $nav;
}

function buildClassificationList($classifications){ 
  $classificationList = ' <br/>
  <label for="classificationList">Choose a classification to see those vehicles</label> <br/> <br/>
  <select name="classificationId" id="classificationList">'; 
  $classificationList .= "<option>Choose a Classification</option>"; 
  foreach ($classifications as $classification) { 
  $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
  } 
  $classificationList .= '</select>'; 
  return $classificationList; 
 }
 


 function buildVehiclesDisplay($vehicles){
  $dv = '<ul id="inv-display">';
  foreach ($vehicles as $vehicle) {
   $dv .= '<li>';
   $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
   $dv .= '<hr>';
   $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
   $dv .= "<span>$vehicle[invPrice]</span>";
   $dv .= '</li>';
  }
  $dv .= '</ul>';
  return $dv;
 }
?>