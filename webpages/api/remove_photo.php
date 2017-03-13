<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 12/03/2017
 * Time: 19:46
 */

require_once '../../corePHP/functions.php';

// Include the Blogpost object

require_once '../objects/Photos.php';

if($_POST){
    $connection = connectToDatabase();

// Create an instance of the Blogpost class so that we
// can use the readAll method.
    $photoLoc = filter_var($_POST['photoLoc'], FILTER_SANITIZE_STRING);
    $photosObject = new Photos($connection);

    $photosObject->userID = $_SESSION['User_id'];
// Read all blogposts

    $results = $photosObject->removePhoto($photoLoc);
//Output in json format

    // Close the connection

    mysqli_close($connection);


    echo $results;
}