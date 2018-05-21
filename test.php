<?php
$test = "4/27/2018";

$time = strtotime($test . ' -1 days');
    echo $date = date("Y-m-d", $time);

    ?>

    <?php
    $test = "<a href=\"http://google.com\">Google</a>";
 echo strip_tags("Hello ". $test." <b><i>world!</i></b>");
    ?>