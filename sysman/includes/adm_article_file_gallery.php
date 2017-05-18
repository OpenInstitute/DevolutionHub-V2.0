
<form action="adm_gallery_upload.php" method="post"  enctype="multipart/form-data" >
<!-- onsubmit="startUpload();" target="_blank"  -->
<fieldset style="background:#f7f7f7;">
<table  border="0" cellspacing="1" cellpadding="3" align="center" >
	<tr><td colspan="2">
	<div class="radio_group">
	<label><input type="radio" name="file_type" id="add_photo" value="p" class="radio" checked="checked" /> 
	Add Gallery Picture </label>
	&nbsp;
	<label><input type="radio" name="file_type" id="add_video" value="v" class="radio" /> Add Video Link </label>  
	
	</div>
	</td></tr>
	<tr>
		<td colspan="2">
		<div id="file_box_video" style="display: none; ">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="nopadd">
		<tr>
		<td style="width:150px;"> <label for="video_name">Video URL:</label> </td>
		<td><input type="text" name="video_name" id="video_name" value="<?php echo $file_name_v; ?>" class="text_full" style="width:99%"></td>
		</tr>
		<tr>
		  <td><label for="video_title">Video Title:</label> </td>
		  <td><input name="video_title" id="video_title" type="text" style="width:99%" value="<?php echo $article_title; ?>" /></td>
		  </tr>
		<tr>
		<td><label for="video_caption">Video Caption:</label> </td>
		<td><textarea name="video_caption" id="video_caption" class="text_full" style="height:30px; width:99%"><?php echo $file_caption; ?></textarea> </td>
		</tr>
		
		</table>
		</div>
		
		
		<div id="file_box_photo">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="nopadd">
		<tr>
		<td style="width:150px;"> <label for="photo_name"><strong>Upload Photo:</strong>: </label> </td>
		<td><input type="file" name="myfile" id="photo_name" size="57"   /></td>
		<td nowrap="nowrap"><strong>OR Enter Name:</strong></td>
		<td><input type="text" name="image_link" id="image_link" style="width:265px;" /></td>
		</tr>
		<tr>
		  <td><label for="photo_title">Picture Title:</label> </td>
		  <td colspan="3"><input name="photo_title" id="photo_title" type="text" style="width:99%" value="<?php echo $article_title; ?>" /></td>
		  </tr>
		<tr>
		<td><label for="photo_caption"> Picture Caption: </label></td>
		<td colspan="3"><textarea name="photo_caption" id="photo_caption" class="text_full" style="height:30px;width:99%"><?php echo $file_caption; ?></textarea> </td>
		</tr>
		<tr>
			<td><label for="id_gallery_cat"><strong>Category:</strong></label></td>
			<td><select name="id_gallery_cat" id="id_gallery_cat" style="width:270px;">
	            <?php echo $ddSelect->dropper_select("dhub_dt_gallery_category", "id", "title", 2) ?>
	            </select></td>
			<td></td>
			<td></td>
		</tr>
		</table>
		</div>		
		
		</td>
	</tr>
	<tr>
		<td style="width:150px;"><label><strong>Date:</strong></label></td>
		<td><input type="text" name="date_posted" id="date_posted" value="<?php echo date("m/d/Y"); ?>" class="date-pick half_width required" style="width: 130px"></td>
	</tr>
	<tr>
	  <td colspan="2"><input type="submit" name="submitBtn" id="upload"  value="Submit Form" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="formname" value="gall_content" />
			<input type="hidden" name="redirect" value="<?php echo "adm_gallery_albums.php?d=".$dir."&op=edit&id=".$id; ?>" />
			</td>
  </tr>
	</table>
</fieldset>
</form>