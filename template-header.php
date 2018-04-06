<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Dashboard"; ?></title>  
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />   
    <link href="css/login.css" rel="stylesheet" />
</head>
<body>
     <?php include_once 'template-navbar.php'; ?>
    <div class="container-fluid"> 
        <?php
        if($page_title!="Login"){
        ?>
            <div class='col-md-12'>
                <div class="page-header">
                    <h1><?php echo isset($page_title) ? $page_title : "TESTING"; ?></h1>
                </div>
            </div>
        <?php
        }
        ?>