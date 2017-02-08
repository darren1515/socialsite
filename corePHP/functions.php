<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 07/02/2017
 * Time: 15:56
 */

require("init.php");

// We require this as we will be able to call our connection file.

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

               echo "Insert the user";
           } else {
               echo "This user already exists";
           }





        }
    } else {

        echo $feedback;

    }



}