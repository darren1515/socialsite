<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 12/02/2017
 * Time: 15:03
 */


ob_start();
session_start();
require_once($_SERVER['DOCUMENT_ROOT']. "/socialSite/corePHP/functions.php");

// We now need to kick the user out to the homepage if they have not logged in

if(!is_logged_in()){
    $ip = gethostbyname(gethostname());

    header("Location:/socialSite/index.php?alertType=4" ."&alertMessage=You need to log in before you are able to view this page");
    exit();

}

#On every page we need a variable that will highlight the relevant page we are on
# in the nav bar

$pageTitle = 'friendsRecommendations';

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php require("includes/head.php"); ?>

    <style>
        /* Sticky footer styles
    -------------------------------------------------- */
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            /* Margin bottom by footer height */
            margin-bottom: 60px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 60px;
            background-color: #f5f5f5;
        }


        /* Custom page CSS
        -------------------------------------------------- */
        /* Not required for template or sticky footer method. */

        body > .container {
            padding: 60px 15px 0;
        }
        .container .text-muted {
            margin: 20px 0;
        }

        .footer > .container {
            padding-right: 15px;
            padding-left: 15px;
        }

        code {
            font-size: 80%;
        }

        /*Stop the nav bar from overlapping the page content*/



    </style>
</head>

<body>

<!-- Place the nav bar here -->
<?php require("includes/nav.php"); ?>

<!-- Begin page content -->
<div class="container">
    <!-- The first row will consist of the page header/welcome message. -->
    <div class="row" style="padding-top: 50px">
        <div class="page-header">
            <h1><?php echo "Welcome: ". $_SESSION['First_name']?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- This element will render the react component/part of the website -->
            <h3><?php echo "Friends requests"?></h3>
            <div id="friendsrequests"></div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <h3><?php echo "Survey for friends recommendations"?></h3>

            <form id="SurveyForm">

                <div class="form-group">
                    <label for="Age" class="control-label">What is your age?</label>
                    <label class="radio-inline"><input type="radio" name="Age" value="0" required>Under 18 years old</label>
                    <label class="radio-inline"><input type="radio" name="Age" value="1">18-27 years old</label>
                    <label class="radio-inline"><input type="radio" name="Age" value="2">28-37 years old</label>
                    <label class="radio-inline"><input type="radio" name="Age" value="3">38-47 years old</label>
                    <label class="radio-inline"><input type="radio" name="Age" value="4">48-57 years old</label>
                    <label class="radio-inline"><input type="radio" name="Age" value="5">58 years old or older</label>
                </div>

                <div class="form-group">
                    <label for="Sports" class="control-label">How often are you participating in sports activities?</label>
                    <label class="radio-inline"><input type="radio" name="Sports" value="1">Never</label>
                    <label class="radio-inline"><input type="radio" name="Sports" value="2">Rarely</label>
                    <label class="radio-inline"><input type="radio" name="Sports" value="3">Occasionally</label>
                    <label class="radio-inline"><input type="radio" name="Sports" value="4">Frequently</label>
                    <label class="radio-inline"><input type="radio" name="Sports" value="5">Very Frequently</label>
                </div>

                <div class="form-group">
                    <label for="Movies" class="control-label">How interested are you in watching movies?</label>
                    <label class="radio-inline"><input type="radio" name="Movies" value="1" required>Not at all</label>
                    <label class="radio-inline"><input type="radio" name="Movies" value="2">Slightly</label>
                    <label class="radio-inline"><input type="radio" name="Movies" value="3">Moderately</label>
                    <label class="radio-inline"><input type="radio" name="Movies" value="4">Very</label>
                    <label class="radio-inline"><input type="radio" name="Movies" value="5">Extremely</label>
                </div>

                <div class="form-group">
                    <label for="Music" class="control-label">How much do you enjoy listening to music?</label>
                    <label class="radio-inline"><input type="radio" name="Music" value="1" required>Not at all</label>
                    <label class="radio-inline"><input type="radio" name="Music" value="2">Slightly</label>
                    <label class="radio-inline"><input type="radio" name="Music" value="3">Moderately</label>
                    <label class="radio-inline"><input type="radio" name="Music" value="4">Very</label>
                    <label class="radio-inline"><input type="radio" name="Music" value="5">Extremely</label>
                </div>

                <button type="submit" class="btn btn-success btn-lg" id="Submit">Submit</button>


            </form>


        </div>

    </div>

    <div class="row">
        <div class="col-md-8">
            <h3><?php echo "Recommended Friends"?></h3>
            <div id="recommendedfriends"></div>

        </div>


    </div>


</div>



<!-- jQuery to capture the user input -->
<script>

    $(document).ready(function() {
        loadData();
    });

    var loadData = function() {
        $.ajax({    //create an ajax request to load_page.php
            type: "GET",
            url: "api/get_friends_requests.php",
            dataType: "html",   //expect html to be returned
            success: function(response){
                $("#friendsrequests").html(response);
                setTimeout(loadData, 5000);
            }

        });
    };

    $("#friendsrequests").on('click', '.acceptfriend', function(){

        // We first need to grab the userID

        var friendID = $(this).attr('rel');

        // We then need to update the database

        $.post("api/accept_friend_request.php", {friendID:friendID}, function(){

            //Once complete need to change the button to say friend request sent.
            // We want $this to refer to the button.

            $(this).attr('class','btn btn-success pull-right');
            $(this).html("Accepted");
        }.bind(this));


    });

    $("#friendsrequests").on('click', '.rejectfriend', function(){

        // We first need to grab the userID

        var friendID = $(this).attr('rel');

        // We then need to update the database

        $.post("api/reject_friend_request.php", {friendID:friendID}, function(){

            //Once complete need to change the button to say friend request sent.
            // We want $this to refer to the button.

            $(this).attr('class','btn btn-danger pull-right');
            $(this).html("Rejected");
        }.bind(this));

    });



    $("#SurveyForm").submit(function(event) {
        //alert("Handler for .submit() called.");
        event.preventDefault();

        // Grab all the values from the form and place them in variables

        var Age = $('input[name=Age]:checked').val();
        console.log(Age);

        var Sports = $('input[name=Sports]:checked').val();
        console.log(Sports);

        var Movies = $('input[name=Movies]:checked').val();
        console.log(Movies);

        var Music = $('input[name=Music]:checked').val();
        console.log(Music);

        // Now send the user inputted data to a php script for processing

        $.post('api/friends_recommendation.php', {
            Age: Age,
            Sports: Sports,
            Movies: Movies,
            Music: Music
        },


            function (data) {
                // We now have feedback message returned from the ajax call
                $("#recommendedfriends").html(data);
                });
        });

    $("#recommendedfriends").on('click', '.addfriend', function(){

        // We first need to grab the userID

        var friendID = $(this).attr('rel');

        // We then need to update the database

        $.post("api/send_friend_request.php", {friendID:friendID}, function(){

            //Once complete need to change the button to say friend request sent.
            // We want $this to refer to the button.

            $(this).attr('class','btn btn-default pull-right');
            $(this).html("Request Sent");
        }.bind(this));


        console.log($(this).attr('rel'));

        console.log('add a friend');
    });

</script>


<footer class="footer">
    <div class="container">
        <p class="text-muted">All rights Reserved 4network</p>
    </div>
</footer>


</body>
</html>