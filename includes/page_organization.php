<?php


$sqdata = "SELECT * FROM `dhub_conf_organizations` WHERE (`organization_seo` = ".q_si($com_org_seo)."); ";
$rsdata = $cndb->dbQueryFetch($sqdata);
if(count($rsdata))
{
	$fData  = current($rsdata); /*displayArray($fData);*/
	$formaction = "_edit";
	$showForm = true;
	
	$logoname = ($fData['logo'] <> '') ? $fData['logo'] : 'no-image-found.jpg'; /*no_image.png*/
	$logopath = DISP_LOGOS.$logoname;
	$logosrc  = substr($logoname, 0 , 3);	
	
	/** EXTERNAL IMAGE **/
	if($logosrc == 'htt' or $logosrc == 'www' or $logosrc == 'ftp' or $logosrc == 'ww2') 
	{ $logopath = $logoname;  }
	
	$org_website = clean_http($fData['organization_website']);
}



?>
<style type="text/css">
	.vid{
		width: 100%;
	}
</style>

<div class="subcolumns clearfix" style="overflow:visible;">
			
	<div class="c33l">
		<div class="padd15_r">
		
			<div class="form-group">
				<div class="avatar-wrap txtcenterX noborder">
					<img src="<?php echo $logopath; ?>" class="" style="max-height:60px;" />
				</div>
			</div>
			<!--<div class="form-group">
				<h2 class="txtcenterX"><?php echo $fData['organization']; ?></h2>
			</div>-->
			
			<h4>Profile</h4>
			<div class="form-group">								
				<div class="trunc1200"> <?php echo $fData['organization_profile']; ?></div>	

			</div>
			
			<h4>Contacts</h4>
			<div class="form-group">
				<div class=""><a href="<?php echo 'mailto:'.$fData['organization_email']; ?>" title="Email" class="" target="_blank"><i class="fa fa-envelope"></i> <?php echo $fData['organization_email']; ?></a></div>
			</div>
			<div class="form-group">
				<div class=""><a href="<?php echo $org_website; ?>" title="Website" class="" target="_blank"><i class="fa fa-globe"></i> <?php echo $fData['organization_website']; ?></a></div>
			</div>
			<div class="form-group">
				<div class=""><a title="Phone" class="" target="_blank"><i class="fa fa-phone"></i> <?php echo $fData['organization_phone']; ?></a></div>
			</div>
			
			<h4>Partners</h4>
			<div class="form-group">
				<ul class="nav_side">
					<li><a href="#">...</a></li>
					<li><a href="#">...</a></li>
				</ul>
			</div>
			
			
			
		</div>
	</div>


	<div class="c66r">
		<div class="padd15_l border_bottom_gray" style="min-height:60px; padding-top:25px;">
			<h1 class="txt30 "><?php echo $fData['organization']; ?></h1>

			<?php if(!empty($fData['url'])){ ?>
			<div class="vid">
				<video style="width:100%;" controls>
				  <source src="<?php echo $fData['url']; ?>" type="video/mp4">
				  Your browser does not support HTML5 video.
				</video>
			</div>
			<?php } ?>
		</div>
		<div class="padd15_l padd15_t" style="min-height:300px;">
		<div id="wrapper" class="">
			
			<?php include("includes/page_organization_tabs.php"); ?>

		</div>
		</div>
	</div>

</div>




<div class="subcolumns clearfix" style="overflow:visible;">
	&nbsp;
</div>