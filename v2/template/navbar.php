<header class="mdl-layout__header">   
    <div class="mdl-layout__drawer-button"><i class="material-icons"></i></div>
    <div class="mdl-layout__header-row">
        <a class="mdl-layout-title" href="<?php echo $home_url . "home.php"; ?>"><span class="">HANC</span></a>
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="<?php echo $home_url . "joborders.php" ; ?>">Job Orders</a>
            <a class="mdl-navigation__link is-active" href="<?php echo $home_url . "2purchaseorders.php" ; ?>">Purchase Orders</a>
        </nav>
        <div class="mdl-layout-spacer"></div>
        <?php 
            if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
        ?>
                <span>hello@example.com</span>
                <div class="wrapper">
                    <button id="demo-menu-lower-right" class="mdl-button mdl-js-button mdl-button--icon">
                        <div class="demo-avatar-dropdown">
                            <i class="material-icons">arrow_drop_down</i>
                    </button>

                            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                                for="demo-menu-lower-right">
                            <li class="mdl-menu__item"><a href="<?php echo $home_url; ?>logout.php">Logout</a></li>
                            </ul>
                        </div>
                </div>
        <?php }
           else echo "<a class=\"mdl-navigation__link\" href=\"<?php echo $home_url; ?>\">Log In</a>";
        ?>
    </div>
    <!--
    <div class="">
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect mdl-color--primary-dark">
            <a href="#overview" class="mdl-layout__tab is-active">Overview</a>
            <a href="#features" class="mdl-layout__tab">Features</a>
            <a href="#features" class="mdl-layout__tab">Details</a>
            <a href="#features" class="mdl-layout__tab">Technology</a>
            <a href="#features" class="mdl-layout__tab">FAQ</a>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored mdl-shadow--4dp mdl-color--accent" id="add">
                <i class="material-icons" role="presentation">add</i>
                <span class="visuallyhidden">Add</span>
            </button>
        </div>
    </div>
    -->
</header>
<div class="mdl-layout__drawer">
    <span class="mdl-layout__title">Simple Layout</span>
</div>
