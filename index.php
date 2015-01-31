<?php // index.php
include_once 'header.php';

echo "<div class='main'>Welcome to $appname,";

if ($loggedin) echo " $user, you are logged in.";
else           echo ' please sign up and/or log in to join.';

?>

</div></body></html>