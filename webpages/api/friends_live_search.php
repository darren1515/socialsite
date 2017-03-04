<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 03/03/2017
 * Time: 23:11
 * This php file is for the friends search bar in the navigation.
 *Jquery will send what the user has inputed to this file and this file
 * will print out all the relevant friends.
 */


session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['friend_search'])){

    $con = connectToDatabase();

    // first clean the string, i.e protect from sql injection.

    $friendText = filter_var($_POST['friend_search'], FILTER_SANITIZE_STRING);

    // Combine the first_name and last_name and use *friendtext* wildcard.
    // We also shouldn't return your self. I.E darren should should not see darren in the search results.
    $query = "SELECT User_id, First_name, Last_name FROM users WHERE CONCAT(First_name, ' ', Last_name) LIKE "
        . "'%$friendText%'";

    $result = mysqli_query($con,$query);
    if (!$result) {
        die(mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {

        // First echo out a table

        echo '<table style="width:100%">';

        while($row = mysqli_fetch_assoc($result)) {

            // We need to print out both the first name, last name and a button.
            echo "<tr><td class='testing' rel='"  .$row['User_id'].  "'>" .$row['First_name'] . " " .$row['Last_name'] . " <button style='height:5px' type=\"button\" class=\"btn btn-success\">Add</button></td></tr>";


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


