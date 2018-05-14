<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database = new Database();
$db = $database->getConnection();

$purchase_order = new PurchaseOrder($db);

$page_title="Purchase Orders";

$require_login=true;
include_once "template/login_check.php";
include 'template/header.php'
?>

<!--*START OF BODY-->
<div class="xd-ribbon"></div>
<div class="xd-main">
    <div class="xd-wrapper">
        <div class="xd-title">
            <h2>Purchase Orders</h2>
            <div class="">
                <?php if($_SESSION['role']=="user")
                    echo "<button type=\"button\" onclick=\"location.href='addpurchaseorder.php'\" class=\"mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect\">+ Purchase Order</button>";
                ?>
            </div>
        </div> 
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <table id="purchaseorders" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">PO</th>
                                    <th class="mdl-data-table__cell--non-numeric">By</th>
                                    <th class="mdl-data-table__cell--non-numeric">Date</th>
                                    <th class="mdl-data-table__cell--non-numeric">Status</th>
                                    <th class="mdl-data-table__cell--non-numeric">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td class="mdl-data-table__cell--non-numeric">Acrylic (Transparent)</td>
                                <td>25</td>
                                <td>$2.90</td>
                                <td>$2.90</td>
                                <td>$2.90</td>
                                </tr>
                                <tr>
                                <td class="mdl-data-table__cell--non-numeric">Plywood (Birch)</td>
                                <td>50</td>
                                <td>$1.25</td>
                                <td>$2.90</td>
                                <td>$2.90</td>
                                </tr>
                                <tr>
                                <td class="mdl-data-table__cell--non-numeric">Laminate (Gold on Blue)</td>
                                <td>10</td>
                                <td>$2.35</td>
                                <td>$2.90</td>
                                <td>$2.90</td> 
                                </tr>
                                <tr>
                                <td class="mdl-data-table__cell--non-numeric">Laminate (Gold on Blue)</td>
                                <td>10</td>
                                <td>$2.35</td>
                                <td>$2.90</td>
                                <td>$2.90</td> 
                                </tr>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/script.js"></script>