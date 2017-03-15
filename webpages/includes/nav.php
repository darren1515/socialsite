<!-- This will be included on every page once the users logged in, php variable called $pageTitle needs
 to be defined at the top.
 -->

<style>


    /*
    Add styling to the results of a live friends search
    we want it to overlap the nav bar
    */

    #livesearch {
        background-color:white;
        color:blue;
        position:absolute;
        z-index:900;
        width:75%;
        border-width: 2px;
    }


</style>


<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">4 Network</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li <?php if($pageTitle == "index") echo 'class="active"'?>><a href="index.php">Home</a></li>
                <li <?php if($pageTitle == "profileSettings") echo 'class="active"'?>><a href="profileSettings.php">Profile Settings</a></li>
                <li <?php if($pageTitle == "friendsRecommendations") echo 'class="active"'?>><a href="friendsRecommendations.php">Friends Recommendations</a></li>
                <li><a href="chatroom.php">ChatRoom</a></li>
                <li class="dropdown droplist_all">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">

                        <!-- new group -->

                        <li><a data-toggle="modal" data-target="#myModal_newgroup">Create New Group</a></li>
                        <li><a data-toggle="modal" data-target="#myModal_manage_group" class="open_group_manage">Manage Group</a></li>
                    </ul>
                </li>

                <li><a href="../index.php" class="logOutLink">Logout</a></li>


                    <!-- This will be used for searching for friends -->
                <div class="col-md-3 pull-right" id="friendSearchContainer">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" size="200" class="form-control" id="friendSearchBox" placeholder="Search For Friends" autocomplete="off">
                        </div>
                        <div id="livesearch" style="background-color:white;width:400px;margin-left:-100px;">

                        </div>

                    </form>
                </div>
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- Place the search bar  -->

<!-- Modal -->


<!-- CREATE A GROUP -->
<div id="myModal_newgroup" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New Group</h4>
            </div>

            <!-- for new group name -->
            <div class="form-createnewgroup">
                <label for="form-createnewgroup">Get a group name:</label>
                <input type="text" class="form-control new_group_name" id="new_groupname">
            </div>

            <!-- friend search -->
            <div class="input-friendsearch">
                <input type="text" size="75" class="form-control search_box" id="newgroup_friendSearchBox" placeholder="Search For Friends">
            </div>
            <div id="friend_livesearch" style="background-color:white">
            </div>

            <!-- group member -->
            <div class="group_list">
                <label for="form-groupmember">Group Member:</label>


                <table class="table table-hover groupmemberlist">


                </table>


            </div>

            <!-- button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default Confirm_group" data-dismiss="modal">Confirm</button>
                <button type="button" class="btn btn-default Cancel_all" data-dismiss="modal">Cancel</button>
            </div>


        </div>


    </div>


</div>

<!-- MANAGE GROUP -->

<div id="myModal_manage_group" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Manage Groups</h4>
            </div>

            <!-- for group created by the user -->
            <div class="group_manager">
                <label for="form-group_manager">Created Groups</label>
                <table class="table table-hover created_group_list">

                </table>
            </div>

            <!-- button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default Finish_edit" data-dismiss="modal">Finish Group Edit</button>
            </div>

        </div>
    </div>
</div>





<!-- ----------------    JAVASCRIPT CODE THAT MAKES THE LIVE SEARCH WORK -----------------   -->

