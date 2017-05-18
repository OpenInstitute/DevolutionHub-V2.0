<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>

    
	<!-- content here -->
<?php
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }



$GLOBALS['FORM_JWYSWYG'] = true;
	
$parent_menu = '';
	
if($op=="edit"){ $title_new	= "Edit "; } elseif($op=="new") { $title_new	= "New "; }

$upload_icon_disp = '';
$upload_icon_id   = '';

$access[1] = '';
$access[2] = '';

$id_owner  = '';

$file_box_link	= ' style="display: none"';
$file_box_upload  = '';

$fData = array();


if($op=="edit"){

	if($id)
	{
	
	//oi_dt_resources
		$sqdata = "SELECT * FROM `dhub_dt_downloads` WHERE  (`resource_id` = ".quote_smart($id).")";
		$rsdata = $cndb->dbQueryFetch($sqdata);
		$fData = current($rsdata);
		
		$res_attr = @unserialize($fData['resource_attributes']); 
		
		$formaction			   = "_edit";		
		$upload_picy			= " ";
		$upload_picn			= " checked ";
		
		$file_box_link	= '';
		$file_box_upload  = ' style="display: none"';
		
	}
} else
	{
	
		
		$formaction			   = "_new";
		
		$upload_picy			= " checked ";
		$upload_picn			= "";
		
		$fData['status'] = 'live';
	}
//displayArray($fData);
@$access[$fData['access_id']] = ' selected ';	
	
	echo '<h2>'.$title_new.' Resources</h2>';
?>




<form class="rwdform rwdfull rwdstripes rwdvalid " name="fm_vds" id="fm_vds" method="post" action="sys_posts.php" enctype="multipart/form-data">
<input type="hidden" name="formtab" value="_documents" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="formname" value="fm_resources" />
<input type="hidden" name="id" value="<?php echo @$fData['resource_id']; ?>" />
<input type="hidden" name="redirect" value="index.php?tab=_documents" />
<input type="hidden" name="post_by" value="<?php echo @$fData['owner_id']; ?>" />
<input type="hidden" name="resource_key" value="<?php echo @$fData['resource_key']; ?>" />
<input type="hidden" name="status_old" value="<?php echo @$fData['status']; ?>" />
<div class=""></div>


<div class="form-group form-row"><label for="resource_title" class="col-md-3">Resource Title: </label>
<input type="text" name="resource_title" id="resource_title" class="form-control col-md-9 required" value="<?php echo @$fData['resource_title']; ?>"  />
</div>

<div class="form-group form-row"><label for="resource_slug" class="col-md-3">Resource Slug: </label>
<input type="text" name="resource_slug" id="resource_slug" class="form-control col-md-9 required" value="<?php echo @$fData['resource_slug']; ?>"  />
</div>

<div class="form-group form-row">
	<label for="resource_description" class="col-md-3">Resource Description: </label>
	<div class="col-md-9 padd0_l padd0_r">
	<textarea name="resource_description" id="resource_description" class="form-controlX requiredX wysiwyg" ><?php echo @$fData['resource_description']; ?></textarea>
	<?php //include("fck_rage/article_sm.php");  ?>
	</div>
</div>


<div class="form-group form-row"><label for="resource_tags" class="col-md-3">Resource Topics/Tags: </label>
<div class="col-md-9 padd0_l padd0_r">
<input type="text" name="resource_tags" id="resource_tags" class="form-control col-md-12 required XXtags-field" style="width:100% !important" value="<?php echo @$fData['resource_tags']; ?>"  /></div>
</div>





<div class="form-group form-row">
<label for="resource_file" class="col-md-3">Resource File: </label>
<div class="col-md-9">
	<table align="left" width="100%" border="0" class="table nopadd nomargin noborder">
	<tr>
		<td style="width:;" class="col-md-3">
		<label style="display:inline-block;"><input name="change_image" id="upload_on" type="radio" value="Yes" <?php echo $upload_picy; ?>  class="radio"/>&nbsp; Upload New</label>&nbsp;
		<label style="display:inline-block;"><input name="change_image" id="upload_off" type="radio" value="No" <?php echo $upload_picn; ?>  class="radio"/> Resource Name</label> 
		</td>
		<td class="col-md-9">
	<div id="file_box_upload" class="col-md-12" <?php echo $file_box_upload; ?>>
	<input type="file" name="fupload" id="fupload"  class="form-control required"  accept="<?php echo $uploadMime; ?>" />
	</div>
	
	<div id="file_box_link" class="col-md-12" <?php echo $file_box_link; ?>>
	<input type="text" name="resource_file" id="resource_file" value="<?php echo @$fData['resource_file']; ?>" class="form-control" placeholder="Enter File link:" />
	</div>
	</td>
	</tr>
	</table>
</div></div>




<div class="form-group form-row">
<label for="year_published" class="col-md-3">Publication Year: </label>
<select name="year_published" id="year_published" class="form-control col-md-3">
	 <option selected><?php echo @$fData['year_published']; ?></option>
	 <?php for($d=date("Y"); $d>=(date("Y")-20); $d--) { ?>   <option><?php echo $d; ?></option><?php } ?> 
</select>

