<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

$page_title="Job Orders";
$require_login=true;

include_once "login_check.php";
include 'template/header.php';
?>


<table class="table table-hover table-bordered">
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
            $stmt = $job_order->read('', $from_record_num, $records_per_page);
            $num  = $stmt->rowCount();

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<th scope=\"row\"><a href=\"joborder.php?&amp;id={$id}\">{$id}</th>";
                        echo "<td><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a></td>";
                        echo "<td>{$username}</td>";
                        echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\"></span></td>";
                        echo "<td>{$modified}</td>";
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
</script>
<?php
include 'template/footer.php';
?>