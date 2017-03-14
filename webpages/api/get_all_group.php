<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 11/03/2017
 * Time: 14:14
 */

session_start();

// First need to include database connection which is in the functions folder
// this php only create the group with

require_once '../../corePHP/functions.php';

if(isset($_POST['page_ready'])) {
    $con = connectToDatabase();
    $userID = $_SESSION['User_id'];
    $sql1 = "SELECT Group_ID FROM grouprelation WHERE User_ID =" . $userID;

    // Run the query / this is equivalent to result
    $grouplist = $con->query($sql1);
    // get the number of groupss
    $numberOfGroups = mysqli_num_rows($grouplist);


    if ($numberOfGroups > 0) {

        // List of group_IDs need to be stored in an array
        $groupIDs = [];

        while ($row = $grouplist->fetch_assoc()) {
            $groupIDs[] = $row['Group_ID'];
        }
        // get all group id out in array

        $sql2 = "SELECT Group_ID, Group_name FROM friendgroup WHERE Group_ID IN (" . implode($groupIDs, ",") . ")";
        $result = $con->query($sql2);
        $numberOfGPs = mysqli_num_rows($result);
        if ($numberOfGPs > 0) {

            // First echo out a table

            echo '<table style="width:100%">';

            while ($row = mysqli_fetch_assoc($result)) {


                // We need to print out both the first name, last name and a button.
                echo "<tr><td style='height:50px' rel='" . $row['Group_ID'] . "'>" . $row['Group_name'] . " <button rel='" . $row['Group_ID'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right click_to_chat \">Click to chat</button></td></tr>";

                //Now that all the friends have been printed, show the non friends if there is space
            }

        }


    } else {
        echo "<tr><td>Please Join a group or create one to start chat</td></tr>";
    };
};
