<?php
if(isset($settings) && $settings=='Y')
    $subdirectory = "../";
else $subdirectory = "";

if($page_title != "Login"){
    include_once $subdirectory . "objects/settings.php";
    $settings  = new Settings($db);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php 
            if (isset($page_title))
                echo $home_title . " - " . $page_title;
            else echo "Index";
        ?>
    </title>
    <link href="<?php echo $subdirectory ?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen" />  
    <link href="<?php echo $subdirectory ?>assets/css/datatables.css" rel="stylesheet" />
    <link href="<?php echo $subdirectory ?>assets/css/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo $subdirectory ?>assets/css/sidebar.css" rel="stylesheet" />
    <link href="<?php echo $subdirectory ?>assets/favicon.png" rel="shortcut icon" />
    <link href="<?php echo $subdirectory ?>assets/css/dataTables.bootstrap.min.css" rel="Stylesheet" />
    <link href="<?php echo $subdirectory ?>assets/css/style.css" rel="stylesheet" />
    <script src="<?php echo $subdirectory ?>assets/js/jquery-3.2.1.js"></script>
<?php
// Create the function, so you can use it
/*function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
// If the user is on a mobile device, redirect them
if(isMobile()){
    echo "test";
    header("Location: http://localhost/xd-live/");
}
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
*/
?>
    <?php
    if($home_url == "http://taxcalculator.pe.hu/"){
    ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121242412-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-121242412-1');
</script>
<?php
    }?>
<script type="text/javascript">
        $(document).ready(function() {
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
                $("#wrapper.toggled").find("#sidebar-wrapper").find(".collapse").collapse("hide");
            });
        });
        </script>
</head>
<body>
<?php /*<div id="progressBar" class="waiting"></div>*/ ?>
     <?php include_once $subdirectory . 'template/navbar.php'; ?>

     <?php if(!empty($_SESSION["modal"])){ ?>
        <div class="xd-alert alert alert-warning clearfix" role="alert">
            <span><?php echo $_SESSION["modal"] ?></span>
            <button type="button" class="close" data-close="alert" aria-label="Close">
            <span>&times;</span>
            </button>
        </div>
    <?php unset($_SESSION['modal']); } ?>

     <?php 
     if(isset($page_ribbon)){
         echo "<div id=\"page-content-wrapper\">";
     }
     else {
        /*echo "<div  id=\"page-wrapper\" class=\"xd-container container\">";*/
        echo "<div id=\"page-content-wrapper\" >";
        echo "<div class=\"xd-ribbon\"></div>";

        echo "<div class=\"xd-container container\">";
     }
     ?>

