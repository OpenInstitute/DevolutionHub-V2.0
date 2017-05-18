<div class="padd15" style="border:0px solid">
<?php echo display_PageTitle('Change Account Password'); ?>
<div class="info">Update your details below. </div>
<!--<h4>Change Password</h4> -->
<form  name="fm_profile_pass"  id="fm_profile_pass" class="fm_base rwdvalid" action="posts_profile.php" method="post" >
<div class="errorBox">Highlighted fields are required!</div>
<TABLE cellpadding="0" cellspacing="0" border="0" class="full noborder">
<tbody>

<TR>
	<TD style="width:250px"><label for="qf_pass_old" class="required">Current Password:</label></TD>	
	<TD><INPUT TYPE="password"  id="qf_pass_old" NAME="qf_pass_old"  maxlength="12" minlength="6" class="required " value="" ></TD>
</TR>
<TR>
	<TD style="width:250px"><label for="qf_password" class="required">New Password:</label></TD>	
	<TD><INPUT TYPE="password"  id="qf_password" NAME="qf_password"  maxlength="12" minlength="6" class="required " value="" ></TD>
</TR>
<TR>
<TD><label for="qf_password_conf" class="required">Confirm New Password:</label></TD>

<TD><INPUT TYPE="password"  id="qf_passconfirm" NAME="qf_passconfirm"  maxlength="12" minlength="6" class="required" value="" ></TD>
</TR>


		
<TR>
<TD>&nbsp;</TD>
<TD align="left">
<button type="submit" class="btn btn-success" id="f_submit" name="submit" value="1"><i class="glyphicon glyphicon-plus"></i>Submit</button>
<input  NAME="formname" type="hidden" value="fm_profile_pass" />
<input  NAME="nah_snd" id="nah_snd" type="text">  
<input name="redirect" type="hidden" value="<?php echo REF_ACTIVE_URL; ?>" />
</TD>
</TR>
</tbody>
</TABLE>
</form>
</div>