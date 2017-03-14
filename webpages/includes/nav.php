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
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
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










</script>
