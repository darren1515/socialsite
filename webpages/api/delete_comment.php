<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 14/03/2017
 * Time: 00:28
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


    // Capture the ID of the comment to be deleted.
    $commentID = filter_var($_POST['commentID'], FILTER_VALIDATE_INT);



// Read all blogposts

    $results = $commentObject->deleteComment($commentID);


    mysqli_close($connection);

    echo $results;


}