<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>

    
	<!-- content here -->
<?php
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }




$parent_menu = '';
	
if($op=="edit"){ $title_new	= "Edit "; } elseif($op=="new") { $title_new	= "New "; }

$upload_icon_disp = '';
$upload_icon_id   = '';

$access[1] = '';
$access[2] = '';

$id_owner  = '';


if($op=="edit"){

	if($id){
	
	
	$dispData->siteGallery();
	
	
	//$sqdata="SELECT `id`, `title`, `description`, `link`, `dsize`, DATE_FORMAT(`date_posted`, '%m/%d/%Y') as `date_posted`,  `id_access`, `published`, `seq`, `dtype`, `hlight`, `language`, `attachment`, `approved`, `id_portal`, `author`, `id_owner` FROM `".$pdb_prefix."dt_downloads` WHERE  (`id` = ".quote_smart($id).")";
	
	$sqdata="SELECT * FROM `".$pdb_prefix."dt_downloads` WHERE  (`resource_id` = ".quote_smart($id).")";
		
	$rsdata=$cndb->dbQuery($sqdata);
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata=$cndb->fetchRow($rsdata);
		
		$pgtitle				="<h2>Edit Resource</h2>";
		
		$id_file			= $cndata['id'];
		$title				= $cndata['title']; 
		$description		=  clean_output($cndata['description']);
		$doc_filename		= $cndata['link'];
		$doc_filename_lbl		= $cndata['link'];
			if(strlen($doc_filename)>100) { $doc_filename_lbl = substr($doc_filename,0,100)."~".substr($doc_filename,-4,4); }
		$dsize				= $cndata['dsize']; 
		$date_posted		= $cndata['date_posted'];
		$id_access			= $cndata['id_access'];
		
		$published			= $cndata['published'];	
		$position			= $cndata['seq'];
		$dtype			= $cndata['dtype'];
		$hlight			= $cndata['hlight'];
		$language			= $cndata['language'];
		$language_sel = "<option selected>$language</option>";	
		
		/*$attachment				= unserialize($cndata[15]); */
		$approved			= $cndata['approved'];
		
		$id_portal			= $cndata['id_portal'];
		$id_owner			= $cndata['id_owner'];
		
		$author			= clean_output($cndata['author']);
		
		if($published==1) {$published="checked ";} else {$published="";}
		if($hlight==1) {$hlight="checked ";} else {$hlight="";}
		if($approved==1) {$approved="checked ";} else {$approved="";}
		
		
		$parent_menu = array();
		$parent_content = array();
		
	$sqdata_m="SELECT `id_menu` , `id_content`, `id_download` FROM `dhub_dt_downloads_parent` WHERE (`id_download` = ".quote_smart($id_file)."); ";
	
	$rsdata_m=$cndb->dbQuery($sqdata_m);
	if( $cndb->recordCount($rsdata_m)) 
	{
		while($cndata_m = $cndb->fetchRow($rsdata_m))
		{
		if($cndata_m['id_menu'] <> 0) { $parent_menu[] = $cndata_m['id_menu']; }
		if($cndata_m['id_content'] <> 0) { $parent_content[] = $cndata_m['id_content']; }
		}
	}
	
	if(@array_key_exists($id_file, master::$listGallery['resource']))
	{
		$upload_icon_id 		= current(master::$listGallery['resource'][$id_file]);
		$upload_icon_name	  = master::$listGallery['full'][$upload_icon_id]['filename'];
		$upload_icon_disp	  = '<img src="'.DISP_GALLERY.$upload_icon_name.'" width="80px;" />';
	}
	
		$formname			   = "download_edit";		
		$upload_picy			= " ";
		$upload_picn			= " checked ";
		
		$file_box_edit	= ' style="display: none"';
		$file_box_new	= '';
		}
	}
} elseif($op=="new")
	{
	
		$pgtitle				="<h2>Add New Resource</h2>";
		
		$id_file			= "";
		$id_cat				= "";
		$id_menu			= "";
		$id_menu2			= "";
		$title				= "";
		$description		= "";
		$doc_filename		= "";
		$dsize				= "";
		$date_posted		= date("m/d/Y");
		$id_access			= 1;
		$published			= "";
		$position			= "9";
		$dtype				= "";
		
		
		$formname			= "download_new";
		
		$upload_picy			= " checked ";
		$upload_picn			= "";
		$published			="checked ";
		$approved			="checked ";
		$hlight				= "";
		
		$file_box_new	= ' style="display: none"';
		$file_box_edit	= '';
	}

