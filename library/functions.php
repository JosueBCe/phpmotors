<?php
function checkEmail($clientEmail)
{
  $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
  return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword)
{
  $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
  return preg_match($pattern, $clientPassword);
}


function navBar($carclassifications)
{
  // Build a navigation bar using the $classifications array
  $nav = '<div class="nav-list" id="nav-bar">';
  foreach ($carclassifications as $classification) {
    $nav .= "<a href='/phpmotors/vehicles/?action=classification&classificationName="
      . urlencode($classification['classificationName']) .
      "' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a>";
  }
  $nav .= " <a class='icon' onclick='displayNav()'>
<img src='/phpmotors/images/nav-icon.png' alt='icon'>
</a>
</div>";
  return $nav;
}

function buildClassificationList($classifications)
{
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



function buildVehiclesDisplay($vehicles)
{
  $dv = '<ul id="inv-display">';
  foreach ($vehicles as $vehicle) {
    $dv .= '<li>';
    $dv .= "<a href='/phpmotors/vehicles/?action=single-vehicle&invId="
      . urlencode($vehicle['invId']) .
      "' title='View our $vehicle[invMake] $vehicle[invModel]'>";

    $dv .= "<img src='$vehicle[imgPath]' alt='$vehicle[invMake] $vehicle[invModel] picture of color $vehicle[invColor]'>";
    $dv .= '<hr>';
    $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
    $dv .= "<span>$" . number_format($vehicle['invPrice'], 2) . "</span>";
    $dv .= '</a>';
    $dv .= '</li>';
  }
  $dv .= '</ul>';
  return $dv;
}
function buildVehicleDisplay($vehicle)
{

  $dv = '<div class="vehicle-details">';
  $dv .= "<div class='sub-div-1'>";
  $dv .= "<img src='$vehicle[imgPath]' alt='$vehicle[invMake] $vehicle[invModel] picture of color $vehicle[invColor]'>";
  $dv .= "<p><strong>Price:</strong> $" . number_format($vehicle['invPrice'], 2) . "</p>";
  $dv .= '</div>';
  $dv .= "<div class='sub-div-2'>";
  $dv .= "<h2>$vehicle[invMake] $vehicle[invModel] </h2>";
  $dv .= "<p><strong>Description:</strong> $vehicle[invDescription]</p>";

  $dv .= "<p><strong>Stock:</strong> $vehicle[invStock]</p>";
  $dv .= '</div>';
  $dv .= '</div>';

  return $dv;
}


function buildExtraImagesDisplay($vehicleImages)
{

  $dv = "<ul  class='thumImages'>";
  foreach ($vehicleImages as $vehicle) {
    $dv .= "<li><img src='$vehicle[imgPath]' alt='$vehicle[invMake] $vehicle[invModel] picture'></li>";
  }
  $dv .= '</ul>';

  return $dv;
}




/* * ********************************
 *  Functions for working with images
 * ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image)
{
  $i = strrpos($image, '.');
  $image_name = substr($image, 0, $i);
  $ext = substr($image, $i);
  $image = $image_name . '-tn' . $ext;
  return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray)
{
  $id = '<ul id="image-display">';
  foreach ($imageArray as $image) {
    $id .= '<li>';
    $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt=' $image[invMake] $image[invModel] picture'>";
    $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
    $id .= '</li>';
  }
  $id .= '</ul>';
  return $id;
}


// Build the vehicles select list
function buildVehiclesSelect($vehicles)
{
  $prodList = '<select name="invId" id="invId">';
  $prodList .= "<option>Choose a Vehicle</option>";
  foreach ($vehicles as $vehicle) {
    $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
  }
  $prodList .= '</select>';
  return $prodList;
}



// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name)
{
  // Gets the paths, full and local directory
  global $image_dir, $image_dir_path;
  if (isset($_FILES[$name])) {
    // Gets the actual file name
    $filename = $_FILES[$name]['name'];
    if (empty($filename)) {
      return;
    }
    // Get the file from the temp folder on the server
    $source = $_FILES[$name]['tmp_name'];
    // Sets the new path - images folder in this directory
    $target = $image_dir_path . '/' . $filename;
    // Moves the file to the target folder
    move_uploaded_file($source, $target);
    // Send file for further processing
    processImage($image_dir_path, $filename);
    // Sets the path for the image for Database storage
    $filepath = $image_dir . '/' . $filename;
    // Returns the path where the file is stored
    return $filepath;
  }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename)
{
  // Set up the variables
  $dir = $dir . '/';

  // Set up the image path
  $image_path = $dir . $filename;

  // Set up the thumbnail image path
  $image_path_tn = $dir . makeThumbnailName($filename);

  // Create a thumbnail image that's a maximum of 200 pixels square
  resizeImage($image_path, $image_path_tn, 200, 200);

  // Resize original to a maximum of 500 pixels square
  resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{

  // Get image type
  $image_info = getimagesize($old_image_path);
  $image_type = $image_info[2];

  // Set up the function names
  switch ($image_type) {
    case IMAGETYPE_JPEG:
      $image_from_file = 'imagecreatefromjpeg';
      $image_to_file = 'imagejpeg';
      break;
    case IMAGETYPE_GIF:
      $image_from_file = 'imagecreatefromgif';
      $image_to_file = 'imagegif';
      break;
    case IMAGETYPE_PNG:
      $image_from_file = 'imagecreatefrompng';
      $image_to_file = 'imagepng';
      break;
    default:
      return;
  } // ends the swith

  // Get the old image and its height and width
  $old_image = $image_from_file($old_image_path);
  $old_width = imagesx($old_image);
  $old_height = imagesy($old_image);

  // Calculate height and width ratios
  $width_ratio = $old_width / $max_width;
  $height_ratio = $old_height / $max_height;

  // If image is larger than specified ratio, create the new image
  if ($width_ratio > 1 || $height_ratio > 1) {

    // Calculate height and width for the new image
    $ratio = max($width_ratio, $height_ratio);
    $new_height = round($old_height / $ratio);
    $new_width = round($old_width / $ratio);

    // Create the new image
    $new_image = imagecreatetruecolor($new_width, $new_height);

    // Set transparency according to image type
    if ($image_type == IMAGETYPE_GIF) {
      $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
      imagecolortransparent($new_image, $alpha);
    }

    if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
      imagealphablending($new_image, false);
      imagesavealpha($new_image, true);
    }

    // Copy old image to new image - this resizes the image
    $new_x = 0;
    $new_y = 0;
    $old_x = 0;
    $old_y = 0;
    imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

    // Write the new image to a new file
    $image_to_file($new_image, $new_image_path);
    // Free any memory associated with the new image
    imagedestroy($new_image);
  } else {
    // Write the old image to a new file
    $image_to_file($old_image, $new_image_path);
  }
  // Free any memory associated with the old image
  imagedestroy($old_image);
} // ends resizeImage function



/* REVIEWS FUNCTIONALITY */

function buildInventoryList($data)
{
  $inventoryDisplay = '<table>';
  // Set up the table labels
  $inventoryDisplay .= '<thead>';
  $inventoryDisplay .= '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
  $inventoryDisplay .= '</thead>';

  // Set up the table body
  $inventoryDisplay .= '<tbody>';
  // Iterate over all vehicles in the array and put each in a row
  foreach ($data as $vehicle) {
    $inventoryDisplay .= '<tr>';
    $inventoryDisplay .= '<td>' . $vehicle['invMake'] . ' ' . $vehicle['invModel'] . '</td>';
    $inventoryDisplay .= '<td><a href="/phpmotors/vehicles?action=mod&invId=' . $vehicle['invId'] . '" title="Click to modify">Modify</a></td>';
    $inventoryDisplay .= '<td><a href="/phpmotors/vehicles?action=del&invId=' . $vehicle['invId'] . '" title="Click to delete">Delete</a></td>';
    $inventoryDisplay .= '</tr>';
  }
  $inventoryDisplay .= '</tbody>';
  $inventoryDisplay .= '</table>';

  // Return the HTML embedded with the information
  return $inventoryDisplay;
}



function addReviewDisplays($vehicle)
{
  $firstNameInitial = substr($_SESSION['clientFirstname'], 0, 1);
  $lastName = ucfirst($_SESSION['clientLastname']);

  $html = "<h2>Review the $vehicle[invMake] $vehicle[invModel]</h2>";
  $html .= '<form action="/phpmotors/reviews/index.php" method="post">';
  $html .= '<label for="screenName">Screen Name <span class="required">*</span></label>';
  $html .= '<input type="text" name="screenName" id="screenName" required maxlength="30"';
  if (isset($firstNameInitial) && isset($lastName)) {
    $html .= " value='$firstNameInitial$lastName'";
  }
  $html .= ' readonly >';
  $html .= '<label for="reviewText">Review <span class="required">*</span></label>';
  $html .= '<textarea name="reviewText" id="reviewText" required></textarea>';
  $html .= '<br>';

  $html .= '<input class="sign-in-up-btn" type="submit" value="Submit Review">';
  $html .= "<input type='hidden' name='invId' value='$vehicle[invId]'>";
  $html .= "<input type='hidden' name='clientId' value='$_SESSION[clientId]'>";
  $html .= '<input type="hidden" name="action" value="add-review">';
  $html .= '</form>';

  return $html;
}



function buildReviewDisplay($vehicleReviews) {
  $html = "<ul>";
  foreach ($vehicleReviews as $review) {
    $clientInitial = strtoupper(substr($review['clientFirstname'], 0, 1));
    $clientLastname = ucfirst(strtolower($review['clientLastname']));
    $date = date('F j, Y', strtotime($review['reviewDate']));
    $html .= "<li><p><strong>$clientInitial$clientLastname </strong>Wrote on $date:</p>
    
    <div><p>  $review[reviewText]</p></div>
    
   </li>";
  }
  $html .= "</ul>";
  return $html;
}



function buildReviewList($data) {
  $inventoryDisplay = '<table>';
  // Set up the table labels
  $dataTable = '<thead>';
  $dataTable .= '<tr><th>Vehicle Name</th><td>&nbsp;</td><td>&nbsp;</td></tr>';
  $dataTable .= '</thead>';
  // Set up the table body
  $dataTable .= '<tbody>';
  // Iterate over all vehicles in the array and put each in a row
  foreach ($data as $element) {
    $reviewId = $element['reviewId'];
    $invMake = $element['invMake'];
    $invModel = $element['invModel'];
    $dates = date('F j, Y', strtotime($element['reviewDate']));
    $dataTable .= "<tr><td>{$invMake} {$invModel} (Reviewed on $dates)  </td>";
    $dataTable .= "<td><a href='/phpmotors/reviews?action=mod&reviewId={$reviewId}' title='Click to modify'>Modify</a></td>";
    $dataTable .= "<td><a href='/phpmotors/reviews?action=del&reviewId={$reviewId}' title='Click to delete'>Delete</a></td></tr>";
  }
  $dataTable .= '</tbody>';
  $inventoryDisplay .= $dataTable;
  $inventoryDisplay .= '</table>';
  // Display the contents in the Vehicle Management view
  return $inventoryDisplay;
}

