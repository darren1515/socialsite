<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 12/03/2017
 * Time: 19:28
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['group_information'])) {

    $groupid = $_POST['group_information'];
    $con = connectToDatabase();
    $userID = $_SESSION['User_id'];
    //write sql query to get message out of the table

    $sql = "SELECT Message_ID, Message, Send_TIME, First_name, Last_name FROM chat INNER JOIN users ON users.User_id = chat.User_ID WHERE Group_ID = $groupid ORDER BY Message_ID ASC";

    $groupmessage = $con->query($sql);
    $numberOfMessages = mysqli_num_rows($groupmessage);
    if ($numberOfMessages > 0) {

        // First echo out a table

        echo '<table style="width:100%">';

        while($row = mysqli_fetch_assoc($groupmessage)) {

            //$array_Chat_IDs[] = $row['Chat_ID'];

            // We need to print out both the first name, last name and a button.
            echo "<tr><td style='height:50px'> " . $row['First_name'] . " " . $row['Last_name'] . "</td> <td style='height:50px'> " . $row['Message'] . "</td> <td style='height:50px'>" . $row['Send_TIME'] . " </td></tr>";
        }


    } else {
        echo "<tr><td>There is no message in this group yet</td></tr>";
    }

    $con->close();

};









