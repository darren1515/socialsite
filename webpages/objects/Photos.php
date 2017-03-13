<?php

/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 12/03/2017
 * Time: 17:35
 */
class Photos
{
    private $conn;

    // object properties. userID will be obtained from the session variable.
    public $userID;



    public function __construct($db){
        $this->conn = $db;
    }

    // The below will pull all the photos a given user has uploaded

    public function readAll(){

        // Create an associative array that will be returned to javascript in JSON format

        $ary = array();

        //select all data, We want newest posts to be at the top
        $query = "SELECT Photo_id,location FROM photos WHERE User_id = $this->userID ORDER BY Timestamp DESC";

        $result = mysqli_query($this->conn,$query);
        // Loop over each row and put UUID and name so that it will work with fineuploader.

        while($row = $result->fetch_assoc()){



            $entry = explode("/", $row['location']);

            $uuid = $entry[0];
            $name = $entry[1];

            $thumbnailUrl = "../vendor/fineuploader/php-traditional-server/files/" .$uuid.  "/" .$name;

            $individualEntry = array();
            $individualEntry['Photo_id'] = $row['Photo_id'];
            $individualEntry['name'] = $name;
            $individualEntry['uuid'] = $uuid;
            $individualEntry['thumbnailUrl'] = $thumbnailUrl;

            $ary[] = $individualEntry;

        }



        return json_encode($ary);
    }

    // Once fineuploader uploads the photo to the website a location is returned
    // This location then needs to be added to the the photos table

    public function addPhoto($location){

        $query = "INSERT INTO photos (User_id,location) VALUES ($this->userID, '$location')";
        $result = mysqli_query($this->conn,$query);

        $Photo_id = mysqli_insert_id($this->conn);

        $info = array("Photo_id"=>$Photo_id);

        return json_encode($info);



    }

    // Once a file has been deleted from the server we also need to remove it from the photos table.
    //. To do this we will need the UUID/NAME and the USERID

    public function removePhoto($location){

        $query = "DELETE FROM photos WHERE User_id = $this->userID AND location = '$location'";

        mysqli_query($this->conn,$query);

        return true;

    }


}