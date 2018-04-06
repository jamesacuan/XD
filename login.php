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
    if ($user_exists && password_verify($_POST['password'], $user->password)){
    
        // if it is, set the session value to true
        $_SESSION['logged_in'] = true;
        $_SESSION['userid'] = $user->userid;
        $_SESSION['role'] = $user->role;
        /*
        $_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
        $_SESSION['lastname'] = $user->lastname;
        */

        // if access level is 'Admin', redirect to admin section
        /*if($user->access_level=='Admin'){
            header("Location: {$home_url}admin/index.php?action=login_success");
        }*/
        header("Location: {$home_url}index.php");

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
 
// login form html will be here
// include page header HTML
include_once "template-header.php";
 
echo "<div class='col-sm-6 col-md-4 col-md-offset-4'>";
 
    // alert messages will be here
 
    // actual HTML login form
    echo "<div class='account-wall'>";
        echo "<div id='my-tab-content' class='tab-content'>";
            echo "<div class='tab-pane active' id='login'>";
                echo "<img class='profile-img' src='images/login-icon.png'>";
                echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                    echo "<input type='text' name='username' class='form-control' placeholder='Username' required autofocus />";
                    echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
                    echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
                echo "</form>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
 
echo "</div>";
 
// footer HTML and JavaScript codes
include_once "template-footer.php";
?>

<!--<form class="form-signin">
    <img class="mb-4" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
    <label>
        <input type="checkbox" value="remember-me"> Remember me
    </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>

-->