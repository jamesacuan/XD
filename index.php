<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title="Dashboard";

// include login checker
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
<ul class="nav nav-pills clearfix" role="tablist">
  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">View All</a></li>
  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Helmet Holder</a></li>
  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Ticket Holder</a></li>
  <div class="btn-group pull-right">
        <button type="button" onclick="location.href='createTicket.php'" class="btn btn-default">+ Job Order</button>
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

<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="home">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="col-xs-2">Code</th>
                <th class="col-xs-3">By</th>
                <th class="col-xs-2">Date</th>
                <th class="col-xs-2">Status</th>
                <th class="col-xs-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">HH-0001</th>
                <td>glenn</td>
                <td>04/09/2018 1:55PM</td>
                <td><span class="label label-primary">For Approval</span></td>
                <td><span class="label label-danger">View</span></td>
            </tr>
            <tr>
                <th scope="row">HH-0002</th>
                <td>ken</td>
                <td>04/05/2018 1:55PM</td>
                <td><span class="label label-danger">Overdue</span></td>
                <td><span class="label label-danger">View</span></td>

            </tr>
            <tr>
                <th scope="row">TH-0001</th>
                <td>mark</td>
                <td>04/08/2018 1:55PM</td>
                <td><span class="label label-success">Done</span></td>
                <td><span class="label label-danger">View</span></td>

            </tr>
            <tr>
                <th scope="row">HH-0003</th>
                <td>glenn</td>
                <td>04/03/2018 1:55PM</td>
                <td><span class="label label-warning">Pending</span></td>
                <td><span class="label label-danger">View</span></td>

            </tr>
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
    include 'template/content.php';
    include 'template/footer.php';
?>