
<div class="xd-header mdl-layout__header mdl-layout__header--waterfall">
<div aria-expanded="false" role="button" tabindex="0" class="mdl-layout__drawer-button"><i class="material-icons"></i></div>
  <div class="mdl-layout__header-row">
    <span class="android-title mdl-layout-title">
      <a href="<?php echo $home_url; ?>">HANC</a>
    </span>
    <!-- Navigation -->
    <div class="xd-navigation-container">
      <nav class="xd-navigation mdl-navigation">
        <a class="mdl-navigation__link mdl-typography--text-uppercase <?php echo $page_title=="Job Orders" ? "active" : ""; ?>" href="<?php echo $home_url . "joborders.php" ; ?>">Job Orders</a>
        <a class="mdl-navigation__link mdl-typography--text-uppercase <?php echo $page_title=="Purchase Orders" ? "active" : ""; ?>" href="<?php echo $home_url . "purchaseorders.php" ; ?>">Purchase Orders</a>
      </nav>
    </div>
    <span class="android-mobile-title mdl-layout-title">
      <img class="android-logo-image" src="images/android-logo.png">
    </span>
    <div class="android-header-spacer mdl-layout-spacer"></div>
    <?php
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true){
    ?>
        <span><?php echo $_SESSION['nickname']; ?></span>
        <button class="android-more-button mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="more-button">
        <i class="material-icons">more_vert</i>
        </button>
        <ul class="mdl-menu mdl-js-menu mdl-menu--bottom-right mdl-js-ripple-effect" for="more-button">
        <li class="mdl-menu__item"><a href="<?php echo $home_url; ?>logout.php">Logout</a></li>
        </ul>
        <?php
                }
                
            else{
                ?><span>Login</span>
            <?php } ?>
  </div>
</div>

<div class="android-drawer mdl-layout__drawer">
  <span class="mdl-layout-title">
    <img class="android-logo-image" src="images/android-logo-white.png">
  </span>
  <nav class="mdl-navigation">

    <span class="mdl-navigation__link" href="">Versions</span>
    <a class="mdl-navigation__link" href="">Lollipop 5.0</a>
    <a class="mdl-navigation__link" href="">KitKat 4.4</a>
    <a class="mdl-navigation__link" href="">Jelly Bean 4.3</a>
    <a class="mdl-navigation__link" href="">Android history</a>
    <div class="android-drawer-separator"></div>
  </nav>
</div>