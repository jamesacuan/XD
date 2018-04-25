
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

include 'template/header.php'
?>

<h3>Something Something here</h3>
<p>Edit profile/Change password/manage users</p>

<?php include 'template/footer.php' ?>