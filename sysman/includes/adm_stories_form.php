
	
<?php
$confDir = ucwords($dir);
$pgtitle			= "<h2>New $confDir</h2>";
$formname           = "fm_share_story";
$formaction         = "_new";
$fData 		      = array();
$fData['published'] = 1;
$fData['confirmed'] = 0;
$fData['approved'] = 0;

$fData['seq']	   = 9;

$fData['cat_parent']	= '';
$fData['cat_directory'] = 0;
$fData['cat_equipment'] = 0;

if($dir == 'directory entries') { $fData['cat_directory'] = 1; $fData['cat_parent'] = '_dir'; }
if($dir == 'cover crop entries') { $fData['cat_crop'] = 1; $fData['cat_parent'] = '_crp'; }


if(!isset($_POST['frm_submit']))
{

if($op=="edit")
{
	$pgtitle	   = "<h2>$confDir</h2>";
	$formaction 	= "_edit";
	
	
	
	if($id)
	{
	
		$sqdata="SELECT * FROM `dhub_reg_storyshare` WHERE  (`id`  = ".quote_smart($id).")";
		//echo $sqdata;
		$rsdata 	   = $cndb->dbQuery($sqdata);
		$rsdata_count =  $cndb->recordCount($rsdata);
		
		$rs_fields = mysqli_num_fields($rsdata);
			
		if($rsdata_count == 1)
		{
			
			$cn_fields = $cndb->fetchRow($rsdata);
			
			/* ************************************************************** 
			@ get fields
			****************************************************************/
	
			for ($i = 0; $i<$rs_fields; $i++)
			{
				$field_names[$i] = mysql_fetch_field($rsdata, $i);			
				$fData[$field_names[$i]->name] = $cn_fields[$field_names[$i]->name];
			}
			
		}
	}
	


//displayArray($fData);
	


	$story_files	 = '';
	$story_files_arr = @unserialize($fData['story_files']);
	$user_profession = implode(', ', @unserialize($fData['user_profession']));
	
	if(is_array($story_files_arr))
	{
		foreach($story_files_arr as $key => $filearr)
		{
			$fname = $filearr['file'];
			$ftext = '<span style="color: green;">Caption: </span>' . clean_output($filearr['caption']);
				
			if(substr($key,0,3) == 'pic') {
				$ftype = '<span style="color: green;">Image: </span>';
				$flink = DISP_CA_STORIES.$fname;
				$fdisp = '<img src="'.DISP_CA_STORIES.$fname.'" style="width:70px; height:50px;" />';
			}
			
			if(substr($key,0,3) == 'vid') {
				$ftype = '<span style="color: green;">Video: </span>&nbsp;';
				$flink = $fname;
				$fdisp = '<img src="'.$flink.'" style="width:70px; height:50px;" />';
			}
			
			$story_files .= '<table><tr><td style="width:80px;">'.$fdisp.'</td><td>'.$ftype.'<a href="'.$flink.'">'.$fname.'</a><br>'.$ftext.'</td></tr></table>';
						
			//$story_files .= $ftype . ' <a href="'.$flink.'">'.$fname.'</a><br>'.$ftext.'<br><br>';
		}
	}

}



	
$published = yesNoChecked($fData['published']);	
$confirmed = yesNoChecked($fData['confirmed']);
$approved  = yesNoChecked($fData['approved']);

$frmClass = '';

?>

<div style="width:90%; margin:0 auto; border:0px solid">

<div style="max-width:900px; margin:auto;">
<div style="text-align:center"><?php echo $pgtitle; ?></div>

<!-- onsubmit="javascript: return false;"-->

<form class="rwdform rwdfull <?php echo $frmClass; ?>" name="fm_share_story" id="fm_share_story" method="post" action="hforms.php?d=<?php echo $dir; ?>">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<input type="hidden" name="id" value="<?php echo @$fData['id']; ?>" />
<input type="hidden" name="redirect" value="hforms.php?d=<?php echo $dir; ?>&op=edit" />


<div class="form-group">
<label class="textlabel control-label" for="story_title">Story Title</label>
<div>
<input type="text" name="share[story_title]" id="story_title" value="<?php echo @$fData['story_title']; ?>" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="problem_nature">Problem Nature</label>
<div>
<textarea name="share[problem_nature]" id="problem_nature" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['problem_nature']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="solution_method">Solution Method</label>
<div>
<textarea name="share[solution_method]" id="solution_method" rows="2" cols="50" class="textarea form-control">
<?php echo @$fData['solution_method']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="solution_impact_results">Solution Impact Results</label>
<div>
<textarea name="share[solution_impact_results]" id="solution_impact_results" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['solution_impact_results']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="expected_effects">Expected Effects</label>
<div>
<textarea name="share[expected_effects]" id="expected_effects" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['expected_effects']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="crops_grown">Crops Grown</label>
<div>
<textarea name="share[crops_grown]" id="crops_grown" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['crops_grown']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="ca_type_practised">CA Type Practised</label>
<div>
<textarea name="share[ca_type_practised]" id="ca_type_practised" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['ca_type_practised']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="farm_size">Farm Size</label>
<div>
<textarea name="share[farm_size]" id="farm_size" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['farm_size']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="terrain">Terrain</label>
<div>
<textarea name="share[terrain]" id="terrain" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['terrain']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="solution_benefits">Solution Benefits</label>
<div>
<textarea name="share[solution_benefits]" id="solution_benefits" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['solution_benefits']; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="story_files">Story Files</label>
<div>
	<div><?php echo $story_files; ?></div>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_name">User Name</label>
<div>
<input type="text" name="user_name" id="user_name" value="<?php echo @$fData['user_name']; ?>"  class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_phone">User Phone</label>
<div>
<input type="text" name="user_phone" id="user_phone"  value="<?php echo @$fData['user_phone']; ?>"  class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_email">User Email</label>
<div>
<input type="text" name="user_email" id="user_email"  value="<?php echo @$fData['user_email']; ?>"  class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_country">User Country</label>
<div>
	<select name="user_country" id="user_country" class="form-control">
	<?php echo $ddSelect->dropper_select("dhub_reg_countries", "id", "country", @$fData['user_country']) ?>
	</select>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_location">User Location</label>
<div>
<input type="text" name="user_location" id="user_location"  value="<?php echo @$fData['user_location']; ?>"  class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_gender">User Gender</label>
<div>
<input type="text" name="user_gender" id="user_gender"  value="<?php echo @$fData['user_gender']; ?>" class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_occupation">User Occupation</label>
<div>
<input type="text" name="user_occupation" id="user_occupation"  value="<?php echo @$fData['user_occupation']; ?>"  class="text form-control"/>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_profession">User Profession</label>
<div>
<textarea name="user_profession" id="user_profession" rows="2" cols="50" class="textarea form-control"><?php echo $user_profession; ?></textarea>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="user_organization">User Organization</label>
<div>
<input type="text" name="user_organization" id="user_organization" value="<?php echo @$fData['user_organization']; ?>"  class="text form-control"/>
</div> 
</div>

<?php /*?><div class="form-group">
<label class="textlabel control-label" for="other_details">Other Details</label>
<div>
<textarea name="other_details" id="other_details" rows="2" cols="50" class="textarea form-control"><?php echo @$fData['other_details']; ?></textarea>
</div> 
</div><?php */?>

<div class="form-group">
<label class="textlabel control-label" for="date_record">Date Posted</label>
<div>
<input type="text" name="date_record" id="date_record" size="19" maxlength="19" value="<?php echo dateDisplayFormat(@$fData['date_record']); ?>" class="text form-control"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="confirmed">Confirmed</label>
<div>
<input type="checkbox" name="confirmed" id="confirmed" <?php echo $confirmed; ?> class="radio"/> <em>(Yes / No)</em>
</div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="approved">Approved</label>
<div>
<input type="checkbox" name="approved" id="approved" <?php echo $approved; ?> class="radio"/> <em>(Yes / No)</em>
</div> 
</div>

<?php /*?><div class="form-group">
<label class="textlabel control-label" for="approved_by">Approved By</label>
<div>
<input type="text" name="approved_by" id="approved_by" size="11" maxlength="11" class="text form-control">
</div> 
</div><?php */?>


<div class="form-group">
<label class="textlabel control-label" for="published">Published</label>
<div>
<input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em>
</div></div>





<div class="form-group">
<div><input type="submit" name="frm_submit" id="Submit" value="Submit" /></div>
</div>	


	
</form>
</div>
</div>
</div>

<?php
}