$access[$id_access] = ' selected ';	
?>

	<!-- content here [end] -->	
	<form class="admformX rwdform rwdfull" name="adm_download_form" id="adm_download_form" method="post" action="adm_posts.php" enctype="multipart/form-data">
	<input type="hidden" name="id_portal" value="1" />
	  <table  border="0" cellspacing="1" cellpadding="5" align="center" style="width:800px; margin:0 auto;" class="table nopaddX">
        <tr>
        	<td colspan="4"><?php echo $pgtitle; ?></td>
        	</tr>
       
        <tr>
        	<td><label for="id_parent">Parent Link</label></td>
        	<td colspan="3"><select name="id_parent[]" id="id_parent" multiple="multiple" class="multiple" style="width:650px;">
        		<?php echo  $dispData->build_MenuSelectRage(0, $parent_menu);
		  //$dispData->build_MenuSelect($dispData->menuMain_portal, $id_menu, 0 , $parent_menu); ?>
        		</select> </td>
        	</tr>
		  
        <tr>
        	<td nowrap="nowrap">Parent Content:</td>
        	<td colspan="3">
			<select name="id_content[]" id="id_content" multiple="multiple" class="multiple" style="width:650px;">
        		<?php 
		echo $dispData->build_MenuArticles(master::$contMain['full'], $parent_content, 0 , $parent_content);  ?>
        		</select></td>
        	</tr>
        <tr>
        	<td nowrap="nowrap"><label class="required" for="title"> Resource Title</label></td>
        	<td colspan="3"><input type="text" name="title" id="title" class="required text_full" value="<?php echo $title; ?>" style="width:100%;" /></td>
        	</tr>
			
			 <tr>
		  	<td colspan="4" style="height:10px"></td>
		  	</tr>
		  
          <?php if($op=="edit"){ ?>
        <tr>
          <td><label>Resource Link</label></td>
          <td colspan="3">
          
            <b><font style="color:#FF0000"><a href="../file/<?php echo $doc_filename; ?>" target="_blank"><?php echo $doc_filename_lbl; ?></a></font></b>
           
          <input type="hidden" id="filename" name="filename" value="<?php echo $doc_filename; ?>" />
            <input type="hidden" name="dtype" value="<?php echo $dtype; ?>" />
            <input type="hidden" name="dsize" value="<?php echo $dsize; ?>" />
            <input type="hidden" name="command" value="1" />
            
          </td>
        </tr>
         <?php } ?>
		 
		<tr style="background:#f3f3f3">
        	<td><label>Upload New:</label></td>
        	<td colspan="3" style="padding-bottom:0px !important">
			
			<table align="left" width="100%" border="0" class="nopadd nomargin">
			<tr>
				<td style="width:200px;">
				<label style="display:inline-block;"><input name="change_image" id="upload_on" type="radio" value="Yes" <?php echo $upload_picy; ?>  class="radio"/>&nbsp; Yes</label>&nbsp;
        		<label style="display:inline-block;"><input name="change_image" id="upload_off" type="radio" value="No" <?php echo $upload_picn; ?>  class="radio"/>No</label> 
				</td>
				<td>
<div id="file_box_upload" <?php echo $file_box_edit; ?>>
	 <input type="file" name="fupload" id="fupload"  class="required" placeholder="Select file to upload:" />
</div>
			
<div id="file_box_link" <?php echo $file_box_new; ?>>
	<input type="text" name="resource_name" id="resource_name" value="<?php echo $doc_filename; ?>" class="text_full" placeholder="Enter File link:" />
