<?php // header.php
session_start();
echo "<!DOCTYPE html>\n<html><head><script src='js/OSC.js'></script>";
include 'functions.php';

$userstr = ' (Guest)';

if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
}
else $loggedin = FALSE;

echo "<title>$appname$userstr</title><link rel='stylesheet'" .
    "href='css/styles.css' type='text/css'>" .
    "</head><body><header class='appname'>$appname$userstr";

if ($loggedin) {
    echo "<ul class='menu'>" .
         "<li><a href='members.php?view=$user'>Home</a></li>" .
         "<li><a href='members.php'>Members</a></li>" .
         "<li><a href='friends.php'>Friends</a></li>" .
         "<li><a href='messages.php'>Messages</a></li>" .
         "<li><a href='profile.php'>Profile</a></li>" .
         "<li><a href='logout.php'>Log out</a></li></ul>" .
         "<div class='clearboth'></div>";
}
else {
    echo "<ul class='menu'>" .
         "<li><a href='index.php'>Home</a></li>" .
         "<li><a href='signup.php'>Sign up</a></li>" .
         "<li><a href='login.php'>Log in</a></li></ul>" .
        "<div class='clearboth'></div>" .
         "<span class='info' id='loggedin'>&#8658; You must be logged in to " .
         "view this page.</span>";
}
echo "</header>";
?>