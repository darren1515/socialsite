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

    /*
     *
     * SELECT Stranger_id, COUNT(MutualFriend_id) AS TotalMutualFriends FROM (SELECT CASE WHEN r1.User_id2 = r2.Friend_id THEN r1.User_id1 ELSE r1.User_id2 END AS Stranger_id, CASE WHEN r1.User_id1 = r2.Friend_id THEN r1.User_id1 ELSE r1.User_id2 END AS MutualFriend_id FROM (SELECT CASE WHEN User_id1 = 25 THEN User_id2 ELSE User_id1 END AS Friend_id FROM friends WHERE User_id1 = 25 OR User_id2 = 25) AS r2 INNER JOIN friends r1 ON (User_id1 != 25 AND User_id2 = r2.Friend_id) OR (User_id1 = r2.Friend_id AND User_id2 != 25) ) AS totals GROUP BY Stranger_id ORDER BY TotalMutualFriends DESC LIMIT 5
     *
     */

    // We first look for friends, need to also pull the privacysettings.
    // If the friend is set to private i.e 1 show no buttons else show a button with view profile.

    // 09/03/16 Also pull in the friendStatus

    $sql  = "SELECT Friend_ID, First_name, Last_name, privacysetting,friendStatus FROM (SELECT User_id2 AS Friend_ID, First_name, Last_name,privacysetting,friendStatus FROM friends INNER JOIN users ON friends.User_id2=users.User_id WHERE friends.User_id1 = " .
 $userID . " UNION SELECT User_id1 AS Friend_ID, First_name, Last_name,privacysetting,friendStatus FROM friends INNER JOIN users ON friends.User_id1=users.User_id WHERE friends.User_id2 = " . $userID . ") temp WHERE CONCAT(First_name, ' ', Last_name) LIKE ". "'%$friendText%' LIMIT " .$upperLimit;




    $result = mysqli_query($con,$sql);
    if (!$result) {
        die(mysqli_error($con));
    }

    $numberOfFriends = mysqli_num_rows($result);
    $amountOfFreeSpace = $upperLimit - $numberOfFriends;
    $confirmedFriendIDs = [];
    $pendingFriendIDs = [];

    // Always print the table

    echo '<table class="table table-hover" style="width:100%">';
    echo '<tbody>';

    // If numberOfFriends that mach our search is greater than print these first
    if ($numberOfFriends > 0) {

        // In this block we are only dealing with friends.


        while($row = mysqli_fetch_assoc($result)) {

            // Keep in mind we only want to count friends.


            if($row['friendStatus']==1){

                $confirmedFriendIDs[] = $row['Friend_ID'];
                $privacysettings = $row['privacysetting'];

                if($privacysettings == 1){

                    // Images ../vendor/fineuploader/php-traditional-server/files/' + imageLoc

                    echo "<tr><td style='height:50px' rel='" . $row['Friend_ID'] . "'><img width='40' height='40' style='margin-right:10px;' class='img-rounded'>" . $row['First_name'] . " " . $row['Last_name'] . "</td></tr>";

                } else {

                    // We need to print out both the first name, last name and a button.
                    echo "<tr><td style='height:50px' rel='" . $row['Friend_ID'] . "'><img width='40' height='40' style='margin-right:10px;' class='img-rounded'>" . $row['First_name'] . " " . $row['Last_name'] . " <button rel='" . $row['Friend_ID'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-primary pull-right\">View</button></td></tr>";

                }


            } else {
                $pendingFriendIDs[] = $row['Friend_ID'];

            }





            //Now that all the friends have been printed, show the non friends if there is space
        }

    }



    // We need to grab all the mutual friends of our logged in user

    $sql = "SELECT Stranger_id, COUNT(MutualFriend_id) AS TotalMutualFriends FROM (SELECT CASE WHEN r1.User_id2 = r2.Friend_id THEN r1.User_id1 ELSE r1.User_id2 END AS Stranger_id, CASE WHEN r1.User_id1 = r2.Friend_id THEN r1.User_id1 ELSE r1.User_id2 END AS MutualFriend_id FROM (SELECT CASE WHEN User_id1 = $userID THEN User_id2 ELSE User_id1 END AS Friend_id FROM friends WHERE User_id1 = $userID OR User_id2 = $userID) AS r2 INNER JOIN friends r1 ON (User_id1 != $userID AND User_id2 = r2.Friend_id) OR (User_id1 = r2.Friend_id AND User_id2 != $userID) ) AS totals GROUP BY Stranger_id ORDER BY TotalMutualFriends DESC LIMIT 5";

    $mutualFriendsArray = [];

    $result = mysqli_query($con,$sql);

    while($row = mysqli_fetch_assoc($result)){

        $mutualFriendsArray[] = $row['Stranger_id'];
    }




    // Edited so that my own profile will not appear in the live search. 07/03/17
    // To the array push the current user sessionID

    array_push($confirmedFriendIDs,$_SESSION['User_id']);
    // If there is free space print then show non friends

    if($amountOfFreeSpace>0){
        // We now need to see if there are any users who are not friends. First select all the users that are not friends then filter based on the user
        // inputed text
        // For non friends we need to pull their privacy settings.

        $sql  = "SELECT User_id,First_name,Last_name, privacysetting FROM users WHERE User_id NOT IN ( '" . implode($confirmedFriendIDs, "', '") . "' )" . " AND CONCAT(First_name, ' ', Last_name) LIKE ". "'%$friendText%' LIMIT " .$amountOfFreeSpace;

        $result = mysqli_query($con,$sql);
        $numberOfNonFriends = mysqli_num_rows($result);




        if (!$result) {
            die(mysqli_error($con));
        }
        while($row = mysqli_fetch_assoc($result)) {


            // Now we need to correctly display the correct button depending on what setting the friend has.
            // If they are a mutual friend or they have their profile set to all then show view profile and add friend button.

            if(($row['privacysetting'] == 3 and in_array($row['User_id'],$mutualFriendsArray)) or $row['privacysetting'] == 4){


                // They are not friends but change add friend to request sent potentially

                if(in_array($row['User_id'],$pendingFriendIDs)){

                    // They are not friends but they should be able to add or view their profile.
                    echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'><img width='40' height='40' style='margin-right:10px;' class='img-rounded'>" . $row['First_name'] . " " . $row['Last_name'] . "<button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-primary pull-right\">View</button> <button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-default pull-right\">Request Sent</button></td></tr>";

                } else {

                    // They are not friends but they should be able to add or view their profile.
                    echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'><img width='40' height='40' style='margin-right:10px;' class='img-rounded'>" . $row['First_name'] . " " . $row['Last_name'] . "<button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-primary pull-right\">View</button> <button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right addfriend\">Add</button></td></tr>";

                }





            } else {

                if(in_array($row['User_id'],$pendingFriendIDs)){

                    echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'><img width='40' height='40' style='margin-right:10px;' class='img-rounded'>" . $row['First_name'] . " " . $row['Last_name'] . " <button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-default pull-right\">Request Sent</button></td></tr>";

                } else {

                    // They should not be able to view their profile however the add button should be there
                    // We need to print out both the first name, last name and a button.
                    echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'><img width='40' height='40' style='margin-right:10px;' class='img-rounded'>" . $row['First_name'] . " " . $row['Last_name'] . " <button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right addfriend\">Add</button></td></tr>";
                }
            }



        }

    }

    // If no one was found then say no users found

    if(($numberOfFriends + $numberOfNonFriends) == 0){
        echo "<tr><td>no users found</td></tr>";
    }

    // Close the connection

    mysqli_close($con);

    // We now need to close the table

    echo "</tbody></table>";



}

?>

<script>
    $(".testing").click(function(){
        console.log('you clicked me');
    });
</script>


