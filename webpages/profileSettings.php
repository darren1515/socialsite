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
  <!-- Include fine-uploader files -->
  <link href="../fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet">
  <script src="../fine-uploader/fine-uploader.min.js"></script>

  </head>

  <body>

    <!-- Place the nav bar here -->
    <?php require_once("includes/nav.php"); ?>




    <!-- Begin page content -->
    <div class="container" style="margin-top:50px">
        <div class="row">
           <div class="col-md-8">
              <div class="page-header">
                <h1>Make changes to your account settings</h1>

              </div>
           </div>
            <div id="profilepic" class="col-md-4">

            </div>

        </div>




      <!-- INSERT THE profile upload section-->

        <script type="text/template" id="qq-template">
            <div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop profile picture here">
                <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
                </div>
                <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
                    <span class="qq-upload-drop-area-text-selector"></span>
                </div>
                <div class="qq-upload-button-selector qq-upload-button">
                    <div>Upload a file</div>
                </div>
                <span class="qq-drop-processing-selector qq-drop-processing">
                <span>Processing dropped files...</span>
                <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
            </span>
                <ul class="qq-upload-list-selector qq-upload-list" role="region" aria-live="polite" aria-relevant="additions removals">
                    <li>
                        <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
                        <div class="qq-progress-bar-container-selector qq-progress-bar-container">
                            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                        </div>
                        <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                        <div class="qq-thumbnail-wrapper">
                            <img class="qq-thumbnail-selector" qq-max-size="120" qq-server-scale>
                        </div>
                        <button type="button" class="qq-upload-cancel-selector qq-upload-cancel">X</button>
                        <button type="button" class="qq-upload-retry-selector qq-upload-retry">
                            <span class="qq-btn qq-retry-icon" aria-label="Retry"></span>
                            Retry
                        </button>

                        <div class="qq-file-info">
                            <div class="qq-file-name">
                                <span class="qq-upload-file-selector qq-upload-file"></span>
                                <span class="qq-edit-filename-icon-selector qq-btn qq-edit-filename-icon" aria-label="Edit filename"></span>
                            </div>
                            <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                            <span class="qq-upload-size-selector qq-upload-size"></span>
                            <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">
                                <span class="qq-btn qq-delete-icon" aria-label="Delete"></span>
                            </button>
                            <button type="button" class="qq-btn qq-upload-pause-selector qq-upload-pause">
                                <span class="qq-btn qq-pause-icon" aria-label="Pause"></span>
                            </button>
                            <button type="button" class="qq-btn qq-upload-continue-selector qq-upload-continue">
                                <span class="qq-btn qq-continue-icon" aria-label="Continue"></span>
                            </button>
                        </div>
                    </li>
                </ul>

                <dialog class="qq-alert-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Close</button>
                    </div>
                </dialog>

                <dialog class="qq-confirm-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">No</button>
                        <button type="button" class="qq-ok-button-selector">Yes</button>
                    </div>
                </dialog>

                <dialog class="qq-prompt-dialog-selector">
                    <div class="qq-dialog-message-selector"></div>
                    <input type="text">
                    <div class="qq-dialog-buttons">
                        <button type="button" class="qq-cancel-button-selector">Cancel</button>
                        <button type="button" class="qq-ok-button-selector">Ok</button>
                    </div>
                </dialog>
            </div>
        </script>




      <!-- Place a form that will allow the user to set privacy settings, put phone number etc -->
      <section class="row">
          <div class="col-md-10 col-md-offset-1">
          <!-- The user will need to have a success message pop up once they hit submit-->
              <div id="updateText">

              </div>
              <div id="uploader"></div>
          <form method="POST">
              <div class="form-group">
                  <h4>Select privacy level:</h4>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption1" value="1" <?php echo (($userSettings['privacysetting']=='1') ? 'checked':''); ?>>
                          <strong>Private</strong> - Your blog and photos will only be viewable by you and you alone
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption2" value="2" <?php echo (($userSettings['privacysetting']=='2') ? 'checked':''); ?>>
                          <strong>Friends</strong> - Your blog and photos will by viewable by you and your friends
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption3" value="3" <?php echo (($userSettings['privacysetting']=='3') ? 'checked':''); ?>>
                          <strong>Friends of Friends</strong> - Your blog and photos will by viewable by you, your friends and their friends
                      </label>
                  </div>
                  <div class="radio">
                      <label>
                          <input type="radio" name="optionsPrivacy" id="privacyOption4" value="4" <?php echo (($userSettings['privacysetting']=='4') ? 'checked':''); ?>>
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


        // Some options to pass to the uploader are discussed on the next page



  <script>
      var jsonPhoto = {};

      $(document).ready(function() {

          // When the page loads grab the latest profile picture

          var manualUploader = new qq.FineUploader({
              element: document.getElementById("uploader"),
              request: {
                  endpoint: "/socialsite/vendor/fineuploader/php-traditional-server/endpoint.php"
              },
              session:{
                  endpoint: "/socialsite/webpages/api/set_update_profile_image.php"
              },
              deleteFile: {
                  enabled: true,
                  endpoint: "/socialsite/vendor/fineuploader/php-traditional-server/endpoint.php"
              },
              chunking: {
                  enabled: true,
                  concurrent: {
                      enabled: true
                  },
                  success: {
                      endpoint: "/socialsite/vendor/fineuploader/php-traditional-server/endpoint.php?done"
                  }
              },
              debug:true,
              resume: {
                  enabled: true
              },
              retry: {
                  enableAuto: true,
                  showButton: true
              },
              validation: {
                  allowedExtensions: ['jpeg', 'jpg', 'png'],
                  itemLimit: 1,
                  sizeLimit: 10 * 1000000 // 10mb = 10 * 1024 bytes
              },
              callbacks: {
                  onComplete:function(id,name,responsejson){


                      // Once the uplaoad has been completed we need to store the location of the file on to the database

                      var imageName = name;
                      var uuid = responsejson['uuid'];

                      var imageLoc = uuid + "/" + imageName;

                      console.log(imageName);
                      console.log(uuid);


                      // Need to send the location to the setupdateprofile script

                      $.ajax({
                          url:"api/set_update_profile_image.php",
                          data:{imageLoc: imageLoc},
                          type: "POST",
                          success:function() {


                              // Once the profile pic has been uploaded we need to update the picture in the top right of
                              // profile settings.
                              $("#profilepic").html('<img width="100" height="100" class="img-rounded" ' + 'src="../vendor/fineuploader/php-traditional-server/files/' + imageLoc + '">');

                          }



                      });
                  },
                  onDeleteComplete: function(){

                      // When we delete the file from the server we also need to remove
                      // the file path which is stored in the database in the users table.

                      $.ajax({
                          url:"api/set_update_profile_image.php",
                          data:{removeprofilepic: true},
                          type: "POST",
                          success:function() {

                              // Change the profile image to a blank pic.
                              $("#profilepic").html('<img width="100" height="100" class="img-rounded"/>');

                          }



                      });

                  }


              }
          });



          $.ajax({
              url: "api/set_update_profile_image.php",
              data: {getprofilepic: true},
              type: "POST",
              success: function (data) {
                  jsonPhoto = JSON.parse(data);
                  // Grab first object
                  jsonPhoto = jsonPhoto[0];
                  if (jsonPhoto['name']) {

                      // we need to decode json data





                        //console.log(jsonPhoto);











                      $("#profilepic").html('<img width="100" height="100" class="img-rounded" ' + 'src="../vendor/fineuploader/php-traditional-server/files/' + jsonPhoto['uuid'] + '/' + jsonPhoto['name'] + '">');




                  } else {

                      // They haven't got a photo put default pic
                      $("#profilepic").html('<img width="100" height="100" class="img-rounded"/>');

                  }


              }


          });













      });


  </script>

  </body>

</html>
