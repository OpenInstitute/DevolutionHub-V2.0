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
    `id_unit_label`
    , `unit_short`
    , `unit_long`
    , `published`
FROM
    `dhub_app_crop_unit_labels`
WHERE (`id_unit_label` = $id);";
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
				
		$formname			= "fm_croplabels_edit";
		
	}
} elseif($op="new")
	{
	
		$pgtitle				="<h2>New $confDir</h2>";
		
		$published			="checked ";
		$position			= 9;		
		
		$formname			= "fm_croplabels_new";
	}
	
	
	?>



	<!-- content here [end] -->	
	<form class="admform" name="rage" method="post" action="adm_posts.php">
	<?php echo $pgtitle; ?>


<div class="form-group">
<label class="textlabel control-label" for="unit_short">Unit Label</label>
<input type="text" name="unit_short" id="unit_short" size="10" maxlength="10" class="text form-control" value="<?php echo @$fData['unit_short']; ?>"/>
</div>

<div class="form-group">
<label class="textlabel control-label" for="unit_long">Unit Description</label>
<input type="text" name="unit_long" id="unit_long" size="20" maxlength="20" class="text form-control" value="<?php echo @$fData['unit_long']; ?>"/>
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
<input type="hidden" name="id_unit_label" value="<?php echo @$fData['id_unit_label']; ?>" />
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />
</div>	
	</form>
	
			

	</div>
</div>