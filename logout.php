<?php // logout.php
include_once 'header.php';

if (isset($_SESSION['user'])) {
    destroySession();
    echo "<script>window.location.replace('index.php');</script>";
    echo "<div class='main'>You have been logged out. Please " .
        "<a href='index.php'>click here</a> if you are not automatically redirected.";
}
else echo "<div class='main'><br>" .
    "You cannot log out because you are not logged in";

?>

<br><br>
</div>
</body>
</html>