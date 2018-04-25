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
$page_title    = "Job Order " . $id;

include_once "login_check.php";
include 'template/header.php';
?>
<?php               $stmt = $job_order->readJO($id);
                $num  = $stmt->rowCount();

                if($num>0){
                    echo $username;
                    }?>


<table id="joborders" class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="col-xs-1">Code</th>
                    <th class="col-xs-1">By</th>
                    <th class="col-xs-4">Note</th>
                    <th class="col-xs-2">Date</th>
                    <th class="col-xs-1">Status</th>
                    <th class="col-xs-2">Action</th>
                </tr>
            </thead>
            <tbody>

            <?php       
                $stmt = $job_order->readJO($id);
                $num  = $stmt->rowCount();

                if($num>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr>";
                            echo "<td><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a></td>";
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
                                if(($role=="hans" || $role=="admin" || $role=="superadmin") && $status=="For Approval"){
                                    echo "<a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Approve\" class=\"btn btn-xs btn-default\">Approve</a>";
                                    echo "<a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Deny\" class=\"btn btn-xs btn-default\">Deny</a>";
                                }
                                if(($status=="For Approval" && $role=="user" && $_SESSION['username']==$username) || ($status=="For Approval" && $role=="superadmin")){
                                    echo "<a href=\"#\" class=\"btn btn-xs btn-default\" data-id={$JODID} data-toggle=\"modal\" data-target=\"#warn\">Delete</a>";
                                }
                                ?>
                            <?php
                            echo "</td>";
                        echo "</tr>";
                    }
                }
                else{
                   // echo "<div class='alert alert-info'>No products found.</div>";
                }
            ?>
            </tbody>
        </table> 


<?php
include 'template/footer.php';
?>