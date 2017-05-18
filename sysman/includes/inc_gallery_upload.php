<!-- content here -->
	<?php
	if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
	if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

	if($id){
	
	$sqdata="SELECT `id`, `id_gallery`, `filename`, `description`, `seq`, `published`, `title`, `title_sub` FROM `dhub_dt_gallery_photos` WHERE  (`id` = ".quote_smart($id).")";
	
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata= $cndb->fetchRow($rsdata);
		
		$pgtitle				="<h2>Edit Gallery Image</h2>";
		
		$id_photo					= $cndata[0];
		$id_gallery					= $cndata[1];
		$title				= trim(html_entity_decode(stripslashes($cndata[6])));
		$title_sub				= trim(html_entity_decode(stripslashes($cndata[7])));
		$image				= trim(html_entity_decode(stripslashes($cndata[2])));
		$image_disp			= "<strong>Name:</strong> ".$cndata[2]."<br /><img src=\"".DISP_BANNERS.$cndata[2]."\"  style=\"max-width:400px; max-height:200px;\" >";
		$description		= trim(html_entity_decode(stripslashes($cndata[3]))); 
		$oldname			= $cndata[2]; 
		$position			= $cndata[4]; 
		$published			= $cndata[5];
		
			$upload_picy			= "";
			$upload_picn			= "  checked ";
			
				
		if($published==1) {$published="checked ";} else {$published="";}
		
		$formname			= "gallery_edit";
		}
	}
} elseif($op=="new")
	{
	
		$pgtitle				="<h2>Add New Gallery Image</h2>";
		
		$id_photo					= "";
		$title		= "";
		$id_gallery					= "";
		$filename				= "";
		$image_disp			= "";
		$description		= "";
		$position		= "9";
		$oldname		= "";
		$published			="checked ";
			$image_disp			= "";
			$upload_picy			= " checked ";
			$upload_picn			= " ";
			
		$formname			= "gallery_new";
	}
	
?>

	<!-- content here [end] -->	
	
	<form class="admform" name="rage" method="post" action="adm_posts.php" enctype="multipart/form-data" >
	  <table width="700px" border="0" cellspacing="1" cellpadding="2" align="center">
        <tr>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;<?php echo $pgtitle; ?></td>
          </tr>
		 <tr style="background:#F1F1F1;">
          <td></td>
          <td>Gallery</td>
          <td><select name="id_gallery">
           <?php echo $ddSelect->dropper_select("dhub_dt_gallery_albums", "id", "title", $id_gallery) ?>
		   </select></td>
        </tr>
         <tr style="background:#F1F1F1;">
        <td></td>
        <td> Image Title </td>
        <td><input type="text" name="title" value="<?php echo $title; ?>" maxlength="45"/></td>
      </tr>
	    <tr style="background:#F1F1F1;">
        <td></td>
        <td> Image Sub Title </td>
        <td><input type="text" name="title_sub" value="<?php echo $title_sub; ?>" maxlength="45"/></td>
      </tr>
        <tr style="background:#dfdfdf;">
          <td class="required">*</td>
          <td>Select Image: </td>
          <td><input type="file" name="MyFile" size="45" <?php echo $image; ?> />
			<input type="hidden" name="command" value="1" />
			
			<br />
			Change Picture:&nbsp;
			<input name="change_image" type="radio" value="Yes" <?php echo $upload_picy; ?> id="checkbox" class="radio"/>
			Yes&nbsp;&nbsp;
			<input name="change_image" type="radio" value="No" <?php echo $upload_picn; ?> id="checkbox"  class="radio"/>No
			<br />
			<input type="text" name="imagename" id="imagename"  value="<?php echo $image; ?>" />
			<input type="hidden" name="imageold" id="imageold"  value="<?php echo $image; ?>" />
			</td>
          </tr>
		  
         <tr style="background:#F1F1F1;">
          <td></td>
          <td>Image Preview</td>
          <td><?php echo $image_disp; ?></td>
        </tr>
		
        
        <tr style="background:#dfdfdf;">
          <td>&nbsp;</td>
          <td>Image Caption </td>
          <td><textarea name="description"><?php echo $description; ?></textarea><br />
		  <input type="text"  style="background-color: #C0EAF8;width:30px" name="COUNTER" size="3" id="in_mid" readonly="" class="radio"></td>
        </tr>
        
       <tr>
          <td>&nbsp;</td>
          <td>Position</td>
          <td><input type="text" name="position" value="<?php echo $position; ?>" class="radio" maxlength="2"/></td>
        </tr>
		<tr style="background:#F1F1F1;">
          <td>&nbsp;</td>
          <td>Visible to Public</td>
          <td><input type="checkbox" name="published" <?php echo $published; ?> class="radio"/></td>
        </tr>
		
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="hidden" name="formname" value="<?php echo $formname; ?>" />
		  <input type="hidden" name="id_photo" value="<?php echo $id_photo; ?>" />
		  <input type="hidden" name="oldname" value="<?php echo $oldname; ?>" />
		  <input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />		  
		  <input type="submit" name="Submit" value="Save Details" /></td>
          </tr>
      </table>
	</form>	