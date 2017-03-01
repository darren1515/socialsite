<?php

  //require("functions/init.php");

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Forgot Password</title>

    <!-- Bootstrap -->
      <link rel="stylesheet" type="text/css" href="vendor/twbs/bootstrap/dist/css/bootstrap.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

      <script src="vendor/components/jquery/jquery.js"></script>

      <script src="vendor/twbs/bootstrap/dist/js/bootstrap.js"></script>
    <![endif]-->

    <style>

    #formRow {

    	border:1px solid grey;
    	border-radius:5px;
	    margin-top:50px;
    	background-color:#F7F9FA;
    	padding-bottom:40px;
    }

    h1 {
    	text-align:center;
    	}




    </style>



  </head>
  <body>



    <!-- The below starts the grid system, there are a total of 12 columns and you can specify
    the size of each column inserted and drop down rows using bootstrap classes-->

    <div class="container">



    <!-- All rows must be placed in a container class-->
    	<div class="row">
    	<!-- All columns must be placed in rows and there width must be specified-->

    		<div class="col-md-6 col-md-offset-3" id="formRow">
    		<!-- This div will have a width of 6 columns and have
    		a left margin of 3 columns to center it in the middle of the page-->

    			<h1>Forgot Password</h1>

          <hr>

          <?php

            if(isset($_POST['changePassword'])) {
            echo call_user_func_array('displayAlert',forgotPassword());
            }

            if(isset($_GET['error'])) {

              echo displayAlert($_GET['error'],4);
            }

           ?>

          <!--
          This section will be used to display sucess and error messages. I.E. A notification about sucessful activation of account



          -->

    			<form method="POST" action="forgot-password.php">
    			<!-- Adding this class makes the form horizontal and makes the different 'form-group'
    			classes behave as grid rows, no .row needed -->

            <div class="form-group">
    				<!-- All form inputs/controls should be wrapped in the class form-group
    				for optimal spacing -->
    				<!-- We can add text or buttons before or after any <input
    					by using .input-group with an .input-group-addon
    				-->

      				<label for="resetEmailAddress">Email Address:</label>
      				<div class="input-group">
      					<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
  						<input type="email" class="form-control" placeholder="Enter the email address you used to sign up" name="resetEmailAddress" required/>

      				</div>

    			 </div>

           <!--The below button will initiate the changing of the password
           Use bootstrap grid classes create two buttons on the same row. A grid system within a row.
           -->
           <div class="row">
             <div class="col-md-6">
               <input type="submit" name="changePassword" class="btn btn-success btn-lg btn-block" value="Password Reset" />
               <!-- This will be used to submit the form-->
             </div>
             <div class="col-md-6">
               <a href="index.php" class="btn btn-danger btn-lg btn-block">Cancel</a>
             </div>
          </div>

    		</form>





    </div><!-- Row -->
</div><!--Container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> Use local downloaded copy for jquery instead-->


    <script>







    </script>
  </body>
</html>
