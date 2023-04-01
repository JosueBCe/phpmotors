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



function getReviewsById($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT r.reviewId, r.reviewDate, r.reviewText, r.clientId, c.clientFirstname, c.clientLastname 
            FROM reviews r 
            INNER JOIN clients c ON r.clientId = c.clientId 
            WHERE r.invId = :invId 
            ORDER BY r.reviewId DESC';
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

?>