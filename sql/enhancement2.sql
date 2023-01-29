/* Create a  new  client called Tony Stark  */

INSERT INTO clients (clientFirstname, clientLastname, clientEmail,clientPassword, comment)
VALUES ("Tony", "Stark", "tony@starkent.com", "Iam1ronM@n", "I am the real Ironman");

/*  Update client level to 3 */
UPDATE clients
SET clientLevel = 3

/*  Replacing the invDescription of the GM Hummer*/
UPDATE inventory
SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior')
WHERE invModel LIKE 'Hummer';

/* Using an inner join to select the invModel field from the inventory table and the classificationName field from the carclassification table for inventory items that belong to the "SUV" category. */

SELECT inventory.invModel, carclassification.classificationName
FROM inventory
INNER JOIN carclassification ON inventory.classificationID = carclassification.classificationID
WHERE carclassification.classificationName = 'SUV';

/* Deleting Jeep Wrangler*/

DELETE FROM inventory
WHERE
    invModel = 'Wrangler';

/* Update all records in the Inventory table to add "/phpmotors" to the beginning of the file path in the invImage and invThumbnail columns using a single query */
UPDATE inventory
SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail)
