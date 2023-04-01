<?php


// Get information for all vehicles
function getReviews()
{
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, reviewId, reviewText, reviewDate, clientId FROM reviews ORDER BY reviewDate ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}





// Register a new Client


/* 
function addReview($reviewText, $reviewDate, $clientId, $invId)
{
// Create a connection object using the phpmotors connection function
$db = phpmotorsConnect();
// The SQL statement
$sql = 'INSERT INTO reviews (reviewText, reviewDate, clientId, invId)
VALUES (:reviewText, :reviewDate, :clientId, :invId)';
// Create the prepared statement using the phpmotors connection
$stmt = $db->prepare($sql);
// Bind the values to the parameters in the SQL statement
$stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
$stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_INT);
$stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
// Insert the data
$stmt->execute();
// Ask how many rows changed as a result of our insert
$rowsChanged = $stmt->rowCount();
// Close the database interaction
$stmt->closeCursor();
// Return the indication of success (rows changed)
return $rowsChanged;
}
*/

function addReview($reviewText, $reviewDate, $clientId, $invId)
{
    // Convert the review date to a Unix timestamp
    $reviewTimestamp = strtotime($reviewDate);
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO reviews (reviewText, reviewDate, clientId, invId)
            VALUES (:reviewText, FROM_UNIXTIME(:reviewTimestamp), :clientId, :invId)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Bind the values to the parameters in the SQL statement
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewTimestamp', $reviewTimestamp, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}



function getReviewsById($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT r.reviewId, r.reviewDate, r.reviewText, r.clientId, c.clientFirstname, c.clientLastname 
            FROM reviews r 
            INNER JOIN clients c ON r.clientId = c.clientId 
            WHERE r.invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
}

function getClientReviews($clientId) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT reviews.reviewDate, inventory.invMake, inventory.invModel, reviews.invId, reviews.reviewId, reviews.reviewText
            FROM reviews
            INNER JOIN inventory ON reviews.invId = inventory.invId
            WHERE reviews.clientId = :clientId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Bind the values to the parameters in the SQL statement
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    // Execute the query
    $stmt->execute();
    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Close the database interaction
    $stmt->closeCursor();
    // Return the results
    return $results;
  }


  function getReviewAndInventoryInfo($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT r.reviewId, r.reviewDate, r.reviewText, i.invModel, i.invMake 
            FROM reviews r 
            INNER JOIN inventory i ON r.invId = i.invId
            WHERE r.reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
}



function updateReviewText($reviewText, $reviewId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


function deleteReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
/* function getInventoryByClassification($classificationId)
{
$db = phpmotorsConnect();
$sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
$stmt->execute();
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
return $inventory;
}
// Get vehicle information by invId
function getInvItemInfo($invId)
{
$db = phpmotorsConnect();
$sql = 'SELECT * FROM inventory WHERE invId = :invId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
$stmt->execute();
$invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
return $invInfo;
}
// Update a vehicle
function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor,
$classificationId, $invId) {
$db = phpmotorsConnect();
$sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
$stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
$stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
$stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
$stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
$stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
$stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
$stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
$stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
$stmt->execute();
$rowsChanged = $stmt->rowCount();
$stmt->closeCursor();
return $rowsChanged;
}
function deleteVehicle($invId) {
$db = phpmotorsConnect();
$sql = 'DELETE FROM inventory WHERE invId = :invId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
$stmt->execute();
$rowsChanged = $stmt->rowCount();
$stmt->closeCursor();
return $rowsChanged;
}
// USE A SUBQUERY TO GET THE CLASSIFICATION BY NAME AND NOT BUT THE DEFAULT THAT IS AN ID.
// function getVehiclesByClassification($classificationName){
//     $db = phpmotorsConnect();
//     $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
//     $stmt = $db->prepare($sql);
//     $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
//     $stmt->execute();
//     $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $stmt->closeCursor();
//     return $vehicles;
//    }
function getVehiclesByClassification($classificationName){
$db = phpmotorsConnect();
$sql = 'SELECT inv.*, img.imgPath 
FROM inventory AS inv 
JOIN images AS img ON inv.invId = img.invId 
WHERE inv.classificationId IN (SELECT classificationId 
FROM carclassification 
WHERE classificationName = :classificationName) 
AND img.imgPath LIKE "%-tn%" 
AND img.imgPrimary = 1';
$stmt = $db->prepare($sql);
$stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
return $vehicles;
}
function getVehicleById($invId){
$db = phpmotorsConnect();
$sql = 'SELECT inv.*, img.imgPath 
FROM inventory AS inv 
JOIN images AS img ON inv.invId = img.invId 
WHERE inv.invId = :invId 
AND img.imgPrimary = 1';
$stmt = $db->prepare($sql);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
$stmt->execute();
$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
return $vehicle;
}
// Get information for all vehicles
function getVehicles(){
$db = phpmotorsConnect();
$sql = 'SELECT invId, invMake, invModel FROM inventory';
$stmt = $db->prepare($sql);
$stmt->execute();
$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
return $invInfo;
}
function getVehicleImagesById($invId){
$db = phpmotorsConnect();
$sql = 'SELECT inv.invMake, inv.invModel, img.imgPath 
FROM inventory AS inv
JOIN images AS img ON inv.invId = img.invId 
WHERE inv.invId = :invId 
AND img.imgPath LIKE "%-tn%"';
$stmt = $db->prepare($sql);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();
return $images;
} */

?>