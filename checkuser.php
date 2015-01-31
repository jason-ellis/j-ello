<?php // checkuser.php
include_once 'functions.php';

// Check to see if user name is available
if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);

    if (mysql_num_rows(queryMysql("SELECT * FROM members WHERE user='$user'")))
        echo "<span class='taken'>&nbsp;&#2718; " .
             "Sorry, this username is taken</span>";
    else echo "<span class='available'>&nbsp;&#x2714; " .
              "This username is available</span>";
}
?>