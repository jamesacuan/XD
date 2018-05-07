<?php
include_once "config/core.php";
$page_title = "Login";
$require_login=false;
include_once "login_check.php";
// default to false
$access_denied=false;
 
if($_POST){
    include_once "config/database.php";
    include_once "objects/user.php";
    
    $database = new Database();
    $db = $database->getConnection();
    
    $user = new User($db);

    $user->username=$_POST['username'];
    $user_exists = $user->userExists();

    /*if hashing is applied to password, use this*/
    /*if ($user_exists && password_verify($_POST['password'], $user->password)){*/
    if ($user_exists && $_POST['password'] == $user->password){

        $_SESSION['logged_in'] = true;
        $_SESSION['userid']    = $user->id;
        $_SESSION['nickname']  = $user->nickname;
        $_SESSION['username']  = $user->username;
        $_SESSION['role']      = $user->role;
        $_SESSION['admin']     = $user->isAdmin;
 
         /*
        $_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
        $_SESSION['lastname'] = $user->lastname;
        */

        // if access level is 'Admin', redirect to admin section
        /*if($user->access_level=='Admin'){
            header("Location: {$home_url}admin/index.php?action=login_success");
        }*/
        header("Location: {$home_url}index.php?action=login_success");

        // else, redirect only to 'Customer' section
        /*else{
            header("Location: {$home_url}index.php?action=login_success");
        }*/
    }
    
    // if username does not exist or password is wrong
    else{
        $access_denied=true;
    }
}

include_once "template/header.php";

echo "<div class='col-sm-6 col-md-4 col-md-offset-4'>";

if($access_denied){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Access Denied.<br /><br />Your username or password maybe incorrect </div>";
}
     echo "<div class='account-wall'>";
        echo "<div id='my-tab-content' class='tab-content'>";
            echo "<div class='tab-pane active' id='login'>";
                echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                    echo "<input type='text' name='username' class='form-control' placeholder='Username' required autofocus />";
                    echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
                    echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
                echo "</form>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
echo "</div>";

include_once "template/footer.php";
?>