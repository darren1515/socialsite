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

    if($firstName =="" || $lastName == "" || $jobRole == "" || $emailSignUp == "" || $emailSignUp2 == "") {

        $signUpResult .= '<li class="list-group-item">Please fill in a a value for all the fields</li>';


    }




}