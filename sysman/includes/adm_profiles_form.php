<div>

<?php

$vac_category = '';
$id_profile_cat  = '';

if($op=="edit"){

	if($id)
	{
	
	$sqstaff_prof = "SELECT `id`, `title`, `overview`, `products`,`contacts`, `website`, `published`, `adminpost`, `title_url` FROM `dhub_profile` WHERE (`id` = ".quote_smart($id).")";
	//`id_user_type`, `usercode`, 
	
	$rsstaff_prof= $cndb->dbQuery($sqstaff_prof);
	$rsstaff_prof_count= $cndb->recordCount($rsstaff_prof);
	
	
	
	if($rsstaff_prof_count==1)
		{
		
		$cndata =  $cndb->fetchRow($rsstaff_prof);
		
		$id_profile 		  = $cndata[0];
		$prof_title		   = trim(html_entity_decode(stripslashes($cndata[1])));
		$overview		= trim(html_entity_decode(stripslashes($cndata[2])));
		$overview 	= str_replace('"image/', '"'.SITE_DOMAIN_LIVE.'image/', $overview);
		$article	= $overview; //remove_special_chars(stripslashes($article));
		
		$products	   = clean_output($cndata[3]); //echo $amenities;
		$contacts		= trim(html_entity_decode(stripslashes($cndata[4])));
		$website	     = trim(html_entity_decode(stripslashes($cndata[5])));
		$published		= $cndata[6];		
		
		if($published==1) {$published="checked ";} else {$published="";}
		
		
		
		$adminpost		  = $cndata[7];	
		$title_url		= $cndata[8];
		
/* profile-circuits */
	$sqdata_m="SELECT `id_menu` , `id_profile` FROM `dhub_profile_to_menus`  WHERE (`id_profile` = ".quote_smart($id_profile)."); ";
	
	$rsdata_m=$cndb->dbQuery($sqdata_m);
	if( $cndb->recordCount($rsdata_m))  {
		while($cndata_m = $cndb->fetchRow($rsdata_m)) { $rec_circuits[] = $cndata_m[0]; }
	}
/* <<<<<<<<<<< */

/* profile-categories */	
	$sqdata_c="SELECT `id_profile_cat` , `id_profile` FROM `dhub_profile_to_category`  WHERE (`id_profile` = ".quote_smart($id_profile)."); ";
	
	$rsdata_c=$cndb->dbQuery($sqdata_c);
	if( $cndb->recordCount($rsdata_c))  {
		while($cndata_c = $cndb->fetchRow($rsdata_c)) { $rec_cats[] = $cndata_c[0]; }
	}
/* <<<<<<<<<<< */	
	
			
		$formact			= "_edit";
		}
	}
} 
elseif($op=="new")
	{
	
		$id					= "";
		$title				= "";
		$description		= "";
		$email				= "";
		$id_user_type		= 2;
		$country				= "156";
		$confirmed			="checked ";
		$published			="checked ";
		$image				="";
		
		$image				="";
		$image_disp			= "";
		$upload_picy			= "";
		$upload_picn			= " ";
		
		$position				= "9";
		$formact			= "_new";
		
		$adminpost	= 1;
		
	}
	$formname			= "conf_profiles";
	
	$form_cat_title   = 'Profile';
	$form_cat_subtype = 'acti';
	$show_cuisine  = false;
	
	if($dir == "accomodations") {
		$form_cat_title 	= 'Accomodation';
		$form_cat_subtype  = 'acmo';
		$show_cuisine  = true;
		if($op=="new") { $id_profile_cat  = 5; }
	}
?>

	

	<div class="txtcenter">&nbsp;<?php echo $pgtitle; ?></div>
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td width="55%" bgcolor="#F7F7F7"><h4 style=" text-transform:uppercase"><?php echo $form_cat_title; ?> DETAILS </h4></td>
<td width="2%" bgcolor="#F7F7F7">&nbsp;</td>
<td width="40%" bgcolor="#F7F7F7"><h4 style="margin-left:20px; color:#000; text-transform:uppercase;"><?php echo $form_cat_title; ?> GALLERY </h4></td>
</tr>
<tr>
<td>

