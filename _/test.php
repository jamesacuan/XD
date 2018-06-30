<?php
include_once "config/core.php";
include_once "config/database.php";

if($_POST){
    echo $_POST['form'];
}

$page_ribbon="F";
$page_title = "playground";

include 'template/header.php';
?>

<div class="row">
<form style="border: 1px solid black" class="col-md-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data"> 

<input type="submit" name="form" value="Submit" />
</form>

<form style="border: 1px solid navy" class="col-md-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data"> 

<input type="submit" name="form" value="Publish" />
</form>

<form method="post" action="upload.php" enctype="multipart/form-data" id="uploadForm">
<table id="joborders" class="table table-hover table-striped">
            <thead style="background-color: #fff">
                <tr>
                    <th class="col-xs-2">Image</th>
                    <th class="col-xs-5">Name</th>
                    <th class="col-xs-5">Type</th>

                </tr>
            </thead>
            <tbody>
            <div class="gallery"></div>


<input type="file" multiple id="gallery-photo-add">

    </tbody>
    </table>
    <input type="submit" name="submit" value="Upload"/>
</form>


<script>
$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});
</script>

<?php echo password_hash("H4milton", PASSWORD_BCRYPT); ?>
</div>

<?php include 'template/header.php';
?>