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

// Need to run a function to pull the name of the users page we are viewing

$html = viewProfilePull($_GET['userID']);

#On every page we need a variable that will highlight the relevant page we are on
# in the nav bar

$pageTitle = 'viewprofile';

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


      <style>
          div.gallery {
              border: 1px solid #ccc;
          }

          div.gallery:hover {
              border: 1px solid #777;
          }

          div.gallery img {
              width: 100%;
              height: auto;

          }



          * {
              box-sizing: border-box;
          }

          .responsive {
              padding: 0 6px;
              float: left;
              width: 33.30%;
              margin-bottom: 10px;
          }



          .clearfix:after {
              content: "";
              display: table;
              clear: both;
          }
      </style>


      <!-- Photo Commment styles include -->

      <link href="css/photoCommentStyles.css" rel="stylesheet">

      <!-- Add in the styling for Posts within comment -->

      <link href="css/photoPostStyles.css" rel="stylesheet">


      <!-- Include fine-uploader files -->
      <link href="../fine-uploader/fine-uploader-gallery.min.css" rel="stylesheet">
      <script src="../fine-uploader/fine-uploader.min.js"></script>



      <!-- Script to get variables from the url http://papermashup.com/read-url-get-variables-withjavascript/ -->

      <script>

          function getUrlVars() {
              var vars = {};
              var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                  vars[key] = value;
              });
              return vars;
          }

      </script>

  </head>

  <body>

    <!-- Place the nav bar here -->
    <?php require("includes/nav.php"); ?>

    <!--------------------------- REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE  ----------------------------------------->

    <script type="text/babel">



        var blogPostStyle = {

            background:"#f5f5f5",
            margin:"20px",
            width:"100%",
            height:"100%",
            padding:"20px"

        };

        var blogPostTextAreaStyle = {
            resize:"none",
            width:"100%",
            height:"100px"
        };

        // Styling for each user photo

        var individualPhotoStyling = {
            width:"33.330%"
        };

        // Styling for photo container

        var commentDeleteButton = {
            marginTop:"-7px"


        };

        // Create a component that will represent the photoContainer

        var PhotoWithComments = React.createClass({


            getInitialState: function() {
                return {
                    comments:[]
                };
            },

            // Once the component is created, pull the comments.
            componentDidMount: function() {
                var photoID = this.props.photoID;
                this.serverRequest = $.post("api/read_all_comments.php", {photoID: photoID}, function (comments) {


                    console.log(comments);

                    this.setState({
                        comments: JSON.parse(comments)
                    });

                }.bind(this));

            },

            // The below method gets run the user clicks the post button

            postComment:function(){

                // We need to grab the text in the text area somehow.


                var userInputtedText = this.refs.commentText.value;
                var photoID = this.props.photoID;

                if(userInputtedText.trim() == ""){
                    return;
                }

                $.post("api/create_new_comment.php", {photoID: photoID, userInputtedText:userInputtedText}, function (commentObject) {


                    commentObject = JSON.parse(commentObject);
                    //Make a copy what is currently in the posts state
                    var arr = this.state.comments;
                    // Add the new comment Object

                    arr.unshift(commentObject);

                    this.setState({comments:arr});


                    // Then we need to clear all text in the text area

                    this.refs.commentText.value = "";

                }.bind(this));



            },


            renderPhotoPost: function(){

                return (

                        <div className="widget-area no-padding blank">
                            <div className="status-upload">
                                <form>
                                    <textarea ref='commentText' placeholder="Say something nice about the above photo?" ></textarea>

                                    <button type="button" onClick={this.postComment} className="btn btn-success green"><i className="fa fa-share"></i> Post</button>
                                </form>
                            </div>
                        </div>

                );

            },




            backButton: function(){
                // Calls the parent components backButton function to change the state in the parent.
                this.props.backButton();
            },

            eachComment: function(commentObject,index){

                // Deal with situation if the user has no profile

                let profileimage = null;

                if(commentObject.profilephoto != ""){
                    profileimage = <img className="img-responsive user-photo" src={commentObject.profilephoto}/>
                } else {
                    profileimage = <img className="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"/>
                }


                return(
                <div key={commentObject.comment_id} className="row" style={{"width":"100%","marginTop":"30px"}}>
                    <div className="col-md-2">
                        <div className="thumbnail">
                            {profileimage}
                        </div>
                    </div>

                    <div className="col-md-10">
                        <div className="panel panel-default">
                            <div className="panel-heading">
                                <strong>{commentObject.first_name} {commentObject.last_name}</strong> <span className="text-muted">{commentObject.time}</span>
                            </div>
                            <div className="panel-body">
                                {commentObject.text}
                            </div>
                        </div>
                    </div>

                </div>);


            },


            // Add a part at the bottom of photos section to add a new comment.
            // We have the userID from the session.

            // Once the comment is added we need it to be added to the list.

            render:function(){

                // We need to call the renderPhotopost method to obtain the html code behind
                // what a post box will look like.

                let commentPost = this.renderPhotoPost();


                return (

                    <div>
                        <div className="row">
                            <div className="col-md-offset-2 col-md-8">
                                <button type="button" onClick={this.backButton} className="btn btn-primary pull-left" style={{"marginBottom":"10px"}}>Back</button>
                            <img src={this.props.imageLoc} className="img-rounded img-responsive" height="200" />
                            </div>
                        </div>

                        {this.state.comments.map(this.eachComment)}

                        <div className="row">

                            {commentPost}

                        </div>

                    </div>

                );

            }

        });



        var PhotoContainer = React.createClass({

            // There will be 3 views for this component, Photos view (1) default, manage(2) and Comments (3)
            // lastPhotoID will be used to store the photo the user clicks on and wants to see comments for.


            getInitialState: function() {
                return {
                    mode: 1,
                    photos:[],
                    lastPhotoID: 0,
                    lastImageLoc:""
                };
            },



            // When the save button is clicked within the manage(2) view go back to photos view (1)

            saveChangesButton: function (){
                this.setState({mode:1});
            },

            // This function will be passed through into PhotoWithComments and allow them to go back to all photos

            backPhotoWithComments: function(){
                this.setState({mode:1});
            },

            eachPhoto:function(photoObject,index)

            {
                // On Click capture the photoID and the location of the image.
                return(<img onClick={this.viewPhoto.bind(this,photoObject.Photo_id,photoObject.thumbnailUrl)} key={photoObject.Photo_id} style={individualPhotoStyling} src={photoObject.thumbnailUrl} className="img-thumbnail"/>);

            },

            // Testing the clicking of an image

            viewPhoto: function(photoID,imageLoc){
                // Need to change the state of lastphotoviewed
                this.setState({lastPhotoID:photoID,lastImageLoc:imageLoc, mode:3});

            },





            photosView: function(){

                return (


                        <div>

                            <div>
                                <h2><u>View Photos</u></h2>


                            </div>
                            <div style={{marginTop:"30px"}}>

                                {this.state.photos.map(this.eachPhoto)}






                            </div>
                        </div>
                );

            },




            // on mount, fetch all products and stored them as this component's state
            // Based on the variable in the URL.
            componentDidMount: function() {
                this.serverRequest = $.get("api/read_all_photos_profile.php", {profilePageID:this.props.profilePageID}, function (photos) {

                    this.setState({
                        photos: JSON.parse(photos)
                    });

                }.bind(this));

            },

            // on unmount, kill product fetching in case the request is still pending
            componentWillUnmount: function() {
                this.serverRequest.abort();
            },



            render: function() {

                const mode = this.state.mode;
                // mainContent will contain html code for one of the 3 modes
                let mainContent = null;

                if(mode == 1){
                    mainContent = this.photosView();
                }
                else {
                    mainContent = <PhotoWithComments key={this.state.lastPhotoID} photoID={this.state.lastPhotoID} imageLoc={this.state.lastImageLoc} backButton={this.backPhotoWithComments}/>;
                }

                return(

                <div className="well">
                    {mainContent}
                </div>
                );
            },


        });



        var App = React.createClass({

            // Grab the userID from the URL of who's page we are on



            // This will contain all the blogPost components

            getInitialState: function() {
                return {
                    posts: []
                };
            },

            // on mount, fetch all products and stored them as this component's state
            componentDidMount: function() {
                this.serverRequest = $.get("api/read_all_posts_profile.php", {profilePageID:this.props.profilePageID}, function (posts) {
                    this.setState({
                        posts: JSON.parse(posts)
                    });

                }.bind(this));

            },

            // on unmount, kill product fetching in case the request is still pending
            componentWillUnmount: function() {
                this.serverRequest.abort();
            },



            // Create a function that will run for every blog post

            eachPost: function(object,i) {

                return (<Blogpost key={object.postID} index={object.postID} date={object.latestTime}
                                  text={object.message}/>);

            },

            render: function() {

                return(

                        <div>
                            <div className="row">
                                {/*Now need to loop over each post, and create a corresponding blog post component*/}
                                {this.state.posts.map(this.eachPost)}




                            </div>

                        </div>

                );

            }


        });

        var Blogpost = React.createClass({

            /* When the post is in edit mode the buttons will be undo and save When the post is not in edit mode the buttons will be edit and delete*/

            getInitialState: function () {
                /*We initially need to pull all the blog posts for the given user.
                * To do this we need the userID*/
                return {
                    text:this.props.text,
                    lastEditDate:this.props.date
                }
            },





            render: function () {


                return(
                        <div style={blogPostStyle}>
                            <p className="text-primary">Last update time: {this.state.lastEditDate}</p>
                            <div className="row" style={{margin:"5%"}}>
                                <textarea style={blogPostTextAreaStyle} onChange={this.handleChange} value={this.state.text}/>

                            </div>
                        </div>

                );

            }



        });

        // We will pass the userID of the profile page we are on into the component as props.
        var whosProfile = getUrlVars()["userID"];

        ReactDOM.render(<App profilePageID={whosProfile}/>,document.getElementById('blogreact'));
        ReactDOM.render(<PhotoContainer profilePageID={whosProfile}/>,document.getElementById('photoContainer'));



    </script>

    <!--------------------------- REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE  ----------------------------------------->


    <!-- Begin page content -->
    <div class="container">

        <!-- The first row will consist of the page header/welcome message. -->
        <div class="row" style="padding-top: 50px">
            <div class="page-header">
                <h1><?php echo $html ?></h1>
            </div>
        </div>

        <div class="row">

            <div class="col-md-5" id="photoContainer" >

            </div>

            <div class="col-md-7">
                <p class="lead">Use this page to manage your blog. You can create, edit, update and delete your posts below</p>
                <div id="blogreact" style="width: 100%;"></div>

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

  <script>

      $(document).ready(function(){

          var first = getUrlVars()["userID"];
          console.log(first);

      });


  </script>



  </body>
</html>
