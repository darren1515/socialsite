<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 08/03/2017
 * Time: 21:48
 * This script will add the file path to a users profile photo in the users table in the database
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

if(isset($_POST['imageLoc'])){


    // Update the profilephoto field in the users table.
    $con = connectToDatabase();

    // first clean the string, i.e protect from sql injection.


    $userID = $_SESSION['User_id'];

    $sql = "UPDATE users SET profilephoto='" .$_POST['imageLoc'] ."' WHERE User_id = $userID";

    $result = mysqli_query($con,$sql);


}

// Need something to return the new profile photo link.

if(isset($_POST['getprofilepic']) or isset($_GET)){

    echo grabUserProfilePicture();


}

// Need something to trigger removeal in the users table

if(isset($_POST['removeprofilepic'])){

    echo removeUserProfilePicture();

}

