<?php require_once("classes/cls.constants.php"); 

$ajRequest = array_map("clean_request", $_REQUEST);

if (!empty($_GET['filter'])) { $filter = trim($_GET['filter']); } else { $filter = ''; }
//if (!empty($_GET['item'])) { $_vp = trim($_GET['_vp']); } else { $_vp = ''; }

if (!empty($_GET['parent'])) { $parent = trim($_GET['parent']); } else { $parent = ''; }
if (!empty($_GET['page'])) { $page = trim($_GET['page']); } else { $page = 0; }
if (!empty($_GET['img'])) { $img = trim($_GET['img']); } else { $img = ''; }
if (!empty($_GET['cs'])) { $cs = trim($_GET['cs']); } else { $cs = 'event'; }

if (!empty($_GET['eqp'])) { $eqp = trim($_GET['eqp']); } else { $eqp = ''; }
if (!empty($_GET['eqp_name'])) { $eqp_name = trim($_GET['eqp_name']); } else { $eqp_name = ''; }

if (!empty($_GET['spl'])) { $spl = trim($_GET['spl']); } else { $spl = ''; }
if (!empty($_GET['spl_name'])) { $spl_name = trim($_GET['spl_name']); } else { $spl_name = ''; }


$form_redirect = (@$_SESSION['sess_dhub_active_url'] <> '') ? $_SESSION['sess_dhub_active_url'] : 'result/'; 

function modHeader($title){
	return '<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">'.$title.'</h4><a href="#close-modal" rel="modal:close" class="close-modal ">Close</a></div><div class="modal-body">';
}

function modFooter(){
	return '</div></div></div>';
}

if($op == 'edit') { $pg_op = 'Details'; } else { $pg_op = 'Add New'; }
$navTabLinks  = '';
//displayArray($_GET);
switch($dir)
{ 
	
	case "account":
		echo modHeader('Sign up / Sign In');
		include("includes/form.account.one.php");
		echo modFooter();
	break;

	case "signup_organization":		
		echo modHeader('Sign up as Organization');
		include("includes/form.account.register.org.php");
		echo modFooter();
	break;
	
	case "pass_reset":		
		echo modHeader('Forgot Password');
		include("includes/form.account.reset.php");
		echo modFooter();
	break;
		
	case "member_password":		
		echo modHeader('Change Password');
		include("includes/members/mem_profile_password.php");
		echo modFooter();
	break;
	
	case "member_avatar":		
		echo modHeader('Your Profile Avatar');
		include("includes/members/mem_profile_avatar.php");
		echo modFooter();
	break;
		
		
	case "cont_event":	
		//echo modHeader('&nbsp');
		//echo '<div class="modal-dialog"><div class="modal-content"><div class="modal-body">';
		$dispData->buildContent_Arr();	
		include("includes/inc.calendar.detail.modal.php");
		//echo '</div></div></div>';
		//echo modFooter();
	break;
		
		
		
		
	case "vprofile":			
		$dispData->buildContent_Arr();	
		include("includes/inc.cont.profile.detail.php");
	break;
	
	case "ipop":	
		echo '<div class="modal"><img src="'.$img.'" /></div>';
	break;
	
	default:
		echo '<div class="modal-dialog"> <div class="modal-content"><div class="modal-header"> <h4 class="modal-title">'.SITE_TITLE_LONG.'</h4> </div> <div class="modal-body ">';
		echo '<h4>Invalid Request.</h4>';
		echo '</div> </div> </div>';
	break;

}

//include("includes/wrap_form_tabs.php");
?>
		


