<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Selectmenu - Custom Rendering</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
      _renderItem: function( ul, item ) {
        var li = $( "<li>" ),
          wrapper = $( "<div>", { text: item.label } );
 
        if ( item.disabled ) {
          li.addClass( "ui-state-disabled" );
        }
 
        $( "<span>", {
          style: item.element.attr( "data-style" ),
          "class": "ui-icon " + item.element.attr( "data-class" )
        })
          .appendTo( wrapper );
 
        return li.append( wrapper ).appendTo( ul );
      }
    });
 
    $( "#filesA" )
      .iconselectmenu()
      .iconselectmenu( "menuWidget" )
        .addClass( "ui-menu-icons" );
 
    $( "#filesB" )
      .iconselectmenu()
      .iconselectmenu( "menuWidget" )
        .addClass( "ui-menu-icons customicons" );
 
    $( "#people" )
      .iconselectmenu()
      .iconselectmenu( "menuWidget")
        .addClass( "ui-menu-icons avatar" );
  } );
  </script>
  <style>
    h2 {
      margin: 30px 0 0 0;
    }
    fieldset {
      border: 0;
    }
    label {
      display: block;
    }
 
    /* select with custom icons */
    .ui-selectmenu-menu .ui-menu.customicons .ui-menu-item-wrapper {
      padding: 0.5em 0 0.5em 3em;
    }
    .ui-selectmenu-menu .ui-menu.customicons .ui-menu-item .ui-icon {
      height: 24px;
      width: 24px;
      top: 0.1em;
    }
    .ui-icon.video {
      background: url("images/24-video-square.png") 0 0 no-repeat;
    }
    .ui-icon.podcast {
      background: url("images/24-podcast-square.png") 0 0 no-repeat;
    }
    .ui-icon.rss {
      background: url("images/24-rss-square.png") 0 0 no-repeat;
    }
 
    /* select with CSS avatar icons */
    option.avatar {
      background-repeat: no-repeat !important;
      padding-left: 20px;
    }
    .avatar .ui-icon {
      background-position: left top;
    }
  </style>
</head>
<body>
 
<div class="demo">
 
<form action="#">
  <h2>Selectmenu with framework icons</h2>
  <fieldset>
    <label for="filesA">Select a File:</label>
    <select name="filesA" id="filesA">
      <option value="jquery" data-class="ui-icon-script">jQuery.js</option>
      <option value="jquerylogo" data-class="ui-icon-image">jQuery Logo</option>
      <option value="jqueryui" data-class="ui-icon-script">ui.jQuery.js</option>
      <option value="jqueryuilogo" selected="selected" data-class="ui-icon-image">jQuery UI Logo</option>
      <option value="somefile" disabled="disabled" data-class="ui-icon-help">Some unknown file</option>
    </select>
  </fieldset>
 
  <h2>Selectmenu with custom icon images</h2>
  <fieldset>
    <label for="filesB">Select a podcast:</label>
    <select name="filesB" id="filesB">
      <option value="mypodcast" data-class="podcast">John Resig Podcast</option>
      <option value="myvideo" data-class="video">Scott González Video</option>
      <option value="myrss" data-class="rss">jQuery RSS XML</option>
    </select>
  </fieldset>
  <label for="files">Select a file</label>
    <select name="files" id="files">
      <optgroup label="Scripts">
        <option value="jquery">jQuery.js</option>
        <option value="jqueryui">ui.jQuery.js</option>
      </optgroup>
      <optgroup label="Other files">
        <option value="somefile">Some unknown file</option>
        <option value="someotherfile">Some other file with a very long option text</option>
      </optgroup>
    </select>
  <h2>Selectmenu with custom avatar 16x16 images as CSS background</h2>
  <fieldset>
    <label for="people">Select a Person:</label>
    <select name="people" id="people">
      <option value="1" data-class="avatar" data-style="background-image: url(&apos;http://www.gravatar.com/avatar/b3e04a46e85ad3e165d66f5d927eb609?d=monsterid&amp;r=g&amp;s=16&apos;);">John Resig</option>
      <option value="2" data-class="avatar" data-style="background-image: url(&apos;http://www.gravatar.com/avatar/e42b1e5c7cfd2be0933e696e292a4d5f?d=monsterid&amp;r=g&amp;s=16&apos;);">Tauren Mills</option>
      <option value="3" data-class="avatar" data-style="background-image: url(&apos;http://www.gravatar.com/avatar/bdeaec11dd663f26fa58ced0eb7facc8?d=monsterid&amp;r=g&amp;s=16&apos;);">Jane Doe</option>
    </select>
  </fieldset>
</form>
 
</div>
<?php 

$file_name= "filenma.jpg";
$tmp       = explode('.',$file_name);
$file_ext  = $tmp[0];
echo $file_ext;


if(isset($_POST["submit"])) {
  if(is_array($_FILES)) {
    $file = $_FILES['myImage']['tmp_name']; 
    
    
    $source_properties = getimagesize($file);
    $image_type = $source_properties[2]; 

    
    if( $image_type == IMAGETYPE_JPEG ) {   
      $image_resource_id = imagecreatefromjpeg($file);  
      $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
      imagejpeg($target_layer,$_FILES['myImage']['name'] . "_thump.jpg");
    }
    elseif( $image_type == IMAGETYPE_GIF )  {  
      $image_resource_id = imagecreatefromgif($file);
      $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
      imagegif($target_layer,$_FILES['myImage']['name'] . "_thump.gif");
    }
    elseif( $image_type == IMAGETYPE_PNG ) {
      $image_resource_id = imagecreatefrompng($file); 
      $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
      imagepng($target_layer,$_FILES['myImage']['name'] . "_thump.png");
    }
  }
}

function fn_resize($image_resource_id,$width,$height) {
  $target_width =200;
  $target_height =200;
  $target_layer=imagecreatetruecolor($target_width,$target_height);
  imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
  return $target_layer;
}
?>
<form name="frmImageResize" action="" method="post" enctype="multipart/form-data">
<input type="file" name="myImage" /> 
<input type="submit" name="submit" value="Submit" />
</form>

</body> 