<?php
$formname		= "conf_account";
$fData 		   = array();
$fData['account_id'] = '';
$fData['newsletter'] = 1;
$fData['published']  = 1;

$formact		 = "_new";
$pgtitle		 = "New Account";
$is_editable 	 = '';
$user_cats	   = array();
$image_disp	  = '';

if($op=="edit")
{
	$pgtitle	 = "Edit Account";
	$is_editable = ' readonly="readonly" ';
	
	if($id)
	{
		$sqdata = "SELECT `account_id` , `namefirst` , `namelast` , `email` , `phone` , `country` , `city` , `profile` , `newsletter` , `published`, `avatar` FROM `dhub_reg_account` where `account_id` = ".quote_smart($id)."; ";
		
		$rsdata	= $cndb->dbQuery($sqdata);
		$rsdata_count =  $cndb->recordCount($rsdata);
		$rs_fields = mysqli_num_fields($rsdata);
		
		
		if($rsdata_count==1)
		{
			$cn_fields = $cndb->fetchRow($rsdata);			
			
			for ($i = 0; $i<$rs_fields; $i++)
			{
				$field_names[$i] = mysql_fetch_field($rsdata, $i);			
				$fData[$field_names[$i]->name] = $cn_fields[$field_names[$i]->name];
			}
			
			$sqdata_m = "SELECT `id_category` FROM `dhub_reg_cats_links` WHERE (`account_id` = ".quote_smart($id)."); ";
			$rsdata_m = $cndb->dbQuery($sqdata_m);
			if( $cndb->recordCount($rsdata_m)) 
			{
				while($cndata_m = $cndb->fetchRow($rsdata_m))
				{
				$user_cats[] = $cndata_m[0];
				}
			}
		
			$photo			= $fData['avatar']; 
			if($photo == '') { $photo = 'no_avatar.png'; }			
			$image_disp			= "<img src=\"".DISP_AVATARS.$photo."\"  style=\"max-width:300px; max-height:300px;\" >";
			
		
		}
		
		$formact		 = "_edit";
	}
}
/*elseif($op=="new")
{

	$id					= "";
	$newsletter			= "checked ";
	$published			= "checked ";
	$formname			= "account_new";
	
	$is_editable	= '';
}*/

$newsletter	= yesNoChecked($fData['newsletter']);
$published	 = yesNoChecked($fData['published']);

//displayArray($user_cats);

?>
<div class="middle" style="width:600px; margin:0 auto;">


<div class="padd15X" style="border:0px solid">
<?php echo display_PageTitle($pgtitle, 'h3'); ?>
<form  class="rwdform rwdfull rwdvalid frmnoborder" method="POST" name="afp_conf_person" id="afp_conf_person" action="adm_posts.php" enctype="multipart/form-data">
<input type="hidden" name="account_id" id="account_id" value="<?php echo @$fData['account_id']; ?>">
<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
<input type="hidden" name="formact" value="<?php echo $formact; ?>" />
<input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />


<div class="form-group">&nbsp;</div>
<legend>User Details</legend>

<div class="form-group">
<label class="textlabel control-label" for="id_category">Account Category</label>
<div>
<select id="id_category" name="id_category[]"  multiple="multiple" class="multiple">
 <?php echo $ddSelect->selectUserCat("n", $user_cats) ?>
</select>
</div> 
</div>

<div class="form-group">
<label class="required control-label" for="namefirst">Firstname</label>
<div>
<input type="text" name="namefirst" id="namefirst" size="50" maxlength="100" class="required form-control" value="<?php echo @$fData['namefirst']; ?>" />
</div> 
</div>

<div class="form-group">
<label class="required control-label" for="namelast">Lastname</label>
<div>
<input type="text" name="namelast" id="namelast" size="50" maxlength="100" class="required form-control " value="<?php echo @$fData['namelast']; ?>" />
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="email">Email</label>
<div>
<input type="text" name="email" id="email" size="50" maxlength="100" class="required email form-control" <?php echo $is_editable; ?> value="<?php echo @$fData['email']; ?>"/>
</div> 
</div>


