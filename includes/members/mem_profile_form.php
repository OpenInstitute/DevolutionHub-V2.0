<br /><h4>Your User Details</h4> 

<div>
<?php

	$sqdata = "SELECT * FROM `dhub_reg_account` WHERE (`account_id` = ".q_si($us_id)."); ";
	
	$rsdata = $cndb->dbQueryFetch($sqdata);
	$fData  = current($rsdata);
	//displayArray($fData);	
	$newsletter = yesNoChecked(@$fData['newsletter']);
	/*if($rsdata_count==1)
	{
		$cndata = mysql_fetch_row($rsdata);
		
		$id					= $cndata[0];
		$firstname				= html_entity_decode(stripslashes($cndata[1]));
		$lastname			= html_entity_decode(stripslashes($cndata[2]));
		$email			= html_entity_decode(stripslashes($cndata[3]));
		$phone			= html_entity_decode(stripslashes($cndata[4]));
		$organization			= html_entity_decode(stripslashes($cndata[5]));
		$country					= $cndata[6];
		$address			= html_entity_decode(stripslashes($cndata[8]));
		$city			= html_entity_decode(stripslashes($cndata[7]));
		$newsletter			= $cndata[9]; 
		if($newsletter==1) {$newsletter="checked ";} else {$newsletter="";}
		
		
	}*/
?>
<form  name="fm_profile"  id="fm_profile" class="fm_base" action="posts.php" method="post" >
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
	<TD><INPUT TYPE="text"  id="email" NAME="email"  class="required email" maxlength="40" disabled="disabled" readonly="readonly" value="<?php echo @$fData['email']; ?>" /></TD>
</TR>


<TR>
	<TD style="width:250px"><label for="qf_firstname" class="required">First Name:</label></TD>	
	<TD><INPUT TYPE="text"  id="namefirst" NAME="namefirst"  class="required" maxlength="50" value="<?php echo @$fData['namefirst']; ?>" /></TD>
</TR>


<TR>
	<TD><label for="namelast" class="required">Last Name:</label></TD>	
	<TD><INPUT TYPE="text"  id="namelast" NAME="namelast"  class="required" maxlength="50" value="<?php echo @$fData['namelast']; ?>" /></TD>
</TR>

<TR>
	<TD><label for="phone">Phone Number(s):</label></TD>
	<TD><input type="text" name="phone" id="phone" maxlength="150" value="<?php echo @$fData['phone']; ?>" /></TD>
</TR>

<?php /*if($us_org_id <> '' and $us_type_id == 1){ ?> 
<TR>
	<TD><label for="organization_id">Organization:</label></TD>
	<TD><select name="organization_id" id="organization_id">
			<?php echo $ddSelect->dropper_select("dhub_conf_organizations", "organization_id", "organization", @$fData['organization_id']) ?>
		</select>
	</TD>
</TR>
<?php }*/ ?> 


<TR>
	<TD><label for="country">Country of Residence:</label></TD>
	<TD>
		<select name="country" id="country" style="margin-bottom:5px;">
			<?php echo $ddSelect->dropper_select("dhub_reg_countries", "iso_code_2", "country", @$fData['country']) ?>
		</select></TD>
</TR>
<!--<TR>
	<TD><label for="city">City:</label></TD>
	<TD><input type="text" name="city" id="city"  maxlength="50" value="<?php echo @$fData['city']; ?>" /></TD>
</TR>-->


<TR>
	<TD><label>Subscribe for Updates:</label></TD>
	<TD><label class="labelleft"><input type="checkbox" name="newsletter" <?php echo $newsletter; ?> class="radio"/>	<strong></strong></label></TD>
</TR>
<TR>
<TD>&nbsp;</TD>
<TD align="left">
<button type="input" name="submit" id="submitProfile" value="submit" class="btn btn-success btn-icon col-md-3">Update Profile </button>

<input  NAME="formname" type="hidden" value="fm_profile" />
<input  NAME="nah_snd" id="nah_snd" type="text" />  
<input name="redirect" type="hidden" value="profile.php<?php echo $ref_qrystr; ?>" />
</TD>
</TR>

</tbody>
</TABLE>
</form>
</div>

<!--<p>&nbsp;</p>-->
