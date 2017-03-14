<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 13/03/2017
 * Time: 23:40
 */

session_start();

// First need to include database connection which is in the functions folder
// this php only create the group with

require_once '../../corePHP/functions.php';

if(isset($_POST['group_by_user'])){

    $con = connectToDatabase();
    $userID = $_SESSION['User_id'];
    $sql = "SELECT Group_name, Group_ID FROM friendgroup WHERE User_ID =" . $userID;
    $result = $con->query($sql);

    echo '<table style="width:100%">';

    while ($row = mysqli_fetch_assoc($result)) {


        // We need to print out both the first name, last name and a button.
        echo "<tr><td style='height:50px' rel='" . $row['Group_ID'] . "'>" . $row['Group_name'] . " <button rel='" . $row['Group_ID'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right Delete_the_group \">Click to Delete</button></td></tr>";

        //Now that all the friends have been printed, show the non friends if there is space
    }






};