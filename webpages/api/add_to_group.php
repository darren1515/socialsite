<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 10/03/2017
 * Time: 13:15
 */

session_start();

// First need to include database connection which is in the functions folder
// this php only create the group with

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript

    $groupid = $_POST['group'];
    $id = $_POST['member'];
    // start connection
    $con = connectToDatabase();
    $userID = $_SESSION['User_id'];

    $sql = "INSERT INTO grouprelation (Group_ID, User_ID)
VALUES ('$groupid', '$id')";
    $result = $con->query($sql);
    echo "$result";

    $con->close();


