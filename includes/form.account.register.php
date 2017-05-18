
<?php

$rec_country = '';
$check_p = ''; $check_b = ' checked ';
$reg_op = @$_REQUEST['reg'];
if($reg_op == 'partner') { $check_p = ' checked '; $check_b = '';}
?>


<div>
<form  name="fm_register"  id="fm_register" class="rwdform rwdfullb" action="posts.php" method="post" >

<!--<div class="errorBox" id="errorReg">All fields are required!</div>-->


<div>
<?php /*?><label class="required" for="ac_name_first">Your Names</label><?php */?>
<div class="input-group">
<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
<INPUT TYPE="text"  id="ac_namefirst" NAME="ac_namefirst"  class="required form-control width-half" maxlength="50" placeholder="First Name"  />
<INPUT TYPE="text"  id="ac_namelast" NAME="ac_namelast"  class="required form-control width-half float-right" maxlength="100" placeholder="Last Name"  /> 
</div>
</div>

<div><div class="padd5"></div></div>

<div class="">
<?php /*?><label for="ac_email" class="required">Email Address:</label><?php */?>
<div class="input-group margin-bottom-smX">
	<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
	<input type="text" name="ac_email" id="ac_email" class="required email form-control" maxlength="50" placeholder="Email" value="" autocomplete="off" />	
</div>
</div>

<div><div class="padd5"></div></div>


<div>
<?php /*?><label for="ac_password" class="required">Password:</label><?php */?>
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
  <input type="password" name="ac_password" id="ac_password" class="required form-control width-half" minlength="8" maxlength="50" placeholder="New Password" >
  <input type="password" name="ac_passconfirm" id="ac_passconfirm" class="required form-control width-half float-right" minlength="8" maxlength="50" placeholder="Retype password" >
</div>
</div>

<div><div class="padd5"></div></div>

<div>
<div class="radio_group">
<input type="checkbox" class="radio required" name="ac_agreeterms" id="ac_agreeterms" /> <label for="ac_agreeterms" class="label-checkboxX required">I agree to the <a href="terms/" class="txtorange bold" target="_blank">Terms of Use</a> </label>
</div>
</div>

<?php /*?>
<div><div><?php include("includes/form.captchajx.php"); ?></div></div>
<?php */?>


<div class="row">
	<div class="col-md-3 nopadd">
		<button type="input" name="signupSubmit" value="Sign Up" class="btn btn-primary btn-icon col-md-12"> Sign Up</button> 
	</div>
	<div class="col-md-9"> 
		<label><a data-href="ajforms.php?d=signup_organization" id="signup_organization" title="Sign Up" rel="modal:open" class="txtorange bold">Sign up as Organization</a></label>
	</div>
</div>

<input  NAME="formname" type="hidden" value="ac_signup" />
<input  NAME="formtype" type="hidden" value="Individual" />
<input  NAME="nah_snd" id="nah_snd" type="text">  
<input name="redirect" type="hidden" value="result.php<?php echo $ref_qrystr; ?>" />
</form>

<div id="reg_result"></div>


</div>


<script language="javascript">

jQuery(document).ready(function($)
{
	$("#fm_register").validate({
		errorContainer: "#errorReg" , 
		errorPlacement: function(error, element) { },
		rules: { ac_passconfirm: { required: true, equalTo: "#ac_password" }}, 
	    messages: { ac_agreeterms: "You must agree to the Terms of Service." }
		,submitHandler: function(form) {
			$.ajax({
				url: form.action,
				type: form.method,
				data: $(form).serialize(),
				beforeSend: function() {
					$('#fm_register').hide();
					$('#col_signin').hide();
					$('#reg_result').html('<img src="image/icons/a-loader.gif" alt="loading..."  />');
				},
				success: function(response) {
					$('#reg_result').html(response);
					/*location.href='home/?tk='+Math.random();*/
				}            
			});
		}
	}); 
	
	
	
});
</script>
