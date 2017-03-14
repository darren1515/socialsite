<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 13/03/2017
 * Time: 23:29
 * Will send a post request from react that contains the
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Include the Blogpost object

require_once '../objects/Comments.php';


if($_POST){

    $connection = connectToDatabase();

    // Create a new comment object

    $commentObject = new Comments($connection);


    // Read post variables sent from react, we also need the userid of the person logged in.
    $userInputtedText = filter_var($_POST['userInputtedText'], FILTER_SANITIZE_STRING);
    $photoID = filter_var($_POST['photoID'], FILTER_VALIDATE_INT);

    //We now need to pass it through to our commentObject

    $commentObject->userID = $_SESSION['User_id'];
    $commentObject->photoID = $photoID;


// Read all blogposts

    $results = $commentObject->addComment($userInputtedText);


    mysqli_close($connection);

    echo $results;


}

