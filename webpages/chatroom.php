<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 11/03/2017
 * Time: 12:35
 */

ob_start();
session_start();
require_once($_SERVER['DOCUMENT_ROOT']. "/socialSite/corePHP/functions.php");

// We now need to kick the user out to the homepage if they have not logged in

if(!is_logged_in()){
    $ip = gethostbyname(gethostname());

    header("Location:". "http://".$ip.":8888/socialSite/index.php?alertType=4" ."&alertMessage=You need to log in before you are able to view this page");
    exit();

}

$pageTitle = 'chatroom';

?>

<!DOCTYPE html>
<html lang="en">
<!-- Insert/include head code here -->

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

    /*
    from the chat room
    !!!!!!!!!!!!!!!!!!
    !!!!!!!!!!!!!!!!!!
    !!!!!!!!!!!!!!!!!!
     */

    /*

    body {
        font-family: arial;
        font-size: 15px;
        line-height: 1.5em;
        background: #f4f4f4;
    }
    */


    #container {
        background: #333333;
        margin: 20px auto;
        overflow: auto;
        width: 100%;
    }


    header h1 {
        color: #333333;
        font-size: 40px;
        padding: 15px 0 10px 10px;
        border-bottom: 1px solid #ffffff;
    }

    #messages {
        width: 90%;
        background: #f4f4f4;
        height: 400px;
        margin: 20px auto;
        overflow: auto;
    }

    .message {
        list-style: none;
        padding: 8px;
        border-bottom: 1px #cccccc dotted;
    }

    .message span {
        color:#aaaaaa;
    }

    #input {
        width: 90%;
        margin: auto;
        padding: 0;
    }

    #input input[type='text'] {
        height: 25px;
        width: 48%;
        padding: 3px;
        margin-bottom: 20px;
        border: #666666 solid 1px;
    }

    #user {
        float: left;
    }

    #newmessage{
        float: right;
    }

    input#show-btn {
        -webkit-appearance:button;
        height: 30px;
        padding: 5px;
        width: 100%;
        margin: 10px auto;
        margin-bottom: 30px;
    }

    .error {
        background: red;
        color: #ffffff;
        padding: 5px;
        margin-bottom: 20px;
    }

    @media only screen and (max-width: 768px) {
        #input input[type='text'] {
            width: 98%;
            float: none;
        }
    }


</style>

<body>

<!-- Place the nav bar here -->
<?php require("includes/nav.php"); ?>

<!-- Begin page content -->
<div class="container" style="margin-top:50px">

    <div class="page-header">
        <h1><?php echo "Welcome to chatroom: ". $_SESSION['First_name']?></h1>
    </div>



    <div class="row">

        <div class="col-md-2">
                <header>
                    <h3>Group List</h3>
                </header>

                <div id="all_chatgroup" style="background-color:white">
                <!--There will be dynamic button here later -->
                </div>
        </div>

        <!-- empty space -->
        <div class="col-md-1">

        </div>

        <!-- chat part -->
        <div class="col-md-9">

            <!-- Mainly from the chatroom file -->
            <div id="chat_content_container">
                <div id="messages">
                    <! -- for message history and new message -->
                    <! -- display though tables, the table refresh -->
                    <! -- 1) when any message is sent by the user -->
                    <! -- 2) auto-refresh every 0.5 second -->
                    <table class="table table-hover group_messages_list">


                    </table>
                </div>

                <div id="input message_groupchat">

                    <table class="table table-hover message_input">


                    </table>

                </div>

            </div>

        </div>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<!--    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>-->
<!--    <script src="../../dist/js/bootstrap.min.js"></script>-->
<!--    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
</body>
</html>


<!-- JAVASCRIPT ON THIS PAGE -->

<script>
    $( document ).ready(function() {
        // get the list of chat_group when the document is loaded
        // run a ajax command to get the table list

        $.ajax({
            url: "api/get_all_group.php",
            data:{page_ready: true },
            type: "POST",
            success: function (returnedData) {
                //alert('it works');
                //$last_groupid = returnedData;
                $("#all_chatgroup").html(returnedData);
            }
        });

        //$(".all_chatgroup").append("<tr><td>" + name + "</td> <td><button class='btn btn-danger pull-right DeleteFromGroup' rel=" + userid + ">Delete</button> </td></tr> ");

        //console.log( "document loaded" );
    });

    /*
    FOR CHAT PART ONCE CLICK THE BUTTON THE CONTENT LOAD AND THE DATABASE IS CONNECTED
     */

    $("#all_chatgroup").on('click','.click_to_chat', function(){
        // erase the message div first


        var group_id = $(this).attr('rel');

        //console.log(group_id);
        // get the group id related to the button
        $.ajax({
            url: "api/get_group_information.php",
            data:{group_information: group_id },
            type: "POST",
            success: function (returnedData) {
                //alert('it works');
                //$last_groupid = returnedData;
                $(".group_messages_list").html(returnedData);
            }
        });

        // this is the chat after click on chat button
        // we have the group id already
        // cant send message before click on group
        // print the text box after click on the group

        $.ajax({
            url: "api/make_message_available.php",
            data:{group_id: group_id },
            type: "POST",
            success: function (returnedData) {

                $(".message_input").html(returnedData);

                //console.log(group_id);

                // refresh the page with ajax


                // end of the interval function

            }

        });

    });

    $(".message_input").on('click','.message_to_go', function(){
        var group_id = $(this).attr('rel');
        //console.log(group_id);
        var message = $("#newmessage").val();
        //console.log(message);

        $.ajax({
            url: "api/send_message.php",
            data:{group_id: group_id, message: message},
            type: "POST",
            success: function (returnedData) {

                $(".group_messages_list").html(returnedData);

                // on success empty the text box
            }

        });

    });


    /*
    $("#all_chatgroup").on('click','.click_to_chat', function(){
        var group_id = $(this).attr('rel');
        // GET REFRESH AJAX WORK EVERY 1 SEC
        setInterval(function(){
            // run ajax to get the information
            var id = group_id;

            $.ajax({
                url: "api/get_group_information.php",
                data:{group_information: id },
                type: "POST",
                success: function (returnedData) {
                    //alert('it works');
                    //$last_groupid = returnedData;
                    $(".group_messages_list").html(returnedData);
                }
            });

        }, 5000) /* time in milliseconds (ie 0.5 seconds)*/

    //});




</script>





