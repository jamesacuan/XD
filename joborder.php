<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";


$database      = new Database();
$db            = $database->getConnection();
$job_order     = new JobOrder($db);

$require_login =true;
$role          = $_SESSION['role'];

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else
    $id ="";
$page_title    = "Job Order #" . $id;

$jocount="";
$i = 1;
include_once "login_check.php";
include 'template/header.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <?php      
            $job_order->getJobOrderDetailsCount($id);
            $jocount = $job_order->answer;

            $job_order->readJO($id);
            echo "by " . $job_order->nickname . ". | Created on " . $job_order->created;
        ?>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
    <?php       
        $stmt = $job_order->readJOD($id);
        $num  = $stmt->rowCount();
        echo "<div class=\"panel-group\" id=\"accordion\" role=\"tablist\">";
        
        if($num>0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                    echo "<div class=\"panel panel-default\">";
                        echo "<div class=\"panel-heading\" role=\"tab\">";
                            echo "<div class=\"row\">";
                                echo "<div class=\"col-md-4\">";
                                    echo "<h4 class=\"panel-title\">";
                                        echo "<a role=\"button\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse{$code}\">";
                                        echo "{$i} - {$code}";
                                        echo "</a>";
                                    echo "</h4>";
                                echo "</div>";
                                echo "<div class=\"col-md-4\">";
                                    
                                echo "</div>";
                                echo "<div class=\"col-md-4 clearfix\">";
                                    echo "<span class=\"label pull-right ";
                                        if     ($status=="For Approval") echo "label-primary";
                                        elseif ($status=="Approved") echo "label-success";
                                        elseif ($status=="Denied") echo "label-danger";
                                        else   echo "label-default";
                                    echo "\">{$status}</span>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div id=\"collapse{$code}\" class=\"panel-collapse collapse ";
                            if($i==1) echo "in";
                        echo "\" role=\"tabpanel\">";
                            echo "<div class=\"panel-body\">";
                                echo "<div class=\"row\">";
                                    echo "<div class=\"col-md-2\">";
                                        echo "<img src=\"{$home_url}images/{$image_url}\" width=\"150\" height=\"150\" data-toggle=\"modal\" data-target=\"#image\" data-file=\"{$image_url}\" />";
                                    echo "</div>";
                                    echo "<div class=\"col-md-9\">";
                                        echo "<a href=\"joborderitem.php?&amp;code={$code}\"><h4>{$code}</h4></a>";
                                        echo "<p>{$note}</p>";
                                        echo "<p>" . date_format(date_create($modified),"F d, Y h:i:s A") . "</p>";
                                    echo "</div>";
                                    echo "<div class=\"col-md-1 btn-group-vertical\">";
                                        if(($role=="hans" || $role=="admin" || $role=="superadmin") && $status=="For Approval"){
                                            echo "<a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Approve\" class=\"btn btn-m btn-default\">Approve</a>";
                                            echo "<a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Deny\" class=\"btn btn-m btn-default\">Deny</a>";
                                        }
                                        if(($status=="For Approval" && $role=="user" && $_SESSION['username']==$username) || ($status=="For Approval" && $role=="superadmin")){
                                            echo "<a href=\"#\" class=\"btn btn-m btn-danger\" data-id={$JODID} data-toggle=\"modal\" data-target=\"#warn\">Delete</a>";
                                        }
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
/*
                    "<a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a>
                    echo "<td></td>";
                    echo "<td>{$username}</td>";
                    echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\" data-file=\"{$image_url}\" title=\"{$image_url}\"></span></td>";
                    echo "<td>" . date_format(date_create($modified),"F d, Y h:i:s A") . "</td>";
                    echo "<td><span class=\"label ";
                        if     ($status=="For Approval") echo "label-primary";
                        elseif ($status=="Approved") echo "label-success";
                        elseif ($status=="Denied") echo "label-danger";
                        else   echo "label-default";
                    echo "\">{$status}</span></div>";
                    echo "<td>";
                    ?>
                    <?php

                    <?php
                    echo "</td>";
                echo "</tr>";*/
                $i+=1;
            }
            
        }
        else{
            echo "<div class='alert alert-info'>No products found.</div>";
        }
        echo "</div>";

    ?>
        </div>
    </div>
</div>

<div class="modal fade" id="image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img class="job-order-for-render" />"
      </div>
    </div>
  </div>
</div>

<script src="js/script.js"></script>

<?php
include 'template/footer.php';
?>