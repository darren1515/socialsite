<?php
/**
 * Created by PhpStorm.
 * User: darrenlahr
 * Date: 12/02/2017
 * Time: 18:32
 */




require_once($_SERVER['DOCUMENT_ROOT']. "/socialSite/corePHP/functions.php");

log_me_out();

$ip = gethostbyname(gethostname());



header("Location:". "http://".$ip.":8888/socialSite/index.php?alertType=3" ."&alertMessage=You have been logged out");




