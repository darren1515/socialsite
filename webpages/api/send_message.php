<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 13/03/2017
 * Time: 18:14
 */

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript

$groupid = $_POST['group_id'];
$message = $_POST['message'];
$userID = $_SESSION['User_id'];

// connect to data base first
$con = connectToDatabase();
$sql = "INSERT INTO chat (Group_ID, User_ID, Message)
VALUES ('$groupid', '$userID', '$message')";
$result = $con->query($sql);

// get the groupchat

$sql2 = "SELECT Chat_ID, Message, Send_TIME, First_name, Last_name FROM chat INNER JOIN users ON users.User_id = chat.User_ID WHERE Group_ID =". $groupid;

$groupmessage = $con->query($sql2);
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




