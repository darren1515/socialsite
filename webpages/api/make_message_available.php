<?php
/**
 * Created by PhpStorm.
 * User: YUJialin
 * Date: 13/03/2017
 * Time: 01:18
 */

session_start();

// First need to include database connection which is in the functions folder

require_once '../../corePHP/functions.php';

// Data has been sent to this file through jquery/javascript
if(isset($_POST['group_id'])) {

    $groupid = $_POST['group_id'];

    $userID = $_SESSION['User_id'];

    echo '<table style="width:100%">';

    echo "<tr><td style='height:50px' > 
          <input type=\"text\" id=\"newmessage\" name=\"message\" placeholder=\"Please enter message here\"/>
          </td>
          <td>
          <button rel='" . $groupid . "' style='height:80%, margin-top:10%' type=\"button\" class=\"btn btn-success pull-right message_to_go \">
          Enter</button></td></tr>";
};