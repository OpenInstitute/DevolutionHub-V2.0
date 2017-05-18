<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php 
switch($dir)
{ 
	
	case "accounts categories":
		include("includes/adm_conf_form_cats_accounts.php");
		break;
	
	
	case "directory categories":
	case "equipment categories":
		include("includes/adm_conf_ca_category_form.php");
		break;
	
	
	case "directory entries":
		include("includes/adm_conf_ca_directory_form.php");
		break;
		
		
	case "equipment entries":
		include("includes/adm_conf_ca_equipment_form_bu.php");
		break;
		
		
	case "cover crop entries":
		include("includes/adm_conf_ca_crop_form.php");
		break;
	
	case "crop packages":
		include("includes/adm_form_crop_package.php");
		break;
	
	
	
	case "shared stories":
		include("includes/adm_stories_form.php");
		break;
		
	case "crop prices":
		//include("includes/adm_articles_list.php");
		break;
		
	case "crop production":
		//include("includes/adm_articles_list.php");
		break;
}

?>

	
<p><br />&nbsp;<br /><br />&nbsp;</p>
<div>
<!-- @end :: content area -->
	
</div>
</div>
		
		
<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>

<link rel="stylesheet" href="../scripts/jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="../scripts/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript">
jQuery(document).ready(function ($)  {
  if( $('.wysiwyg').length ) {  $('.wysiwyg').wysiwyg();  }
});
</script>

<style type="text/css">
.dd-selected{ overflow:hidden; display:block; padding:1px 10px 1px;  font-weight:bold;}
.dd-options{ max-height:300px; overflow:hidden; overflow-y: scroll; }
.dd-option { max-height: 50px; vertical-align:middle;}
.dd-option-image, .dd-selected-image { vertical-align:middle; float:left; margin-right:5px; width:64px; max-height:40px; }
</style>	
<script type="text/javascript" src="../scripts/slickselect/jquery.ddslick.js"></script>
<script type="text/javascript">
<?php include("_json_gallery.php"); ?>

jQuery(document).ready(function ($)  {
	
	$('#demoBasic').ddslick({
		data: ddData,
		width: 400,
		imagePosition: "left",
		selectText: "Select image",
		onSelected: function (ddData) {
			if (ddData.selectedIndex !== 0) {
				if (ddData.selectedData) {	
					$('#eq_image').attr("value",  ddData.selectedData.value);	
				}
			}
		}
	});
	
	if( $('#myPics').length ) {  
		$('#myPics').ddslick({
			width: 400
	  });
	}
});
</script>


<div class="modal current" style="display:none;"></div>

<link rel="stylesheet" href="../scripts/modal/jquery.modal_2.css" type="text/css" media="screen" />
<script src="../scripts/modal/jquery.modal.js" type="text/javascript" charset="utf-8"></script>

</body>
</html>
