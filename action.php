<?php require("classes/cls.constants.php"); include("classes/cls.paths.php"); ?>
<?php include("zscript_meta.php"); 

if(!isset($_SESSION['sess_dhub_member']))
{	
	if($this_page == 'profile.php') { header("Location: index.php?qst=199"); }
}
?>

<body>
<?php include("includes/wrap_head.php"); ?>



<div>
	
		<div class="head_width">
		<div class="padd15_0">
		<div class="subcolumns clearfix" style="overflow:visible;">
			
			<div class="col-md-12">
				<div class="padd15" style="min-height:400px;">
				<div id="wrapper" class="">
				
				<?php
				$ac 	= @$request['ac'];	
				$fcall 	= @$request['fcall'];
					
				if(isset($_REQUEST['ac']))
				{
					if($reg_mod == 'mbr'){
						echo display_PageTitle('Accept Account Invite');
						include("includes/form.account.createpass.php");	
					}
					
					if($reg_mod == 'rst'){
						//echo display_PageTitle('Reset Account Password');
						include("includes/form.account.resetpass.php");	
					}
				}
					
				if(isset($_REQUEST['fcall']))
				{
					$fcall = $request['fcall'];
					
					if($fcall == 'signin'){	
						echo display_PageTitle('Sign In');
						include("includes/form.account.login.php");
					}
				}
				
				if($ac == '' and $fcall == ''){
					echo display_PageTitle('Warning! Invalid request.');
					?>
					<div class="subcolumns clearfix">

						<!-- home cont -->

						<div class="col-md-6">
							<div class="padd15_t padd15_r">
								<?php include("includes/nav_downloads-latest.php"); ?>
							</div>
						</div>

						<div class="col-md-6">
							<div class="padd15_t padd15_r">
								<?php include("includes/nav_downloads-popular.php"); ?>
							</div>
						</div>

						<!-- end:: home cont -->

					</div>
					<?php
				}	
				
				?>
				
				</div>
				</div>
			</div>

		

		</div>
		</div>
		</div>
	
	
</div>



<?php include("includes/wrap_foot.php"); ?>
<?php include("zscript_vary.php"); ?>




</body>
</html>