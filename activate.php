<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 08/02/2017
 * Time: 19:58
 */

ini_set('display_errors', 'On');
//echo $_SERVER['DOCUMENT_ROOT']. "socialSite/corePHP/functions.php";
require_once($_SERVER['DOCUMENT_ROOT']. "/socialSite/corePHP/functions.php");


/*
 * EXAMPLE OF A ACTIVATION EMAIL
 *
 * When the user clicks on the link the a GET variable will be set
 *
 * Dear Darren,

Thanks for signing up to facebook clone

To activate your account please click the below link
http://192.168.1.3:8888/Customer%20Training%20Scheduler/activate.php?token=fe5d18a5bd073a5c7383fca475324ac5

Once you have activated your account you will receive an email to confirm
 */



if(isset($_GET['token'])){

    $connection = connectToDatabase();

    // First clean the token, as the user may have played around with it

    $token = mysqli_real_escape_string($connection,$_GET['token']);

    $query = "UPDATE users SET activated = 1, activationToken = NULL WHERE activationToken = '$token'";

    // Now run the query

    try {
        mysqli_query($connection,$query);

        if(mysqli_affected_rows($connection) >0){

            echo "Your account has been activated";

            mysqli_close($connection);

        } else {
            echo "Your token is invalid";
        }



    } catch (Exception $e) {

        die($e->getMessage());
    }

} else {
    echo "You have entered a incorrect URL";
}
