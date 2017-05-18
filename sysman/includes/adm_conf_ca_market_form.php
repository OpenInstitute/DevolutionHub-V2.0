<?php


if(isset($_POST['frm_submit']))
{
	
	$post	 = array_map("filter_data", $_POST);
	//displayArray($post);// exit;
		
	$redirect   = $_POST['redirect'];
	$formaction = $post['formact'];
	$field_names = array_keys($post['share']); 	
	
	$field_names[] = 'published';
	$field_names[] = 'expired';
	//$field_names[] = 'confirmed';
	
	//displayArray($field_names); 
	
	$myCols = array();
	$myDats = array();
	
	$myImg = "";
	
	foreach($field_names as $field)
	{
		if(	 $field == "formname"     or $field == "frm_submit" or $field == "txtCaptcha" or 
				$field == "s_pic1_text"  or $field == "s_pic2_text" or $field == "qf_agree" or 
				$field == "formtype"     or $field == "nah_snd" or $field == "s_vid" or 
				$field == "s_vid_text"   or $field == "id_product"        or $field == "redirect" )
		{	$mySql .= "";	}
		else
		{
			if($field <> "published" and $field <> "expired")
			{
				$fieldVal	= $post['share'][''.$field.''];
			}
			else
			{
				if(!array_key_exists(''.$field.'', $post)) { $post[''.$field.''] = 'off'; }
				
				$fieldVal = yesNoPost($post[''.$field.'']);
			}
			
			//if($field == "published") 	{ $fieldVal = yesNoPost($post[''.$field.'']); } 
			//if($field == "user_profession") { $fieldVal = @serialize($post['user_profession']); } 
			
			
			if($formaction == "_edit") {
				$myCols[] = " `$field` = ".quote_smart($fieldVal).""; 
			}			
			elseif($formaction == "_new"){ 
				$myCols[] = "`$field`";	
				$myDats[] = "".quote_smart($fieldVal)."";
			}
			
			
		}
	}
	
	if ($formaction=="_edit" ) {	
		$sqpost = "UPDATE `dhub_pub_adverts` set  ".implode($myCols, ', ')." where (`id_product` = ".quote_smart($post['id_product'])." )" ;		
	}
	if ($formaction=="_new" ) {	
		$sqpost  =  "insert into `dhub_pub_adverts` (".implode($myCols, ', ').") values (". implode($myDats, ', ') ."); ";
	}
	//echobr($sqpost); exit;
	$type	= new posts;
	$type->inserter_plain($sqpost);
	
	if ($formaction=="_new" ) { $id_story = $type->qLastInsert; }
	if ($formaction=="_edit" ) { $id_story = $post['id_product']; }
	
	$redirect = $redirect.'&op=edit&id='.$id_story; //exit;
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	exit;
}




$formname		= "conf_marketplace";
$formact		 = "_add";
$redirect 		= $ref_back;
$fData 		   = array();


$fData['published']  = 1;
$fData['expired']    = 0;
$fData['product_days'] =  7;
//$fData['id_partner'] = $u_id_partner;

if($op=="edit" and isset($id) or $op=="view" and isset($id))
{

$unit_function	= '';

	$sqdata="SELECT
  `id_product`,
  `id_category`,
  `product_name`,
  `product_name_seo`,
  `product_desc`,
  `product_cost`,
  `product_cost_curr`,
  `product_days`,
  `date_start`,
  `date_end`,
  `product_gallery`,
  `product_hits`,
  `contact_id`,
  `contact_name`,
  `contact_email`,
  `contact_name_first`,
  `contact_name_last`,
  `contact_phone`,
  `country`,
  `contact_address`,
  `date_record`,
  `verify_code`,
  `expired`,
  `published`
FROM `dhub_pub_adverts` WHERE (`id_product` = ".quote_smart($id).")";
	
	//echo $sqdata;
	
	$rsdata=$cndb->dbQuery($sqdata);// 
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
		
		$fData['date_start'] = ($cn_fields['date_start'] > 0) ? date('m/d/Y', $cn_fields['date_start']): '';
		$fData['date_end']   = ($cn_fields['date_end'] > 0) ? date('m/d/Y', $cn_fields['date_end']): '';
		
		
		$contact_id 		 = $cn_fields['contact_id'];
		
		if($contact_id <> '')
		{
	
			$sq_contact="SELECT concat_ws(' ', `firstname`, `lastname`) as `name`, `email` FROM `afp_conf_person_list` WHERE `id`  = ".quote_smart($contact_id)." ";
			$rs_contact = $cndb->dbQuery($sq_contact);
			if( $cndb->recordCount($rs_contact))
			{
				$cn_contact = $cndb->fetchRow($rs_contact, 'assoc');
				foreach($cn_contact as $cont_key => $cont_val)
				{
					$fData['contact_'.$cont_key.''] = $cont_val;
				}
			}
		}
		
	
	}
	
	//displayArray($fData);
	$formact		 = "_edit";
	$redirect		= "dashone.php?d=" . $dir; //RDR_REF_PATH;
	
	
} 

$published = yesNoChecked($fData['published']);
$expired = yesNoChecked($fData['expired']);


$story_files	 = '';
$story_files_arr = @unserialize($fData['product_gallery']); //displayArray($story_files_arr);

