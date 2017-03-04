<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 03/03/2017
 * Time: 23:11
 * This php file is for the friends search bar in the navigation.
 *Jquery will send what the user has inputed to this file.
 * Aim: The output of the search results will be limited to 8 records.
 * Friends will shown first and if there are not 8 then the remaining slots
 * will be filled with non-friends
 *
 *
 * Logic
 *
 * First show friends put a view profile button
 * If (number_of_friends < 8) then get non friends (have a add friend button)
 * To do this search users and use the previous userID's of friends (NOT IN ARRAY)
 */


session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['friend_search'])){


    // Set a maximum for the number of results that can be displayed by the live search
    // at any given time.

    $upperLimit = 5;


    $con = connectToDatabase();

    // first clean the string, i.e protect from sql injection.

    $friendText = filter_var($_POST['friend_search'], FILTER_SANITIZE_STRING);

    $userID = $_SESSION['User_id'];


    // Combine the first_name and last_name and use *friendtext* wildcard.
    // First search for existing friends also store the ID's in an array

    $sql  = "SELECT Friend_ID, First_name, Last_name FROM (SELECT User_id2 AS Friend_ID, First_name, Last_name FROM friends INNER JOIN users ON friends.User_id2=users.User_id WHERE friends.User_id1 = " .
 $userID . " AND friendStatus = 1 UNION SELECT User_id1 AS Friend_ID, First_name, Last_name FROM friends INNER JOIN users ON friends.User_id1=users.User_id WHERE friends.User_id2 = " . $userID . " AND friendStatus = 1) temp WHERE CONCAT(First_name, ' ', Last_name) LIKE ". "'%$friendText%' LIMIT " .$upperLimit;




    $result = mysqli_query($con,$sql);
    if (!$result) {
        die(mysqli_error($con));
    }

    $numberOfFriends = mysqli_num_rows($result);
    $amountOfFreeSpace = $upperLimit - $numberOfFriends;
    $arrayIDs = [];
    if ($numberOfFriends > 0) {

        // First echo out a table

        echo '<table style="width:100%">';

        while($row = mysqli_fetch_assoc($result)) {

            $arrayIDs[] = $row['Friend_ID'];

            // We need to print out both the first name, last name and a button.
            echo "<tr><td style='height:50px' rel='" . $row['Friend_ID'] . "'>" . $row['First_name'] . " " . $row['Last_name'] . " <button rel='" . $row['Friend_ID'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-primary pull-right\">View Profile</button></td></tr>";

            //Now that all the friends have been printed, show the non friends if there is space
        }
        if($amountOfFreeSpace>0){
            // We now need to see if there are any users who are not friends. First select all the users that are not friends then filter based on the user
            // inputed text
            $sql = $sql = "SELECT User_id,First_name,Last_name FROM users WHERE User_id NOT IN ( '" . implode($arrayIDs, "', '") . "' )" . " AND CONCAT(First_name, ' ', Last_name) LIKE ". "'%$friendText%' LIMIT " .$amountOfFreeSpace;
            $result = mysqli_query($con,$sql);
            if (!$result) {
                die(mysqli_error($con));
            }
            while($row = mysqli_fetch_assoc($result)) {



                // We need to print out both the first name, last name and a button.
                echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'>" . $row['First_name'] . " " . $row['Last_name'] . " <button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right\">Add</button></td></tr>";

                //Now that all the friends have been printed, show the non friends if there is space
            }

        }


    } else {
        echo "<tr><td>no users found</td></tr>";
    }
}

?>

<script>
    $(".testing").click(function(){
        console.log('you clicked me');
    });
</script>


