<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 10/03/2017
 * Time: 02:10
 */

DEFINE("USERNAME", "bf54438d8bfa8c");
DEFINE("SERVERPASSWORD", "d5333f74");
DEFINE('SERVERNAME', 'eu-cdbr-azure-west-d.cloudapp.net');
DEFINE("DATABASENAME", "4network");
DEFINE("DSN",'mysql:host=' .SERVERNAME. ';dbname='.DATABASENAME);


}
$con = mysqli_connect(SERVERNAME,USERNAME,SERVERPASSWORD,DATABASENAME);

// Check connection
if (mysqli_connect_errno())
{
    die("Failed to connect to MySQL: " . mysqli_connect_error()) ;
} else{
    return $con;

}