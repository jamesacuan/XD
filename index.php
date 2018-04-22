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
echo "</div>";
?>
<div>


<div class="row home-approval">
    <div class="col-md-6">
        <?php       
            $stmt = $job_order->read('', $from_record_num, $records_per_page);
            $num  = $stmt->rowCount();

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<div class=\"row\">";
                        echo "<div class=\"col-sm-1\" style='text-align:center'>";
                        echo "<span class=\"glyphicon glyphicon-picture\" data-toggle=\"modal\" data-target=\"#image\" data-file=\"{$image_url}\" title=\"{$image_url}\"></span>";
                        echo "</div>";
                        echo "<div class=\"col-sm-9\">";
                            echo "<div class=\"title\"><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a>";
                            echo " - <span class=\"note\">{$note}</span> <span class=\"label label-primary\">{$status}</span></div>";
                            echo "<div class=\"info\"><span class=\"text-muted\">From <a href=\"joborder.php?&amp;id={$id}\">Job Order #{$id}</a> by {$username} on " . date_format(date_create($modified),"F d, Y") . "</div>";
                        echo "</div>";
                        echo "<div class=\"col-sm-2\">";
                            echo "<button class=\"btn btn-default btn-sm\">Approve</button>";
                        echo "</div>";
                    echo "</div>";
                }
            }
            else{
                echo "<div class='alert alert-info'>No products found.</div>";
            }
        ?>
  
  </div>
</div>

</div>
        </div>


<div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img class="job-order-for-render" />"
      </div>
    </div>
  </div>
</div>
<script>
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

$('#image').on('shown.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var filename = button.data('file');
  var modal = $(this);
  modal.find('.job-order-for-render').attr('src',"<?php echo $home_url; ?>" + "images/" + filename);
  $('#myInput').focus()
})
</script>
<?php
    //include 'template/content.php';
    include 'template/footer.php';
?>