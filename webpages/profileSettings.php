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

$pageTitle = 'profileSettings';

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
      </style>
  </head>

  <body>

    <!-- Place the nav bar here -->
    <?php require("includes/nav.php"); ?>

    <!-- Begin page content -->
    <div class="container" style="margin-top:50px">
      <div class="page-header">
        <h1>Make changes to your account settings</h1>
      </div>

      <!-- Place a form that will allow the user to set privacy settings, put phone number etc -->
      <section class="row">
          <form>
              <div class="form-group">
                  <h4>Select privacy level:</h4>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                          <strong>Private</strong> - Your blog and photos will only be viewable by you and you alone
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                          <strong>Friends</strong> - Your blog and photos will by viewable to you and your friends
                      </label>
                  </div>
                  <div class="radio disabled">
                      <label>
                          <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled>
                          Option three is disabled
                      </label>
                  </div>
              </div>

          </form>
      </section>




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
