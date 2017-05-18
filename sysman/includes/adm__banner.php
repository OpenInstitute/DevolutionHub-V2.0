<style type="text/css">
	.img100{
		width:250px;
		float:left;
		overflow:hidden;
		height:60px;
		display:inline-block;
		text-align:center;
		margin:auto;
	}
	.img100 img{
		width:90%;
		height:auto;
		margin:auto;
	}
</style>
<?php
if($dir == "") {$dir = "Admin Panel Home";}
$siteLogo = SITE_LOGO;
?>
<div style="background:#000<?php //echo $cms_bg_color?>; clear:both; text-align:left; padding:5px 30px 0; height:65px;">
	<div style="float:right; width:250px; display:inline-block; text-align:right; line-height:40px;"><span style="font-size:11px; color: #FFF"> <?php echo $sys_us_admin['adminname']; ?>  | <a href="adm_posts.php?signout=on" style="color:#fff">Log Off</a></span>
	</div>
	
	<div style="width:auto; margin-right:260px;">
		<div class="img100">
			<a href="home.php" style="display:inline-block; width:auto;"><img src="<?php echo $siteLogo; ?>" align="left" height="80" title="<?php echo SITE_TITLE_LONG; ?>"/></a>
		</div>
		<?php /*?><strong style="font-size:19px;"><?php echo SITE_TITLE_LONG; ?></strong><?php */?>
		<div style="width:auto; margin-left:160px; height:40px;font-size:19px; line-height:40px;color:#F5F5F5">
			&nbsp; ADMIN &raquo; <b style="color:#FFC"><?php echo clean_title(strtoupper($dir))." &raquo; "; ?></b>
		</div>
	
	</div>
	
</div>

<?php /*?><div style="clear:both; width:95%; margin:0 auto;">
	
<div style="width:200px; float:left; padding:5px; overflow:hidden; height:50px;">
	<a href="home.php"><img src="<?php echo $siteLogo; ?>" align="left" height="40"  title="<?php echo SITE_TITLE_LONG; ?>"/></a>
</div>

<div style="width:500px; float:left; padding:8px 0 0 5px; border:0px solid">
	<h1 style="padding:0 0 0 5px;color:#993300;"><?php echo clean_title(strtoupper($dir))." &raquo; "; ?></h1>
</div>

<div style="width:200px; float:right; padding: 10px 10px 2px 10px; font-size:15px; text-align:right; color:#1b4b8d" id="acc_wrap">
	<!--<div><strong>Website Administration Area</strong></div>-->
</div> 

	</div><?php */?>
