<?php
/* Social Logins*/
if($GLOBALS['SOCIAL_CONNECT']  == true) { 
	require_once 'social/Facebook/autoload.php';
	$fb = new Facebook\Facebook([
	  'app_id' => '197494917384538',
	  'app_secret' => 'c8c1e62bb1ab5711dcc08f69e0f505db',
	  'default_graph_version' => 'v2.8',
	]);
	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email', 'user_likes','public_profile']; // optional
	$loginUrl = $helper->getLoginUrl('http://sand-box.es/devhub/social/login-callback.php', $permissions);
	require_once 'social/twitoauth.php';

	// Google+ Login
	require_once 'social/gplus/index.php';
}
/* END - Social Logins*/
?>

<style type="text/css">
	.ssm{width:80%;
		 height:55px;}
	.ssm img{
		width:100%;
	}
	.modal-content {
    min-height: 450px !important;
	}
	.pad{
		padding:5px;
	}
</style>


<!--<div class="modal-dialog modal-lg"> <div class="modal-content"> 
		<div class="modal-header"> 
			<h4 class="modal-title txtcenter">Log-in or Sign up</h4>
		</div>-->
		
<div class="modal-body Xmodal-long nano nopadd">
<div class="XXnano-content">

<div class="subcolumns clearfix">

	<div class="c50l" id="col_register">
		<div class="padd20 padd0_t  padd0_l">	
		<div class="subcolumns">
		<h3>Sign up as Individual</h3>
		<?php include("includes/form.account.register.php"); ?>
		</div>
		</div>
	</div>
	
	
	<div class="c50r " id="col_signin">
		<div class="padd20 padd0_t padd0_r">	
		<div class="subcolumns clearfix ">
		<h3>Sign in using Email</h3>
		<?php include("includes/form.account.login.php"); ?>
		</div>
		</div>
		
	</div>
</div>
<div class="subcolumns clearfix">
	<!-- Sign in with social media -->
			<div class="col-md-12 padd5">
			  <div>
				<h3>&nbsp; Or Sign in using social media</h3>
				<div class="col-md-4 col-sm-4">
					<a class="btn btn-primary btn-icon" style="background-color:#3B5998; width:100%; border-radius:50px;" href="<?php echo @$loginUrl; ?>">
						<i class="fa fa-facebook txt15"></i> &nbsp; <b>Login</b> with <b>Facebook</b>
					</a>
				</div>
				<div class="col-md-4 col-sm-4">
					<a class="btn btn-info btn-icon padd10" style="background-color:#62B2EF;border-color:#62B2EF; width:100%; border-radius:50px;" href="<?php echo @$url; ?>">
						<i class="fa fa-twitter txt15"></i> &nbsp; <b>Login</b> with <b>Twitter</b>
					</a>
				</div>
				<div class="col-md-4 col-sm-4">
					<a class="btn btn-info btn-icon padd10" style="background-color:#DD2C00; width:100%; border-radius:50px;" href="<?php echo @$authUrl; ?>">
						<i class="fa fa-google-plus txt15"></i> &nbsp; <b>Login</b> with <b>Google+</b>
					</a>
				</div>
			</div>
			</div>
<!-- //Sign in with social media -->
</div>
<!-- </div> -->




</div></div> 

<!--</div> </div>-->