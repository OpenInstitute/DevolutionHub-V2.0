<div style="max-width:500px;margin:auto;">
<?php

$redirect = 'profile.php?tab=profile&token='.$conf_token.'#dashboard';
if(substr($ref_back,0,5) <> 'index' and substr($ref_back,0,6) <> 'result' and substr($ref_back,0,1) <> '?') 
{ $redirect = $ref_back; /*cleanRedStr($ref_back) . 'tk='.$conf_token;*/ }

?>


<div>

<div id="sign_result" class="txtred"></div>

<form  name="fm_login"  id="fm_login" class="rwdform rwdfullb" action="posts.php" method="post"  >
<!--<div class="errorBox" id="errorLogin">Highlighted fields are required!</div>-->
<input name="formname" type="hidden" value="ac_login" />
<input name="redirect" type="hidden" value="<?php echo $redirect; ?>" />

<div>
<?php /*?><label for="log_emailb" class="required">Email Address:</label><?php */?>
<div class="input-group margin-bottom-sm">
	<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
	<input type="text" name="log_email" id="log_emailb" class="required email form-control" maxlength="50" placeholder="Email Address" value="<?php echo $ureg; ?>" autocomplete="off" />	
</div>
</div>


<span id="emailbox" style="display:none"></span>

<div>
<div class="padd5"></div>
</div>

<div id="field_log_passw">
<?php /*?><label for="log_passwb" class="required">Password:</label><?php */?>
<div class="input-group margin-bottom-sm">
  <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
  <input type="password" name="log_passw" id="log_passwb" class="required form-control" autocomplete="off" maxlength="50" placeholder="Password" >
</div>
</div>

<div>
<div class="padd5"></div>
</div>


<div class="row">
	<div class="col-md-3 nopadd">
	<button type="input" name="submit" value="login" class="btn btn-primary btn-icon col-md-12"> Log In</button> </div>
	<div class="col-md-8 txtrightX padd0_r"> <label><a data-href="ajforms.php?d=pass_reset" id="pass_reset" rel="modal:open" class="txtorange bold">Forgot your password?</a></label></div>
</div>


</form>



</div>
</div>


<script language="javascript">

jQuery(document).ready(function($)
{
	$("#fm_login").validate({
		errorContainer: "#errorLogin" , 
		errorPlacement: function(error, element) { },
		submitHandler: function(form) {
			$.ajax({
				url: form.action,
				type: form.method,
				data: $(form).serialize(),
				beforeSend: function() {
					$('#fm_login').hide();
					$('#sign_result').html('<img src="image/icons/a-loader.gif" alt="loading..."  />');
				},
				success: function(response) {
					var str2 = "log_1";
					if(response.indexOf(str2) != -1) 
					{ location.href='profile.php?tk='+Math.random(); } else 
					{ $('#fm_login').show(); $('#sign_result').html(response); } 				
					
				}            
			});
		}
	}); 
});
</script>