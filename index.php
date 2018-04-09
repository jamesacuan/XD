<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title="Dashboard";

// include login checker
$require_login=true;
include_once "login_check.php";
include 'template-header.php'
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
        <button type="button" onclick="location.href='createTicket.php'" class="btn btn-primary">Create a Ticket</button>
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="createTicket.php?product=HHP">Helmet Holder - plain</a></li>
            <li><a href="createTicket.php?product=HHC">Helmet Holder - custom logo</a></li>
            <li><a href="createTicket.php?product=THP">Ticket Holder - plain</a></li>
            <li><a href="createTicket.php?product=THC">Ticket Holder - custom logo</a></li>
        </ul>
    </div>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="home">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="col-xs-1">Ticket Number</th>
                <th class="col-xs-5">Note</th>
                <th class="col-xs-2">Image</th>
                <th class="col-xs-1">Seller</th>
                <th class="col-xs-2">Date</th>
                <th class="col-xs-1">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>llsdasasdasdasdasdasdasdsaasd</td>
                <td>testing.jpg</td>
                <td>glenn</td>
                <td>04/09/2018 1:55PM</td>
                <td>Pending</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
                <td>@mdo</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
                <td>@mdo</td>
                <td>@mdo</td>
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
    include 'template-footer.php'
?>