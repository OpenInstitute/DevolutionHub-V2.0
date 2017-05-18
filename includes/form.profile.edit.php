
<?php

$formname		= "conf_account";
$fData 		   = array();

	$sqdata = "SELECT `account_id` , `namefirst` , `namelast` , `email` , `phone` , `country` , `city` , `profile` , `newsletter`, `avatar` FROM `dhub_reg_account` WHERE (`account_id` = ".quote_smart($us_id).");";
	
	$rsdata=$cndb->dbQuery($sqdata);// 
	$rsdata_count=$cndb->recordCount($rsdata);
	
	$rs_fields = mysqli_fetch_fields($rsdata);
	
	
	if($rsdata_count==1)
	{
		$cn_fields = $cndb->fetchRow($rsdata);
		
		foreach ($rs_fields as $i => $dt_field)
		{ $fData[$dt_field->name] = $cn_fields[$dt_field->name]; }
		
		
		$photo			= $fData['avatar']; 
		if($photo == '') { $photo = 'no_avatar.png'; }
		
		$image_disp			= "<img src=\"".DISP_AVATARS.$photo."\"  style=\"max-width:300px; max-height:300px;\" >";
		
	
	}
	
	//displayArray($fData);
	$formact		 = "_edit";
	$redirect		= REF_ACTIVE_URL; //"profile.php?ptab=" . $ptab; //RDR_REF_PATH;
	

?>

<div class="padd15" style="border:0px solid">
<?php echo display_PageTitle('Account Profile'); ?>
<form  class="rwdform rwdfull rwdvalid frmnoborder" method="POST" name="afp_conf_person" id="afp_conf_person" action="posts_profile.php" enctype="multipart/form-data">
<input type="hidden" name="account_id" id="account_id" value="<?php echo @$fData['account_id']; ?>">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formact" value="<?php echo $formact; ?>" />
<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

<legend>User Details</legend>

<?php /*?><div class="form-group">
<label class="textlabel control-label" for="id_partner">Id Partner</label>
<div>
<input type="text" name="id_partner" id="id_partner" size="11" maxlength="11" class="text form-control">
</div> 
</div><?php */?>

<div class="form-group">
<label class="required control-label" for="namefirst">Firstname</label>
<div>
<input type="text" name="namefirst" id="namefirst" size="50" maxlength="100" class="required form-control" value="<?php echo @$fData['namefirst']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="required control-label" for="namelast">Lastname</label>
<div>
<input type="text" name="namelast" id="namelast" size="50" maxlength="100" class="required form-control " value="<?php echo @$fData['namelast']; ?>" />
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="email">Email</label>
<div>
<input type="text" name="email" id="email" size="50" maxlength="100" class="required email form-control" readonly="readonly" value="<?php echo @$fData['email']; ?>"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="phone">Phone</label>
<div>
<input type="text" name="phone" id="phone" size="50" maxlength="100" class="text form-control" value="<?php echo @$fData['phone']; ?>"/></div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="country">Country</label>
<div>
	<select name="country" id="country" class="form-control required">
	<?php //echo $ddSelect->dropper_select("dhub_reg_countries", "id", "country", @$fData['country']) ?>
	<?php echo $ddSelect->dropper_select("dhub_reg_countries", "iso_code_2", "country", @$fData['country'], "Select Country") ?>
	</select>
</div> 
</div>






<legend>Profile Photo</legend>

<div class="form-group">
<label class="textlabel control-label" for="country_id">Upload Photo:</label>
<div>
	<div class="radio_group">
	<label><input name="change_image" id="upload_y" type="radio" value="Yes"  class="" /> Yes </label>
	<label><input name="change_image" id="upload_n" type="radio" value="No" checked="checked" class="" /> No</label>
	</div>
</div>
</div>
				
<div class="form-group" id="upload_avatar" style="display:none">
<label class="textlabel control-label" for="reg_photo">&nbsp;</label>
<div>
	<div class="uploader" id="upload_reg_photo">
		<input style="opacity: 0;" name="reg_photo" id="reg_photo" type="file" accept="image/*" onchange="javascript: setFilename('upload_reg_photo', 'reg_photo', '1')" >
		<span style="-moz-user-select: none;" class="filename">No file selected</span>
		<span style="-moz-user-select: none;" class="action">Choose File</span>	
	</div> 
		<input type="hidden" name="command" value="1" />
		<input type="hidden" name="image_old" value="<?php echo $photo; ?>" />
</div> 
</div>


<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<?php echo $image_disp; ?>	
</div> 
</div>			


<div class="form-group">&nbsp;</div>
				
<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<button type="submit" class="btn btn-success" id="f_submit" name="submit" value="1"><i class="glyphicon glyphicon-plus"></i>Submit</button>
</div>

</div>



</form>
</div>



<p>&nbsp;</p>



<script type="text/javascript">
jQuery(document).ready(function($)
{ 
	$("#upload_y").click(function () { 
		$("#upload_avatar").show();   
	});
	$("#upload_n").click(function () { 
		$("#upload_avatar").hide();   
	});
});

function setFilename(upBox, upField, upKey)
{
 jQuery(document).ready(function($){
  	var fileDefaultText = 'No file selected';
	
  	var filenameTag = $('div#'+upBox+' span.filename');
	var filenameBtn = $('div#'+upBox+' span.action');
	
	var fileLabel = $('input#file_title_'+upKey+'');
	
	
	var $el = $('#'+upField+''); 
	var filename = $el.val();
	var filenameC = $el.val();
	
	filenameC = filenameC.split(".");
	filenameC = filenameC[(filenameC.length-1)].toUpperCase();
	
		if (filename === '') {	filename = fileDefaultText;	}
		else { 	
			filename = filename.split(/[\/\\]+/); filename = filename[(filename.length-1)];		
			filenameTag.html(filename);
			fileLabel.attr("value", filename.substr(0,filename.length-4)).focus();
	
		}
	});
};
</script>