<?php if($adminpost == 0) { ?>
<h5 style="color:#f00">Tourism Industry Business Profile</h5>
<?php } ?>

<form class="admform" name="rage" method="post" action="adm_posts.php">
	
<!-- +++++++++++++++++++++++++++++++++++++++++++++++++ -->

<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center" class="tims">
<tr>
	<td nowrap="nowrap"><label class="required" for="id_parent"><?php echo $form_cat_title; ?> Circuit:</label></td>
	<td><select name="id_parent[]" id="id_parent" multiple="multiple" class="multiple" style="width:400px">
		  <?php echo $ddSelect->selectCircuits($rec_circuits); ?>
          </select> </td>
</tr>

<tr>
<td nowrap="nowrap"><label for="vac_category"><?php echo $form_cat_title; ?> Category:  </label></td>
<td>
<select id="vac_category" name="vac_category[]" multiple="multiple" class="multiple" style="width:400px">
	<?php echo $ddSelect->select_directoryCatsMenu($rec_cats); ?>
 </select>
</td>
</tr>
<TR>
	<TD nowrap="nowrap"><label for="title" class="required"><?php echo $form_cat_title; ?> Name:</label></TD>	
	<TD><INPUT TYPE="text"  id="title" NAME="title"  class="required" value="<?php echo $prof_title; ?>" maxlength="100" ></TD>
</TR>

<TR>
	<TD><label for="overview"><?php echo $form_cat_title; ?> Details:</label></TD>	
	<TD>
	<?php /*?><textarea name="overview" id="overview" class="wysiwyg" style="height:150px" /><?php echo $overview; ?></textarea><?php */?>	
	</TD>
</TR>
<TR>
	<TD colspan="2"><?php include("fck_rage/article_sm.php") ; ?></TD>
	</TR>

<TR>
	<TD><label for="contacts"><?php echo $form_cat_title; ?> Contacts:</label></TD>	
	<TD><textarea name="contacts" id="contacts" class="wysiwyg" /><?php echo $contacts; ?></textarea></TD>
</TR>
<?php /*?><TR>
	<TD><label for="website">Website:</label></TD>	
	<TD><INPUT TYPE="text"  id="website" NAME="website" value="<?php echo $website; ?>" maxlength="100" ></TD>
</TR><?php */?>

<?php
if($adminpost == 1) {
?><?php } ?>
<TR>
	<TD><label for="products"><?php echo $form_cat_title; ?> Products:</label></TD>	
	<TD><textarea name="products" id="products" class="wysiwyg" /><?php echo $products;//clean_breaks() ?></textarea></TD>
</TR>



<tr>
	<td>Is Active </td>
	<td><input type="checkbox" name="published" <?php echo $published; ?> class="radio"/>
		(<em>Tick = Yes, Blank = No</em>)</td>
</tr>
<tr>
	<td>&nbsp; </td>
	<td>&nbsp;</td>
</tr>
<tr><td colspan="2" style="background:#FFF">

<?php 
if($op=="edit" and $rsstaff_prof_count==1 and $adminpost == 0 and count($attachments) > 0) { 
	include("adm_profiles_pics_register.php");

 } ?>
</td></tr>

<tr>
<td>&nbsp;</td>
<td colspan="2">
<input type="submit" name="formsubmit" value="Save Profile"  style="height:30px;"/>
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formact" value="<?php echo $formact; ?>" />
<input type="hidden" name="adminpost" value="<?php echo $adminpost; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" />
<input type="hidden" name="redirect_edit" value="<?php echo "adm_profiles.php?d=".$dir."&op=edit&id="; ?>" />
<input type="hidden" name="redirect_new" value="<?php echo "adm_profiles.php?d=".$dir."&op=new"; ?>" />
</td>
</tr>
</table>

