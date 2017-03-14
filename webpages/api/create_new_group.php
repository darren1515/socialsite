<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 07/03/2017
 * Time: 16:34
 */
session_start();

// First need to include database connection which is in the functions folder
// this php only create the group with

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['create_new_group'])){

    $group_nm = $_POST['create_new_group'];
    $con = connectToDatabase();
    $userID = $_SESSION['User_id'];
    $sql = "INSERT INTO friendgroup (Group_name, User_ID)
VALUES ('$group_nm', '$userID')";


    if ($con->query($sql) === TRUE) {

        $last_groupid = $con->insert_id;

        // get the last groupid
        // define global groupid
        //echo "A new group is created!!!";

        // once the group is created
        // add this groupid and userid to group_relation table
        $sql2 = "INSERT INTO grouprelation (Group_ID, User_ID)
VALUES ('$last_groupid', '$userID')";
        $result = $con->query($sql2);
        echo "$last_groupid";

    } else {
        echo "lolllll";
    }

    // close connection
    $con->close();

};