</div>
			</td>
			</tr>
			</table>
			
			</td>
        </tr>
			
        
        
		<?php /*?><tr>
			<td><label>Resource Language</label></td>
		  	<td> <select name="language" id="language" style="width:100px !important;">
        		<?php echo $language_sel; ?> <option>English</option> <option>Swahili</option> </select>
			</td>
		  	<td style=""><label>Author</label></td>
		  	<td style=""><input type="text" name="author" id="author" value="<?php echo $author; ?>" /></td>
		</tr><?php */?>
        
        <tr>
        	<td><label>Resource Date</label></td>
        	<td colspan="3">
        		
	<table border="0" cellspacing="0" cellpadding="0" style="margin:0 " align="left">
	<tr>
	<td><input type="text" name="created" id="created" value="<?php echo $date_posted; ?>" class="date-pick half_widthX required" style="width: 90px !important"></td>
	<td style="width:100px;"><em>(mm/dd/yyyy)</em></td>
	<td>&nbsp;</td>
	<td style="width:70px">&nbsp;</td>
	<td><label><!--Position: &nbsp;--> <input type="hidden" name="position" value="<?php echo $position; ?>"  class="radio" maxlength="2"/></label></td>
		
		
	<td style="text-align:right;" nowrap="nowrap">&nbsp;</td>
	<td><label><input type="checkbox" name="sidebar" <?php echo $hlight; ?>   class="radio"/> 
		Featured </label></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
		
	<td>&nbsp;</td>
	<td nowrap="nowrap"><label style="color:#900" class="labelleft"><input type="checkbox" name="approved" <?php echo $approved; ?> class="radio"/>	<strong>Is Approved</strong></label></td>
	<td>&nbsp;</td>
	<td nowrap="nowrap"><label style="color:#900"><input type="checkbox" name="published" <?php echo $published; ?>   class="radio"/>	<strong>Is Published</strong></label></td>
		
	</tr>
	</table>
        		
        		</td>
        	</tr>
        <tr>
        	<td nowrap="nowrap"><label>Resource Description</label></td>
        	<td colspan="3"><textarea name="description" id="description" style="height:30px; width:700px;" class=""> <?php echo $description; ?></textarea></td>
        	</tr>
		
		<tr>
			<td><label>Resource Image</label></td>
		  	<td colspan="3" style="">
			<input type="file" name="upload_icon" id="upload_icon"  placeholder="Upload new avatar" />
			<?php echo $upload_icon_disp; ?>
			</td>
		</tr>
		
		<tr>
			<td style=""><label>Access</label></td>
		  	<td style="">
			<select name="id_access" id="id_access">
           <option value='2' <?php echo $access[2]; ?> >Private (Members Only) Access</option>
		   <option value='1' <?php echo $access[1]; ?>>Public Access</option> 
          </select>
			</td>
			<td><label>Owner</label></td>
		  	<td>
			<select name="id_owner" id="id_owner">
            <?php echo $ddSelect->dropper_select("dhub_reg_account", "account_id", "concat_ws(' ', namefirst,namelast)", $id_owner) ?>
          </select>
			</td>
		</tr>
		
        <tr>
        	<td>&nbsp;</td>
        	<td colspan="3"><input type="hidden" name="formname" value="<?php echo $formname; ?>" />
        		<input type="hidden" name="id_file" value="<?php echo $id_file; ?>" />
        		<input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />		  
        		<input type="submit" name="Submit" value="Save Details"  id="in_big" style="height:30px;"/></td>
        	</tr>
      </table>
	</form>	
  

</div>
<!-- @end :: content area -->
	
</div>
</div>

<script type="text/javascript" src="../scripts/validate/jquery.validate.js"></script>	
<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$('label.required').append('&nbsp;<span class="rq">*</span>&nbsp;');
	$('textarea').autoResize({extraSpace : 10 });
	
	
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
	
	$("#adm_download_form").validate();
	
});
</script>		
</body>
</html>
