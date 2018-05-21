    <div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle " data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
 
            <a class="navbar-brand" href="<?php echo $home_url; ?>">HANC</a>
        </div>
 
        <div class="navbar-collapse collapse">
        <?php
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
                ?>
            <ul class="nav navbar-nav">
                <li <?php echo $page_title=="Dashboard" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url; ?>">Home</a>
                </li>
                <li <?php echo $page_title=="Job Orders" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url . "joborders.php" ; ?>">Job Orders</a>
                </li>
                <!--
                <li>
                  <div class="btn-group navbar-btn">
                    <button onclick="location.href='joborders.php'" class="btn">Job Orders</button>
                    <button data-toggle="dropdown" class="btn dropdown-toggle"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $home_url . "joborders.php?type=HH"; ?>">Helmet Holder</a></li>
                        <li><a href="<?php echo $home_url . "joborders.php?type=TH"; ?>">Ticket Holder</a></li>
                    </ul>
                  </div>
                </li>
                -->
                <li <?php echo $page_title=="Purchase Orders" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url . "purchaseorders.php" ; ?>">Purchase Orders</a>
                </li>
                <li <?php echo $page_title=="Products" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url . "products.php" ; ?>">Products</a>
                </li>
            </ul>
            <?php   } ?>
            
            <?php
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li <?php echo $page_title=="Edit Profile" ? "class='active'" : ""; ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class=""></span>
                            &nbsp;&nbsp;<?php echo $_SESSION['username']; ?>
                            &nbsp;&nbsp;<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo $home_url; ?>profile.php">Profile</a></li>
                            <?php if($_SESSION['admin']=='Y'){
                                echo "<li><a href=\"" . $home_url . "settings.php\">Settings</a></li>";
                            }?>
                            <li><a href="<?php echo $home_url; ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
                }
                
            else{
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li <?php echo $page_title=="Login" ? "class='active'" : ""; ?>>
                        <a href="<?php echo $home_url; ?>login">
                            <span class="glyphicon glyphicon-log-in"></span> Log In
                        </a>
                    </li>
                </ul>
                <?php
                }
            ?>
        </div>
    </div>
</div>
