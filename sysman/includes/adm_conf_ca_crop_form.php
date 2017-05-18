<div style="width:90%; margin:0 auto; border:0px solid">
	
	<div style="padding:10px;">
	
<?php
$confDir = ucwords($dir);
$pgtitle			= "<h2>New $confDir</h2>";
$formname           = "fm_equipment";
$formaction         = "_new";
$fData 		      = array();
$fData['published'] = 1;
$fData['seq']	   = 9;

$fData['cat_parent']	= '';
$fData['cat_directory'] = 0;
$fData['cat_equipment'] = 0;

if($dir == 'directory entries') { $fData['cat_directory'] = 1; $fData['cat_parent'] = '_dir'; }
if($dir == 'cover crop entries') { $fData['cat_crop'] = 1; $fData['cat_parent'] = '_crp'; }



if($op=="edit")
{
	$pgtitle	   = "<h2>Edit $confDir</h2>";
	$formaction 	= "_edit";
	
	
	
	if($id)
	{
		
		$dispData->siteGallery();
	
		$sqdata="SELECT * FROM `dhub_reg_equipment` WHERE  (`id_equipment`  = ".quote_smart($id).")";
		//echo $sqdata;
		$rsdata 	   = $cndb->dbQuery($sqdata);
		$rsdata_count =  $cndb->recordCount($rsdata);
		
		$rs_fields = mysqli_num_fields($rsdata);
			
		if($rsdata_count == 1)
		{
			
			$cn_fields = $cndb->fetchRow($rsdata);
			
			/* ************************************************************** 
			@ get fields
			****************************************************************/
	
			for ($i = 0; $i<$rs_fields; $i++)
			{
				$field_names[$i] = mysql_fetch_field($rsdata, $i);			
				$fData[$field_names[$i]->name] = clean_output($cn_fields[$field_names[$i]->name]);
			}
			$eq_other = @unserialize($cn_fields['eq_other']);
			
			
			/* ************************************************************** 
			@ get images
			****************************************************************/
			$pic_list = '';
			if (array_key_exists($id, master::$listGallery['equip'])) 
			{
				foreach(master::$listGallery['equip'][$id] as $picVal)
				{
					$picArr 		= master::$listGallery['full'][$picVal];
					$pic_disp	 = '<img src="'.DISP_CA_GALLERY.$picArr['filename'].'" style="width:70px;" />';
					$pic_list 	.= '<span>'.$pic_disp.'</span> &nbsp; &nbsp;';
				}
			}
			
			
			/* ************************************************************** 
			@ get suppliers
			****************************************************************/	
			$suppliers = array();
		
			$sqdata_m = "SELECT `id_directory` FROM `dhub_reg_equipment_supplier` WHERE (`id_equipment` = ".quote_smart($id)."); ";
			
			$rsdata_m=$cndb->dbQuery($sqdata_m);
			if( $cndb->recordCount($rsdata_m)) 
			{
				while($cndata_m = $cndb->fetchRow($rsdata_m))
				{ $suppliers[] = $cndata_m['id_directory']; }
			}
		}
	}
	
}
	
$published = yesNoChecked($fData['published']);	
	
	?>


<div style="max-width:900px; margin:auto;">
<div style="text-align:center"><?php echo $pgtitle; ?></div>

<!-- content here [end] -->	
<form class="rwdform rwd-two-columnx rwdfull" name="fm_equipment" id="fm_equipment" method="post" action="adm_posts.php"  enctype="multipart/form-data">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="id" value="<?php echo @$fData['id_equipment']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />
<?php /*?><input type="hidden" name="redirect" value="hforms.php?d=<?php echo $dir; ?>&op=new" /> <?php */?>
<input type="hidden" name="entry_class" value="crop" />
<input type="hidden" name="eq_image" id="eq_image" value="" />

<?php /*?><fieldset style="margin-bottom:5px;">
<legend style="font-size:14px;">Basic Details</legend>
</fieldset><?php */?>
<div class="form-group">
<label class="textlabel control-label" for="id_category"> Category</label>
<div>
<select name="id_category" id="id_category" class="form-control required" >
	<?php echo $ddSelect->selectDirCategory(@$fData['id_category'], @$fData['cat_parent']) ?>
</select>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="eq_title">Name</label>
<div>
<input type="text" name="eq_title" id="eq_title" value="<?php echo @$fData['eq_title']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="eq_other_botanical">Botanical Name</label>
<div>
<input type="text" name="eq_other[botanical_name]" id="eq_other_botanical" value="<?php echo @$eq_other['botanical_name']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="eq_other_climate">Climate</label>
<div>
<input type="text" name="eq_other[climate]" id="eq_other_climate" value="<?php echo @$eq_other['climate']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="eq_other_altitude">Altitude</label>
<div>
<input type="text" name="eq_other[altitude]" id="eq_other_altitude" value="<?php echo @$eq_other['altitude']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="eq_other_uses">Other Uses</label>
<div>
<input type="text" name="eq_other[uses]" id="eq_other_uses" value="<?php echo @$eq_other['uses']; ?>" size="50" maxlength="100" class="text form-control"/>
</div> 
</div>

<?php /*?><div class="form-group">
<label class="textlabel control-label" for="eq_handling_class">Handling</label>
<div>
<input type="text" name="eq_handling_class" id="eq_handling_class" value="<?php echo @$fData['eq_handling_class']; ?>" class="text form-control"/>
</div> 
</div>
<?php */?>

<div class="form-group">
<label class="textlabel control-label" for="eq_other_recommend_rate">Recommended Seed Rate</label>
<div>
<input type="text" name="eq_other[recommend_rate]" id="eq_other_recommend_rate" value="<?php echo @$eq_other['recommend_rate']; ?>" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="eq_description">Description </label>
<div>
<textarea name="eq_description" id="eq_description" class="wysiwyg"><?php echo @$fData['eq_description']; ?></textarea>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="id_supplier"> Suppliers</label>
<div>
<select name="id_supplier[]" id="id_supplier" multiple="multiple" class="form-control multiple" >
	<?php echo $ddSelect->dropper_select("dhub_reg_directory", "id", "ac_organization", $suppliers) ?>
</select>
</div> 
</div>

<?php if($op == 'edit') { ?>
<div class="form-group">
<label class="textlabel control-label">Image(s)</label>
<div><?php echo @$pic_list; ?></div> 
</div>
<?php } ?>

<div class="form-group" style="height:50px; overflow:visible;">
<label class="textlabel control-label">Select Image</label>
<div>
  <div id="demoBasic"></div>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="upload_name">Upload New Image</label>
<div>
<input type="file" name="upload_name" id="upload_name" accept="image/*"   />
<input type="hidden" name="upload_cat" value="7" />
</div> 
</div>




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

<script type="text/javascript">
jQuery(document).ready(function($){
	<?php /*?>$.get('adm_gallery_pics.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
		$('#files').html(data);
	});<?php */?>
});
</script>