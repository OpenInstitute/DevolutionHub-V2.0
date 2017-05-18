<div style="width:90%; margin:0 auto; border:0px solid">
	
	<div style="padding:10px;">
	
<?php
$GLOBALS['FORM_JWYSWYG'] = true;
	
$confDir 			= ucwords($dir);

$pgtitle			= "<h2>New $confDir</h2>";
$formname           = "fm_organization";
$formaction         = "_new";

$fData 		      = array();
$fData['published'] = 1;

$group[1] = $group[2] = $group[3] = $group[4] = '';	
		
if($op=="edit"){

	if($id){
	
	$sqdata="SELECT `dhub_reg_account`.*, `dhub_conf_organizations`.* , `dhub_conf_organizations`.`published` as `org_publish`  FROM `dhub_conf_organizations` 
	LEFT JOIN `dhub_reg_account` ON (`dhub_conf_organizations`.`contact_id` = `dhub_reg_account`.`account_id`)
	WHERE  (`dhub_conf_organizations`.`organization_id`  = ".quote_smart($id).")";
	//echo $sqdata;
	$rsdata = $cndb->dbQueryFetch($sqdata);
	
	$fData = current($rsdata);	
	//displayArray($fData);	
	$pgtitle ="<h2>Edit $confDir</h2>";
	$formaction			= "_edit";
		
		
		$logoname = ($fData['logo'] <> '') ? $fData['logo'] : 'no-image-found.jpg'; /*no_image.png*/
		$logopath = DISP_LOGOS.$logoname;
		$logosrc  = substr($logoname, 0 , 3);	

		/** EXTERNAL IMAGE **/
		if($logosrc == 'htt' or $logosrc == 'www' or $logosrc == 'ftp' or $logosrc == 'ww2') 
		{ $logopath = $logoname;  }	
		
	}
}
	
$published = yesNoChecked($fData['org_publish']);	
$is_partner = yesNoChecked($fData['is_partner']);	
$group[$fData['group_id']] = ' selected ';
		
	?>

<div style="max-width:900px; margin:auto;">
<div style="text-align:center"><?php echo $pgtitle; ?></div>

	
<form class="rwdform" name="fm_organization" id="fm_organization" method="post" action="adm_posts.php" enctype="multipart/form-data">
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="fm_organization" />
<input type="hidden" name="organization_id" id="organization_id" value="<?php echo @$fData['organization_id']; ?>">
<input type="hidden" name="account_id" id="account_id" value="<?php echo @$fData['account_id']; ?>">
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />


<div>
	<div class="padd5"><h3>Organization Details</h3></div>
</div>


<div class="form-group">
<label class="textlabel col-md-3" for="organization">Organization Name</label>
<input type="text" name="org[organization]" id="organization" maxlength="100" class="text form-control col-md-9" value="<?php echo @$fData['organization']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="organization_profile">Profile</label>

<div class="col-md-9 nopadd">	
<textarea name="org[organization_profile]" id="organization_profile" class="text form-control  wysiwyg"><?php echo @$fData['organization_profile']; ?></textarea>
</div>
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="organization_phone">Phone</label>
<input type="text" name="org[organization_phone]" id="organization_phone" maxlength="50" class="text form-control col-md-9" value="<?php echo @$fData['organization_phone']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="organization_email">Email</label>
<input type="email" name="org[organization_email]" id="organization_email" maxlength="50" class="text form-control col-md-9" value="<?php echo @$fData['organization_email']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="organization_website">Website</label>
<input type="url" name="org[organization_website]" id="organization_website" class="text form-control col-md-9" value="<?php echo @$fData['organization_website']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="">Logo</label>
	<div class="col-md-9 nopadd">
	<?php if($op == "edit"){ ?>	
			<div class="padd20">
			<img src="<?php echo $logopath; ?>" class="" style="max-height:60px;" />
			</div>
		
  	<?php } ?>
  	<input type="file" name="uplogo" id="uplogo" size="" style="width:100%;"   />
  	</div>
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="is_partner">Is Partner</label>
<div class="col-md-9 nopadd">
	<label><input type="checkbox" name="org[is_partner]" id="is_partner" <?php echo $is_partner; ?> class="radio" /> <em>(Yes / No)</em></label>
</div></div>


<div class="form-group">
<label class="textlabel col-md-3" for="published">Publish</label>
<div class="col-md-9 nopadd">
	<label><input type="checkbox" name="org[published]" id="published" <?php echo $published; ?> class="radio" /> <em>(Yes / No)</em></label>
</div></div>

<div>
	<div class="padd5"><h3>Contact Details</h3></div>
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="website">First Name</label>
<input type="text" name="user[namefirst]" id="namefirst" maxlength="100" class="text form-control col-md-9" value="<?php echo @$fData['namefirst']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="namelast">Last Name</label>
<input type="text" name="user[namelast]" id="namelast" maxlength="100" class="text form-control col-md-9" value="<?php echo @$fData['namelast']; ?>" />
</div>
	
<div class="form-group">
<label class="textlabel col-md-3" for="email">Email</label>
<input type="text" name="user[email]" id="email" maxlength="100" class="text form-control col-md-9" disabled value="<?php echo @$fData['email']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="phone">Telephone</label>
<input type="text" name="user[phone]" id="phone" maxlength="100" class="text form-control col-md-9"  value="<?php echo @$fData['phone']; ?>" />
</div>

<div class="form-group">
<label class="textlabel col-md-3" for="">Verified</label>
<input type="text" disabled class="col-md-3" disabled value="<?php echo @yesNoText($fData['uservalid']); ?>" />
</div>		


<div class="form-group">
<label class="textlabel col-md-3" for="group_id">Contact Access Level</label>
<div class="col-md-3 nopadd">
	<select name="user[group_id]" id="group_id" class="form-control required">
		<option value="1" <?php echo $group[1]; ?>>Administrator</option>
		<option value="2" <?php echo $group[2]; ?>>User</option>
		<option value="3" <?php echo $group[3]; ?>>Editor</option>
		<option value="4" <?php echo $group[4]; ?>>Contributor</option>
	</select>
</div></div>

<div>
	<div class="padd5"></div>
</div>

<div class="form-group">
	<label class="col-md-3" for="">&nbsp;</label>
	<div class="col-md-3 nopadd"><input type="submit" name="submit" id="Submit" value="Submit" /></div>
</div>	


	
</form>
</div>


	
			

	</div>
</div>