<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- set the page title, for seo purposes too -->
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Front"; ?></title>    
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/login.css" rel="stylesheet" />
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
 
    <!-- include the navigation bar -->
    <?php include_once 'template-navbar.php'; ?>
 
    <!-- container -->
    <div class="container">
 
        <?php
        // if given page title is 'Login', do not display the title
        if($page_title!="Login"){
        ?>
        <div class='col-md-12'>
            <div class="page-header">
                <h1><?php echo isset($page_title) ? $page_title : "The Code of a Ninja"; ?></h1>
            </div>
        </div>
        <?php
        }
        ?>