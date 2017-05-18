<?php require("classes/cls.constants.php"); include("classes/cls.paths.php"); ?>
<?php include("zscript_meta.php"); ?>

<body>
<?php include("includes/wrap_head.php"); ?>


<?php
 //echo '<div class="row clearfix">'.REF_ACTIVE_URL.' => '.$my_redirect .' id: '.$com_active .' sec: '.$comMenuSection.' type:'.$comMenuType.' seo:'.$seo_name.'</div>';

//echobr($GLOBALS['SOCIAL_CONNECT']);
switch($my_redirect)
{ 
	case "index.php":
		include("includes/page_index.php");
		break;
	
	case "content.php":
	case "contact.php":	
	case "events.php":
	case "contacc.php":
	case "news.php":
	case "library.php":
	case "sitemap.php":
	case "policies.php":
	case "result.php":
	case "pillars.php":
	case "profiles.php":	
	case "404.php":
	case "calendar.php":	
	case "partners.php":
	case "gallery.php":
	case "register.php":
	case "places.php":
		include("includes/page_content.php");
		break;
	
	case "rescat.php":
		include("includes/page_resource_cats.php");
		break;	
	
	case "organizations.php":
		include("includes/page_resource_orgs.php");
		break;	
		
	case "county.php":
		include("includes/page_resource_county.php");
		break;	
		
	case "polls.php":
		include("poll_arch.php");
		break;
		
	
	/*case "contacc.php":
		include("includes/page_contacc.php");
		break;
	
	
	case "gallery.php":
		include("includes/page_gallery.php");
		break;*/
	
	case "directory.php":
		include("includes/page_directory.php");
		break;
		
	case "account.php":
	case "signin.php":
	case "signup.php":
	case "reset.php":
	case "profile.php":
		include("includes/page_profile.php");
		break;
		
}
?>



<?php include("includes/wrap_foot.php"); ?>
<?php include("zscript_vary.php"); ?>

</body>
</html>