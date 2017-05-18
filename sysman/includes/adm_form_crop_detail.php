<div style="width:90%; margin:0 auto; border:0px solid">
	
	<div style="padding:10px;">
	
<?php
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }

$fData 		   		 = array();
$fData['published']	= 'checked';
$fData['seq']		  = 9;

$confDir = ucwords($dir);
	
if($op=="edit"){ $title_new	= "Edit "; }  elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

$pgtitle				="<h2>Edit $confDir</h2>";

	if($id)
	{
	
	$sqdata="SELECT
    `id_product`
    , `id_product_category`
    , `id_unit_label`
    , `id_unit_volume`
    , `product`
    , `description`
    , `published`
FROM
    `dhub_app_product_detail`
WHERE (`id_product` = $id);";
	//echo $sqdata;
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
	
	$rs_fields = mysqli_num_fields($rsdata);
	
	
	if($rsdata_count==1)
	{
		$cn_fields = $cndb->fetchRow($rsdata);
		
		for ($i = 0; $i<$rs_fields; $i++)
		{
			$field_names[$i] = mysql_fetch_field($rsdata, $i);			
			$fData[$field_names[$i]->name] = $cn_fields[$field_names[$i]->name];
		}	
	}
	//displayArray($fData);
						
		if($published==1) {$published="checked ";} else {$published="";}
				
		$formname			= "fm_cropdetail_edit";
		
	}
} elseif($op="new")
	{
	
		$pgtitle				="<h2>New $confDir</h2>";
		
		$published			="checked ";
		$position			= 9;		
		
		$formname			= "fm_cropdetail_new";
	}
	
	
	?>



	<!-- content here [end] -->	
	<form class="admform" name="rage" method="post" action="adm_posts.php">
	<?php echo $pgtitle; ?>


<div class="form-group">
<label class="textlabel control-label" for="id_product_category">Product Category</label>
<select name="id_product_category" id="id_product_category" class="text form-control">
<?php echo $ddSelect->dropper_select("dhub_app_product_category", "id_product_category", "product_category", @$fData['id_product_category']) ?>
</select>
</div>

<div class="form-group">
<label class="textlabel control-label" for="id_unit_label">Unit Label</label>
<select name="id_unit_label" id="id_unit_label" class="text form-control">
<?php echo $ddSelect->dropper_select("dhub_app_crop_unit_labels", "id_unit_label", "unit_short", @$fData['id_unit_label']) ?>
</select>
</div>

<div class="form-group">
<label class="textlabel control-label" for="id_unit_volume">Unit Volume</label>
<select name="id_unit_volume" id="id_unit_volume" class="text form-control">
<?php echo $ddSelect->dropper_select("dhub_app_crop_unit_labels", "id_unit_label", "unit_short", @$fData['id_unit_volume']) ?>
</select>
</div>

<div class="form-group">
<label class="textlabel control-label" for="product">Product</label>
<input type="text" name="product" id="product" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['product']; ?>"/>
</div>

<div class="form-group">
<label class="textlabel control-label" for="description">Description</label>
<textarea name="description" id="description" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['description']; ?></textarea>
</div>

<div class="form-group">
<label class="textlabel control-label" for="published">Is Active</label>
<div class="input-group">	
	<label class="radiolabel control-labelx" for="published">
	<input type="checkbox" name="published" id="published" <?php echo yesNoChecked(@$fData['published']); ?> class="radio"/>    Yes / No</label>
</div>
</div>


<div>
<input type="submit" name="Submit" value="Submit" />
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="id_product" value="<?php echo @$fData['id_product']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />
</div>	
	</form>
	
			

	</div>
</div>