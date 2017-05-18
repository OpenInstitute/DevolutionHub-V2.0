<div style="margin:0; border:2px solid #fff; position:relative; clear:both;">

<!-- @@ COL 1 -->
<div style="float:left; width:64%;  position:relative;border-right:1px solid #E5E5E5;">

<div style="padding:10px 20px 10px 0px;">
	
<?php
$confDir = ucwords($dir);
$pgtitle			= "<h2>New $confDir</h2>";
$formname           = "fm_directory";
$formaction         = "_new";
$fData 		      = array();
$fData['published'] = 1;
$fData['seq']	   = 9;

$fData['cat_parent']	= '';
$fData['cat_directory'] = 0;
$fData['cat_equipment'] = 0;

if($dir == 'directory entries') { $fData['cat_directory'] = 1; $fData['cat_parent'] = '_dir'; }
if($dir == 'equipment entries') { $fData['cat_equipment'] = 1; $fData['cat_parent'] = '_eqp'; }



if($op=="edit")
{
	$pgtitle	   = "<h2>Edit $confDir</h2>";
	$formaction 	= "_edit";
	
	
	
	if($id)
	{
	
		$sqdata="SELECT * FROM `dhub_reg_directory` WHERE  (`id`  = ".quote_smart($id).")";
		//echo $sqdata;
		$rsdata 	   = $cndb->dbQuery($sqdata);
		$rsdata_count =  $cndb->recordCount($rsdata);
		
		$rs_fields = mysqli_num_fields($rsdata);
			
		if($rsdata_count == 1)
		{
			
			$cn_fields = $cndb->fetchRow($rsdata);
			
			for ($i = 0; $i<$rs_fields; $i++)
			{
				$field_names[$i] = mysql_fetch_field($rsdata, $i);			
				$fData[$field_names[$i]->name] = $cn_fields[$field_names[$i]->name];
			}
			
					
			
		}
	}
	
}
	
$published = yesNoChecked($fData['published']);	
	
	?>

<div style="max-width:; margin:0;">
<div style="text-align:"><?php echo $pgtitle; ?></div>

<!-- content here [end] -->	
<form class="rwdform rwd-two-columnx rwdfull" name="fm_directory_cat" id="fm_directory_cat" method="post" action="adm_posts.php">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="id" value="<?php echo @$fData['id']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />


<fieldset class="rwd-two-columnx">
<legend style="font-size:14px;">Basic Details</legend>

<div class="form-group">
<label class="textlabel control-label" for="id_directory_cat"> Category</label>
<div>
<select name="id_directory_cat" id="id_directory_cat" class="form-control required" >
	<?php echo $ddSelect->selectDirCategory(@$fData['id_directory_cat'], @$fData['cat_parent']) ?>
</select>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_organization">Name</label>
<div>
<input type="text" name="ac_organization" id="ac_organization" value="<?php echo @$fData['ac_organization']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="ac_speciality">Speciality</label>
<div>

<input type="text" name="ac_speciality" id="ac_speciality" value="<?php echo @$fData['ac_speciality']; ?>" class="text form-control"/>
</div> 
</div>

</fieldset>


<fieldset class="rwd-two-column">
<legend>Organization Contact Details</legend>


<div class="form-group">
<label class="textlabel control-label" for="ac_country">Country</label>
<div>
<input type="text" name="ac_country" id="ac_country" value="<?php echo @$fData['ac_country']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="ac_town">Town</label>
<div>
<input type="text" name="ac_town" id="ac_town" value="<?php echo @$fData['ac_town']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div>

<?php /*?><div class="form-group">
<label class="textlabel control-label" for="ac_region">Region</label>
<div>
<input type="text" name="ac_region" id="ac_region" value="<?php echo @$fData['ac_region']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div><?php */?>
<?php /*?><div class="form-group">
<label class="textlabel control-label" for="ac_gps">GPS</label>
<div>
<input type="text" name="ac_gps" id="ac_gps" value="<?php echo @$fData['ac_gps']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div><?php */?>


