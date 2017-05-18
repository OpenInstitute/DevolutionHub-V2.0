<div style="text-align:left">
<h2 style="font-size:22px; font-weight:normal; text-transform:none">Quick Content Add:</h2>
</div>

<!--multiple  accept="audio/*"-->

<div id="order_uploads" style="display:none;">
<textarea style="display:none" id="file_filler">
<tr class="tr_file_{0}" style="border-top:5px solid #f5f5f5;">
	
	<td style="padding:5px 5px 0 0">{0}.</td>
	
	
	<td>
	<input type="text" name="title[{0}]" id="title_{0}"  maxlength="300" class="text_full required" placeholder="Content title" style="width:100%;" title="Required"><br>
	<input type="text" name="title_sub[{0}]" id="title_sub_{0}"  maxlength="500" placeholder="Alternate Title /Keywords" class="text_full">
	<br /><br />
	<input type="text" name="image[{0}]" id="image_{0}" value=""  class="text_full" maxlength="50" placeholder="Enter Image Name">
	</td>
	<td>
	<?php /*?><select name="id_section[{0}]" id="id_section_{0}" class="required" style="width:130px;">
        <?php echo $dropSection; ?>
      </select><?php */?>
	  <input type="text" name="created[{0}]" id="created_{0}" class="date-pick half_width required" style="width: 90px" value="<?php echo $created; ?>" >
	  <br />
	  
	 <select name="published[{0}]" id="published_{0}" style="width:130px;">
        <option value="1">Is Active</option><option value="0">Not Active</option>
      </select>
	</td>
	<td>
	<textarea name="article[{0}]" id="article_{0}" class="wysiwyg" style="height:150px" placeholder="Enter text" /></textarea>
	</td>
	
</tr>
</textarea>
</div>
		





<form class="admform" id="cont_multi" name="rage" method="post" action="adm_posts.php" onSubmit="javascript:return valid_article()"   enctype="multipart/form-data">
<input type="hidden" name="sidebar" value="0"/>
<input type="hidden" name="id_portal" value="1" />
<input type="hidden" name="link_static" value=""/>

<table  border="0" cellspacing="1" cellpadding="3" align="center" style="width:99%" >

<tr>
<td nowrap="nowrap"><label class="required" for="id_parent">Parent Link</label></td>
<td colspan="3">
<select name="id_parent[]" id="id_parent" multiple="multiple" class="multiple" style="width:700px">
<?php echo $dispData->build_MenuSelectRage(0, $parent); ?>
<?php //echo $dispData->build_MenuSelect($dispData->menuMain_portal, $parent, 0 , $parent); ?>
</select>      
</td>
</tr>
<tr>
      <td nowrap="nowrap"><label class="required" for="id_section">Display Type</label></td>
      <td><select name="id_section" id="id_section">
        <?php echo $ddSelect->dropper_select("dhub_dd_sections", "id", "title", $id_section) ?>
      </select></td>
      <td></td>
      <td>
      </td>
    </tr>
</table>
<div style="width:100%; display:block; border:3px solid #e1e1e1; margin:10px auto;">

  
<table   border="0" cellspacing="0" cellpadding="0" id="file" style="margin:0px auto; width:100%;">
<thead>
<tr id="display_titles">
<td>&nbsp;</td>
<td style="width:450px;"><label>Content Title: </label></td>
<td><label>Date and Status: </label></td>
<td><label>Content Text:</label></td>
</tr>
</thead>
<tbody>

</tbody>

<tfoot>
  <tr>
	<td></td>
	<td><a id="del_file" class="nav_button">Cancel [-]</a> </td>
	<td colspan="4" style="text-align:right"><a id="add_file" class="nav_button">Add New Row [+]</a> </td>
  </tr>
  <tr>
	<td colspan="6">
	<div style="padding:15px; background:#e2e2e2; text-align:center;">
	<input type="submit" name="cont_submit" value="Submit Content" class="submit" style="padding:10px; width:200px;"   />
        <input type="hidden" name="formname" value="<?php echo $formname; ?>" />
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="redirect" value="adm_articles_multi.php?d=contents&op=new" />	
		<?php //echo "home.php?d=".$dir; ?>
	</div>
	</td>
  </tr>
</tfoot>

</table>

</div>


</form>