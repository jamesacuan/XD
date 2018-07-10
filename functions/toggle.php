<?php

session_start();
if($_SESSION["toggle"] == ""){
    $_SESSION["toggle"] = "toggled-2";
}
else $_SESSION["toggle"] = "";

?>