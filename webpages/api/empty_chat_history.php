<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 13/03/2017
 * Time: 22:01
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['empty'])) {


        echo "<tr><td></td></tr>";

};









