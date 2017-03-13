<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 13/03/2017
 * Time: 01:57
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Include the Blogpost object

require_once '../objects/Comments.php';

$connection = connectToDatabase();

// Create an instance of the Blogpost class so that we
// can use the readAll method.

$commentsObject = new Comments($connection);

$commentsObject->photoID = $_POST['photoID'];
// Read all blogposts

$results = $commentsObject->readAll();

//Output in json format

// Close the connection

mysqli_close($connection);

echo $results;