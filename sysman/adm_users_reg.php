<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php
$ths_page="?d=$dir&op=$op";
	
	if($op=="edit"){ $title_new	= "Edit "; }  elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

	if($id)
	{
	
	
		$sqdata = "SELECT `id`, `firstname`, `lastname`, `email`, `phone`, `organization`, `country`, `city`, `address`, `newsletter`, `id_user_type`, `confirm`, `published` FROM    `dhub_reg_users` WHERE (`id` = ".quote_smart($id)."); ";	
		$rsdata = $cndb->dbQuery($sqdata);
		$rsdata_count =  $cndb->recordCount($rsdata);
			
			if($rsdata_count==1)
			{
				$cndata =  $cndb->fetchRow($rsdata);
				
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
				$confirm			= $cndata[11]; 
				$published			= $cndata[12]; 
				
				$id_user_type = $cndata[10]; 
				
				
				if($newsletter==1) {$newsletter="checked ";} else {$newsletter="";}
				if($confirm==1) {$confirm="checked ";} else {$confirm="";}
				if($published==1) {$published="checked ";} else {$published="";}
				
				
			}
		$pgtitle				="<h2>Member Account Details</h2>";
		$formname			= "account_edit";
		$readonly = ' readonly="readonly" ';
	}
}
elseif($op =="new")
	{
	
		$pgtitle				="<h2>New Member Account </h2>";
		
		$id					= '';
		$readonly	= '';
		
		$id_user_type	= 3;
		$published			= "checked ";
		$formname			= "account_new";
	}
 ?>

	<br />
	
	

<form  name="fm_profile"  id="fm_profile" class="admform" action="adm_posts.php" method="post" >
<!--<div class="errorBox">Highlighted fields are required!</div>-->
 <table  border="1" cellspacing="1" cellpadding="3" align="center" width="60%">
<tbody>
<tr> <td colspan="2" style="padding:10px;"><?php echo $pgtitle; ?></td> </tr>

<TR>
	<TD style="width:250px"><label for="qf_firstname" class="required">First Name:</label></TD>	
	<TD><INPUT TYPE="text"  id="qf_firstname" NAME="qf_firstname"  class="required" maxlength="50" value="<?php echo $firstname; ?>" ></TD>
</TR>
<TR>
	<TD><label for="qf_lastname" class="required">Last Name:</label></TD>	
	<TD><INPUT TYPE="text"  id="qf_lastname" NAME="qf_lastname"  class="required" maxlength="50" value="<?php echo $lastname; ?>" ></TD>
</TR>

<TR>
	<TD><label for="qf_email" class="required"> Email Address:</label></TD>
	<TD><INPUT TYPE="text"  id="qf_email" NAME="qf_email"  class="required email" maxlength="40" <?php echo $readonly; ?> value="<?php echo $email; ?>" ></TD>
</TR>
<TR>
	<TD><label>Account Type:</label></TD>
	<TD>
	<select name="id_user_type" id="id_user_type" style="margin-bottom:5px;">
	<?php echo $ddSelect->dropper_select("dhub_reg_users_type", "id", "title", $id_user_type) ?>
	</select>
	</TD>
</TR>
<TR>
	<TD>&nbsp;</TD>
	<TD>&nbsp;</TD>
</TR>
<TR>
	<TD><label for="qf_phone">Phone Number(s):</label></TD>
	<TD><input type="text" name="qf_phone" id="qf_phone" maxlength="150" value="<?php echo $phone; ?>" /></TD>
</TR>
<TR>
	<TD><label for="qf_organization">Organization:</label></TD>
	<TD><input type="text" name="qf_organization" id="qf_organization"  maxlength="50" value="<?php echo $organization; ?>" /></TD>
</TR>

<TR>
	<TD><label for="qf_country">Country of Residence:</label></TD>
	<TD>
		<select name="qf_country" id="qf_country" style="margin-bottom:5px;">
			<?php echo $ddSelect->dropper_select("dhub_reg_countries", "id", "country", $country) ?>
			</select></TD>
</TR>
<TR>
	<TD><label for="qf_city">City:</label></TD>
	<TD><input type="text" name="qf_city" id="qf_city"  maxlength="50" value="<?php echo $city; ?>" /></TD>
</TR>
<TR>
	<TD><label for="qf_address">Address:</label></TD>
	<TD><input type="text" name="qf_address" id="qf_address"  maxlength="250" value="<?php echo $address; ?>" /></TD>
</TR>

<TR>
	<TD>&nbsp;</TD>
	<TD>&nbsp;</TD>
</TR>

<TR>
	<TD><label>Subscribed to Mailing List</label></TD>
	<TD><label class="labelleft"><input type="checkbox" name="newsletter" <?php echo $newsletter; ?> class="radio"/>	<strong></strong></label></TD>
</TR>

<TR>
	<TD><label> Account Confirmed:</label></TD>
	<TD><label class="labelleft"><input type="checkbox" name="confirm" <?php echo $confirm; ?> class="radio"/>	<strong></strong></label></TD>
</TR>

<TR>
	<TD><label> Account Activated:</label></TD>
	<TD><label class="labelleft"><input type="checkbox" name="published" <?php echo $published; ?> class="radio"/>	<strong></strong></label></TD>
</TR>

<TR>
	<TD style="width:250px"> </TD>	
	<TD>&nbsp; </TD>
</TR>
<?php if($op=="new") { ?>
<TR>
	<TD style="width:250px"><label for="qf_password" class="required">New Password:</label></TD>	
	<TD><INPUT TYPE="password"  id="qf_password" NAME="qf_password"  maxlength="12" minlength="6" class="required " value="" ></TD>
</TR>
<TR>
<TD><label for="qf_password_conf" class="required">Confirm New Password:</label></TD>

<TD><INPUT TYPE="password"  id="qf_passconfirm" NAME="qf_passconfirm"  maxlength="12" minlength="6" class="required" value="" ></TD>
</TR>
<?php } ?>

<TR>
<TD>&nbsp;</TD>
<TD align="left">
<input  NAME="submit" type="submit" value="Save Profile"/>
<input  NAME="formname" type="hidden" value="<?php echo $formname; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input name="redirect" type="hidden" value="<?php echo "home.php?d=".$dir; ?>" />
</TD>
</TR>

</tbody>
</TABLE>
</form>


	<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>
</div>
	
	

<div>
<!-- @end :: content area -->
	
</div>
</div>
		
		
</body>
</html>
