<?php // functions.php
include 'config.php';

// Create tables during setup process in setup.php
function createTable($name, $query) {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

// Query MySQL database or die and display error
function queryMysql($query) {
    $result = mysql_query($query) or die(mysql_error());
    return $result;
}

function destroySession() {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var) {
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return mysql_real_escape_string($var);
}

function showProfile($user) {
    if (file_exists("img/profile/$user.jpg")) echo "<img src='img/profile/$user.jpg' align='left'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if (mysql_num_rows($result)) {
        $row = mysql_fetch_row($result);
        if($row[2]) echo "Name: " . stripslashes($row[2]) . "<br>";
        echo "About: " . stripslashes($row[1]) . "<br clear='left'><br>";
    }
}
?>