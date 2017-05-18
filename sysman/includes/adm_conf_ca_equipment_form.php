<div style="margin:0; border:2px solid #fff; position:relative; clear:both;">

<div style="width:60%; margin:0; border-right:1px solid #E5E5E5; float:left;">
	
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
<form class="rwdform rwdfull" name="fm_equipment" id="fm_equipment" method="post" action="adm_posts.php"  enctype="multipart/form-data">
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
<label class="textlabel control-label" for="id_equipment_parent"> Parent Item</label>
<div>
<select name="id_equipment_parent" id="id_equipment_parent" class="form-control" style="width:100% !important" >
	<?php echo $caData->get_equipment_select(@$fData['id_equipment_parent'])  ?>
</select>
</div> 
</div>


<?php /*?><div class="form-group">
<label class="textlabel control-label" for="id_supplier"> Suppliers</label>
<div>
<select name="id_supplier[]" id="id_supplier" multiple="multiple" class="form-control multiple" >
	<?php echo $ddSelect->dropper_select("dhub_reg_directory", "id", "ac_organization", $suppliers) ?>
</select>
</div> 
</div><?php */?>


<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>
<div>
<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em>
</div></div>




<?php /*?><div class="form-group">
<label class="textlabel control-label">Image(s)</label>
<div>
<?php echo $pic_list; ?>

</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="upload_name">Upload New Image</label>
<div>
<input type="file" name="upload_name" id="upload_name" accept="image/*"   />
<input type="hidden" name="upload_cat" value="7" />
</div> 
</div><?php */?>




<div class="form-group">
<div><input type="submit" name="submit" id="Submit" value="Submit" /></div>
</div>	


	
</form>
</div>
	

	</div>
</div>



<div style="width:38%; margin:0; border:1px solid #F7F7F7; float:right;">
<h2>Gallery</h2>
<div class="subcolumns" style="display:block; width:100%;">
<p id="f1_upload_process" align="center">Loading...<br/><img src="image/loader.gif" /><br/></p>
<form action="adm_posts.php" method="post"  enctype="multipart/form-data" onsubmit="startEqUpload();" target="post_target" >
<fieldset style="background:#f7f7f7;">
		<div id="f1_upload_form">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%">
		<tr>
		<td style="width:40%"><input type="file" name="upload_name" id="upload_name" accept="image/*" style="height:34px !important; padding:0;"   /></td>
		<td style="width:40%"><input name="photo_title" id="photo_title" type="text" style="width:99%" placeholder="Enter Caption" /></td>
		<td>
		<input type="submit" name="submitBtn" id="upload"  value="Upload New" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="formname" value="fm_equipment_gallery" />
			<input type="hidden" name="redirect" value="<?php echo $this_page."?d=".$dir."&op=edit&id=".$id; ?>" />
		</td>
		</tr>
		</table>
		</div>
</fieldset>
</form>
<iframe id="post_target" name="post_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</div>

<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%">
	<tr><td><ul id="files" style="display:block; width:100%;" ></ul></td></tr>
</table>
</div>



<div>
<h2>Suppliers</h2>
<div>
<?php
$sqList = "SELECT
    `dhub_reg_directory`.`id`
    , `dhub_reg_directory`.`ac_organization` AS `name`
    , `dhub_reg_directory`.`ac_country` AS `country`
    , `dhub_reg_directory`.`published` AS `visible`
FROM
    `dhub_reg_equipment_supplier`
    INNER JOIN `dhub_reg_directory` 
        ON (`dhub_reg_equipment_supplier`.`id_directory` = `dhub_reg_directory`.`id`)
WHERE (`dhub_reg_equipment_supplier`.`id_equipment` = ".quote_smart($id).") ; ";
			
$dir_manual = "directory entries";	
echo $m2_data->getData($sqList,"hforms.php?d=$dir_manual&",0);

?>
</div>
</div>



</div>


<div style="clear:both;">&nbsp;</div>
</div>


<script type="text/javascript">
	<!--
	function startEqUpload(){
		  document.getElementById('f1_upload_process').style.visibility = 'visible';
		  document.getElementById('f1_upload_form').style.visibility = 'hidden';
		  return true;
	}
	
	function stopEqUpload(success, the_file){
		  var result = '';
		  if (success == 1){
			 result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
		  }
		  else {
			 result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
		  }
		  
		  $(function(){
		  	var isuccess = success;
			var ifile = the_file;
			
			if (success == 1){
		  		showEqUploads();
				//$('<li></li>').appendTo('#files').html('<img src="'+ifile+'" alt="" /><br />'+ifile).addClass('success');
			 }
		  	else {
				//$('<li></li>').appendTo('#files').text(ifile).addClass('error');
			}
		  });
		  document.getElementById('f1_upload_process').style.visibility = 'hidden';   
		  document.getElementById('image_title').value = '';   
		  document.getElementById('image_myfile').value = '';  
		  return true;   
	}
	
	function showEqUploads(){
	  jQuery(document).ready(function($){  
			
			$.get('eq_pics.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
			$('#files').html(data);
			});
			  
	   });
	}
	
	jQuery(document).ready(function(){
		showEqUploads();
	 });
	//-->
</script>