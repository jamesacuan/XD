<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Index"; ?></title>  
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />   
    <link href="css/datables.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.js"></script>   
    <script src="js/bootstrap.min.js"></script>   
    <script src="js/datatables.min.js"></script>   
</head>
<body>
     <?php include_once 'template/navbar.php'; ?>
     <div class="container">
        <?php
        if($page_title!="Login"){
        ?>
            <div class='col-md-12'>
                <div class="page-header">
                    <h1><?php echo isset($page_title) ? $page_title : "Index"; ?></h1>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- Split button -->
