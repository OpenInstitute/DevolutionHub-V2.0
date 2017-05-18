<div style="width:90%; margin:0 auto; border:0px solid">
	
	<div style="padding:10px;">
	
<?php
$confDir 			= ucwords($dir);

$pgtitle			= "<h2>New $confDir</h2>";
$formname           = "fm_directory_cat";
$formaction         = "_new";

$fData 		      = array();
$fData['published'] = 1;
$fData['seq']	   = 9;

$fData['cat_directory'] = 0;
$fData['cat_equipment'] = 0;

if($dir == 'directory categories') { $fData['cat_directory'] = 1; }
if($dir == 'equipment categories') { $fData['cat_equipment'] = 1; }

if($op=="edit"){

	if($id){
	
	$sqdata="SELECT `id`, `id_menu`, `cat_directory`, `cat_equipment`, `title`, `description`, `published`, `seq` FROM `dhub_reg_directory_category` WHERE  (`id`  = ".quote_smart($id).")";
	//echo $sqdata;
	$rsdata = $cndb->dbQuery($sqdata);// ;
	$rsdata_count =  $cndb->recordCount($rsdata);
	$rs_fields = mysqli_num_fields($rsdata);
	
		
		if($rsdata_count == 1)
		{
		$pgtitle				="<h2>Edit $confDir</h2>";
		$cn_fields = $cndb->fetchRow($rsdata);
		
		for ($i = 0; $i<$rs_fields; $i++)
		{
			$field_names[$i] = mysql_fetch_field($rsdata, $i);			
			$fData[$field_names[$i]->name] = $cn_fields[$field_names[$i]->name];
		}
				
		$formaction			= "_edit";
		}
	}
}
	
$published = yesNoChecked($fData['published']);	
	
	?>

<div style="max-width:900px; margin:auto;">
<div style="text-align:center"><?php echo $pgtitle; ?></div>

	
<form class="rwdform" name="fm_directory_cat" id="fm_directory_cat" method="post" action="adm_posts.php">
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="id" value="<?php echo @$fData['id']; ?>" />
<input type="hidden" name="cat_directory" id="cat_directory" value="<?php echo @$fData['cat_directory']; ?>">
<input type="hidden" name="cat_equipment" id="cat_equipment" value="<?php echo @$fData['cat_equipment']; ?>">
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />



<div class="form-group">
<label class="textlabel control-label" for="title">Title</label>
<div>
<input type="text" name="title" id="title" size="50" maxlength="100" class="text form-control" value="<?php echo @$fData['title']; ?>" />
</div></div>

<?php
if($dir == 'equipment categories'){
?>
<div class="form-group">
<label class="selectlabel control-label" for="id_menu">Parent Menu</label>
<div>
<select name="id_menu" id="id_menu" size="1" class="select form-control">
   <?php echo  $dispData->build_MenuSelectRage(0, $fData['id_menu']);
		  //$dispData->build_MenuSelect($dispData->menuMain_portal, $fData['id_menu'], 0); ?>
</select>
</div></div>
<?php
}
?>

<div class="form-group">
<label class="textlabel control-label" for="description">Description</label>
<div>
<textarea name="description" id="description" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['description']; ?></textarea>
</div></div>

<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>
<div>
<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em>
</div></div>

<?php /*?><div class="form-group">
<label class="textlabel control-label" for="seq">Seq</label>
<div>
<input type="text" name="seq" id="seq" size="11" maxlength="11" class="text form-control" value="<?php echo @$fData['seq']; ?>">
</div></div>	<?php */?>

<div class="form-group">
<div><input type="submit" name="submit" id="Submit" value="Submit" /></div>
</div>	


	
</form>
</div>


	
			

	</div>
</div>