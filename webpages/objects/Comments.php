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

    public function readAll($photoID){

        // Create an associative array that will be returned to javascript in JSON format

        $ary = array();

        //select all data, We want newest posts to be at the top
        $query = "SELECT * FROM comments WHERE Photo_id = $this->photoID ORDER BY Timestamp DESC";

        $result = mysqli_query($this->conn,$query);
        // Loop over each row and put UUID and name so that it will work with fineuploader.

        while($row = $result->fetch_assoc()){

            // Loop over each row in the comments table

            $individualEntry = array();
            $individualEntry['Photo_id'] = $row['Photo_id'];
            $individualEntry['name'] = $name;
            $individualEntry['uuid'] = $uuid;
            $individualEntry['thumbnailUrl'] = $thumbnailUrl;

            $ary[] = $individualEntry;

        }



        return json_encode($ary);
    }
}