<?php 
/* FUCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCC */

if(isset($_SESSION['JOH']) && isset($_SESSION['submit'])){
    if($_SESSION['submit']=='delete'){
        $job_order->userid = $_SESSION['userid'];
        foreach($_SESSION['JOH'] as $key => $n ) {
            //print "The product is ".$n."<br>";
            $job_order->status = "Y";
            $job_order->joborderdetailsid = $n;
            $job_order->delete();
        }
        $i = $key +1;
        $_SESSION['modal'] = "{$i} entries have been sucessfully deleted";
    }

    if($_SESSION['submit']=='accept'){
        $job_order->userid = $_SESSION['userid'];
        $i = 0;
        //$joid = 0;
        foreach($_SESSION['JOH'] as $key => $n ) {
            $job_order->userid = $_SESSION["userid"];
            //$job_order->code   = $itemcode;
            $job_order->status = "Accepted";  ///Accepted Status
            
            $job_order->joborderdetailsid = $n;
            
            $code = $job_order->getJOCode($n);
            $job_order->code = $code;
            
            $job_order->setStatus();
            $i++;
        }
        if($i > 0) {$_SESSION['modal'] = "Successfully accepted {$i} entries";}
        else if($i == 0) $_SESSION['modal'] = "Nothing is selected.";
    }
    unset($_SESSION['JOH']);
    unset($_SESSION['submit']);
}

if($_POST){
    //$userid   = $_SESSION['userid'];
    $_SESSION['JOH'] = $_POST['JOH'];
    $_SESSION['submit'] = $_POST['submit'];
    header("Location:{$home_url}joborders.php?");
}
?>