<div class="form-group">
<label class="textlabel control-label" for="phone">Phone</label>
<div>
<input type="text" name="phone" id="phone" size="50" maxlength="100" class="text form-control" value="<?php echo @$fData['phone']; ?>"/></div> 
</div>

<div class="form-group">
<label class="textlabel control-label" for="country">Country</label>
<div>
	<select name="country" id="country" class="form-control required">
	<?php echo $ddSelect->dropper_select("dhub_reg_countries", "iso_code_2", "country", @$fData['country'], "Select Country") ?>
	</select>
</div> 
</div>

<div class="form-group">&nbsp;</div>
<legend>Account Options</legend>

<div class="form-group">
<label class="textlabel control-label" for="newsletter">Newsletter Subscribe:</label>
<div>
	<div class="radio_group">
	<label><input type="checkbox" id="newsletter" name="newsletter" <?php echo $newsletter; ?> class="radio"/> Yes / No</label>
	</div>
</div>
</div>

<?php 
if($op=="edit"){
?>
<div class="form-group">
<label class="textlabel control-label" for="published">Active:</label>
<div>
	<div class="radio_group">
	<label><input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/> Yes / No</label>
	</div>
</div>
</div>
<?php 
}
?>

<?php /*?>
<legend>Profile Photo</legend>

<div class="form-group">
<label class="textlabel control-label" for="country_id">Upload Photo:</label>
<div>
	<div class="radio_group">
	<label><input name="change_image" id="upload_y" type="radio" value="Yes"  class="" /> Yes </label>
	<label><input name="change_image" id="upload_n" type="radio" value="No" checked="checked" class="" /> No</label>
	</div>
</div>
</div>
				
<div class="form-group" id="upload_avatar" style="display:none">
<label class="textlabel control-label" for="reg_photo">&nbsp;</label>
<div>
	<div class="uploader" id="upload_reg_photo">
		<input style="opacity: 0;" name="reg_photo" id="reg_photo" type="file" accept="image/*" onchange="javascript: setFilename('upload_reg_photo', 'reg_photo', '1')" >
		<span style="-moz-user-select: none;" class="filename">No file selected</span>
		<span style="-moz-user-select: none;" class="action">Choose File</span>	
	</div> 
		<input type="hidden" name="command" value="1" />
		<input type="hidden" name="image_old" value="<?php echo $photo; ?>" />
</div> 
</div>


<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<?php echo $image_disp; ?>	
</div> 
</div>			
<?php */?>

<div class="form-group">&nbsp;</div>
				
<div class="form-group">
<label class="control-label" for="">&nbsp;</label>
<div>
<button type="submit" class="btn btn-success" id="f_submit" name="submit" value="1"><i class="glyphicon glyphicon-plus"></i>Submit</button>
</div>

</div>



</form>
</div>


