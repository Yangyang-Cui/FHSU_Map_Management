<?php
date_default_timezone_set('America/Chicago');
$dbn = 'mysql:host=localhost; dbname=map';
$username = 'root';
$password = '';

try {
    // create an instance of the PDO class with the required parameters
    $db = new PDO($dbn , $username, $password);

    // set pdo error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // display success message
    // echo "Connected to the register database. ";
} catch (PDOException $ex) {
    // display error message
    echo "Connection failed. " . $ex->getMessage();
}



