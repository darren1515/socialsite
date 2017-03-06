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

    header("Location:". "http://".$ip.":8888/socialSite/index.php?alertType=4" ."&alertMessage=You need to log in before you are able to view this page");
    exit();

}
// 06/03/17 Below will update the database when the user clicks update profile
if($_POST){
    updateUserSettings($_POST);
}

$userSettings = pullUserSettings();

$pageTitle = 'profileSettings';

?>


<!DOCTYPE html>
<html lang="en">
  <!-- Insert/include head code here -->

  <?php require_once("includes/head.php"); ?>

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
      </style>
  </head>

  <body>

    <!-- Place the nav bar here -->
    <?php require_once("includes/nav.php"); ?>




    <!-- Begin page content -->
    <div class="container" style="margin-top:50px">
      <div class="page-header">
        <h1>Make changes to your account settings</h1>
      </div>

      <!-- Place a form that will allow the user to set privacy settings, put phone number etc -->
      <section class="row">
          <div class="col-md-10 col-md-offset-1">
          <!-- The user will need to have a success message pop up once they hit submit-->
              <div id="updateText">

              </div>
          <form method="POST">
              <div class="form-group">
                  <h4>Select privacy level:</h4>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption1" value="1" <?php echo (($userSettings['privacysettings_fk']=='1') ? 'checked':''); ?>>
                          <strong>Private</strong> - Your blog and photos will only be viewable by you and you alone
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption2" value="2" <?php echo (($userSettings['privacysettings_fk']=='2') ? 'checked':''); ?>>
                          <strong>Friends</strong> - Your blog and photos will by viewable by you and your friends
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption3" value="3" <?php echo (($userSettings['privacysettings_fk']=='3') ? 'checked':''); ?>>
                          <strong>Friends of Friends</strong> - Your blog and photos will by viewable by you, your friends and their friends
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption4" value="4" <?php echo (($userSettings['privacysettings_fk']=='4') ? 'checked':''); ?>>
                          <strong>All</strong> - Your blog and photos will by viewable by all
                      </label>
                  </div>
              </div>
              <!-- Add input elements that represent facts that user entered about themselves on signup -->
              <div class="form-group">
                  <label for="genderRatio" autofocus>Gender:</label>
                  <label class="radio-inline "><input type="radio" value="male" required <?php echo (($userSettings['Gender']=='male') ? 'checked':'disabled'); ?>>Male</label>
                  <label class="radio-inline"><input type="radio" value="female" <?php echo (($userSettings['Gender']=='female') ? 'checked':'disabled'); ?>>Female</label>
              </div>
              <div class="form-group">
                  <label for="firstName">First Name:</label>
                  <input type="text" class="form-control" name="firstName" placeholder="First Name" required value="<?php echo $userSettings['First_name'];?>">
              </div>
              <div class="form-group">
                  <label for="lastName">Last Name:</label>
                  <input type="text" class="form-control" name="lastName" placeholder="Last Name" required value="<?php echo $userSettings['Last_name'];?>">
              </div>
              <div class="form-group">
                  <label class="control-label">Email</label>
                  <p class="form-control-static"><?php echo $userSettings['Username'];?></p>
              </div>
              <div class="form-group">
                  <label for="telNumber">Phone Number:</label>
                  <input type="number" class="form-control" id="telNumber" name="Phone" placeholder="02077273101" value="<?php echo $userSettings['Phone'];?>">
              </div>
              <button type="submit" class="btn btn-success">Update profile</button>
          </form>
          </div>
      </section>



    <?php var_dump($_POST);?>


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
