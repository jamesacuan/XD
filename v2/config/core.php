<?php
    error_reporting(E_ALL);
    session_start();
    date_default_timezone_set('Asia/Manila');
    
    $home_url    = "http://localhost/xd/v2/";
    $home_title  = "HANC";

    $page = isset($_GET['page']) ? $_GET['page'] : 1;  
    $records_per_page = 10;
    $from_record_num = ($records_per_page * $page) - $records_per_page;
?>