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

$connection = connectToDatabase();

// Create an instance of the Blogpost class so that we
// can use the readAll method.



$blogObject = new Blogpost($connection);

$blogObject->userID = $_SESSION['User_id'];
// Read all blogposts

$results = $blogObject->createPost();

//Output in json format

echo $results;