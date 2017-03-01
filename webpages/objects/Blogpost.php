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


            // insert query
            $query = "INSERT INTO $this->table_name (userID, latestTime) VALUES ('$this->userID','$latestTime')";

            $result = mysqli_query($this->conn,$query);



            // Execute the query
            if($result = mysqli_query($this->conn,$query)){
                return true;
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

        //select all data
        $query = "SELECT postID, message, latestTime FROM posts WHERE userID = '$this->userID'";

        $result = mysqli_query($this->conn,$query);

        // Fetch all
        $allBlogPosts = mysqli_fetch_all($result,MYSQLI_ASSOC);

        return json_encode($allBlogPosts);
    }



}