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
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />   
    <link href="css/datatables.css" rel="stylesheet" />
    <link href="css/jquery-ui.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap.min.css" rel="Stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/jquery-ui.min.js"></script>  
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/datatables.min.js"></script>
</head>
<body>
<?php /*<div id="progressBar" class="waiting"></div>*/ ?>
     <?php include_once 'template/navbar.php'; ?>
     <?php 
     if(isset($page_ribbon)){
        echo "<div class=\"container\">";
     }
     else {
        echo "<div class=\"xd-ribbon\"></div>";
        echo "<div class=\"xd-container container\">";
     }
     ?>