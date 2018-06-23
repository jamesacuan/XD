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
    
<?php
/*
    <div id="wrapper" class="toggled">
    <!-- Navigation -->
    <nav class="xd-new-nav navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <button id="menu-toggle" type="button" data-toggle="button" class="btn btn-default btn-xs">
                    <i class="glyphicon glyphicon-menu-hamburger"></i>
            </button>
            <a class="navbar-brand" href="<?php echo $home_url; ?>">HANC</a>            
        </div>
        <div class="navbar-search">
            <input type="text" class="form-control" placeholder="Search...">
        </div>
        <ul class="nav navbar-top-links navbar-right">
        <div class="xd-nav navbar-collapse collapse">
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){ ?>
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
        </ul>
        <div class="xd-sidebar" id="sidebar-wrapper">
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav in" id="side-menu">
                        <li class="sidebar-search">
                            <div class="masked">    
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        <!-- /input-group -->
                        </li>
                        <li <?php echo $page_title=="Dashboard" ? "class='active'" : ""; ?>>
                    <a href="<?php echo $home_url; ?>" data-placement="right" data-toggle="tooltip" title="Home"><i class="glyphicon glyphicon-home"></i> <span class="masked">Home</span></a>
                </li>
                    <li <?php echo $page_title=="Job Orders" ? "class='active'" : ""; ?>>
                        <a href="<?php echo $home_url . "joborders.php" ; ?>" data-placement="right" data-toggle="tooltip" title="Job Orders"><i class="glyphicon glyphicon-briefcase"></i> <span class="masked">Job Orders</span></a>
                    </li>
                    <li <?php echo $page_title=="Purchase Orders" ? "class='active'" : ""; ?>>
                        <a href="<?php echo $home_url . "purchaseorders.php" ; ?>" data-placement="right" data-toggle="tooltip" title="Purchase Orders"><i class="glyphicon glyphicon-tags"></i> <span class="masked">Purchase Orders</span></a>
                    </li>
                    <li <?php echo $page_title=="Products" ? "class='active'" : ""; ?>>
                        <a href="<?php echo $home_url ."products.php"; ?>" data-placement="right" data-toggle="tooltip" title="Products"><i class="glyphicon glyphicon-home"></i> <span class="masked">Products</span></a>
                    </li>
                     </ul>
                </div>
            </div>
       </div>
    </nav>
*/?>

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
 
        <div class="xd-nav navbar-collapse collapse">
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){ ?>
            <ul class="nav navbar-nav xd-main-menu">
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

<?php
/*
<style>
    .xd-nav {  }
.xd-main-menu { margin: 0 auto; list-style: none; position: relative; }
.xd-main-menu li { display: inline; }
.xd-main-menu li a { color: #bbb; font-size: 14px; display: block; float: left; text-decoration: none;  }
.xd-main-menu li a:hover { color: white; }
#magic-line { position: absolute; top: 0px; left: 0; width: 10px; height: 2px; background: #18FFFF; }
</style>
<script>
    $(function() {

var $el, leftPos, newWidth,
    $mainNav = $(".xd-main-menu");

$mainNav.append("<li id='magic-line'></li>");
var $magicLine = $("#magic-line");

$magicLine
    .width($(".active").width())
    .css("left", $(".active").position().left)
    .data("origLeft", $magicLine.position().left)
    .data("origWidth", $magicLine.width());
    console.log($magicLine.position().left);
console.log($magicLine.width());
    
$(".xd-main-menu li").find("a").hover(function() {
    $el = $(this);
    leftPos = $el.parent().position().left;
    newWidth = $el.parent().width();
    $magicLine.stop().animate({
        left: leftPos,
        width: newWidth
    });

    console.log(leftPos + "," +newWidth);
}, function() {
    $magicLine.stop().animate({
        left: $magicLine.data("origLeft"),
        width: $magicLine.data("origWidth")
    });    
});
});
</script>
*/ ?>