</div>

<div class="modal fade" id="keycode" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Keyboard shortcut</h4>
      </div>
      <div class="modal-body" data-spy="scroll" data-target="keynav">
        <div class="row">
            <div class="col-sm-3" id="keynav">
                <ul>
                    <li>Menus</li>
                    <li>Navigation</li>
                    <li>Application</li>
                </ul>
            </div>
            <div class="col-sm-9" style="overflow-y: scroll; height:300px">
                <h4>Menus</h4>
                <dl class="dl-horizontal">
                    <dt><kbd>Shift</kbd> + <kbd>H</kbd></dt>
                    <dd>Home</dd>
                    <dt><kbd>Shift</kbd> + <kbd>J</kbd></dt>
                    <dd>Job Orders</dd>
                    <dt><kbd>Shift</kbd> + <kbd>P</kbd></dt>
                    <dd>Purchase Orders</dd>
                    <dt><kbd>Shift</kbd> + <kbd>R</kbd></dt>
                    <dd>Products</dd>
                    <dt><kbd>Shift</kbd> + <kbd>S</kbd></dt>
                    <dd>Settings</dd>
                </dl>
                <h4>Actions</h4>
                <dl class="dl-horizontal">
                    <dt><kbd>Ctrl</kbd> + <kbd>N</kbd></dt>
                    <dd>New Job Order</dd>
                    <dt><kbd>Shift</kbd> + <kbd>2</kbd></dt>
                    <dd>Job Orders</dd>
                    <dt><kbd>Shift</kbd> + <kbd>3</kbd></dt>
                    <dd>Purchase Orders</dd>
                    <dt><kbd>Shift</kbd> + <kbd>4</kbd></dt>
                    <dd>Products</dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt><kbd>Up</kbd></dt>
                    <dd>Move up (in JO/PO table)</dd>
                    <dt><kbd>Down</kbd></dt>
                    <dd>Move Down (in JO/PO table)</dd>
                </dl>
                <h4>Application</h4>
                <dl class="dl-horizontal">
                    <dt><kbd>/</kbd></dt>
                    <dd>Search</dd>
                    <dt><kbd>?</kbd></dt>
                    <dd>Opens keyboard shortcut</dd>
                </dl>
            </div>
        </div>
    </div>
  </div>
</div>


<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<?php
    if ($page_title=="Job Orders" || $page_title=="Purchase Orders"){ ?>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/datatables.min.js"></script>
<script src="assets/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/keytable/2.4.1/js/dataTables.keyTable.min.js"> </script>

<script src="assets/js/lazyload.min.js"></script>
<?php 
    }
?>
<script src="assets/js/jquery.hotkeys.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>