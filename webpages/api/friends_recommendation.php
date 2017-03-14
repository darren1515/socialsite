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
// Create connection
$conn = connectToDatabase();

$User_id = $_SESSION['User_id'];

// Grab the form data and remove whitespace
$age = trim($_POST['Age']);
$sports= trim($_POST['Sports']);
$movies = trim($_POST['Movies']);
$music = trim($_POST['Music']);

//check if the user has done the survey before
$sql = "SELECT * FROM attributes
WHERE User_id = $User_id;
;
";
$check = $conn->query($sql);
$row_cnt = $check->num_rows;

$insert_user_rating = "INSERT INTO attributes(User_id, Age, Sports, Movies, Music)
   VALUES($User_id , $age, $sports, $movies, $music);
			";

$update_user_rating = "UPDATE attributes
SET Age = $age, Sports = $sports, Movies = $movies, Music = $music
WHERE User_id = $User_id;
			";

if($row_cnt == 1) {
    $conn->query($update_user_rating);
} else {
    $conn->query($insert_user_rating);
}

$get_non_friend_rating = "SELECT User_id, Age, Sports, Movies, Music
FROM attributes
WHERE User_id NOT IN(
Select User_id1 as User_id from friends 
where User_id2 = $User_id
UNION
Select User_id2 as User_id from friends 
where User_id1 = $User_id
);
			";

//submit query
$result = $conn->query($get_non_friend_rating);

if ($result->num_rows > 0) {
    // calculate the difrrence between attributes vectors
    while($row = $result->fetch_assoc()) {
        $difference = ($age - $row["Age"])*($age - $row["Age"]) + ($sports - $row["Sports"])*($sports - $row["Sports"]) +($movies - $row["Movies"])*($movies - $row["Movies"]) + ($music - $row["Music"])*($music - $row["Music"]);
        $result1[$row["User_id"]] = $difference;
    }
}

unset($result1[$User_id]);// Removed my own User_id

//sql query to be passed to $conn/$connection object
$get_user_id_sql = "SELECT User_id, COUNT(MutualFriend_id) AS TotalMutualFriends 
FROM 
(SELECT 
CASE WHEN r1.User_id2 = r2.Friend_id THEN r1.User_id1 ELSE r1.User_id2 END AS User_id, 
CASE WHEN r1.User_id1 = r2.Friend_id THEN r1.User_id1 ELSE r1.User_id2 END AS MutualFriend_id 
FROM 
(SELECT 
CASE WHEN User_id1 = $User_id THEN User_id2 ELSE User_id1 END AS Friend_id 
FROM friends 
WHERE User_id1 = $User_id OR User_id2 = $User_id) AS r2 
INNER JOIN friends r1 
ON (User_id1 != $User_id AND User_id2 = r2.Friend_id) OR (User_id1 = r2.Friend_id AND User_id2 != $User_id) ) AS totals 
GROUP BY User_id
			";

//submit query
$result2 = $conn->query($get_user_id_sql);

if ($result2->num_rows > 0) {
    // decrease the distance based on the numbe rof mutual friends
    while($row = $result2->fetch_assoc()) {
        if (array_key_exists($row["User_id"], $result1)) {
            $result1[$row["User_id"]] = $result1[$row["User_id"]] / ($row["TotalMutualFriends"]+1);
        }
    }
}

ksort($result1);

$userIds = array_keys($result1);

$userIds = implode(",",$userIds);

$get_names_sql = "SELECT User_id, First_name, Last_name, privacysetting,profilephoto FROM users
            WHERE User_id in ($userIds)
            LIMIT 5;
			";
//submit query
$result3 = $conn->query($get_names_sql);


// Always print the table

echo '<table class="table table-hover" style="width:100%">';
echo '<tbody>';

if ($result3->num_rows > 0) {
    // output data of each row
    while($row = $result3->fetch_assoc()) {

        $urlOfFriend = "viewprofile.php?userID=".$row['User_id'];
        $profilephoto = $row['profilephoto'];
        if($profilephoto){
            $imagehtml = "<img width='40' height='40' src='../vendor/fineuploader/php-traditional-server/files/$profilephoto' style='margin-right:10px;' class='img-rounded'>";
        } else {
            $imagehtml = "<img width='40' height='40' style='margin-right:10px;' class='img-rounded'>";
        }
        echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'>$imagehtml" . $row['First_name'] . " " . $row['Last_name'] . "<a href='" . $urlOfFriend . "' rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-primary pull-right\">View</a><button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right addfriend\">Add</button></td></tr>";
    }
} else {
    echo "0 results";
}
echo "</tbody></table>";

//close the connection
mysqli_close($conn);

?>

