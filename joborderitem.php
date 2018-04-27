<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

$page_title="Job Order Item: " . $_GET['code'];

$job_order->code=$_GET['code'];
$job_order->getJOItem();
$require_login=true;

include_once "login_check.php";
include 'template/header.php';
?>

<div class="row">
<div class="col-md-3">
    <div class="row">
        <div class="col-xs-12"><img src="<?php echo $home_url . "images/" . $job_order->image_url?>" width="250" height="250"/>
        </div>
    </div>
  </div>
  <div class="col-md-7">
      <div class="row">
          <div class="col-xs-3">From Job Order</div>
          <div class="col-xs-9"><?php echo $job_order->joborderid?></div>
      </div>
      <div class="row">
          <div class="col-xs-3">By:</div>
          <div class="col-xs-9"><?php echo $job_order->username?></div>
      </div>
      <div class="row">
          <div class="col-xs-3">Date added:</div>
          <div class="col-xs-9"><?php echo $job_order->modified?></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="md-stepper-horizontal">
          <div class="md-step active">
            <div class="md-step-circle"><span>1</span></div>
            <div class="md-step-title">Request</div>
            <div class="md-step-bar-left"></div>
            <div class="md-step-bar-right"></div>
          </div>
          <div class="md-step inactive">
            <div class="md-step-circle"><span>2</span></div>
            <div class="md-step-title">Proposal</div>
            <!--<div class="md-step-optional">Rendered Image</div>-->
            <div class="md-step-bar-left"></div>
            <div class="md-step-bar-right"></div>
          </div>
          <div class="md-step inactive">
            <div class="md-step-circle"><span>3</span></div>
            <div class="md-step-title">Launch</div>
            <div class="md-step-bar-left"></div>
            <div class="md-step-bar-right"></div>
          </div>
        </div>
      </div>
      </div>
  </div>
  <div class="col-md-2">
  <?php
    if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){
        echo "<a href=\"#\" class=\"btn btn-danger\">Delete</a>";
    }
    if($job_order->status=='For Approval' && $_SESSION['role']=='admin'){
        echo "<a href=\"#\" class=\"btn btn-primary\">Approve</a>";
    }
   ?>
   </div>
</div>


<div class="row" style="margin-top:30px;">
  <div class="col-md-12">
    <h3>Feedback</h3>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="media">
        <div class="media-left media-top">
            <img class="media-object" src="#" width="64" height="64" />
        </div>
        <div class="media-body">
          <h4 class="media-heading">Middle aligned media</h4>
          <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
        </div>
      </div>
  </div>
  <div class="col-md-12">
    <div class="media">
        <div class="media-left media-top">
            <img class="media-object" src="#" width="64" height="64" />
        </div>
        <div class="media-body">
          <h4 class="media-heading">Middle aligned media</h4>
          <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
        </div>
      </div>
  </div>
  <div class="col-md-12">
    <div class="media">
        <div class="media-left media-top">
            <img class="media-object" src="#" width="64" height="64" />
        </div>
        <div class="media-body">
          <h4 class="media-heading">Middle aligned media</h4>
          <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
        </div>
      </div>
  </div>
  <div class="col-md-12">
    <div class="media">
        <div class="media-left media-top">
            <img class="media-object" src="#" width="64" height="64" />
        </div>
        <div class="media-body">
          <h4 class="media-heading">Middle aligned media</h4>
          <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
        </div>
      </div>
  </div>
  <div class="col-md-12">
    <div class="media">
        <div class="media-left media-top">
            <img class="media-object" src="#" width="64" height="64" />
        </div>
        <div class="media-body">
          <h4 class="media-heading">Middle aligned media</h4>
          <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
        </div>
      </div>
  </div>
</div>
<?php
include 'template/footer.php';
?>