<?php
$GLOBALS['FORM_KEYTAGS'] = true;

$date_start = array();
$showForm = false;
$access[1] = ''; $access[2] = '';
$selapp[0] = ''; $selapp[1] = '';
$resource_file = '';
$uploadRequire	= '';

if($op=="edit" or $op=="view"){

	if($id)
	{
		
		$sq_posted_by = "  and `id_owner` = ".quote_smart($us_id)." ";
		if($us_org_id <> '' and $us_type_id == 1 or $us_org_id <> '' and $us_type_id == 3){
			$sq_posted_by = "";
		}
		
		
		$sqdata = "SELECT * FROM `dhub_dt_content` WHERE  (`id` = ".quote_smart($id)." ".$sq_posted_by.")";
		$rsdata = $cndb->dbQueryFetch($sqdata); 
		
		if(count($rsdata))
		{
			$showForm 	= true;
			$fData 		= current($rsdata);		
			//displayArray($fData);
			
			$article	= $fData['article']; 
			$article	= str_replace(SITE_PATH, '', $article);
			$article	= str_replace(SITE_DOMAIN_LIVE, '', $article);		
			$article 	= str_replace('"image/', '"'.SITE_DOMAIN_LIVE.'image/', $article);
			$article	= remove_special_chars(stripslashes($article));
			
			$arr_extras			= @unserialize($fData['arr_extras']); 
			if(is_array($arr_extras)) {
				$ev_location = $arr_extras['location'];
				$book_form   = $arr_extras['book_form'];
				$book_amount = @$arr_extras['book_amount'];
			}
			
			
			$sq_item_dates = "SELECT date, end_date FROM `dhub_dt_content_dates` WHERE (`id_content` = ".quote_smart($fData['id']).") order by date ASC; ";
			//echobr($sq_item_dates);
			$rs_item_dates = $cndb->dbQuery($sq_item_dates);
			if( $cndb->recordCount($rs_item_dates)) 
			{
				$loop = 55;
				while($cn_item_dates = $cndb->fetchRow($rs_item_dates))
				{
					$date_start[$loop] = datePickerFormat($cn_item_dates['date']); 
					$time_start[$loop] = date("H:i:s",strtotime($cn_item_dates['date']));
					$time_end[$loop] = date("H:i:s",strtotime($cn_item_dates['end_date']));

					$loop += 1;
				}
			}
			
				
			$formaction			   = "_edit";		
			$upload_picy			= " ";
			$upload_picn			= " checked ";
			
			
			$file_box_link	= '';
			$file_box_upload  = ' style="display: none"';
		}
		
		
	}
} 
else
{
	$showForm = true;
	$formaction			   = "_new";

	$upload_picy			= " checked ";
	$upload_picn			= "";
	$uploadRequire	= 'required';
	$fData['date_created'] = date('Y-m-d');
	$fData['status'] = 'pending approval';
	
	$fData['id_owner'] = $us_id;
	$fData['organization_id'] = @$us_org_id;
	$fData['approved']  = 0;
}
//displayArray($fData);
@$access[$fData['id_access']] = ' selected ';	
@$selapp[$fData['approved']] = ' selected ';
echo '<br /><h4>Entry Details</h4> ';
if($showForm)
{
?>



<div id="event_dates_row" style="display:none;">
<textarea style="display:none" id="date_filler">

<tr id="tr_date_row_{0}">
<td><input type="text" name="date_add[{0}]" id="date_add_{0}" value="<?php //echo date("m/d/Y"); ?>"  class="small_width hasDatePicker date-pick required" ></td>
<td><select name="time_start[{0}]" id="time_start_{0}" class="small_width"><?php echo displayTime(); ?></select></td>
<td><select name="time_end[{0}]" id="time_end_{0}" class="small_width"><?php echo displayTime('','p'); ?></select></td>
<td><a onclick="javascript: del_date_row({0});">del</a></td>
</tr>

</textarea>
</div>


<?php
$itemDates = '';
if($op=='edit'  or $op=="view" )
{
if(count($date_start) > 0)
{
	foreach($date_start as $row => $rowval)
	{
		
$itemDates .= '<tr id="tr_date_row_'.$row.'">
<td><input type="text" name="date_add['.$row.']" id="date_add_'.$row.'" value="'.$rowval.'"  class="small_width hasDatePicker required" ></td>
<td><select name="time_start['.$row.']" id="time_start_'.$row.'" class="small_width">'.displayTime(''.$time_start[$row].'').'</select></td>
<td><select name="time_end['.$row.']" id="time_end_'.$row.'" class="small_width">'.displayTime(''.$time_end[$row].'').'</select></td>
<td><a href="#" onclick="del_date_row('.$row.');return false;">del</a></td>
</tr>';

	}
}
}
?>



<form class="rwdform rwdfull rwdstripes rwdvalid " name="fm_vds" id="cont_basic" method="post" action="posts.php" enctype="multipart/form-data" >
<input type="hidden" name="formtab" value="_calendar" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="fm_calendar" />
<input type="hidden" name="id_section" value="6" />
<input type="hidden" name="id" value="<?php echo @$fData['id']; ?>" />
<input type="hidden" name="id_owner" value="<?php echo @$fData['id_owner']; ?>" />
<input type="hidden" name="organization_id" value="<?php echo @$fData['organization_id']; ?>" />
<input type="hidden" name="redirect" value="profile.php?ptab=calendar" />
<input type="hidden" name="url_title_article" id="url_title_article" value="<?php echo @$fData['url_title_article']; ?>"  />
<input type="hidden" name="status" value="<?php echo @$fData['status']; ?>"  />

<div class=""></div>


<div class="form-group form-row"><label for="title" class="col-md-3">Event Title: </label>
<input type="text" name="title" id="title" class="form-control col-md-9 required" value="<?php echo @$fData['title']; ?>"  />
</div>


<div class="form-group form-row">
	<label for="article" class="col-md-3">Event Dates: </label>
	<div class="col-md-9 padd0_l padd0_r">
	<table style="margin:0;" id="event_dates_table" border="1" class="table-striped">
	<thead>
		<tr>
			<th><strong>Date <em>(yyyy/mm/dd)</em></strong></th>
			<th><strong>Start Time</strong></th>
			<th><strong>End Time</strong></th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $itemDates; ?>
	</tbody>

	<tfoot>
	  <tr>
		<th><a id="del_date" class="nav_button">Remove Date [-]</a> </th>
		<th colspan="3" style="text-align:right"><a id="add_date" class="nav_button">Add Date [+]</a> </th>
	  </tr>  
	</tfoot>
</table>
	</div>
</div>


<div class="form-group form-row">
	<label for="article" class="col-md-3">Event Description: </label>
	<div class="col-md-9 padd0_l padd0_r">
	<textarea name="article" id="article" class="form-control wysiwyg" style="height:200px;" ><?php echo @$article; ?></textarea>
	</div>
</div>


<div class="form-group form-row">
	<label for="ev_location" class="col-md-3">Venue: </label>
	<input type="text" name="ev_location" id="ev_location" class="form-control col-md-9 required" value="<?php echo @$ev_location; ?>"  />
</div>


<div class="form-group form-row"><label for="article_keywords" class="col-md-3">Tags: </label>
<div class="col-md-9 padd0_l padd0_r">
<input type="text" name="article_keywords" id="article_keywords" class="form-control col-md-12 requiredX tags-field" style="width:100% !important" value="<?php echo @$fData['article_keywords']; ?>"  /></div>
</div>


<div class="form-group form-row"><label for="id_access" class="col-md-3">Access Level: </label>
<select name="id_access" id="id_access" class="form-control col-md-3">
	 <option value='1' <?php echo $access[1]; ?>>Public Access</option> 
   <option value='2' <?php echo $access[2]; ?> >Private (Members Only) Access</option>
</select>

<label for="county" class="col-md-3">Related County: </label>
<select name="county" id="county" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("county", @$fData['county']) ?>
</select>
</div>




<div class="form-group form-row">

<label for="published" class="col-md-3">Publish Status: </label>
<select name="published" id="published" class="form-control col-md-3 required">
 	<?php echo $ddSelect->drop_publishStatus($fData['published']); ?>
</select>

<label class="col-md-3">Approved Status: </label>

<?php if($us_org_id <> '' and $us_type_id == 1){ ?> 
<select name="approved" id="approved" class="form-control col-md-3">
	<option value='0' <?php echo $selapp[0]; ?>>No</option> 
   	<option value='1' <?php echo $selapp[1]; ?> >Yes</option>
</select>
<?php } else { ?>
<input type="hidden" name="approved" value="<?php echo @$fData['approved']; ?>"  />
<label class="col-md-3 txtleft txtred"><?php echo yesNoText(@$fData['approved']); ?> </label>
<?php } ?>

<!--<label for="publisher" class="col-md-3">Related Organization: </label>
<select name="publisher" id="publisher" class="form-control col-md-3">
	  <?php //echo $ddSelect->dropper_conf("publishers", @$fData['organization_id']) ?>
</select>-->


</div>



<div class="form-group form-row">
	<label class="col-md-3">&nbsp;</label>
	<button type="input" name="submit" id="submit" value="submit" class="btn btn-success btn-icon col-md-3">Submit </button>
</div>

	
</form>



<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$("#upload_on").click(function () { $("#file_box_upload").show(); $("#file_box_link").hide(); });
	$("#upload_off").click(function () { $("#file_box_upload").hide(); $("#file_box_link").show(); });
	
	$("#adm_download_form").validate();
	
});
</script>	


