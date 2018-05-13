<?php
include_once "config/core.php";
$page_title = "Login";
$require_login=false;

include_once "template/login_check.php";
$access_denied=false;

if(isset($_GET['goto'])) $_SESSION['goto'] = $_GET['goto'];

if($_POST){
    include_once "config/database.php";
    include_once "objects/user.php";
    
    $database = new Database();
    $db = $database->getConnection();
    
    $user = new User($db);

    $user->username=$_POST['username'];
    $user_exists = $user->userExists();

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

        if(!$_SESSION['goto']){
            header("Location: {$home_url}index.php?action=login_success");
        }
        else{
            header("Location: " . $_SESSION['goto']);
        }
    }
    
    // if username does not exist or password is wrong
    else{
        $access_denied=true;
    }
}

include_once "template/header.php";
?>

<div class="xd-login mdl-layout__content">
    <div class="mdl-card mdl-shadow--6dp">
        <div class="mdl-card__supporting-text">
            <?php echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>"; ?>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="username" name="username" />
                    <label class="mdl-textfield__label" for="username" >Username</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="password" id="userpass" name="password" />
                    <label class="mdl-textfield__label" for="userpass">Password</label>
                </div>  
            <input type='submit' class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect' value='Log In' />
            </form>
        </div>
    </div>
</div>
<?php
if($access_denied){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Access Denied.<br /><br />Your username or password maybe incorrect </div>";
}

?>

<?php
include_once "template/footer.php";
?>

