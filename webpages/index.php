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

#On every page we need a variable that will highlight the relevant page we are on
# in the nav bar

$pageTitle = 'index';

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
      </style>
  </head>

  <body>

    <!-- Place the nav bar here -->
    <?php require("includes/nav.php"); ?>

    <!--------------------------- REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE  ----------------------------------------->

    <script type="text/babel">

        var App = React.createClass({


            render: function() {

                return(

                        <div><p>THIS IS RENDERED IN REACT</p></div>

                );

            }


        });


        ReactDOM.render(<App/>,document.getElementById('blogreact'));



    </script>

    <!--------------------------- REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE  ----------------------------------------->


    <!-- Begin page content -->
    <div class="container">

        <!-- The first row will consist of the page header/welcome message. -->
        <div class="row">
            <div class="page-header">
                <h1><?php echo "Welcome: ". $_SESSION['First_name']?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <p class="lead">Use this page to manage your blog. You can create, edit, update and delete your posts below</p>


            </div>
            <div class="col-md-4">
                <h1>JIALIN ZONE</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- This element will render the react component/part of the website -->
                <div id="blogreact"></div>

            </div>
            <div class="col-md-4">
                <h1>JIALIN ZONE</h1>
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
