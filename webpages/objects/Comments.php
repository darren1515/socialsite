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
}