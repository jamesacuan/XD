<?php
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    $beta = isset($_GET['betagree']) ? $_GET['betagree'] : "";
    
    if($beta == 1 && $page_title != "Login"){
        $_SESSION['beta'] = 1;
    }
    if($page_title != "Login"){
    if($_SESSION['beta'] != 1){
        include "infobar.php";
    }

    include_once "notify.php";
    $notify = new Notify($db);
}
    ?>
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
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){ ?>
            <ul class="nav navbar-nav">
                <li <?php echo $page_title=="Dashboard" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url; ?>">Home</a>
                </li>
                <li <?php echo $page_title=="Job Orders" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url . "joborders.php" ; ?>">Job Orders</a>
                </li>
                <li <?php echo $page_title=="Purchase Orders" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url . "purchaseorders.php" ; ?>">Purchase Orders</a>
                </li>
                <li <?php echo $page_title=="Products" ? "class='active'" : ""; ?>>
                    <?php echo "<a href=\"{$home_url}products.php\">Products</a>"?>
                </li>
            </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <span class="glyphicon glyphicon-plus"></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <?php if($_SESSION['role']=="user"){
                                echo "<li><a href=\"{$home_url}addjoborder.php\">Job Order</a></li>";
                                echo "<li><a href=\"{$home_url}addpurchaseorder.php\">Purchase Order</a></li>";
                            }
                            if(!empty($_SESSION['admin'])){
                                echo "<li><a href=\"{$home_url}addproduct.php\">New Product</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li <?php echo $page_title=="Edit Profile" ? "class='active'" : ""; ?>>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <?php echo "<span>" . $_SESSION['nickname'] . "</span>&nbsp;<span class=\"caret\"></span>"; ?>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <?php /*<li><a href="<?php echo $home_url; ?>profile.php">Profile</a></li>*/ ?>
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