if(isset($_POST['frm_submit']))
{
	
	$post	 = array_map("filter_data", $_POST);
	//if(!array_key_exists('approved', $post)) { $post['approved'] = 'off'; }
		
	$redirect   = $_POST['redirect'];
	$formaction = $post['formaction'];
	$field_names = array_keys($post['share']); 	
	
	$field_names[] = 'published';
	$field_names[] = 'approved';
	$field_names[] = 'confirmed';
	
	//displayArray($field_names); 
	
	$myCols = array();
	$myDats = array();
	
	$myImg = "";
	
	foreach($field_names as $field)
	{
		if(	 $field == "formname"     or $field == "frm_submit" or $field == "txtCaptcha" or 
				$field == "s_pic1_text"  or $field == "s_pic2_text" or $field == "qf_agree" or 
				$field == "formtype"     or $field == "nah_snd" or $field == "s_vid" or 
				$field == "s_vid_text"   or $field == "id"        or $field == "redirect" )
		{	$mySql .= "";	}
		else
		{
			if($field <> "published" and $field <> "approved" and $field <> "confirmed")
			{
				$fieldVal	= $post['share'][''.$field.''];
			}
			else
			{
				if(!array_key_exists(''.$field.'', $post)) { $post[''.$field.''] = 'off'; }
				
				$fieldVal = yesNoPost($post[''.$field.'']);
			}
			
			//if($field == "published") 	{ $fieldVal = yesNoPost($post[''.$field.'']); } 
			//if($field == "user_profession") { $fieldVal = @serialize($post['user_profession']); } 
			
			
			if($formaction == "_edit") {
				$myCols[] = " `$field` = ".quote_smart($fieldVal).""; 
			}			
			elseif($formaction == "_new"){ 
				$myCols[] = "`$field`";	
				$myDats[] = "".quote_smart($fieldVal)."";
			}
			
			
		}
	}
	
	if ($formaction=="_edit" ) {	
		$sqpost = "UPDATE `dhub_reg_storyshare` set  ".implode($myCols, ', ')." where (`id` = ".quote_smart($post['id'])." )" ;		
	}
	if ($formaction=="_new" ) {	
		$sqpost  =  "insert into `dhub_reg_storyshare` (".implode($myCols, ', ').") values (". implode($myDats, ', ') ."); ";
	}
	//echobr($sqpost); exit;
	$type	= new posts;
	$type->inserter_plain($sqpost);
	
	if ($formaction=="_new" ) { $id_story = $type->qLastInsert; }
	if ($formaction=="_edit" ) { $id_story = $post['id']; }
	
	$redirect = $redirect.'&op=edit&id='.$id_story; //exit;
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
}

?>



<script type="text/javascript">
jQuery(document).ready(function($){
	<?php /*?>$.get('adm_gallery_pics.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
		$('#files').html(data);
	});<?php */?>
});
</script>