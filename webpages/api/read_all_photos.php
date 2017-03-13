<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 12/03/2017
 * Time: 19:35
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Include the Blogpost object

require_once '../objects/Photos.php';

$connection = connectToDatabase();

// Create an instance of the Blogpost class so that we
// can use the readAll method.

$photosObject = new Photos($connection);

$photosObject->userID = $_SESSION['User_id'];
// Read all blogposts

$results = $photosObject->readAll();

//Output in json format

// Close the connection

mysqli_close($connection);

echo $results;