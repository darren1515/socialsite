<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2017
 * Time: 18:04
 */


session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';
// Create connection
$conn = connectToDatabase();

$User_id = $_SESSION['User_id'];


$get_names_sql = "SELECT User_id, First_name, Last_name, privacysetting,profilephoto FROM users
            WHERE User_id in (
Select User_id2 as User_id from friends 
where User_id1 = $User_id and friendStatus = 0
);
			";
//submit query
$result = $conn->query($get_names_sql);

// Always print the table

echo '<table class="table table-hover" style="width:100%">';
echo '<tbody>';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $urlOfFriend = "viewprofile.php?userID=".$row['User_id'];
        $profilephoto = $row['profilephoto'];
        if($profilephoto){
            $imagehtml = "<img width='40' height='40' src='../vendor/fineuploader/php-traditional-server/files/$profilephoto' style='margin-right:10px;' class='img-rounded'>";
        } else {
            $imagehtml = "<img width='40' height='40' style='margin-right:10px;' class='img-rounded'>";
        }
        echo "<tr><td style='height:50px' rel='" . $row['User_id'] . "'>$imagehtml" . $row['First_name'] . " " . $row['Last_name'] . "<a href='" . $urlOfFriend . "' rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-primary pull-right\">View</a><button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-danger pull-right rejectfriend\">Reject</button><button rel='" . $row['User_id'] . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right acceptfriend\">Accept</button></td></tr>";
    }
}
echo "</tbody></table>";

//close the connection
mysqli_close($conn);

?>