<script type="text/javascript">
jQuery(document).ready(function($)
{ 
	
	/* ============= @@ additional toggles ======================== */
	
	var template_doc = jQuery.validator.format($.trim($("#date_filler").val()));
	
	
	function addRow_doc() { 
		var newDate; 
		if(j > 1)
		{   var pd = $("#date_add_"+(j-1)).attr('value'); 
		    if(pd !== ''){
			var d1 = new Date(pd);
			newDate = addDays(d1, 2); }
		}
		$(template_doc(j++)).appendTo("#event_dates_table tbody"); 
		$("#date_add_" + (j-1)).attr("value", newDate);
		
	}
	function delRow_doc() { j= j-1; $("#tr_date_row_"+j).remove();  }
	
	var j = 1; <?php if(count($date_start) == 0){ ?> addRow_doc(); <?php } ?> 
	$("#add_date").click(addRow_doc);
	$("#del_date").click(delRow_doc);
	
	/* ============= @@ validations ======================== */
	
	var validator = $("#cont_basic").validate({ ignore: '', errorPlacement: function(error, element) { } });
	
	$('input.date-pick').live('click', function() {
		$(this).datepick('destroy').datepick({showOn:'focus'}).focus();
	});
		
});

function addDays(theDate, days) 
{
	var ndate = new Date(theDate.getTime() + days*24*60*60*1000);
	var dd = ndate.toISOString().substr(8,2); //ndate.getDate();
    var mm = ('0' + (ndate.getMonth() + 1)).slice(-2);
    var y = ndate.getFullYear();
	
	//var someFDate = mm + '/' + dd + '/' + y;
	var someFDate = y + '-' + mm + '-' + dd;
    return someFDate;
}


function del_date_row(row_id) { 
	jQuery(document).ready(function($){ 	
		if(row_id !== 1){
		$("#tr_date_row_"+row_id).remove(); }
	});
}


</script>




<?php
}
else
{ echo '<div class="warning">You are not authorized to modify this item!</div>';
}
 ?>