<script>

    $("#friendSearchBox").keyup(function(event){
        // Pass through the event, to access whats in the text box.
       var text = event.target.value.trim();


       //If the text box contains any text we want to run a query

        if(text !== ""){

            $.ajax({
                url:"api/friends_live_search.php",
                data:{friend_search: text},
                type: "POST",
                success:function(returnedData) {

                    // returnedData will be equal to what was echoed in friends_live_search.php

                    // Put the returnedData into the livesearch div.
                    $("#livesearch").html(returnedData);

                }



            });




        } else {
            $("#livesearch").empty();
        }


    });

    // Code to get add friends button working
    // Need to bind it to a static ancestor

    $("#livesearch").on('click','.addfriend',function(){

        // We first need to grab the userID

        var friendID = $(this).attr('rel');

        // We then need to update the database

        $.post("api/send_friend_request.php", {friendID:friendID}, function(){

            //Once complete need to change the button to say friend request sent.
            // We want $this to refer to the button.

            $(this).attr('class','btn btn-default pull-right');
            $(this).html("Request Sent");
        }.bind(this));



        console.log($(this).attr('rel'));

        console.log('add a friend');
    });

    /*
     JIALIN
     */

    $("#newgroup_friendSearchBox").keyup(function(event){
        // Pass through the event, to access whats in the text box.
        var text = event.target.value.trim();


        //If the text box contains any text we want to run a query

        if(text !== ""){

            $.ajax({
                url:"api/group_live_search.php",
                data:{group_search: text},
                type: "POST",
                success:function(returnedData) {

                    // returnedData will be equal to what was echoed in friends_live_search.php

                    // Put the returnedData into the livesearch div.
                    $("#friend_livesearch").html(returnedData);

                }



            });




        } else {
            $("#friend_livesearch").empty();
        }


    });

    /*
     JIALIN
     */


    $("#myModal_newgroup").on('click','.AddToGroup', function(){
        var userid = $(this).attr('rel');
        var name = $(this).parent().html();

        //console.log(userid);
        //console.log(name);
        // extract the name
        name = name.slice(0, name.indexOf("<button"));
        // button with name and delete
        // the ref for each button is the userid
        var $array_gl = [];
        $array_gl = $array_gl.push(userid);
        $(".groupmemberlist").append("<tr><td>" + name + "</td> <td><button class='btn btn-danger pull-right DeleteFromGroup' rel=" + userid + ">Delete</button> </td></tr> ");
    });


    /*
     JIALIN
     */

    $("#myModal_newgroup").on('click','.DeleteFromGroup', function(){
        var del_id = $(this).attr('rel');
        console.log(del_id);
        $(this).parent().parent().fadeOut().remove();

    });

    /*
     confirm group
     1. create a new group and get group id back
     2. put group id and user id together
     */

    $('#myModal_newgroup').on('click','.Confirm_group',function () {
        // save the group name
        var groupname = $("#new_groupname").val();


        if (groupname !== "") {
            var array_gl = [];

            $('.groupmemberlist > tr').each(function () {
                var id = $(this).children().find(".DeleteFromGroup").attr('rel');

                //console.log(groupname);
                // put id in this group

                array_gl.push(id);
            });

            // array_gl is known by now
            // create a group and get id back

            $.ajax({
                url: "api/create_new_group.php",
                data:{create_new_group: groupname},
                type: "POST",
                success: function (returnedData) {
                    // return data with the lastgroup id created
                    // returnedData in success

                    var groupid = returnedData;

                    /*
                     get group table work and this can auto added to group relation table
                     get all member to the group relation table
                     the return data should be group_id
                     */

                    /*
                     run another ajax on completing a ajax
                     */

                    array_gl.forEach(function(element) {

                        //var gm = parseInt($(this).val());
                        var g_id = element;

                        $.ajax({
                            url: "api/add_to_group.php",
                            data:{group: groupid, member: g_id},
                            type: "POST",
                            success: function (returnedData) {
                                // return data with the lastgroup id created
                                //alert('it works');
                                //$last_groupid = returnedData;

                                // now the chat group is created and all members are added to the group
                                // we now add a message to chat table for this group

                                // another ajax command in between
                            }
                        });

                    });

                    // add one message to the group to avoid error

                    $.ajax({
                        url:"api/welcome_message.php",
                        data:{welcome_message: groupid},
                        type: "POST",
                        success:function(returnedData) {
                            // return alert saying the chat is ready
                            //alert('the chat is ready and all groups can be found in ChatRoom tab');
                            //$("#friend_livesearch").html(returnedData);
                            alert(returnedData);
                        }
                    });

                }
            });

        } else {
            alert('lol');
        }

        // all sucessmove delete data
        $('.groupmemberlist').empty();



    });


    /*
     Delete everymember in the group
     */

    $('#myModal_newgroup').on('click','.Cancel_all',function () {
        $('.groupmemberlist').empty();
    });

    /*
     FOR MANAGE GROUP
     */
    $(".droplist_all").on('click','.open_group_manage',function () {
        // generate all groups linked with the user

        // group created by the user
        $.ajax({
            url: "api/group_by_user.php",
            data:{group_by_user:true},
            type: "POST",
            success: function (returnedData) {
                $(".created_group_list").html(returnedData);
            }
        });

    });

    $(".created_group_list").on('click','.Delete_the_group',function () {
        var group_id = $(this).attr('rel');
        if (confirm('Are you sure you want to delete the group?')) {

            $(".created_group_list").empty();

            $.ajax({
                url: "api/delete_group.php",
                data:{group:group_id},
                type: "POST",
                success: function (returnedData) {
                    $(".created_group_list").html(returnedData);
                }
            });


            // Save it!
        } else {
            // Do nothing!
        }

    });










</script>
