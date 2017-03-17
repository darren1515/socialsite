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
$ip = gethostbyname(gethostname());
//echo $ip;
//header("Location:". "http://".$ip.":8888/socialSite/index.php?alertType=3" ."&alertMessage=Your account has either been previously activated or have entered an invalid token ID.");
//exit();
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

    $token = $_GET['token'];

    $query = "UPDATE users SET activated = 1, activationToken = NULL WHERE activationToken = '$token'";

    // Now run the query

    try {
        mysqli_query($connection,$query);

        //Get ip address of the server
        $ip = gethostbyname(gethostname());

        if(mysqli_affected_rows($connection) >0){


            mysqli_close($connection);

            // After the account has been activated, we have to wait 5 seconds
            // Then redirect the user to the homepage.



            // Now redirect the user


            //header("Location:". "http://".$ip.":8888/socialSite/index.php?alertType=1" ."&alertMessage=You have successfully activated your account.");
            //http://4network.azurewebsites.net/socialsite

            header("Location:". "http://4network.azurewebsites.net/socialsite/index.php?alertType=1" ."&alertMessage=You have successfully activated your account.");



        } else {


            header("Location:". "http://4network.azurewebsites.net/socialsite/index.php?alertType=3" ."&alertMessage=Your account has either been previously activated or have entered an invalid token ID.");
        }



    } catch (Exception $e) {

        die($e->getMessage());
    }

} else {
    echo "You have entered a incorrect URL";
}

