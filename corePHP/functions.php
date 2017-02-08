<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 07/02/2017
 * Time: 15:56
 * This file will contain functions that will be called from all over the land.
 */

// Included so that we can use swiftmailer.
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] ."/socialSite/vendor/autoload.php");

$directoryOfCurrentFile = dirname(__FILE__);
$chop = explode("/",$directoryOfCurrentFile);
require($chop[0]."/".$chop[1]."/".$chop[2]."/password.php");

//var_dump($password);
function test(){
    global $chop;
    echo $chop[0]."/".$chop[1]."/".$chop[2]."/password.php";
}


function connectToDatabase(){

    DEFINE("USERNAME", "root");
    DEFINE("SERVERPASSWORD", "7AEA61437E");
    DEFINE('SERVERNAME', 'localhost');
    DEFINE("DATABASENAME", "test");
    DEFINE("DSN",'mysql:host=' .SERVERNAME. ';dbname='.DATABASENAME);

    $con = mysqli_connect(SERVERNAME,USERNAME,SERVERPASSWORD,DATABASENAME);

// Check connection
    if (mysqli_connect_errno())
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error()) ;
    } else{
        return $con;

    }

}
//ini_set('display_errors', 'On');
//try {
//    sendEmailNoAttachment("doby151515@live.com","noreply","darrenlahr@gmail.com","d","apple","test");
//} catch(Exception $e){
//    die($e->getMessage());
//}



function sendEmailNoAttachment($fromAddress, $fromName, $toAddress, $toName, $subject, $body) {

    global $emailLogin, $password;
    // Create the SMTP configuration
    $transport = Swift_SmtpTransport::newInstance('smtp.live.com', 587,'tls')->setUsername($emailLogin)->setPassword($password);

    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance($subject)
        ->setFrom(array($fromAddress => $fromName))
        ->setTo(array($toAddress => $toName))
        ->setBody($body, 'text/html');
    $mailer->send($message);


}

/*
try {
    sendEmailNoAttachment("doby151515@live.com","Doby","darrenlahr@gmail.com","Darren","Registration","This is a test");
    echo "Email has been sent";
} catch (Exception $e) {
    echo $e->getMessage();
}
*/
















//We require this as we will be able to call our connection file.

//Case 1 SignUp the user

if(isset($_POST['signUp'])){

    // The user has clicked the signup button and we need to
    // clean the information that has come from the form.

    // Grab the form data and remove whitespace
    $gender = trim($_POST['gender']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $dob = trim($_POST['dob']);
    $telNumber = trim($_POST['telNumber']);
    $username1 = trim($_POST['username1']);
    $username2 = trim($_POST['username2']);
    $password1 = trim($_POST['password1']);
    $password2 = trim($_POST['password2']);


    //Create a variable that will be used to userfeedback

    $feedback = "";

    // First check that all the required fields have been entered

    if($gender =="" || $firstName == "" || $lastName == "" || $dob == "" || $username1 == "" || $username2 == "" || $password1 == "" || $password2 =="") {

        $feedback .= '<li class="list-group-item">Please fill in a a value for all the required fields</li>';

    }

    //Next we do a further check (1st html5) to check that a valid email address has been entered.

    if($feedback == "") {

        // Remove illegal characters from the email

        $username1 = filter_var($username1, FILTER_SANITIZE_EMAIL);
        $username2 = filter_var($username2, FILTER_SANITIZE_EMAIL);

        // Is the fixed/non illegal character email valid
        if(filter_var($username1,FILTER_VALIDATE_EMAIL) == True) {

            // Now check that the email addresses match, i.e. dobby@gmail.com against dob@gmail.com

            if($username1 != $username2){
                $feedback .= '<li class="list-group-item">The email address(s) entered do not match</li>';
            }

        } else {

            // An invalid email has been entered

            $feedback .= '<li class="list-group-item">Please enter a valid email address </li>';

        }

    }

    // We need to valid the passwords, we need to check that the password contains at least 1 capital letter, 1 capital and is 8 characters or longer

    //Sanitize the password, remove tags and special characters.

    $password1 = filter_var($password1, FILTER_SANITIZE_STRING);
    $password2 = filter_var($password2, FILTER_SANITIZE_STRING);

    // First check if they are valid, i.e. match the conditions above

    if((preg_match('/[A-Z]/', $password1)) && (preg_match('/[a-z]/', $password1)) && (strlen($password1) >= 8)){

        // The password is valid

        if($password1 != $password2){

            // password1 matches our requirements but
            $feedback .= '<li class="list-group-item">Your entered passwords do not match</li>';
        }

    } else {

        $feedback .= '<li class="list-group-item">Please enter a password that contains at least 1 capital letter and is at least 8 characters in length </li>';

    }

    //echo $feedback;

    // If $feedback is empty then we are ready to register the user.

    if(empty($feedback)){
        //signup the user. We need our connection object

        $connection = connectToDatabase();

        if(empty($connection)){
           // Error message will be printed out through the die
        } else {
           // We have our connection to the database.


           //Escape variables for secturity

           $username1 = mysqli_real_escape_string($connection,$username1);

           // First check whether the user has been registered previously

           $query = "SELECT User_id FROM users WHERE Username = '$username1'";

           // Run the query

           $result = mysqli_query($connection,$query) or die('Error checking for existing users with the same name');

           //If there is anything returned in result there already is a username

           if($result->num_rows ==0){

               // We need to generate a user token that will be sent to the users email address. This will form part of the activiation url

               $token = bin2hex(random_bytes(32));
               $encrpytedPassword = md5(md5($username1).$password1);

               // We now need to change our query based on whether the phone number was entered.

               if(empty($telNumber)){
                   $query = "INSERT INTO users (First_name, Last_name, Username, dob, Gender, password, activationToken) VALUES ";
                   $query .= "('$firstName','$lastName','$username1','$dob', '$gender', '$encrpytedPassword', '$token')";
               } else {
                   // The phone number was entered
                   $query = "INSERT INTO users (First_name, Last_name, Username, dob, Phone, Gender, password, activationToken) VALUES ";
                   $query .= "('$firstName','$lastName','$username1','$dob', $telNumber, '$gender', '$encrpytedPassword', '$token')";
               }


               $result = mysqli_query($connection,$query) or die(mysqli_error($connection) . "<br> $query");

               //Get ip address of the server
               $ip = gethostbyname(gethostname());

               $subject = "Facebook Clone Activation Email";

               $activationURL = "http://".$ip.":8888/socialSite/activate.php?token=$token";
               // We now need to create the message that will be
               $htmlMessage =  <<<EOM
                <html>
                  <body>
                  <p>Dear $firstName, </p>
                  <p>Thanks for signing up to facebook clone</p>
                  <p>To activate your account please click the below link <br> $activationURL </p>
                  <p>Once you have activated your account you will receive an email to confirm</p>
                  </body>
                </html>


EOM;


               // We need a try catch block to send the activation email.

               try {

                   sendEmailNoAttachment("doby151515@live.com","noreply",$username1,$firstName,$subject,$htmlMessage);
                   $feedback = '<div class="alert alert-success"><strong>A activation email has been sent to your email address</strong></div>';
               } catch (Exception $e){
                   die($e->getMessage());
               }


           } else {
               $feedback = '<div class="alert alert-warning"><strong>'.$username1.'</strong> Has already been registered</div>';
           }


            mysqli_close($connection);

        }
    } else {

        $feedback = '<div class="alert alert-danger"><strong>Please correct the following error(s)</br></strong><ul class="list-group">'. $feedback. '.</ul></div>';

    }

    echo $feedback;

}