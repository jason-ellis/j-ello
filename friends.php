<?php // friends.php
include_once 'header.php';

if (!loggedin) die();

// view user that is selected or logged in user if none selected
if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else                      $view = $user;

// This is how we will refer to the user whose friends we're viewing
if ($view == $user) {
    $name1 = $name2 = "Your";
    $name3 =          "You are";
}
else {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
}

echo "<div class='main'>";

showProfile($view); // Show the profile of the user whose friends we're viewing

$followers = array(); // Users who are following the subject
$following = array(); // Users the subject is following

// Find all users in DB that follow the subject user
$result = queryMysql("SELECT f.*,p.realname FROM friends f
    LEFT JOIN profiles p ON f.friend = p.user WHERE f.user='$view'");
$num    = mysql_num_rows($result);

// Populate followers 2d array with name and real name
for ($j = 0 ; $j < $num ; ++$j) {
    $row           = mysql_fetch_row($result);
    $followers[$row[1]] = $row[2];
}

// Find all users in DB that subject is following
$result = queryMysql("SELECT f.*,p.realname FROM friends f
  LEFT JOIN profiles p ON f.user = p.user WHERE f.friend='$view'");
$num    = mysql_num_rows($result);

// Populate following 2d array with name and real name
for ($j = 0 ; $j < $num ; ++$j) {
    $row            = mysql_fetch_row($result);
    $following [$row[0]] = $row[2];
}

// Separate mutual, following, and followers
$mutual    = array_intersect_key($followers, $following);
$followers = array_diff_key($followers, $mutual);
$following = array_diff_key($following, $mutual);
$friends   = FALSE;

// Display mutual relationships if any exist
if (sizeof($mutual)) {
    echo "<span class='subhead'>$name2 mutual friends</span><ul>";
    foreach($mutual as $friend => $realname) {
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
        if ($realname != '') echo " ($realname)";
    }
    echo "</ul>";
    $friends = TRUE;
}

// Display followers if any exist
if (sizeof($followers)) {
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach($followers as $friend => $realname) {
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
        if ($realname != '') echo " ($realname)";
    }
    echo "</ul>";
    $friends = TRUE;
}

// Display following if any exist
if (sizeof($following)) {
    echo "<span class='subhead'>$name3 following</span><ul>";
    foreach($following as $friend => $realname) {
        echo "<li><a href='members.php?view=$friend'>$friend</a>";
        if ($realname != '') echo " ($realname)";
    }
    echo "</ul>";
    $friends = TRUE;
}

// Display message if user has no followers/following
if (!$friends) echo "<br>You don't have any friends yet.<br><br>";

// View messages
echo "<a class='button' href='messages.php?view=$view'>" .
    "View $name2 messages</a>";
?>

</div><br>
</body>
</html>