<?php

/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 01/03/2017
 * Time: 18:54
 */
class Blogpost
{
    // database connection and table name
    private $conn;
    private $table_name = "posts";

    // object properties. userID will be obtained from the session variable.
    public $postID;
    public $userID;
    public $message;



    public function __construct($db){
        $this->conn = $db;
    }

    public function createPost(){
        try{

            // Escape any dodgy characters
            // userID is not accessed by user so do not need to clean it.


            //$message=htmlspecialchars(strip_tags($this->message));
            $latestTime=date('Y-m-d H:i:s');


            // insert query, by default when a user creates a new post it is blank.
            $query = "INSERT INTO $this->table_name (userID, latestTime) VALUES ('$this->userID','$latestTime')";

            $result = mysqli_query($this->conn,$query);



            // Execute the query and return the latest postID, and the $latestTime
            if($result){

                $post_id = mysqli_insert_id($this->conn);
                $info = array("postID"=>$post_id, 'latestTime'=>$latestTime, "message"=>'');

                return json_encode($info);

            }else{


                return false;
            }

            // Close the connection

        }

            // show error if any
        catch(Exception $e){

            die('ERROR: ' . $e->getMessage());
        }
    }


    // Add a method that will read all the blog posts for the given user.

    public function readAll(){

        //select all data, We want newest posts to be at the top
        $query = "SELECT postID, message, latestTime FROM posts WHERE userID = '$this->userID' ORDER BY latestTime DESC";

        $result = mysqli_query($this->conn,$query);

        // Fetch all
        $allBlogPosts = mysqli_fetch_all($result,MYSQLI_ASSOC);

        return json_encode($allBlogPosts);
    }

    // Remove a comment, all it requires is the userID and postID which is the key.

    public function deletePost($postID){

        //Delete query, we need to ensure that we only remove one record and condition also on userID
        $postID=htmlspecialchars(strip_tags($postID));
        $query = "DELETE FROM $this->table_name WHERE postID=$postID and userID=$this->userID LIMIT 1";

        if(mysqli_query($this->conn,$query) === TRUE){
            return True;
        } else {
            return False;
        }

    }

    // To update a comment we need the userID, postID and the text
    public function updatePost($postID,$newText) {



        $query = "UPDATE $this->table_name SET message='$newText' WHERE postID=$postID and userID=$this->userID LIMIT 1";

        if(mysqli_query($this->conn,$query) === TRUE){
            return True;
        } else {
            return False;
        }

    }


}