<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Facebook Clone</title>

      <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.css">

      <script src="bower_components/jquery/dist/jquery.js"></script>

      <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>



      <style>

          #formRow {

              border:1px solid grey;
              border-radius:5px;
              margin-top:50px;
              background-color:#F7F9FA;
              padding-bottom:40px;
          }

          h1 {
              text-align: center;
          }

      </style>
  </head>
  <body>

      <div class="container">
          <div class="row">
              <div class="col-md-6 col-md-offset-3" id="formRow">
                  <!-- This div will have a width of 6 columns and have
                  a left margin of 3 columns to center it in the middle of the page-->

                  <h1>Facebook Clone</h1>


                  <form method="POST" action="index.php">
                      <!-- Adding this class makes the form horizontal and makes the different 'form-group'
                      classes behave as grid rows, no .row needed -->
                      <div class="form-group">
                          <!-- All form inputs/controls should be wrapped in the class form-group
                          for optimal spacing -->
                          <!-- We can add text or buttons before or after any <input
                              by using .input-group with an .input-group-addon
                          -->
                          <label for="username" class="control-label">Email Address:</label>
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <input type="email" class="form-control" placeholder="Email Address" name="username" required/>
                          </div>

                      </div>

                      <div class="form-group">

                          <label for="password">Password:</label>
                          <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <input type="password" class="form-control" placeholder="Password" name="password" required/>

                          </div>

                      </div>

                      <input type="submit" name="logIn" class="btn btn-success btn-lg btn-block" value="Log In"/>


                  </form>

                  <div class="text-center" id="forgotPassword">
                      <p>
                          <a href="#">Forgotten your password?</a>
                      </p>
                      <p>
                          <!-- Trigger the modal with a button -->
                          <a class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#myModal">Sign Up</a>
                      </p>
                  </div>
              </div>
              <!-- We need a modal for the user to register.-->







          </div>
      </div>


      <!-- Modal -->
      <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Registration</h4>
                  </div>
                  <div class="modal-body">

                      <!-- Place a signUpFeedback here -->

                      <div id="signUpFeedback" class="alert alert-success">You have signed up succesfully</div>
                      <!-- Add a form that will allow the user to sign up to the website -->

                      <form id="signUpForm">
                          <div class="form-group">
                              <label for="genderRatio" autofocus>Gender:</label>
                              <label class="radio-inline"><input type="radio" name="genderRadio" value="male" required>Male</label>
                              <label class="radio-inline"><input type="radio" name="genderRadio" value="female">Female</label>
                          </div>
                          <div class="form-group">
                              <label for="firstName">First Name:</label>
                              <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
                          </div>
                          <div class="form-group">
                              <label for="lastName">Last Name:</label>
                              <input type="text" class="form-control" id="lastName" placeholder="Last Name">
                          </div>
                          <div class="form-group">
                              <label for="dob">Date Of Birth:</label>
                              <input type="date" class="form-control" id="dob" required>
                          </div>
                          <div class="form-group">
                              <label for="telNumber">Phone Number:</label>
                              <input type="number" class="form-control" id="telNumber" placeholder="02077273101" required>
                          </div>
                          <div class="form-group">
                              <label for="username1">Email/Username:</label>
                              <input type="email" class="form-control" id="username1" required>
                          </div>
                          <div class="form-group">
                              <label for="username2">Confirm Email/Username:</label>
                              <input type="email" class="form-control" id="username2">
                          </div>
                          <div class="form-group">
                              <label for="password1">Password:</label>
                              <input type="password" class="form-control" placeholder="Enter your password" id="username1">
                          </div>
                          <div class="form-group">
                              <label for="password2">Confirm Password:</label>
                              <input type="password" placeholder="Confirm your password" class="form-control" id="username2">
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-success pull-right" id="signUp">Sign Up</button>
                          </div>

                      </form>




                  </div>

              </div>

          </div>
      </div>

      <!-- jQuery to capture the user input -->
      <script>


          $("#signUpForm").submit(function(event) {
              alert("Handler for .submit() called.");
              event.preventDefault();

              // Need to create a variable so that PHP knows
              // that we want to process the signup

              var signUp = true;


              // Grab all the values from the form and place them in variables

              var gender = $('input[name=genderRadio]:checked').val();
              console.log(gender);

              var firstName = $('#firstName').val();
              console.log(firstName);

              var lastName = $('#lastName').val();
              console.log(lastName);

              var dob = $('#dob').val();
              console.log(dob);

              var telNumber = $('#telNumber').val();
              console.log(telNumber);

              var username1 = $("#username1").val();
              console.log(username1);

              var username2 = $("#username2").val();
              console.log(username2);

              var password1 = $("#password1").val();
              console.log(password1);

              var password2 = $("#password2").val();
              console.log(password2);

              // Now send the user inputted data to a php script for processing

              $.post('corePHP/functions.php', {

                      signUp: signUp,
                      gender: gender,
                      firstName: firstName,
                      lastName: lastName,
                      dob: dob,
                      telNumber: telNumber,
                      username1: username1,
                      username2: username2,
                      password1: password1,
                      password2: password2


                  },

                  function (data, status) {



              });





          });

      </script>





  </body>
</html>






