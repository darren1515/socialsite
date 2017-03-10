<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 09/03/2017
 * Time: 22:51
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';



if($_POST['friendID']){
    $con = connectToDatabase();


    $friendID = filter_var($_POST['friendID'], FILTER_VALIDATE_INT);


    $userID = $_SESSION['User_id'];


    // In User_id2 is the person who wants to be friends with User_id1

    $sql = "INSERT INTO friends (User_id1,User_id2) VALUES ($friendID,$userID)";

    mysqli_query($con,$sql);

    // Close the connection

    mysqli_close($con);




}