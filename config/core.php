<?php
    error_reporting(E_ALL);
    session_start();
    date_default_timezone_set('Asia/Manila');
    
    $home_url    = "http://localhost/xd/";
    $home_title  = "HANC";

    //$home_url="http://www.3d.local/";
    $page = isset($_GET['page']) ? $_GET['page'] : 1;  
    $records_per_page = 10;
    $from_record_num = ($records_per_page * $page) - $records_per_page;

// current time
//echo date('h:i:s') . "\n";

// sleep for 10 seconds
//sleep(20);

// wake up !
//echo date('h:i:s') . "\n";


?>