<div class="form-group">
<label class="textlabel control-label" for="ac_address_physical">Physical Address </label>
<div>
<input type="text" name="ac_address_physical" id="ac_address_physical" value="<?php echo @$fData['ac_address_physical']; ?>"  class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_address_post">Postal Address</label>
<div>
<input type="text" name="ac_address_post" id="ac_address_post" value="<?php echo @$fData['ac_address_post']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_phone">Phone</label>
<div>
<input type="text" name="ac_phone" id="ac_phone" value="<?php echo @$fData['ac_phone']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_fax">Fax</label>
<div>
<input type="text" name="ac_fax" id="ac_fax" value="<?php echo @$fData['ac_fax']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_email">Email</label>
<div>
<input type="text" name="ac_email" id="ac_email" value="<?php echo @$fData['ac_email']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_website">Website</label>
<div>
<input type="text" name="ac_website" id="ac_website" value="<?php echo @$fData['ac_website']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

</fieldset>


<fieldset class="rwd-two-column">
<legend> Contact Person</legend>

<div class="form-group">
<label class="textlabel control-label" for="ac_contact_name">Contact Name</label>
<div>
<input type="text" name="ac_contact_name" id="ac_contact_name" value="<?php echo @$fData['ac_contact_name']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_contact_email">Contact Email</label>
<div>
<input type="text" name="ac_contact_email" id="ac_contact_email" value="<?php echo @$fData['ac_contact_email']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_contact_phone">Contact Phone</label>
<div>
<input type="text" name="ac_contact_phone" id="ac_contact_phone" value="<?php echo @$fData['ac_contact_phone']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

</fieldset>


<?php /*?><div class="form-group">
<label class="textlabel control-label" for="ac_year_engage">Year of Engagement</label>
<div>
<input type="text" name="ac_year_engage" id="ac_year_engage" value="<?php echo @$fData['ac_year_engage']; ?>" size="50" maxlength="50" class="text form-control"/>
</div> 
</div><?php */?>



<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>
<div>
<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em>
</div></div>

<div class="form-group">
<div><input type="submit" name="submit" id="Submit" value="Submit" /></div>
</div>	


	
</form>
</div>


</div>
	
</div>
<!-- @@ end: COL 1 -->


<!-- @@ COL 2 -->
<div style="float:left; width:33%; position:relative;">
<div style="padding:10px 10px 10px 25px;">

<h2>Directory Equipments / Cover Crops</h2>

<div style="background:#FFC; padding: 10px; border:1px solid #ccc; margin-bottom:20px;">


<form class="" id="fm_directory_products" name="fm_directory_products" method="post" action="adm_posts.php">
<input type="hidden" name="formname" value="fm_directory_products" />
<input type="hidden" name="formaction" value="_new" />
<input type="hidden" name="id_supplier" value="<?php echo $id; ?>" />
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />
<input type="hidden" name="redirect" value="hforms.php?d=<?php echo $dir; ?>&op=edit&id=<?php echo $id; ?>" />
<?php /*?><?php */?>
	<div class="form-group">
	<label class="textlabel control-label" for="id_equipment"> Select Products / Services</label>
	<div>
	<select name="id_equipment[]" id="id_equipment" multiple="multiple" class="form-control multiple" style="width:100% !important" >
		<?php echo $caData->get_equipment_select();  ?>
	</select>
	</div> 
	</div>
	
	<div class="form-group">
	<div><input type="submit" name="submit" id="Submit" value="Add" /></div>
	</div>	
</form>


</div>
<div>
<?php
$sqList = "SELECT
    `dhub_reg_equipment`.`id_equipment` AS `id`
    , `dhub_reg_equipment`.`entry_class` AS `class`
    , `dhub_reg_equipment`.`eq_title` AS `name`
    , `dhub_reg_equipment`.`published` AS `visible`
FROM
    `dhub_reg_equipment`
    INNER JOIN `dhub_reg_equipment_supplier` 
        ON (`dhub_reg_equipment`.`id_equipment` = `dhub_reg_equipment_supplier`.`id_equipment`)
WHERE (`dhub_reg_equipment_supplier`.`id_directory` = ".quote_smart($id).");";
		//echo $sqList;		
	$dir_manual = "equipment entries";	
	  echo $m2_data->getData($sqList,"hforms.php?d=$dir_manual&",0);
?>
</div>



</div>
</div>
<!-- @@ end: COL 2 -->	

<div style="clear:both;">&nbsp;</div>
</div>