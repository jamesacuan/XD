<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();
$type = "";

$job_order = new JobOrder($db);
if (!isset($_GET['type'])){
    $type = "";
}
else {
    if(strtolower($_GET['type'])=='hh') $type="HH";
    elseif(strtolower($_GET['type'])=='th') $type="TH";
    else $type="";
}
$page_title="Job Orders";
$require_login=true;

include_once "login_check.php";
include 'template/header.php';
?>

<ul class="nav nav-tabs clearfix" role="tablist">
  <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">View All</a></li>
  <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Helmet Holder</a></li>
  <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Ticket Holder</a></li>
  <div class="btn-group pull-right">
        <button type="button" onclick="location.href='addjoborder.php'" class="btn btn-primary">+ Job Order</button>
  </div>
</ul>

<div class="tab-job tab-content" style="margin-top:20px">
  <div role="tabpanel" class="tab-pane active" id="home">
    <table id="joborders" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="col-xs-1">Job Order</th>
                    <th class="col-xs-1">Code</th>
                    <th class="col-xs-1">By</th>
                    <th class="col-xs-6">Note</th>
                    <th class="col-xs-2">Date</th>
                    <th class="col-xs-1">Status</th>
                </tr>
            </thead>
            <tbody>

            <?php       
                $stmt = $job_order->read($type);
                $num  = $stmt->rowCount();

                if($num>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr>";
                            echo "<th scope=\"row\"><a href=\"joborder.php?&amp;id={$id}\">{$id}</th>";
                            echo "<td><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a></td>";
                            echo "<td>{$username}</td>";
                            echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\"></span></td>";
                            echo "<td>" . date_format(date_create($modified),"F d, Y h:i:s A") . "</td>";
                            echo "<td><span class=\"label label-primary\">{$status}</span></td>";
                            /*echo "<td>";
                                if($username==$_SESSION['username']){
                                echo " <button class=\"btn btn-sm btn-default\">Delete</button>";
                                }*/
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
    <div role="tabpanel" class="tab-pane" id="profile">
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
            $stmt = $job_order->read('HH',$from_record_num, $records_per_page);
            $num  = $stmt->rowCount();

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<th scope=\"row\">{$id}</th>";
                        echo "<td>{$code}</td>";
                        echo "<td>{$username}</td>";
                        echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\"></span></td>";
                        echo "<td>{$modified}</td>";
                        echo "<td><span class=\"label label-primary\">{$status}</span></td>";
                        echo "<td>
                            <a href=\"joborderitem.php?&code={$code}\" class=\"btn btn-sm btn-default\">View</a>";
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
  <div role="tabpanel" class="tab-pane" id="messages">
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
            $stmt = $job_order->read('TH',$from_record_num, $records_per_page);
            $num  = $stmt->rowCount();

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<th scope=\"row\">{$id}</th>";
                        echo "<td>{$code}</td>";
                        echo "<td>{$username}</td>";
                        echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\"></span></td>";
                        echo "<td>{$modified}</td>";
                        echo "<td><span class=\"label label-primary\">{$status}</span></td>";
                        echo "<td>
                            <a href=\"joborderitem.php?&code={$code}\" class=\"btn btn-sm btn-default\">View</a>";
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
</div>
<div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img src="" />
      </div>
    </div>
  </div>
</div>
<script>
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#image').on('shown.bs.modal', function () {
  $('#myInput').focus()
})

$(document).ready( function () {
    $('#joborders').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "pageLength": 25
    });
    
} );
</script>
<?php
include 'template/footer.php';
?>