<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php 
            if (isset($page_title))
                echo $home_title . " - " . $page_title;
            else echo "Index";
            ?>
    </title>
    <link href="css/datables.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="css/material.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.js"></script>    
    <script src="js/datatables.min.js"></script>
    <script src="js/material.min.js"></script>
</head>
<body>
<div class="mdl-layout mdl-js-layout ">
     <?php include_once 'template/navbar.php'; ?>
