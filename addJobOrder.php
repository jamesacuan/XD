<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);
$page_title="Create Job Order";

include 'template/header.php';

echo "test" . $_SESSION['userid'];
?>

<?php
if($_POST){
    $job_order->getJobOrderCount();
    $newJO = $job_order->jocount + 1;

    $job_order->getTypeCount($_POST['type']);
    $newTY = $job_order->tycount + 1;

    echo $job_order->userid = $_SESSION['userid'];
    echo $job_order->type = $_POST['type'];

    if($newTY<10){
        $job_order->code = $_POST['type'] . "-000" . $newTY;
    }
    elseif($newTY<100){
        $job_order->code = $_POST['type'] . "-00" . $newTY;
    }
    elseif($newTY<1000){
        $job_order->code = $_POST['type'] . "-0" . $newTY;
    }
    else{
        $job_order->code = $_POST['type'] . "-" . $newTY;
    }
    echo $job_order->code;
    echo $job_order->note       = $_POST['note'];
    echo $job_order->image_url  = $_POST['url'];
    echo $job_order->status     = "For Approval";
    echo $job_order->expectedJO = $newJO;
    
    if($job_order->create()){
        echo "<div class='alert alert-success'>Job Order was created.</div>";        
    }
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }

    echo "<div>INSERT INTO job_order(`id`, `userid`, `created`, `modified`, `isDeleted`)</div>";
}
?>

<?php echo "username " . $_SESSION['username'] ?>
<?php echo "role " . $_SESSION['role'] ?>

<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
  <div class="form-group">
    <label class="col-sm-2 control-label">Type</label>

    <div class="checkbox col-sm-10">
        <label class="radio-inline">
            <input type="radio" name="type" value="HH">Helmet Holder
        </label>
        <label class="radio-inline">
            <input type="radio" name="type" value="TH">Ticket Holder
        </label>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label" for="noteArea">Note</label>
    <div class="col-sm-10">
        <textarea class="form-control" name="note" rows="3" id="noteArea" required></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="url" class="col-sm-2 control-label">Image URL</label>
    <div class="col-sm-10">
        <input type="text" name="url" class="form-control" id="url" placeholder="image url" required>
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>


<?php include 'template/footer.php'; ?>

