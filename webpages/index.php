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

                                <button type="button" onClick={this.addNewPost} className="btn btn-primary">New Post <span className="glyphicon glyphicon-plus"></span></button>

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
