
<?php echo display_PageTitle('Member Account Details', 'h3', 'txtgray'); ?>

<?php
	//displayArray($request);

$showForm = false;
$fData = array();
$lockEmail = ' disabled="disabled" readonly="readonly" ';

$group[1] = $group[2] = $group[3] = $group[4] = '';	

if($op == "edit" or $op == "view")
{
	if($id)
	{		
		$sqdata = "SELECT * FROM `dhub_reg_account` WHERE (`account_id` = ".q_si($request['id'])." and `organization_id` = ".q_si($us_org_id)."); ";
		$rsdata = $cndb->dbQueryFetch($sqdata);
		if(count($rsdata))
		{
			$fData  = current($rsdata);
			$formaction = "_edit";
			$showForm = true;
		}
		else
		{ $showForm = false; }
	}
}
elseif($op == "new")
{
	$formaction = "_new";
	$showForm = true;
	$lockEmail = '';
	
	$fData['group_id'] = 2;
}

$group[$fData['group_id']] = ' selected ';
//displayArray($fData);	
	
$published = yesNoChecked(@$fData['published']);

$us_type_id = 2;
$frmNoEdit = '';
if($us_type_id == 2){ $frmNoEdit = 'frmNoEdit'; }


if($showForm)
{	
?>
<div>
<form  name="fm_profile"  id="fm_profile_member" class="fm_base rwdvalid <?php echo $frmNoEdit; ?>" action="posts.php" method="post" >
<input type="hidden" name="formaction" value="<?php echo $formaction; ?>" />
<INPUT TYPE="hidden" NAME="organization_id" value="<?php echo @$us_org_id; ?>" />
<INPUT TYPE="hidden" NAME="account_id" value="<?php echo @$fData['account_id']; ?>" />

<div class="errorBox">Highlighted fields are required!</div>
<TABLE cellpadding="0" cellspacing="0" border="0" class="full noborder">
<tbody>
<TR>
	<TD><label for="organization_id">Organization:</label></TD>
	<TD><INPUT TYPE="text" disabled="disabled" readonly="readonly" value="<?php echo $us_org; ?>" />
	</TD>
</TR>
<TR>
	<TD><label for="email" class="required"> Email / Username:</label></TD>
	<TD><INPUT TYPE="text"  id="email" NAME="email"  class="required email" maxlength="40" <?php echo $lockEmail; ?> value="<?php echo @$fData['email']; ?>" /></TD>
</TR>
<TR>
	<TD style="width:250px"><label for="namefirst" class="required">First Name:</label></TD>
	
	<TD><INPUT TYPE="text"  id="namefirst" NAME="namefirst"  class="required" maxlength="50" value="<?php echo @$fData['namefirst']; ?>" /></TD>
</TR>
<TR>
	<TD><label for="namelast" class="required">Last Name:</label></TD>	
	<TD><INPUT TYPE="text"  id="namelast" NAME="namelast"  class="required" maxlength="50" value="<?php echo @$fData['namelast']; ?>" /></TD>
</TR>

<?php
 if($formaction == "_edit"){
 ?>
<TR>
	<TD><label for="phone">Phone Number:</label></TD>
	<TD><input type="text" name="phone" id="phone" maxlength="150" value="<?php echo @$fData['phone']; ?>" /></TD>
</TR>
<TR>
	<TD><label for="country">Country of Residence:</label></TD>
	<TD><select name="country" id="country" style="margin-bottom:5px;">
			<?php echo $ddSelect->dropper_select("dhub_reg_countries", "iso_code_2", "country", @$fData['country']) ?>
		</select></TD>
</TR>
<TR>
	<TD><label for="city">City:</label></TD>
	<TD><input type="text" name="city" id="city"  maxlength="50" value="<?php echo @$fData['city']; ?>" /></TD>
</TR>

<TR>
	<TD><label for="group_id">Access Level:</label></TD>	
	<TD><select name="group_id" id="group_id" class="form-control required">
		<?php if($us_type_id == 1){ ?> 
		<option value="1" <?php echo $group[1]; ?>>Administrator</option>
		<?php } ?> 
		<option value="2" <?php echo $group[2]; ?>>User</option>
		<option value="3" <?php echo $group[3]; ?>>Editor</option>
		<option value="4" <?php echo $group[4]; ?>>Contributor</option>
	</select>
	</TD>
</TR>


<TR>
	<TD><label for="published">Is Active:</label></TD>
	<TD><label class="labelleft"><input type="checkbox" name="published" id="published" <?php echo $published; ?> class="radio"/>	 <small>(Yes / No)</small></label></TD>
</TR>
<?php
 }
 ?>
<TR>
<TD>&nbsp;</TD>
<TD align="left">
<button type="input" name="submit" id="submitProfile" value="submit" class="btn btn-success btn-icon col-md-3">Submit </button>
<input  NAME="formname" type="hidden" value="fm_profile_member" />
<input  NAME="nah_snd" id="nah_snd" type="text" />  
<input name="redirect" type="hidden" value="profile.php<?php echo $ref_qrystr; ?>" />
</TD>
</TR>

</tbody>
</TABLE>
</form>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$("#fm_profile_member").validate();
	
});
</script>	


<?php
}
else
{ echo '<div class="warning">Nothing to display here!</div>';
}
 ?>