<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 01/03/2017
 * Time: 23:22
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Include the Blogpost object

require_once '../objects/Blogpost.php';

if($_POST){
    $connection = connectToDatabase();

// Create an instance of the Blogpost class so that we
// can use the readAll method.
    $postID = filter_var($_POST['postID'], FILTER_VALIDATE_INT);
    $newText = filter_var($_POST['newText'], FILTER_SANITIZE_STRING);

    $blogObject = new Blogpost($connection);

    $blogObject->userID = $_SESSION['User_id'];
// Read all blogposts

    $results = $blogObject->updatePost($postID,$newText);
//Output in json format

    echo $results;
}
