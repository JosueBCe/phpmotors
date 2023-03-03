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
$nav .= "<a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a>";
foreach ($carclassifications as $classification) {
  $nav .= "<a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a>";
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
 
?>