<label for="date_created" class="col-md-3">Date Posted: </label>
<input type="text" name="date_created" id="date_created" class="form-control col-md-3 hasDatePicker" value="<?php echo @$fData['date_created']; ?>"  />
</div>



<div class="form-group form-row">
<label for="publisher" class="col-md-3">Publisher: </label>
<select name="publisher" id="publisher" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("publishers", @$fData['publisher']) ?>
</select>

<label for="source_url" class="col-md-3">Original Source: </label>
<input type="text" name="source_url" id="source_url" class="form-control col-md-3" value="<?php echo @$fData['source_url']; ?>"  />
</div>


<div class="form-group form-row"><label for="content_type" class="col-md-3">Content Type: </label>
<select name="content_type" id="content_type" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("content_type", @$fData['content_type']) ?>
</select>

<label for="county" class="col-md-3">Related County: </label>
<select name="county" id="county" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("county", @$fData['county']) ?>
</select>
</div>





<div class="form-group form-row"><label for="language" class="col-md-3">Language: </label>
<select name="language" id="language" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("language", @$fData['language']) ?>
</select>

<label for="devolved_functions" class="col-md-3">Devolved Function: </label>
<select name="devolved_functions" id="devolved_functions" class="form-control col-md-3">
	  <?php echo $ddSelect->dropper_conf("devolved_functions", @$fData['devolved_functions']) ?>
</select>
</div>




<div class="form-group form-row"><label for="access_id" class="col-md-3">Access Level: </label>
<select name="access_id" id="access_id" class="form-control col-md-3">
	 <option value='1' <?php echo $access[1]; ?>>Public Access</option> 
   <option value='2' <?php echo $access[2]; ?> >Private (Members Only) Access</option>
</select>

<label for="status" class="col-md-3">Status: </label>
<select name="status" id="status" class="form-control col-md-3 required">
  	<option><?php echo @$fData['status']; ?></option>
  	<option>live</option><option>draft</option><option>archive</option>
</select>
</div>



<?php /*?>
<div class="form-group form-row">
<label for="resource_image" class="col-md-3">Resource Image: </label>
<input type="file" name="resource_image" id="resource_image" class="form-control col-md-3" style=""  />
<?php echo @$upload_icon_disp; ?>

</div>





<div class="form-group form-row"><label for="resource_date_update" class="col-md-3">Resource Date Update: </label>
<input type="text" name="resource_date_update" id="resource_date_update" class="form-control hasDatePicker" value=""  />
</div></div>


<div class="form-group form-row"><label for="owner_id" class="col-md-3">Owner Id: </label>
<input type="text" name="owner_id" id="owner_id" class="form-control " value=""  />
</div></div>

<div class="form-group form-row"><label for="owner_approve" class="col-md-3">Owner Approve: </label>
<input type="text" name="owner_approve" id="owner_approve" class="form-control " value=""  />
</div></div>

<div class="form-group form-row"><label for="published" class="col-md-3">Published: </label>
<label><input type="checkbox" name="published" id="published" class="form-control radio "    /> <small>(Yes / No)</small></label>
</div></div><?php */?>


<div class="form-group form-row">
<label class="col-md-3">&nbsp;</label>
<button type="input" name="submit" id="submit" value="submit" class="btn btn-success btn-icon col-md-3">Submit </button></div>
</div>
</form>



</div>
<!-- @end :: content area -->
	
</div>
</div>

<?php include("sec__foot.php"); ?>


<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$('label.required').append('&nbsp;<span class="rq">*</span>&nbsp;');
	//$('textarea').autoResize({extraSpace : 10 });
	
	
	$("#upload_on").click(function () { $("#file_box_upload").show(); $("#file_box_link").hide(); });
	$("#upload_off").click(function () { $("#file_box_upload").hide(); $("#file_box_link").show(); });
	
	
	$("select#id_content").change(function () {
	  var valTitle = $("input#title").val();
	  var valSlash = /(.+)(\/)/g; 
	  var valClean, str = "";
	  $("select#id_content option:selected").each(function () { str += $(this).text() + " ";  });	  
	  if(str.search(valSlash) == 0) { valClean = str.replace(valSlash,""); } else { valClean = str; }	  
	  if(valTitle == "") { $("input#title").attr("value", valClean); }
	});	
	
	
	$("#resource_title").blur(function () {
	  var valTitle 	= $(this).val();
	  var hyphenated  = urlTitle(valTitle);             
	  $('#resource_slug').val(hyphenated);       
	  
	  var valKeywords = $("#resource_tags").val();
	  //var valMeta 	  = valTitle.replace(/[^a-zA-Z0-9]/g,",").replace(/[,]+/g,",").toLowerCase();	  
	  var valMeta = wordInString(valTitle, ['of','the','this'], '');
		  valMeta = valMeta.trim().replace(/[^a-zA-Z0-9]/ig,",").replace(/[,]+/ig,",").toLowerCase();
	  if(valKeywords == "") {  $("#resource_tags").val(valMeta); }
	});
	
	$("#adm_download_form").validate();
	
	/*if( $('.wysiwyg').length ) { 
			$('.wysiwyg').wysiwyg(); 
	}*/
	function wordInString(s, words, replacement){ 
	  var re = new RegExp( '\\b' + words.join('|') + '\\b','gi');
	  return s.replace(re, replacement);
	}
});
</script>		
</body>
</html>
