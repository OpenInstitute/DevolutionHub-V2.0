<style type="text/css">
.goog-te-gadget-simple { background: none !important; border: none;}
.goog-te-gadget-icon { display: none !important;}
</style>
<div class="subcolumns clearfix showall padd15_r" >
<ul class="sf-menu sf-small sf-menu-right sf-arrows" style="height:45px;">


<?php if($GLOBALS['SOCIAL_CONNECT'] == true) { ?> 
<li>
<div id="google_translate_element" style="height:25px !important;"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,sw,de,es,fr,ja,zh-CN', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
</li>

<?php
}

$nav_head_side = $dispData->buildMenu_Main($com_active, 6, 0, 'nav_top');
//echo $nav_head_side;
?>

<?php
if(!isset($_SESSION['sess_dhub_member'])) {	
?>
<li class="">
	<a data-href="ajforms.php?d=account" id="header-login" title="Sign In / Sign Up" rel="modal:open"><i class="fa fa-user"></i>&nbsp; Accounts</a>
	<ul>
	<li><a data-href="ajforms.php?d=account" id="header-loginb" title="Sign In" rel="modal:open"><i class="fa fa-user"></i>&nbsp; Sign In </a></li>	
	<li><a data-href="ajforms.php?d=signup_organization" id="organization-login" title="Sign Up" rel="modal:open"><i class="fa fa-building-o"></i>&nbsp; Organization Sign Up </a></li>
	<li><a data-href="ajforms.php?d=account" id="account-login" title="Sign Up" rel="modal:open"><i class="fa fa-user"></i>&nbsp; Individual Sign Up </a></li>
	</ul>
</li>

	
<?php } else { ?>
	
		<li class="nav_acc nav-rightX"> <?php echo $us_acc_current; ?>
			<ul>
			<?php echo conf_usAccLinks(1); ?>
			<li class="divider"></li>
			<li><?php echo $us_acc_logout; ?> </li>
			</ul>		
		</li>
<?php
}
?>


</ul>
</div>

