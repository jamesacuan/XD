<?php
// core configuration
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

$page_title="Dashboard";

$require_login=true;
include_once "login_check.php";
include 'template/header.php'
?>
<?php
echo "<div class='col-md-12'>";
 
// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

// if login was successful
/*if($action=='login_success'){
    echo "<div class='alert alert-info'>";
        echo "<strong>Hi " . $_SESSION['username'] . ", welcome back!</strong>";
    echo "</div>";
}
// if user is already logged in, shown when user tries to access the login page
else if($action=='already_logged_in'){
    echo "<div class='alert alert-info'>";
        echo "<strong>You are already logged in.</strong>";
    echo "</div>";
}
*/

// content once logged in
//echo "<div class='alert alert-info'>";
//    echo "Content when logged in will be here. For example, your premium products or services.";
//echo "</div>";

echo "</div>";
?>
<div>

<!-- Nav tabs -->
<ul class="nav nav-tabs clearfix" role="tablist">
  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">View All</a></li>
  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Helmet Holder</a></li>
  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Ticket Holder</a></li>
  <div class="btn-group pull-right">
        <button type="button" onclick="location.href='addJobOrder.php'" class="btn btn-primary">+ Job Order</button>
        <button type="button" onclick="location.href='createTicket.php'" class="btn btn-primary">+ Purchase Order</button>
        <!--
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="createTicket.php?product=HHP">Helmet Holder - plain</a></li>
            <li><a href="createTicket.php?product=HHC">Helmet Holder - custom logo</a></li>
            <li><a href="createTicket.php?product=THP">Ticket Holder - plain</a></li>
            <li><a href="createTicket.php?product=THC">Ticket Holder - custom logo</a></li>
        </ul>
        -->
    </div>
</ul>

<div class="tab-job tab-content" style="margin-top:20px">
  <div role="tabpanel" class="tab-pane active" id="home">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th class="col-xs-1">Job Order</th>
                <th class="col-xs-1">Code</th>
                <th class="col-xs-1">By</th>
                <th class="col-xs-3">Note</th>
                <th class="col-xs-2">Date</th>
                <th class="col-xs-2">Status</th>
                <th class="col-xs-2">Action</th>
            </tr>
        </thead>
        <tbody>

        <?php       
            $stmt = $job_order->read($from_record_num, $records_per_page);
            $num  = $stmt->rowCount();

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<th scope=\"row\">{$id}</th>";
                        echo "<td>{$code}</td>";
                        echo "<td>{$username}</td>";
                        echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"pull-right\">View</span></td>";
                        echo "<td>{$modified}</td>";
                        echo "<td><span class=\"label label-primary\">{$status}</span></td>";
                        echo "<td>
                            <button class=\"btn btn-sm btn-default\">View</button>";
                            if($username==$_SESSION['username']){
                            echo " <button class=\"btn btn-sm btn-default\">Delete</button>";
                            }
                        echo "</td>";
                    echo "</tr>";
                }
            }
            else{
                echo "<div class='alert alert-info'>No products found.</div>";
            }
        ?>
        </tbody>
    </table>
  
  </div>
  <div role="tabpanel" class="tab-pane" id="profile">.2.</div>
  <div role="tabpanel" class="tab-pane" id="messages">..3</div>
</div>

</div>

<script>
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
<?php
    //include 'template/content.php';
    include 'template/footer.php';
?>