<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 12/03/2017
 * Time: 21:06
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['welcome_message'])){
    $groupid = $_POST['welcome_message'];
    $con = connectToDatabase();
    $userID = $_SESSION['User_id'];
    $sql = "INSERT INTO chat (Group_ID, User_ID, Message)
VALUES ('$groupid', '$userID', 'Welcome to chat')";
    $result = mysqli_query($con,$sql);

    echo "Access all groups in ChatRoom";

};