if(is_array($story_files_arr))
{
	foreach($story_files_arr as $key => $filearr)
	{
		$fname = $filearr['file'];
		$ftext = '<span style="color: green;">Caption: </span>' . clean_output($filearr['caption']);
			
		if(substr($key,0,3) == 'pic') {
			$ftype = '<span style="color: green;">Image: </span>';
			$flink = DISP_ADVERT.$fname;
			$fdisp = '<img src="'.DISP_ADVERT.$fname.'" style="width:70px; height:50px;" />';
		}
		
		if(substr($key,0,3) == 'vid') {
			$ftype = '<span style="color: green;">Video: </span>&nbsp;';
			$flink = $fname;
			$fdisp = '<img src="'.$flink.'" style="width:70px; height:50px;" />';
		}
		
		$story_files .= '<table><tr><td style="width:80px;">'.$fdisp.'</td><td>'.$ftype.'<a href="'.$flink.'">'.$fname.'</a><br>'.$ftext.'</td></tr></table>';
					
		//$story_files .= $ftype . ' <a href="'.$flink.'">'.$fname.'</a><br>'.$ftext.'<br><br>';
	}
}

$frmClass = '';
//if($op=="edit" and $u_id_partner <> 1 and $fData['id_partner'] <> $u_id_partner) { $frmClass = ' frmNoEdit '; }

?>

<div class="padd15" style="border:0px solid; width:auto; max-width:800px;">
<form  class="rwdform rwdfull <?php echo $frmClass; ?>" method="POST" name="frm_pub_adverts" id="frm_pub_adverts" action="hforms.php?d=<?php echo $dir; ?>">
<input type="hidden" name="id_product" id="id_product" value="<?php echo @$fData['id_product']; ?>">
<input type="hidden" name="contact_id" id="contact_id" value="<?php echo @$fData['contact_id']; ?>">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formact" value="<?php echo $formact; ?>" />
<input type="hidden" name="redirect" value="hforms.php?d=<?php echo $dir; ?>&op=edit" />



<h4>Advertisement Details</h4>
<div class="form-group">
<label class="textlabel control-label" for="id_category">Category</label>
<div>
<select name="share[id_category]" id="id_category" class="required">
		<?php echo $ddSelect->selectConfTypes(2, @$fData['id_category'], 0, 'Select Product Category'); ?>
	</select>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="product_name">Name</label>
<div>
<input type="text" name="share[product_name]" id="product_name" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['product_name']; ?>" />
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="product_desc">Description</label>
<div>
<textarea name="share[product_desc]" id="product_desc" style="height:45px;" class="textarea form-control"> <?php echo @$fData['product_desc']; ?> </textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="product_cost">Cost</label>
<div>
		<div class="subcolumns">
		<div class="c33l">
		<input type="text" name="product_cost" id="product_cost" maxlength="15" class="text form-control width-full txtright" value="<?php echo @$fData['product_cost']; ?>" >
		</div>
		<div class="c33l">
		<input type="text" name="product_cost_curr" id="product_cost_curr" size="10" maxlength="10" class="text form-control width-full"  value="<?php echo @$fData['product_cost_curr']; ?>" />
		</div>
		</div>


</div> 
</div>



<div class="form-group">
<label class="textlabel control-label" for="product_days">Start Date / End Date / Days</label>
<div>

	<div class="subcolumns">
		
		<div class="c33l">
		<input type="text" name="date_start" id="date_start" size="20" maxlength="20" class="text form-control width-full" value="<?php echo @$fData['date_start']; ?>" >
		</div>
		
		<div class="c33l">
		<input type="text" name="date_end" id="date_end" size="20" maxlength="20" class="text form-control width-full" value="<?php echo @$fData['date_end']; ?>" >
		</div>
		
		<div class="c33l">
		<input type="text" name="product_days" id="product_days" size="11" maxlength="11" class="text form-control width-full" value="<?php echo @$fData['product_days']; ?> days" >
		</div>
		
	</div>
		

</div> 
</div>



<div class="form-group">
<label class="textlabel control-label" for="product_gallery">Product Gallery</label>
<div>
<?php echo $story_files; ?>
</div> 
</div>






<div class="form-group">
<label class="textlabel control-label" for="expired">Expired</label>
<div>

<label class="radiolabel" for="expired">
		<input type="checkbox" name="expired" id="expired" value="<?php echo $fData['expired']; ?>" <?php echo $expired; ?> class="radio-inline"/>  
	 Yes / No</label>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>

<div class="input-group padd5_t">	
	<label class="radiolabel control-labelx" for="published">
		<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio-inline"/>  
	 Yes / No</label>
</div>
</div>


<div class="form-group">&nbsp;</div>


<h4>Contact Details</h4>

<div class="form-group">
<label class="textlabel control-label" for="contact_name"> Name</label>
<div>
<input type="text" name="contact[name]" id="contact_name" size="50" maxlength="100" class="text form-control" value="<?php echo @$fData['contact_name']; ?>" style="border:none;" readonly="readonly" />
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="contact_email">Email</label>
<div>
<input type="text" name="contact[email]" id="contact_email" size="50" maxlength="100" class="email form-control" value="<?php echo @$fData['contact_email']; ?>" style="border:none;" readonly="readonly" />
</div> 
</div>



<?php /*?><div class="form-group">
<label class="textlabel control-label" for="contact_phone">Contact Phone</label>
<div>
<input type="text" name="contact_phone" id="contact_phone" size="50" maxlength="50" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="country">Country</label>
<div>
<input type="text" name="country" id="country" size="10" maxlength="10" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="contact_address">Contact Address</label>
<div>
<input type="text" name="contact_address" id="contact_address" size="50" maxlength="50" class="text form-control"/>
</div> 
</div><?php */?>


<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<button type="submit" class="btn btn-success" id="f_submit" name="frm_submit" value="1"><i class="glyphicon glyphicon-plus"></i>Submit</button>
</div>

</div>



</form>

</div>

