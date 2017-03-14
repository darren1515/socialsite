<?php

/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 13/03/2017
 * Time: 01:37
 */
class Comments
{
    private $conn;

    // This will be used to store who has made a new comment
    public $userID;
    public $photoID;



    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){

        // Create an associative array that will be returned to javascript in JSON format

        $ary = array();

        //select all data, We want newest posts to be at the top
        $query = "SELECT comment_id,First_name, Last_name,profilephoto, Text, comments.TimeStamp FROM comments INNER JOIN users ON comments.User_ID=users.User_id WHERE Photo_id = $this->photoID ORDER BY comments.TimeStamp DESC";

        $result = mysqli_query($this->conn,$query);
        // Loop over each row and put UUID and name so that it will work with fineuploader.

        while($row = $result->fetch_assoc()){

            // Loop over each row in the comments table, we want json data that we can use in react.

            $individualEntry = array();
            $individualEntry['comment_id'] = $row['comment_id'];
            $individualEntry['first_name'] = $row['First_name'];
            $individualEntry['last_name'] = $row['Last_name'];


            $profilephoto = trim($row['profilephoto']);

            if(!empty($profilephoto)){
                $individualEntry['profilephoto'] = "../vendor/fineuploader/php-traditional-server/files/" . $row['profilephoto'];
            } else {
                $individualEntry['profilephoto'] = "";
            }
            $individualEntry['text'] = $row['Text'];

            $individualEntry['time'] = $row['TimeStamp'];

            $ary[] = $individualEntry;

        }



        return json_encode($ary);
    }

    // The below method will be used to add a comment, the user_id, photoid and text will be needed

    public function addComment($text){


        // Will need to return a json object ob the newly created comment

        $myComment = array();

        // What we need

        /*
         * comment_id (database)
         * first_name (database)
         * last_name (database)
         * profilephoto (database)
         * text (javascript)
         * time (php)
         */

        // We first need to insert the comment into the comments table

        $query = "INSERT INTO comments (User_ID, Photo_ID, Text) VALUES ($this->userID, $this->photoID, '$text')";

        // Now insert the comment into the table
        mysqli_query($this->conn,$query);

        $comment_id = mysqli_insert_id($this->conn);

        $myComment['comment_id'] = $comment_id;

        // We now need to pull the first_name, last_name, profilephoto

        $query = "SELECT First_name, Last_name, profilephoto FROM users WHERE User_id=$this->userID";

        // This will pull back a single row.

        $result = mysqli_query($this->conn,$query);

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        $myComment['first_name'] = $row['First_name'];
        $myComment['last_name'] = $row['Last_name'];

        // Put the text

        $myComment['text'] = $text;


        //Put the time

        $myComment['time']=date('Y-m-d H:i:s');

        // The user may or may not have a profile picture

        $profilephoto = trim($row['profilephoto']);

            if(!empty($profilephoto)){
                $myComment['profilephoto'] = "../vendor/fineuploader/php-traditional-server/files/" . $row['profilephoto'];
            } else {
                $myComment['profilephoto'] = "";
            }

        return json_encode($myComment);

    }

    // Delete a comment, we will need the commentID

    public function deleteComment($commentID){


        $query = "DELETE FROM comments WHERE Comment_ID=$commentID LIMIT 1";

        if(mysqli_query($this->conn,$query) === TRUE){
            return True;
        } else {
            return False;
        }
    }

}