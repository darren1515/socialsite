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

            // Delete a comment, all we need is the commentID

            deleteComment: function(e){

                var commentID = e.target.getAttribute('rel');

                // We need to update the state.comments



                for (var i = 0; i < this.state.comments.length; i++) {
                    if (this.state.comments[i].comment_id == commentID) {
                        var arr = this.state.comments;
                        arr.splice(i, 1);
                        this.setState({comments: arr});
                        break;
                    }
                }

                // We also need to send a request to the database.

                $.post("api/delete_comment.php",{commentID:commentID});


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
                                <strong>{commentObject.first_name} {commentObject.last_name}</strong> <span className="text-muted">{commentObject.time}<button type="button" style={commentDeleteButton} onClick={this.deleteComment} rel={commentObject.comment_id} className="btn btn-danger pull-right glyphicon glyphicon-trash"></button></span>
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


            // When Manage button is clicked in Photos view go to the manage view (2)

            manageButton: function(){

                this.setState({mode:2});
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
                                <h2><u>My Photos</u><button onClick={this.manageButton} type="button" className="btn btn-primary pull-right">Manage <span className="glyphicon glyphicon-th-large"></span></button></h2>


                            </div>
                            <div style={{marginTop:"30px"}}>

                                {this.state.photos.map(this.eachPhoto)}






                            </div>
                        </div>
                );

            },

            manageView:function(){

                return(

                       <section>
                        <div className="row">
                            <div id="fineuploader"></div>
                        </div>
                        <div className="row">
                            <button onClick={this.saveChangesButton} type="button" className="btn btn-success pull-right">Back</button>
                        </div>
                       </section>


                );

            },



            // on mount, fetch all products and stored them as this component's state
            componentDidMount: function() {
                this.serverRequest = $.get("api/read_all_photos.php", function (photos) {
                    console.log(photos);
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
                } else if (mode ==2) {
                    mainContent = this.manageView();
                } else {
                    mainContent = <PhotoWithComments key={this.state.lastPhotoID} photoID={this.state.lastPhotoID} imageLoc={this.state.lastImageLoc} backButton={this.backPhotoWithComments}/>;
                }

                return(

                <div className="well">
                    {mainContent}
                </div>
                );
            },


            // The below is run after the component is rendered.
            // This is needed as we need to get the upload drop box working.
            componentDidUpdate: function() {
                var self = this;
                if (this.state.mode == 2) {

                    var manualUploader = new qq.FineUploader({
                        element: document.getElementById("fineuploader"),
                        request: {
                            endpoint: "/socialsite/vendor/fineuploader/php-traditional-server/endpoint.php"
                        },
                        session: {
                            endpoint: "/socialsite/webpages/api/read_all_photos.php"
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
                        debug: true,
                        resume: {
                            enabled: true
                        },
                        retry: {
                            enableAuto: true,
                            showButton: true
                        },
                        validation: {
                            allowedExtensions: ['jpeg', 'jpg', 'png'],
                            itemLimit: 100,
                            sizeLimit: 10 * 1000000 // 10mb = 10 * 1024 bytes
                        },
                        callbacks: {
                            onComplete: function (id, name, responsejson) {


                                // Once the uplaoad has been completed we need to store the location of the file on to the database

                                var imageName = name;
                                var uuid = responsejson['uuid'];

                                var photoLoc = uuid + "/" + imageName;

                                //console.log(imageName);
                                //console.log(uuid);


                                // Now the photo has been stored we need to store the location (text) in the database

                                $.post({
                                    url: "api/add_photo.php",
                                    data: {photoLoc: photoLoc},
                                    type: "POST",
                                    success: function (data) {

                                        var photoData = JSON.parse(data);
                                        var Photo_id = photoData.Photo_id;

                                        //Make a copy what is currently in the posts state
                                        var arr = self.state.photos;

                                        // Create new object to add to the state.photos

                                        var newPhoto = {"Photo_id":Photo_id, "name":imageName, "uuid":uuid, "thumbnailUrl": "../vendor/fineuploader/php-traditional-server/files/" + photoLoc};

                                        arr.unshift(newPhoto);

                                        self.setState({photos:arr});


                                    }

                                }); // End of $post.


                                // Once the file has been uploaded we also need to update state




                            },// end of oncomplete
                            onDeleteComplete: function(id){



                                var imageName = this.getName(id);
                                var uuid = this.getUuid(id);

                                var photoLoc = uuid + "/" + imageName;

                                for (var i = 0; i < self.state.photos.length; i++) {
                                    if (self.state.photos[i].uuid == uuid && self.state.photos[i].name == imageName) {
                                        var arr = self.state.photos;
                                        arr.splice(i, 1);
                                        self.setState({photos: arr});
                                        break;
                                   }
                                }



                                $.post({
                                    url: "api/remove_photo.php",
                                    data: {photoLoc: photoLoc},
                                    type: "POST",
                                    success: function (data) {

                                        console.log(data);
                                    }

                                }); // End of $post.


                                // We now need to remove this 'image' from state.posts

                                // Its been deleted, rather then pull all posts again from the database loop through the
                                // posts state and pop the entry






                            }// end of onDeleteComplete
                        }// end of callbacks

                    }); // end of fine uploader







                    // We now need to check if there were any changes


                } // end of if block


            }// end of componentdidUpdate

        });



        var App = React.createClass({

            // This will contain all the blogPost components

            getInitialState: function() {
                return {
                    posts: []
                };
            },

            // on mount, fetch all products and stored them as this component's state
            componentDidMount: function() {
                this.serverRequest = $.get("api/read_all_posts.php", function (posts) {
                    this.setState({
                        posts: JSON.parse(posts)
                    });

                }.bind(this));

            },

            // on unmount, kill product fetching in case the request is still pending
            componentWillUnmount: function() {
                this.serverRequest.abort();
            },

            // This will be called when the user clicks the New post button
            // By default when a user creates a new post there will be no text.
            addNewPost: function(){
                $.get("api/create_new_post.php", function (newpost) {
                    //newpost is a javascript object with postID and latestTime

                    newpost = JSON.parse(newpost);

                    console.log(newpost);

                    //Make a copy what is currently in the posts state
                    var arr = this.state.posts;
                    // Add the new post info

                    arr.unshift(newpost);

                    this.setState({posts:arr});

                }.bind(this));


            },

            removePost: function(postID) {
                // Use ajax to send the data to delete_post


                $.post("api/delete_post.php",
                    {postID: postID},
                    function (success) {

                        if (success) {
                            // Its been deleted, rather then pull all posts again from the database loop through the
                            // posts state and pop the entry
                            for (var i = 0; i < this.state.posts.length; i++) {
                                if (this.state.posts[i].postID == postID) {
                                    var arr = this.state.posts;
                                    arr.splice(i, 1);
                                    this.setState({posts: arr});
                                    break;
                                }
                            }

                            // We now need to make a copy of state.post

                        }


                    }.bind(this));



            },

            // Create a function that will update a users post once they press the save button

            updatePost: function(postID, newText){


                $.post("api/update_post.php",
                    {postID: postID, newText: newText},
                    function (success) {

                        if (success) {
                            // The entry has been successfully updated. Find it in the
                            // posts and update it instead of requesting data from server.
                            for (var i = 0; i < this.state.posts.length; i++) {
                                if (this.state.posts[i].postID == postID) {
                                    var arr = this.state.posts;
                                    arr[i].text = newText;
                                    this.setState({posts: arr});
                                    break;
                                }
                            }

                            // We now need to make a copy of state.post

                        }

                    }.bind(this));




            },

            // Create a function that will run for every blog post

            eachPost: function(object,i) {

                return (<Blogpost key={object.postID} index={object.postID} date={object.latestTime}
                                  text={object.message} deletePost={this.removePost} updatePost={this.updatePost}/>);

            },

            render: function() {

                return(

                        <div>
                            <div className="row">

                                <button type="button" onClick={this.addNewPost} className="btn btn-primary pull-right">New Post <span className="glyphicon glyphicon-plus"></span></button>

                            </div>
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
                    editMode:false,
                    text:this.props.text,
                    lastEditDate:this.props.date
                }
            },

            edit: function () {
                this.setState({editMode:true});
            },

            save: function() {
                console.log('Update the comment.');
                this.props.updatePost(this.props.index,this.state.text);
            },

            // When deleting a blog post we need to use a method in the parent component

            delete: function (){
                console.log('Delete the comment.');
                this.props.deletePost(this.props.index);
            },

            cancelChanges : function(){
                //No updates will made to the database and we will leave editMode
                this.setState({editMode:false});
            },




            handleChange: function(event){

                if(this.state.editMode){
                    this.setState({text:event.target.value});
                }

            },

            renderEditButtons: function () {

                return (
                        <div>
                            <button type="button" onClick={this.cancelChanges} className="btn btn-warning"><span className="glyphicon glyphicon-refresh"></span> Undo</button>
                            <button type="button" onClick={this.save} className="btn btn-success"><span className="glyphicon glyphicon-floppy-disk"></span> Save </button>
                        </div>

                );

            },

            renderNonEditButtons: function () {
                return (
                        <div>
                            <button type="button" onClick={this.edit} className="btn btn-warning"><span className="glyphicon glyphicon-pencil"></span> Edit</button>
                            <button type="button" onClick={this.delete} className="btn btn-danger"><span className="glyphicon glyphicon-trash"></span> Delete</button>
                        </div>
                );


            },



            render: function () {

                const inEditMode = this.state.editMode;
                let buttons = null;

                if(inEditMode){
                    buttons = this.renderEditButtons();
                } else {
                    buttons = this.renderNonEditButtons();
                }



                return(
                        <div style={blogPostStyle}>
                            <p className="text-primary">Last update time: {this.state.lastEditDate}</p>
                            <div className="row" style={{margin:"5%"}}>
                                <textarea style={blogPostTextAreaStyle} onChange={this.handleChange} value={this.state.text}/>

                            </div>
                            <div className="row" style={{margin:"-2% 5%"}}>
                                {buttons}
                            </div>
                        </div>

                );

            }



        });


        ReactDOM.render(<App/>,document.getElementById('blogreact'));
        ReactDOM.render(<PhotoContainer/>,document.getElementById('photoContainer'));



    </script>

    <!--------------------------- REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE REACT CODE  ----------------------------------------->


    <!-- Begin page content -->
    <div class="container">

        <!-- The first row will consist of the page header/welcome message. -->
        <div class="row" style="padding-top: 50px">
            <div class="page-header">
                <h1><?php echo "Welcome: ". $_SESSION['First_name']?></h1>
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



  </body>
</html>
