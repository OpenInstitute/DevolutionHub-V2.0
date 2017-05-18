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
  `post_id`,
  `post_sess`,
  `post_date`,
  `post_form`,
  `post_status`,
  `post_type`,
  `item_id`,
  `item_name`,
  `item_quantity`,
  `item_notes`,
  `supplier_id`,
  `supplier_name`,
  `supplier_contact`,
  `contact_id`,
  `contact_name`,
  `contact_email`,
  `user_country`,
  `user_details`,
  `date_modify`,
  `comments`,
  `published`,
  `archived`
FROM `dhub_log_forms` WHERE (`post_form` ='place_order') and (`post_id` = ".quote_smart($id).")";
	
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
		
		$fData['post_date'] = ($cn_fields['post_date'] > 0) ? date('m/d/Y', strtotime($cn_fields['post_date'])): '';
		
		
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
$archived = yesNoChecked($fData['archived']);



$frmClass = 'frmNoEdit';
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





<h4>Order Details</h4>

<div class="form-group">
<label class="textlabel control-label" for="post_type">Order Type</label>
<div>
<input type="text" name="post_type" id="post_type" size="50" maxlength="50" class="text form-control" value="<?php echo @ucwords($fData['post_type']); ?>"/>
</div> 
</div>

<div>
<label class="textlabel control-label" for="post_date">Order Date</label>
<div>
<input type="text" name="post_date" id="post_date" size="19" maxlength="19" value="<?php echo @$fData['post_date']; ?>" class="text form-control"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="item_name">Item Name</label>
<div>
<input type="text" name="item_name" id="item_name" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['item_name']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="item_quantity">Item Quantity</label>
<div>
<input type="text" name="item_quantity" id="item_quantity" size="20" maxlength="20" class="text form-control" value="<?php echo @$fData['item_quantity']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="item_notes">Item Notes</label>
<div>
<input type="text" name="item_notes" id="item_notes" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['item_notes']; ?>" />
</div> 
</div>



<?php /*?><div class="form-group">
<label class="textlabel control-label" for="comments">Comments</label>
<div>
<textarea name="comments" id="comments" rows="2" cols="50" class="textarea form-control"> <?php echo @$fData['comments']; ?></textarea>
</div> 
</div><?php */?>







<?php /*?>
<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>

<div class="input-group padd5_t">	
	<label class="radiolabel control-labelx" for="published">
		<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio-inline"/>  
	 Yes / No</label>
</div>
</div>


<div class="form-group">
<label class="textlabel control-label" for="archived">Archived</label>
<div>

<label class="radiolabel" for="archived">
		<input type="checkbox" name="archived" id="archived" value="<?php echo $fData['archived']; ?>" <?php echo $archived; ?> class="radio-inline"/>  
	 Yes / No</label>
</div> 
</div>
<?php */?>


<h4>Supplier Details</h4>


<div class="form-group">
<label class="textlabel control-label" for="supplier_name">Supplier Name</label>
<div>
<input type="text" name="supplier_name" id="supplier_name" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['supplier_name']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="supplier_contact">Supplier Contact</label>
<div>
<input type="text" name="supplier_contact" id="supplier_contact" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['supplier_contact']; ?>" />
</div> 
</div>


<h4>Contact Details</h4>


<div class="form-group">
<label class="textlabel control-label" for="contact_name">Contact Name</label>
<div>
<input type="text" name="contact_name" id="contact_name" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['contact_name']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="contact_email">Contact Email</label>
<div>
<input type="text" name="contact_email" id="contact_email" size="50" maxlength="50" class="text form-control" value="<?php echo @$fData['contact_email']; ?>" />
</div> 
</div>


<?php /*?><div class="form-group">
<label class="textlabel control-label" for="user_country">User Country</label>
<div>
<input type="text" name="user_country" id="user_country" size="11" maxlength="11" class="text form-control">
</div> 
</div><?php */?>






<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<button type="submit" class="btn btn-success" id="f_submit" name="submit" value="1"><i class="glyphicon glyphicon-plus"></i>Submit</button>
</div>

</div>



</form>

</div>

