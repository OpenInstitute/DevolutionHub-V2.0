<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>



	<?php
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; $id = 60;}
	
if($op=="edit")
{
	if($id)
	{
		$article_title = master::$menusFull[$id]["title"];
	}
} 
	?>

<div style="width:950px; margin:0 auto; border:0px solid">

	<div style="padding:5px;">
		<h3>Add New Video Link &raquo;</h3>
		
		
		<form action="adm_gallery_upload.php" method="post"   enctype="multipart/form-data" > 
<fieldset style="background:#f7f7f7;">
<table  border="0" cellspacing="1" cellpadding="3" align="center" >
	<tr>
	  <td style="width:110px"><label class="required" for="id_parent">Video Parent</label></td>
	  <td ><select name="id_parent" id="id_parent">
	  		<?php echo  $dispData->build_MenuSelectRage(0, $id);
		  //$dispData->build_MenuSelect($dispData->menuMain, $id, 0 , $id); ?>
	  		</select></td>
	  <td  style="width:110px"><label for="video_title">Video Title:</label></td>
	  <td ><input name="video_title" id="video_title" type="text" style="width:300px" max="100" value="<?php echo $article_title; ?>" /></td>
	  <td rowspan="2" >
	  <input type="submit" name="submitBtn" id="upload"  value="Submit" style="height:40px; width: 70px;" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="formname" value="gall_video" />
	  </td>
	  </tr>
	<tr>
			<td><label for="video_name">Video URL:</label></td>
			<td ><input type="text" name="video_name" id="video_name" value="<?php echo $file_name; ?>" style="width:265px;">
					<br /><span class="hint"><em>e.g. http://www.youtube.com/embed/xxxxxxxxxx</em></span></td>
			<td ><label for="video_caption">Video Caption:</label></td>
			<td ><textarea name="video_caption" id="video_caption" class="text_full" style="height:30px; width:99%"><?php echo $file_caption; ?></textarea></td>
	</tr>
	<tr>
			<td colspan="5"></td>
	</tr>
	</table>
</fieldset>
</form>
<?php
if($op == "edit")
	{
?>	

		<?php
				//include("includes/adm_article_file_gallery.php") ;
				//include("adm_gallery_vids_long.php") ;
			  ?>
		
		<br />
		
		
		<fieldset>
		<legend>Gallery Videos &raquo;</legend>
		<form action="adm_posts.php" method="post"><!-- target="upload_target" -->
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td>
				<p id="f1_upload_process" align="center">Loading...<br/><img src="image/loader.gif" /><br/></p>
				
				<ul id="files_long" ></ul>				
				</td>
			</tr>
			<tr>
				<td style="padding-left:150px">
				<input type="submit" value="Save Changes Made" name="submit" id="edit_photo_submit" />
				<input type="hidden" name="formname" value="edit_photo" />
				<input type="hidden" name="redirect" value="<?php echo $ref_page; ?>" />
				</td>
			</tr>
		</table>
		</form>
		</fieldset>
		</div>
	
<?php
}
?>	
	
	</div>



	

</div>
	
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$('label.required').append('&nbsp;<span class="rq">*</span>&nbsp;');
	$('textarea').autoResize({extraSpace : 10 });
	
	
	$("#add_video").click(function () { $("#file_box_video").show(); $("#file_box_photo").hide();   });
	$("#add_photo").click(function () { $("#file_box_video").hide(); $("#file_box_photo").show();   });
	
	//if( $('#cont_news').length ) 		{ $("#cont_news").validate(); }
	
});
</script>

<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</body>
</html>
