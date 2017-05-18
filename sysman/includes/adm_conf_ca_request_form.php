<?php

$formname		= "conf_orders";
$formact		 = "_add";
$redirect 		= $ref_back;
$fData 		   = array();


$fData['published']  = 1;
$fData['archived']    = 0;
$fData['product_days'] =  7;
//$fData['id_partner'] = $u_id_partner;

if($op=="edit" and isset($id) or $op=="view" and isset($id))
{

$unit_function	= '';

	$sqdata="SELECT
  `id`,
  `id_directory_cat`,
  `ac_organization`,
  `ac_speciality`,
  `ac_town`,
  `ac_region`,
  `ac_country`,
  `ac_gps`,
  `ac_address_physical`,
  `ac_address_post`,
  `ac_phone`,
  `ac_fax`,
  `ac_email`,
  `ac_website`,
  `contact_id`,
  `ac_contact_name`,
  `ac_contact_email`,
  `ac_contact_phone`,
  `ac_year_engage`,
  `date_record`,
  `src_public`,
  `src_public_items`,
  `src_reference`,
  `src_authcode`,
  `published`,
  `newsletter`
FROM `dhub_reg_directory` WHERE (`src_public` =1) and (`id` = ".quote_smart($id).")";
	
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
		
		$fData['date_record'] = ($cn_fields['date_record'] > 0) ? date('m/d/Y', strtotime($cn_fields['date_record'])): '';
		
		
		$contact_id 		 = $cn_fields['contact_id'];
		
		/*if($contact_id <> '')
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
		}*/
		
	
	}
	
	//displayArray($fData);
	$formact		 = "_edit";
	$redirect		= "dashone.php?d=" . $dir; //RDR_REF_PATH;
	
	
} 

$published = yesNoChecked($fData['published']);
//$archived = yesNoChecked($fData['archived']);




$src_reference = @$fData['src_reference']; 

$listingLabels['inputs_select_cat'] = '_eqp';
$listingLabels['inputs_label']	  = 'Equipment';

$inputs_select_cat = '_eqp';
if($src_reference == 'crop_register') 
{ 
	$listingLabels['inputs_select_cat'] = '_crp'; 
	$listingLabels['inputs_label']	  = 'Product';
}



$story_files	 = '';
$products_arr = @unserialize($fData['src_public_items']); //displayArray($products_arr);

$prod_row	 = array();


if(is_array($products_arr))
{
	foreach($products_arr as $key => $prodarr)
	{
		$prod_cat = $prodarr['cat'];
		$prod_name = clean_output($prodarr['name']);
		$prod_desc = clean_output($prodarr['desc']);
		
		$equipCats = $ddSelect->selectDirCategory($prod_cat, $listingLabels['inputs_select_cat']);
		
		$prod_row[] = '<tr>
	<td><select name="input[{0}][cat]" id="input_cat_{0}" class="required">'.$equipCats.'</select>    </td>
	<td><input type="text" name="input[{0}][name]" id="input_name_{0}" value="'.$prod_name.'" ></td>
	<td><input type="text" name="input[{0}][desc]" id="input_desc_{0}" value="'.$prod_desc.'"></td>
</tr>';
		
	}
}


$frmClass = '';
//if($op=="edit" and $u_id_partner <> 1 and $fData['id_partner'] <> $u_id_partner) { $frmClass = ' frmNoEdit '; }

?>

<div class="padd15" style="border:0px solid; width:auto; max-width:800px;">
<form  class="rwdform rwdfull <?php echo $frmClass; ?>" method="POST" name="frm_pub_adverts" id="frm_pub_adverts" action="#">
<input type="hidden" name="id_product" id="id_product" value="<?php echo @$fData['id_product']; ?>">
<input type="hidden" name="contact_id" id="contact_id" value="<?php echo @$fData['contact_id']; ?>">
<input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo @$fData['supplier_id']; ?>">
<input type="hidden" name="item_id" id="item_id" value="<?php echo @$fData['item_id']; ?>">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formact" value="<?php echo $formact; ?>" />
<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />





<h4>Organization Details</h4>



<div class="form-group">
<label class="textlabel control-label" for="ac_organization">Organization</label>
<div>
<input type="text" name="ac_organization" id="ac_organization" size="50" maxlength="100" class="text form-control fldNoEdit"  value="<?php echo @$fData['ac_organization']; ?>" />
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="id_directory_cat">Category</label>
<div>
<select name="id_directory_cat" id="id_directory_cat" class="form-control fldNoEdit">
		<option value="">Select Category</option>
		<?php echo $ddSelect->selectDirCategory(@$fData['id_directory_cat']) //@$fData['cat_parent'] ?>
	</select>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="ac_country">Country</label>
<div>
<select name="ac_country" id="ac_country" class="form-control fldNoEdit">
		<?php echo $ddSelect->dropper_sel_title("dhub_reg_countries", "iso_code_2", "country", @$fData['ac_country']) ?>
	</select>
</div> 
</div>



<h4>Product Details</h4>

<div>

<table width="100%" border="0" cellspacing="0" id="party" class="table noborder nopadd nomargin">
		<thead>
		  <tr>
			<td style="width:40%"><div class="padd5 bold"><?php echo $listingLabels['inputs_label']; ?> Category:</div></td>
			<td style="width:30%"><div class="padd5 bold"><?php echo $listingLabels['inputs_label']; ?> Name: </div></td>
			<td><div class="padd5 bold">Description:</div></td>
		  </tr>
		</thead>
	  <tbody>
	  <?php echo implode("", $prod_row); ?>
	  </tbody>
	  
</table>  
</div>







<h4>Contact Details</h4>


<div class="form-group">
<label class="textlabel control-label" for="ac_contact_name">Contact Name</label>
<div>
<input type="text" name="ac_contact_name" id="ac_contact_name" size="50" maxlength="50" class="text form-control fldNoEdit" value="<?php echo @$fData['ac_contact_name']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ac_contact_email">Contact Email</label>
<div>
<input type="text" name="ac_contact_email" id="ac_contact_email" size="50" maxlength="50" class="text form-control fldNoEdit" value="<?php echo @$fData['ac_contact_email']; ?>" />
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="date_record">Request Date</label>
<div>
<input type="text" name="date_record" id="date_record" size="19" maxlength="19"  value="<?php echo @$fData['date_record']; ?>" class="text form-control fldNoEdit"/>
</div> 
</div>

<h4>&nbsp;</h4>

<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>

<div class="input-group padd5_t">	
	<label class="radiolabel control-labelx" for="published">
		<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio-inline"/>  
	 Yes / No</label>
</div>
</div>



<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<button type="submit" class="btn btn-success" id="f_submit" name="submit" value="1"><i class="glyphicon glyphicon-plus"></i>Submit</button>
</div>

</div>



</form>

</div>