<?php /*?>
<p>&nbsp;</p>
<hr />
        <form action="adm_posts.php" method="post"  id="register" name="create" class="cmxform admform" >
      <b style="margin-bottom: 2px; display: block;">Personal Details</b>

      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table class="full">
          <tr>
          	<td><label>Account Category:</label></td>
          	<td><select id="id_category" name="id_category[]"  multiple="multiple" class="multiple">
 <?php echo $ddSelect->selectUserCat("n", $user_cats) ?>
</select></td>
          	</tr>
          <tr>
            <td width="150"><label class="required" for="firstname"> First Name:</label></td>
            <td><input type="text" name="firstname" id="firstname" class="required" value="<?php echo $firstname; ?>"  maxlength="50" <?php echo $is_editable; ?> />
              </td>
          </tr>

          <tr>
            <td><label class="required" for="lastname"> Last Name:</label></td>
            <td><input type="text" name="lastname" id="lastname" class="required" value="<?php echo $lastname; ?>" maxlength="50" <?php echo $is_editable; ?> />
              </td>
          </tr>
          <tr>
            <td><label class="required" for="email"> E-Mail:</label></td>

            <td><input type="text" name="email" id="email" class="required email" value="<?php echo $email; ?>" maxlength="40" <?php echo $is_editable; ?> />
              </td>
          </tr>
          <tr>
            <td><label for="phone"> Phone Number:</label></td>
            <td><input type="text" name="phone" id="phone"  value="<?php echo $phone; ?>" maxlength="30" <?php echo $is_editable; ?> />
              </td>

          </tr>
         
        </table>
      </div>
      <b style="margin-bottom: 2px; display: block;">Other Details</b>

      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table class="full">
          <tr>
            <td width="150"><label for="organization">Organization:</label></td>
            <td><input type="text" name="organization" id="organization" value="<?php echo $organization; ?>" maxlength="50" /></td>
          </tr>
		  <tr>
		     <td width="150"><label for="currentpost">Current Post:</label></td>
            <td><input type="text" name="currentpost" id="currentpost" value="<?php echo $currentpost; ?>" maxlength="50" /></td>
	      </tr>
		  <tr>
		    <td><label for="country">Country:  </label></td>
		    <td><select name="country" id="country" class="required">
        <?php echo $ddSelect->dropper_select("dhub_reg_countries", "id", "country", $country) ?>
      </select></td>
	      </tr>
        </table>
      </div>
	  <?php
	  if($op=="new"){
	  ?>
      <b style="margin-bottom: 2px; display: block;">Account Password</b>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table class="full">

          <tr>

            <td width="150"><label class="required" for="password"> Password:</label></td>
            <td><input type="password" name="password" id="password" class="required password" value="" maxlength="15" />
              </td>
          </tr>
          <tr>
            <td><label class="required" for="confirm"> Confirm Password:</label></td>

            <td><input type="password" name="confirm" id="confirm" class="required" value="" maxlength="15" />
            </td>
          </tr>
        </table>
      </div>
	  <?php
	  }
	  ?>
      <b style="margin-bottom: 2px; display: block;">Newsletter</b>
      <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
        <table class="full">

          <tr>
            <td width="150"><label>Subscribe:</label></td>
            <td>
			<label><input type="checkbox" name="newsletter" <?php echo $newsletter; ?> class="radio"/> Yes / No</label>
			</td>
          </tr>
          <tr>
            <td width="150"><label>Is Active:</label></td>
            <td>
			<label><input type="checkbox" name="published" <?php echo $published; ?> class="radio"/> Yes / No</label>
			</td>
          </tr>
        </table>

      </div>
            <div class="buttons">
        <table class="full" border="0">
          <tr>
            <td  style="padding-right: 5px; width:170px">&nbsp;</td>
            <td>
			<input type="submit" name="submit" value="Save Details" />	
			<input type="hidden" name="formname"  value="<?php echo $formname; ?>" />
		  <input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />
		   </td>
          </tr>
        </table>
      </div>
          </form>

<?php */?>

</div>


<script type="text/javascript">
jQuery(document).ready(function($)
{ 
	$("#upload_y").click(function () { 
		$("#upload_avatar").show();   
	});
	$("#upload_n").click(function () { 
		$("#upload_avatar").hide();   
	});
});

function setFilename(upBox, upField, upKey)
{
 jQuery(document).ready(function($){
  	var fileDefaultText = 'No file selected';
	
  	var filenameTag = $('div#'+upBox+' span.filename');
	var filenameBtn = $('div#'+upBox+' span.action');
	
	var fileLabel = $('input#file_title_'+upKey+'');
	
	
	var $el = $('#'+upField+''); 
	var filename = $el.val();
	var filenameC = $el.val();
	
	filenameC = filenameC.split(".");
	filenameC = filenameC[(filenameC.length-1)].toUpperCase();
	
		if (filename === '') {	filename = fileDefaultText;	}
		else { 	
			filename = filename.split(/[\/\\]+/); filename = filename[(filename.length-1)];		
			filenameTag.html(filename);
			fileLabel.attr("value", filename.substr(0,filename.length-4)).focus();
	
		}
	});
};
</script>