<!-- +++++++++++++++++++++++++++++++++++++++++++++++++ -->
</form>			 
	
	
	
			 
</td>
<td bgcolor="#F7F7F7">&nbsp;</td>
<td>
<?php if($op=="edit" and $rsstaff_prof_count==1) { ?>

	

<div>
<form class="admform" id="acc_gallery" name="acc_gallery" method="post" action="adm_posts.php"   enctype="multipart/form-data">
	<div class="radio_group">
	<label><input type="radio" name="file_type" id="add_photo" value="p" class="radio"  /> Upload Photo </label>	&nbsp;
	<?php /*?>
	<label><input type="radio" name="file_type" id="add_photo_url" value="u" class="radio"  /> Link Photo</label>	&nbsp;
	<?php */?>
	<label><input type="radio" name="file_type" id="add_video" value="v" class="radio" />Link Video </label>  
		
	</div>
	<input type="hidden" id="title_url" name="title_url" value="<?php echo $title_url; ?>" />
	
	<div id="file_box_video" style="display: none; background: #FDF7A6; ">
		<table width="96%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><label for="video_name" style="display:inline; padding:0"><strong>Video URL & Caption: &nbsp;</strong></label><?php /*?><span style="font-size:9px">URL e.g. http://www.youtube.com/embed/xxxxxxxxxx</span><?php */?></td>
		</tr>
		<tr>
		<td><input type="text" name="video_name" id="video_name" class="text_full" placeholder="Enter Video URL" ></td>
		</tr>
		
		<?php /*?><tr>
			<td><label for="video_caption"><strong>Video Caption:</strong></label></td>
		</tr><?php */?>
		<tr>
		<td><textarea name="video_caption" id="video_caption" class="text_full" style="height:30px;" placeholder="Caption"><?php echo $prof_title; ?></textarea> </td>
		</tr>
		<tr>
		<td><label><input type="submit" name="Submitv" value="Submit" style="width:80px; display:inline"/></label></td></tr>
		
		</table>		
	</div>
	
	
	<div id="file_box_photo_url" style="display: none; ">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td style="width:100px;"> <label for="photo_url_name"><strong>Image URL:</strong></label> </td>
		<td><input type="text" name="photo_url_name" id="photo_url_name" value=""  class="text_full"> </td>
		</tr>
		
		<tr>
		<td><label for="photo_url_caption"><strong>Image Caption:</strong></label> </td>
		<td><textarea name="photo_url_caption" id="photo_url_caption" class="text_full" style="height:30px; width:99%"><?php echo $prof_title; ?></textarea> </td>
		</tr>
		
		</table>
	</div>
		
		
	<div id="file_box_photo" style="display: none;background:#FEE2FC;">
		<table width="96%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td> <label for="photo_name"><strong>Select Image:</strong>: </label> </td>
		<td><label for="id_gallery_cat"><strong>Category:</strong></label></td>
		<td></td>
		</tr>
		<tr>
			<td><input type="file" name="myfile" id="photo_name" size="37"   /></td>
			<td><select name="id_gallery_cat" id="id_gallery_cat" style="width:140px;">
				<?php echo $ddSelect->dropper_select("dhub_dt_gallery_category", "id", "title", 2) ?>
			</select></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
		<td colspan="2">
			<textarea name="photo_caption" id="photo_caption" class="text_full" style="height:30px;width:99%" placeholder="Image Caption"><?php echo $prof_title; ?></textarea></td>
		<td></td>
		</tr>
		<tr>
		<td><label><input type="submit" name="Submitu" value="Submit" style="width:80px; display:inline"/></label></td>
		<td><input type="hidden" name="formname" value="conf_profiles_gallery" />
			<input type="hidden" name="id" value="<?php echo $id; ?>" />
			<input type="hidden" name="redirect" value="<?php echo "adm_profiles.php?d=".$dir."&op=edit&id=".$id; ?>" /></td>
		<td> </td>
		</tr>		
		<tr><td></td>
			<td></td>
			<td></td></tr>
		</table>		
	</div>	
	
	<div>
	
        
	</div>
</form>	
</div>

<hr />

<form action="adm_posts.php" method="post">
<ul id="files_long" ></ul>

<input type="hidden" name="redirect" value="<?php echo $ref_page; ?>" />
<input type="hidden" name="id_profile" value="<?php echo $id; ?>" />
</form>		

<?php } ?>		
</td>
</tr>
</table>




</div>