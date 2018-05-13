
<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$page_title="Settings";

include 'template/header.php';
?>

<div class="container">

<?php
$stmt = $user->getUser($_SESSION['userid']);
$num  = $stmt->rowCount();
$temp=0;
?>
    <div class="row">
        <div class="col-md-12">
            <h3>Account Settings</h3>
            <h4>Profile</h4>
            <p>Edit profile/Change password/</p>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            <h3>Admin Settings</h3>
            <h4>Manage Users</h4>
            <table id="users" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-4">Display Name</th>
                        <th class="col-xs-3">Username</th>
                        <th class="col-xs-1">Date Created?</th>
                        <th class="col-xs-1">Last Logged In</th>
                        <th class="col-xs-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php       
                        $stmt = $user->read();
                        $num  = $stmt->rowCount();
                        if($num>0){
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                echo "<tr>";
                                echo "<td>{$nickname}</td>";
                                echo "<td>{$username}</td>";
                                echo "<td>{$modified}</td>";
                                echo "<td></td>";
                                echo "<td><a href=\"#\" class=\"btn btn-xs btn-default\">Change Profile</a><a href=\"#\" class=\"btn btn-xs btn-default\">Reset Password</a><a href=\"#\" class=\"btn btn-xs btn-default\">Delete</a></td>";
                                echo "</tr>";
                            }
                        }
                ?>
                </tbody>
                   
            </table>
        </div>
    </div>
</div>
<?php include 'template/footer.php' ?>