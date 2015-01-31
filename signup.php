<?php // signup.php
include_once 'header.php';

echo <<<_END
<script>
// Hide "you must be logged in..." message
document.getElementById('loggedin').style.display = 'none';

function checkUser(user) {
    if (user.value == '') {
        O('info').innerHTML = '';
        return;
    }

    params  = "user=" + user.value;
    request = new ajaxRequest();
    request.open("POST", "checkuser.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.setRequestHeader("Content-length", params.length);
    request.setRequestHeader("Connection", "close");

    request.onreadystatechange = function() {
        if (this.readyState == 4)
            if (this.status == 200)
                if (this.responseText != null)
                    O('info').innerHTML = this.responseText;
        };
    request.send(params);
}

function ajaxRequest() {
    try { var request = new XMLHttpRequest() }
    catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
            try { request = new ActiveXObject("Microsoft.XMLHTTP") }
            catch(e3) {
                request = false;
            }
        }
    }
    return request;
}
</script>
<div class='main'><h3>Please enter your details to sign up</h3>
_END;

$error = $user = $pass = $pass2 = $token = "";

if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user'])) {
    $user  = sanitizeString($_POST['user']);
    $pass  = sanitizeString($_POST['pass']);
    $pass2 = sanitizeString($_POST['pass2']);
    $token = password_hash("$pass", PASSWORD_BCRYPT); // Hash and salt passwords

    if ($user == "" || $pass == "")
        $error = "<span class='error'>Not all fields were entered</span><br><br>";
    else {
        if (mysql_num_rows(queryMysql("SELECT * FROM members WHERE user='$user'")))
            $error = "<span class='error'>That username already exists</span><br><br>";
        elseif ($pass != $pass2) {
            $error = "<span class='error'>The passwords you entered do not match</span><br><br>";
        }
        else {
            queryMysql("INSERT INTO members VALUES('$user', '$token')");
            die("<h4>Account created</h4>Please <a href='login.php'>Log in</a>.<br><br>");
        }
    }
}

echo <<<_END
<form method='post' action='signup.php'>
    $error
    <span class='fieldname'>Username</span>
    <input type='text' maxlength='16' name='user' value='$user' onBlur='checkUser(this)' autofocus required>
    <span id='info'></span><br>
    <span class='fieldname'>Password</span>
    <input type='password' maxlength='16' name='pass' value='$pass' required><br>
    <span class='fieldname'>Confirm Password</span>
    <input type='password' maxlength='16' name='pass2' required><br>
_END;
?>

    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Sign up'>
</form>
</div>
<br>
</body>
</html>