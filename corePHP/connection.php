<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 07/02/2017
 * Time: 15:28
 * The connectToDatabase function will create a connection object
 */

function connectToDatabase(){

    DEFINE("USERNAME", "root");
    DEFINE("SERVERPASSWORD", "7AEA61437E");
    DEFINE('SERVERNAME', 'localhost');
    DEFINE("DATABASENAME", "customertraining");
    DEFINE("DSN",'mysql:host=' .SERVERNAME. ';dbname='.DATABASENAME);

    $con = mysqli_connect(SERVERNAME,USERNAME,SERVERPASSWORD,DATABASE);

// Check connection
    if (mysqli_connect_errno())
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error()) ;
    } else{
        return $con;
    }

}