<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 01/03/2017
 * Time: 19:30
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Include the Blogpost object

require_once '../objects/Blogpost.php';

if($_GET){

    $connection = connectToDatabase();

// Create an instance of the Blogpost class so that we
// can use the readAll method.

    $blogObject = new Blogpost($connection);
    $blogObject->userID = filter_var($_GET['profilePageID'], FILTER_VALIDATE_INT);
// Read all blogposts

    $results = $blogObject->readAll();

//Output in json format

// Close the connection

    mysqli_close($connection);

    echo $results;
}

