<?php
/* Proxy connection to the phpmotors database */

function phpmotorsConnect()
{
    $server = 'localhost';
    $dbname = 'phpmotors';
    $username = 'iClient';
    $password = "K7CeUvdFunFHL[-x";
    $dsn = "mysql:host=$server;dbname=$dbname";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try{
        $link = new PDO($dsn, $username, $password, $options);
        return $link;
    } catch(PDOException $e){
        header('Location: /view/500.php');
        exit;
    }
}

?>