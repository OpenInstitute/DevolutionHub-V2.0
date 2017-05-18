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
if($dir == 'equipment entries') { $fData['cat_equipment'] = 1; $fData['cat_parent'] = '_eqp'; }



if($op=="edit")
{
	$pgtitle	   = "<h2>Edit $confDir</h2>";
	$formaction 	= "_edit";
	
	
	
	if($id)
	{
	
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
				$fData[$field_names[$i]->name] = $cn_fields[$field_names[$i]->name];
			}
			
			/* ************************************************************** 
			@ get images
			****************************************************************/
			$pic_list = '';
			if (array_key_exists($id, master::$listGallery['equip'])) 
			{ 
				foreach(master::$listGallery['equip'][$id] as $picVal)
				{
					$picArr 		= master::$listGallery['full'][$picVal]; //displayArray($picArr);
					$pic_disp	 = '<img src="'.DISP_CA_GALLERY.$picArr['filename'].'" style="width:70px;" />';
					$pic_list 	.= '<span>'.$pic_disp.'<br>'.$picArr['title'].'</span> &nbsp; &nbsp;';
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
<input type="hidden" name="entry_class" value="equipment" />

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
<label class="textlabel control-label" for="eq_handling_class">Handling</label>
<div>
<input type="text" name="eq_handling_class" id="eq_handling_class" value="<?php echo @$fData['eq_handling_class']; ?>" class="text form-control"/>
</div> 
</div>



<div class="form-group">
<label class="textlabel control-label" for="eq_description">Description </label>
<div>
<textarea name="eq_description" id="eq_description"><?php echo @$fData['eq_description']; ?></textarea>
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


<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>
<div>
<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em>
</div></div>




<div class="form-group">
<label class="textlabel control-label">Image(s)</label>
<div>
<?php echo $pic_list; //@$fData['eq_image']; ?>
<?php /*?><input type="text" name="eq_image" id="eq_image" value="<?php echo @$fData['eq_image']; ?>" class="text form-control"/><?php */?>

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
<div><input type="submit" name="submit" id="Submit" value="Submit" /></div>
</div>	


	
</form>
</div>


<hr />


<form action="adm_gallery_upload.php" method="post"  enctype="multipart/form-data" >
<!-- onsubmit="startUpload();" target="_blank"  -->
<fieldset style="background:#f7f7f7;">
		
		<div id="file_box_photo">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:770px">
		<tr>
		<td style="width:100px;"> <label for="photo_name"><strong>Upload Photo:</strong>: </label> </td>
		<td><input type="file" name="myfile" id="photo_name" size="57"   /></td>
		<td><strong>OR Enter Name:</strong></td>
		<td><input type="text" name="image_link" id="image_link" style="width:265px;" /></td>
		</tr>
		<tr>
		  <td><label for="photo_title">Picture Title:</label> </td>
		  <td colspan="3"><input name="photo_title" id="photo_title" type="text" style="width:99%" value="<?php echo $article_title; ?>" /></td>
		  </tr>
		<tr>
		<td><label for="photo_caption"> Picture Caption: </label></td>
		<td colspan="3"><textarea name="photo_caption" id="photo_caption" class="text_full" style="height:30px;width:99%"><?php echo $file_caption; ?></textarea> </td>
		</tr>
		<tr>
			<td><label for="id_gallery_cat"><strong>Category:</strong></label></td>
			<td><select name="id_gallery_cat" id="id_gallery_cat" style="width:270px;">
	            <?php echo $ddSelect->dropper_select("dhub_dt_gallery_category", "id", "title", 2) ?>
	            </select></td>
			<td></td>
			<td></td>
		</tr>
		</table>
		</div>		
		<input type="submit" name="submitBtn" id="upload"  value="Submit Form" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="formname" value="gall_content" />
			<input type="hidden" name="redirect" value="<?php echo "adm_gallery_albums.php?d=".$dir."&op=edit&id=".$id; ?>" />
			
</fieldset>
</form>
	
			

	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	<?php /*?>$.get('adm_gallery_pics.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
		$('#files').html(data);
	});<?php */?>
});
</script>