<?php
?>

<div>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#stats">Stats</a></li>
                <li><a data-toggle="tab" href="#activity">Activity</a></li>
            </ul>
            <div class="tab-content">
                <div id="stats" class="tab-pane fade in active">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>Pending</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">26</div>
                                    <div>Pending</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="activity" class="tab-pane fade in">
            <?php
            /*$stmt = $job_order->readJODRecentStream();
            $num  = $stmt->rowCount();
            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
            ?>

                    <div class="info-card">
                        <div class="media">
                            <div class="media-left">
                                <a href="<?php echo "{$home_url}joborderitem.php?&code={$code}" ?> ">
                                <?php  if($image_url=="") $image_url = "def.png"; ?>
                                <img class="img-rounded media-object" src="<?php echo "{$home_url}images/thumbs/{$image_url}" ?>" width="32" height="32" /></a>
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $code ?></h4>
                                <p>added by <?php echo $nickname ?> </p>
                            </div>
                        </div>
                    </div>

            <?php }
            } ?>
                            </div>
            </div>*/
            ?>