<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 14/03/2017
 * Time: 15:14
 */

session_start();

// First need to include database connection which is in the functions folder
// this php only create the group with

require_once '../../corePHP/functions.php';

if(isset($_POST['group'])){
    $groupdi = $_POST['group'];
    $con = connectToDatabase();
    $sql = "DELETE FROM friendgroup
WHERE Group_ID =" . $groupdi;
    $result = $con->query($sql);
    $sql3 = "DELETE FROM grouprelation
WHERE Group_ID =" . $groupdi;
    $result3 = $con->query($sql3);


    $userID = $_SESSION['User_id'];
    $sql2 = "SELECT Group_name, Group_ID FROM friendgroup WHERE User_ID =" . $userID;
    $result2 = $con->query($sql2);

    echo '<table style="width:100%">';

    while ($row = mysqli_fetch_assoc($result2)) {


        // We need to print out both the first name, last name and a button.
        echo "<tr><td style='height:50px' rel='" . $row['Group_ID'] . "'>" . $row['Group_name'] . " <button rel='" . $row['Group_ID'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right Delete_the_group \">Click to Delete</button></td></tr>";

        //Now that all the friends have been printed, show the non friends if there is space
    }


}