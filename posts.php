<?php
require("classes/cls.constants.php"); 
require("classes/cls.functions_gallery.php");
require("classes/cls.functions_misc.php");
require_once("social/TwitterAPIExchange.php");

/* +--------------------------------------------------+
/* Our Twitter keys for the oauth
/* +--------------------------------------------------+ */
// $settings = array(
//     'oauth_access_token' => "1461713198-JMR9qCeoePtzLJ1G22VWstJ8KCznL3EZmN3Oqdo",
//     'oauth_access_token_secret' => "kAOFGj2ph5vOnPONfVttet3x2nWrCDcjVakwJbYeAljOi",
//     'consumer_key' => "5HKi7tc8sdvwX5HwnyFrCYlfT",
//     'consumer_secret' => "Ii7TSScjY6GYCgzOBeRg2Ng9NayrUD6yoJDxyIGdMDvhP2lcCU"
// );
$settings = array(
    'oauth_access_token' => "3062966625-zsfKPSJUGctVy79PqbnRyHd4v3uSfyHVFAnGfLP",
    'oauth_access_token_secret' => "0oMNWyV4PRIwz5LVbbvbQwwEMN13vHKGPVrDoM8vEvrFU",
    'consumer_key' => "UyZklKPYmX7hbBsHL8rWS1oFx",
    'consumer_secret' => "3WxQ7kgjL9vrs0zQtSSkL7M9b6YjD18yh9bDJlUQRtYcGZwCVk"
);

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';








function getSalt()
{
	return substr(md5(uniqid(rand(), true)), 0, 6);
}	

/* ============================================================================== 
/*	SIGN OUT
/* ------------------------------------------------------------------------------ */
if(isset($_GET['signout']) and ($_GET['signout'] == "on")) 
{
	unset($_SESSION['sess_dhub_member']); 
	unset($_SESSION['exp_member']); 
	
	unset($_SESSION['sess_dhub_shop_order']);
	unset($_SESSION['sess_dhub_shop_cart']);
	
	unset($_SESSION['dhub_cart_order']);
	unset($_SESSION['dhub_cart_key']);
	  
	$_SESSION['redirect_login'] = NULL; 
	$_SESSION['captcha_id'] = NULL;
	
	echo "<script language='javascript'>location.href=\"index.php?qst=199&token=".md5(rand())."\"; </script>"; 
	exit;
}



/* ============================================================================== 
/*	SPAM BLOCK! 
/* ------------------------------------------------------------------------------ */
if($_SERVER['REQUEST_METHOD'] !== 'POST') { 
echo "<script language='javascript'>location.href=\"action.php?qst=401&token=".$conf_token."\"; </script>"; exit; }

if (isset($_POST['nah_snd'])){$nah_snd=$_POST['nah_snd'];} else {$nah_snd='';}
if(strlen($nah_snd)>0) {echo "<script language='javascript'>location.href=\"index.php\"; </script>"; exit; }

/* ============================================================================== */





/* ********** FORM FUNCTIONS ****************************************************
********************************************************************************/
$formLog   = new hitsLog;
$debugmail = $GLOBALS['NOTIFY_DEBUG'];

//echobr($GLOBALS['EMAIL_TEMPLATE']);

$post	 = array_map("filter_data", $_POST);
$postb 	= array_map("quote_smart", $post);

$formname    = $post['formname'];	
$formact     = (isset($post['formact']))  ? $post['formact'] : '';
$formaction  = (isset($post['formaction']))  ? $post['formaction'] : $formact ;
$redirect    = (isset($post['redirect'])) ? $post['redirect'] : 'index.php';

$published = yesNoPost(@$post['published']);
$approved  = yesNoPost(@$post['approved']);
$mailing   = yesNoPost(@$post['mailing']);

if(strripos($redirect,"?")){ $redstr="&"; } else {$redstr="?";}

$field_names = array_keys($post); 
$mySql  	= "";	
$myCols 	= array();
$myDats 	= array();

$fields_ignore = array("formname","formaction","formtab","id","redirect","submit","publishval","password_r", "nah_snd", "resource_attr", "change_image", "status_comments");


//displayArray($_FILES);
//displayArray($_SESSION);
//displayArray($post); 
//exit;



/******************************************************************
@begin :: ORGANIZATION PROFILE DETAILS
********************************************************************/	

if($formname=="frm_profile_org")
{
	if (!empty($_SESSION['sess_dhub_member'])) 
	{ 
		
		//$sqpost = "UPDATE `dhub_reg_account` set  ".implode($myCols, ', ')." where (`account_id` = ".q_si($post['account_id'])." )" ;		
		//echo $sqpost; exit;
		//$rspost = $cndb->dbQuery($sqpost);
	}
	exit;

}


/* ============================================================================== 
/*	MEMBER EVENTS CALENDAR
/* ------------------------------------------------------------------------------ */

if ($formname=="fm_calendar" ) 
{
	
	$article = $post['article']; 
	if($article == '') { $article = cleanSimplex($_POST['article']); }
	
	
	$url_title_article = generate_seo_title($post['title'], '-');
	
	$dateCreated = "CURRENT_TIMESTAMP()"; 
	
	$booking_post = yesNoPost(@$post['booking_form']);
	$approved 	  = yesNoPost(@$post['approved']);
	
	$applicType = substr($formname,-9);
	
	$arr_extras_raw = array(
		'location' => ''.@$post['ev_location'].''
		,'book_form' => ''.$booking_post.''
		,'book_amount' => ''.@$post['booking_amount'].''
	);
	
	$arr_extras = serialize($arr_extras_raw);
	//displayArray($sess_mbr); exit; 
	
	if($formaction=="_new")  
	{
	$sq_post="insert into `".$pdb_prefix."dt_content`  (`id_section`, `title`, `article`, `published`, `date_created`, `approved`, `url_title_article`, `arr_extras`, `id_owner`, `organization_id`, `article_keywords`, `id_access`) values (".$postb['id_section'].", ".quote_smart($post['title']).", ".quote_smart($article).",  '".$published."',  ".$dateCreated.",   '".$approved."',  ".quote_smart($url_title_article).", ".quote_smart($arr_extras).", ".q_si($us_id).", ".q_si($us_org_id).", ".q_si($post['article_keywords']).", ".q_si($post['id_access'])." )";		
	}
	elseif ($formaction=="_edit")
	{	
	$sq_post="update `".$pdb_prefix."dt_content`   set `id_section`=".$postb['id_section'].", `title`=".quote_smart($post['title']).", `article`=".quote_smart($article).", `published`='".$published."', `approved` = '".$approved."', `url_title_article` = ".quote_smart($url_title_article).", `arr_extras`=".quote_smart($arr_extras).", `id_owner`=".q_si($post['id_owner']).", `organization_id`=".q_si($post['organization_id']).", `article_keywords`=".q_si($post['article_keywords']).", `id_access`=".q_si($post['id_access'])." WHERE `id` = '".$id."' ";
		
		$id_content = $post['id'];
	}
	
	//echo $sq_post; exit;
	$rs_post = $cndb->dbQuery($sq_post);	
	if($formaction=="_new") { 
		$id_content = $cndb->insertId($rs_post);  
	} 
	


/* ************************************************************** 
@BEG :: update-content-dates
****************************************************************/	
	if(is_array($post['date_add']) and count($post['date_add']) > 0)
	{	
		if($formaction=="_edit") { 
			$sqdatesclean = "delete from dhub_dt_content_dates where id_content = ".q_si($id_content)."; ";
			$cndb->dbQuery($sqdatesclean);
		}
		
		$seq_cont_dates  = array();		
		$content_date 	 = $post['date_add'];
		
		foreach($content_date as $k => $datev) 
		{  
		
			if($datev <> '') 
			{ 
			  $dateStart = "".q_si(date("Y-m-d", strtotime($datev))." ".$post['time_start'][$k]).""; 
			  $dateEnd   = "".q_si(date("Y-m-d", strtotime($datev))." ".$post['time_end'][$k]).""; 
			
			  $seq_cont_dates[]  = " insert IGNORE into dhub_dt_content_dates (id_content, date, end_date) values (".q_si($id_content).", ".$dateStart.", ".$dateEnd."); ";
			} 
	
		} 
		//displayArray($seq_cont_dates); //exit;
		if(count($seq_cont_dates)>0) { $cndb->dbQueryMulti($seq_cont_dates); }
		
	}
/* ************************************************************** 
@END :: update-content-dates
****************************************************************/	
	
		
/* ************************************************************** 
@ update content-to-parent 
****************************************************************/
	
	//$content_parent 	= $post['id_parent'];
	//$ddSelect->populateContentParent($id_content, $content_parent);
	saveJsonContent();	
	
//exit;	
?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} 
	
	
	


/* ============================================================================== 
/*	RESOURCES
/* ------------------------------------------------------------------------------ */

if($formname=="fm_resources")
{
	
	$file_seo 	 = generate_seo_title($post['resource_title'], '-');	
	
	// displayArray($tag_names); exit;
	$tweetAction = 0;
	$tweetLink = '';
	$tweetCat = ''; 
	if($post['resource_key'] == ''){ $post['resource_key'] = hash("ripemd128", $file_seo); }
	if($post['status'] == 'live'){ $post['published'] = 1; $tweetAction = 1; } else { $post['published'] = 0; }
	
	/*$post['posted_by'] 		 = $us_id;
	$post['organization_id'] = $us_org_id;*/
	if(@$post['organization_id'] == 0) 
		{ $post['organization_id'] = current($post['publisher']); }
	$post['resource_slug'] 	 = $file_seo;
	
	$fields_ignore[] = 'county';
	$fields_ignore[] = 'content_type';
	$fields_ignore[] = 'publisher';
	
	$col_names = array(); $col_values = array();
		
	foreach($post as $b_key => $b_val)  {
		$field = strtolower($b_key);		
		if(!in_array($field, $fields_ignore)) {
			if($formaction=="_new") 
			{
				$col_names[] = "`$field`";	
				$col_values[] = "".q_si($b_val)."";
			} 
			elseif($formaction=="_edit") 
			{
				$col_names[] = " `$field` = ".q_si($b_val).""; 
			}
		}			
	}
		
	if($formaction=="_new")  
	{ 
		$sq_post 	= "INSERT IGNORE INTO `dhub_dt_downloads` (".implode($col_names, ', ').") values (".implode($col_values, ', ')."); "; 
		$log_detail = 'Name: '.$post['resource_title'].' [Status:'.$post['status'].']';
	} 
	elseif($formaction=="_edit") 
	{ 
		$post_id 	= $post['id'];
		$sq_post 	= "UPDATE `dhub_dt_downloads` set  ".implode($col_names, ', ')." where (`resource_id` = ".q_si($post_id)." )" ;
		$log_detail = 'Name: '.$post['resource_title'].' [Status:'.$post['status'].']';
	}
	// displayArray($post);
	// echobr($post['resource_title']); exit;		
	$rs_post = $cndb->dbQuery($sq_post);
	
	if($formaction=="_new") { 
		$post_id = $cndb->insertId($rs_post);  
	} 
	
	if($tweetAction == 1){ 
		$sq_org = "select * from `dhub_conf_organizations` WHERE `organization_id` = ".q_si($post['organization_id'])." ";
		$rs_org = current($cndb->dbQueryFetch($sq_org));
		//$tweetOrg = ($rs_org['organization_handle'] <> '') ? $rs_org['organization_handle'] : $rs_org['organization'];

		$content_type = current($post['content_type']);
		
		if($content_type > 0){
			$sq_cat = "select * from `dhub_dt_downloads_type` WHERE `res_type_id` = ".q_si($content_type)." ";
			$rs_cat = current($cndb->dbQueryFetch($sq_cat));
			$tweetCat = ' #'.generate_seo_title($rs_cat['download_type'], '', false, true) .' ';
			
		}


		$tweetTitle = substr($post['resource_title'], 0 ,70).'...';
		$tweetOrg = substr($rs_org['organization'],0, 20).'...';
		$tweetLink = SITE_DOMAIN_LIVE.'resource.php?id='.$post_id;

		$tweet = $tweetTitle." has been uploaded! \n ".$tweetCat." #Devolution - ".$tweetLink;
		// $tweet = 'New document uploaded by '. $tweetOrg. "\n ".$tweetCat.' #Devolution - '.$tweetLink;
		echobr(nl2br($tweet));

		/* INITIATE TWITTER FUNCTION HERE */

		// See above after the oauth tokens to get the flow
		$postfields = array(
		    'screen_name' => 'Nivekkav', 
		    'skip_status' => '1',
		    'status' => $tweet
		);
		/** Perform a POST request and echo the response **/
		$twitter = new TwitterAPIExchange($settings);
		echo $twitter->buildOauth($url, $requestMethod)
                ->setPostfields($postfields)
                ->performRequest(); exit;
	}

/* ************************************************************** 
@ update download-to-parent 
****************************************************************/

	/* ==========  download-to-menu  =========== */	

	$seq_parent = array();
	
	if(array_key_exists('county', $post) and is_array($post['county']) and count($post['county']) > 0)
	{	
		$county_parent 	= $post['county'];
		foreach($county_parent as $k => $county_id)	
		{  
		  if($county_id <> '') {				
			$seq_parent[]  = " insert IGNORE into `dhub_dt_downloads_parent` ( `resource_id`, `county_id` ) values "
			." (".q_si($post_id).", ".q_si($county_id).");  ";	
		  }
		} 
	}
	
	if(array_key_exists('content_type', $post) and is_array($post['content_type']) and count($post['content_type']) > 0)
	{	
		foreach($post['content_type'] as $k => $res_type_id)	
		{  
		  if($res_type_id <> '') {				
			$seq_parent[]  = " insert IGNORE into `dhub_dt_downloads_parent` ( `resource_id`, `res_type_id` ) values "
			." (".q_si($post_id).", ".q_si($res_type_id).");  ";	
		  }
		} 
	}
	
	if(array_key_exists('publisher', $post) and is_array($post['publisher']) and count($post['publisher']) > 0)
	{	
		foreach($post['publisher'] as $k => $organization_id)	
		{  
		  if($organization_id <> '') {				
			$seq_parent[]  = " insert IGNORE into `dhub_dt_downloads_parent` ( `resource_id`, `organization_id` ) values "
			." (".q_si($post_id).", ".q_si($organization_id).");  ";	
		  }
		} 
	}
	
	//displayArray($seq_parent); exit;
	
	
	if(count($seq_parent))
	{
		$sq_par_clean = " delete from `dhub_dt_downloads_parent` where `resource_id` = ".q_si($post_id)."; ";
		$cndb->dbQuery($sq_par_clean);
		
		$cndb->dbQueryMulti($seq_parent);		
		unset($seq_parent);
	}
	

/* ************************************************************** 
@ upload process
****************************************************************/
	
	if(isset($_FILES['fupload']) and strlen($_FILES['fupload']['name']) > 4) 
	{
		$file_key 	 = hash("crc32", $post_id);
		$res_upload   = $_FILES['fupload'];	
		$dfile 		  = $res_upload['name'];
		$doc_ext      = ".".strtolower(substr(strrchr($dfile,"."),1));
		
		$doc_newname  = substr($file_key.'-'.$file_seo,0,45).$doc_ext;
		$doc_temp     = $res_upload['tmp_name'];		
		$doc_target   = UPL_FILES . $doc_newname;
		
		$ures = array();
		if(move_uploaded_file($doc_temp, $doc_target)) { 
			$ures['file'] = $doc_newname; 
			$ures['mime'] = $res_upload['type'];
			$ures['size'] = $res_upload['size'];
					
		
			$sq_file = "UPDATE `dhub_dt_downloads` set  `resource_file` = ".q_si($ures['file']).", `resource_mime` = ".q_si($ures['mime']).", `resource_size` = ".q_si($ures['size'])." where (`resource_id` = ".q_si($post_id)." )" ;
			//echobr($sq_file); //exit;		
			$rs_file = $cndb->dbQuery($sq_file);
		}
		
		/* --------- @@ Activity Logger --------------- */	
		//$log_detail = 'Name: ' . @$ures['file']. '';
		//$formLog->formsUserLogs('resource', $formaction, $post_id, $log_detail );
		/* =============================================== */	
		
	}
	
	
	
	/* --------- @@ Populate Tags --------------- */	
	$tag_names 	= explode("," , $post['resource_tags']);
	$formLog->tagsPopulate($tag_names, 'resource' , $post_id );
	/* =============================================== */	
	
	
	/* =============================================== */	
	/* @@ Activity Log   */
	$formLog->formsUserLogs('resource', $formaction, $post_id, $log_detail . ' [By:'.$us_email.']' );
	/* =============================================== */
	
	saveJsonResources();
	//exit;
	
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}

	
/******************************************************************
@begin :: USER PROFILE ARTICLES
********************************************************************/	

if ($formname=="fm_profile_article_edit" or $formname=="fm_profile_article_new") 
{
	
	if(is_array($post['id_parent']))
	{	$arr_parent 	= serialize($post['id_parent']); } else 
	{	$arr_parent		= NULL;	}	
	
	
	if(isset($_POST['id'])) {$id=$_POST['id']; } else { $id=NULL; }
	
	if($post["created"] <> '') {
		$dateCreated = "'".date("Y-m-d", strtotime($_POST["created"]))." ".date("H:i:s")."'"; //
	} else { $dateCreated = "CURRENT_TIMESTAMP()"; }
	
	if ($formname=="fm_profile_article_new")
	{
	$sqpost="insert into `actp_dt_content`  (`id_section`, `title`, `article`,  `date_created`,  `yn_gallery`, `parent`, `published`, `approved`, `id_owner`) values ('".$post['id_section']."', ".quote_smart($post['title']).", ".quote_smart($post['article']).",   ".$dateCreated.",  '".$gallery."', ".quote_smart($arr_parent).",  '".$published."',  '".$approved."', ".$us_id." )";
	
	
	}
	elseif ($formname=="fm_profile_article_edit" )
	{	
	$sqpost="update `actp_dt_content`   set `id_section`=".quote_smart($post['id_section']).", `title`=".quote_smart($post['title']).", `article`=".quote_smart($post['article']).", `published`='".$published."', `yn_gallery`= '".$gallery."', `date_created` =".$dateCreated.", `parent`=".quote_smart($arr_parent).", `approved` = '".$approved."' WHERE `id` = '".$id."' ";
	}
	
	//echo $sqpost; exit;
	
	$type=new posts;
	$type->inserter_plain($sqpost);
	
	if 		( $formname=="fm_profile_article_new") 		{ $id_content = $type->qLastInsert; }
	elseif 	( $formname=="fm_profile_article_edit") 		{ $id_content = $post['id']; }
	

/* ************************************************************** 
@ update content-to-parent 
****************************************************************/
	$sq_par_clean = " delete from `actp_dt_content_parent` where `id_content` = '".$id_content."' ";
	$type->inserter_plain($sq_par_clean);
	
	if(is_array($post['id_parent']))
	{	
		$content_parent 	= $post['id_parent'];
		if(count($content_parent)>0)
		{
			for($i=0; $i <= (count($content_parent)-1); $i++) 
			{  
				$seq_update_content[]  = " insert IGNORE into `actp_dt_content_parent` ( `id_content`, `id_parent` ) values "
				." ('".$id_content."', '".$content_parent[$i]."')  ";
			} 
			
			//displayArray($seq_update_content); exit;
			$type->inserter_multi($seq_update_content);
		}
	}	
	//exit;
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
	
} 

/******************************************************************
@begin :: USER PROFILE PASSWORD
********************************************************************/	

if($formname=="fm_profile_pass")
{
	
	if (!empty($_SESSION['sess_dhub_member'])) 
	{ 
		//$pass_old 	= md5($post['currentpass']);
		//$pass_new 	= md5($post['password']);
		
		$ac_salt 		= getSalt();
		$pass_new 	    = sha1($_POST['password'] . $ac_salt);
		
		$sq_check = "SELECT * FROM `dhub_reg_account` WHERE (`account_id` = ".q_si($us_id).")";  /* and (`userpass` = ".q_si($pass_old).")*/
		$rs_check = $cndb->dbQuery($sq_check);
	
		if(mysqli_num_rows($rs_check) <> 1)
		{ ?><script>location.href="<?php echo $redirect; ?>&qst=115";</script> <?php exit; }
		
		
		$sqpost = "update `dhub_reg_account` SET `usersalt`= ".q_si($ac_salt).", `userpass`= ".q_si($pass_new)." WHERE `account_id`=".q_si($us_id)."; ";
		$cndb->dbQuery($sqpost);
	
		//$redirect .= "&qst=7#profile";
	}
	
	?><script>location.href="<?php echo $redirect; ?>&qst=7";</script> <?php exit;

}





/******************************************************************
@begin :: USER PROFILE DETAILS
********************************************************************/	


if($formname=="fm_profile_member")
{
	if (!empty($_SESSION['sess_dhub_member'])) 
	{ 
		
		if($formaction=="_edit")
		{
	
			foreach($field_names as $field)
			{
				$field = strtolower($field);

				if(!in_array($field, $fields_ignore))
				{
					$fieldNam	= $field;
					$fieldVal	= $post[''.$field.''];

					if( $field == "published") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
					if( $field == "newsletter") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
					if( $field == "pay_years") { $fieldVal = $post['pay_years'] * 12; $fieldNam = 'pay_months'; } 
					if( $field == "userpass")  { $fieldVal = md5($post[''.$field.'']);  } 


					$myCols[] = " `$fieldNam` = ".q_si($fieldVal).""; 
					/*if ($formaction == "_edit" ) { 
						//
					} elseif ($formaction == "_new" ) { $myCols[] = "`$fieldNam`";	$myDats[] = "".q_si($fieldVal)."";}*/

				}
			}

			$sqpost = "UPDATE `dhub_reg_account` set  ".implode($myCols, ', ')." where (`account_id` = ".q_si($post['account_id'])." )" ;		
			//echo $sqpost; exit;
			$rspost = $cndb->dbQuery($sqpost);
			$redirect = "profile.php?ptab=members&qst=7";
		} 
		elseif($formaction=="_new")
		{
			$post['formtype'] = 'Individual';
			$sq_check = "SELECT `email` FROM `dhub_reg_account` WHERE (`email` = ".q_si($post['email']).")";
			$rs_check = $cndb->dbQuery($sq_check);
			if($cndb->recordCount($rs_check)>=1)
			{ /*echo $msge_array[20];*/ echo '<script>alert("'.$msge_array[20].'"); history.back();</script>'; exit; }
			else 
			{
				$ac_email 	= $post['email'];
				$auth_code	= 'MBR'.strtoupper(md5(uniqid(rand() . $ac_email)));
				
				/* =============================================== */	
				/* get Account, Category | Link Account to Category */
				$account_user_arr = array("organization_id" =>"".$post['organization_id']."",
										  "namefirst"       =>"".$post['namefirst']."",
										  "namelast"   	    =>"".$post['namelast']."",
										  "userauth"    	=>"".$auth_code."",
										  );	
				$account_id  	  = $ddSelect->getAddUserAccount($ac_email, $account_user_arr);
				$account_user_cat = $ddSelect->getAddUserCat($post['formtype']);
				$ddSelect->addUserToCategory($account_user_cat, $account_id);
				/* =============================================== */
				
				
				/* =============================================== */	
				/* @@ Send User Invite  */

					$confirm_link1 = SITE_DOMAIN_LIVE.'/action.php?ac='.$auth_code;
					$confirm_link2 = '<a href="'.$confirm_link1.'" target="_blank">'.$confirm_link1.'</a>';
					$messageDetail = array("message_link"   	=>"".$confirm_link2."",
										   "message_subject"  =>"Account Invite",
										   "contact_email"    =>"".$ac_email."",
										   "message_sender"   =>"".$us_org."",
										   "message_to"   	  =>"".$ac_email."" );

					$messageContent = $mailer->messageTemplate('account_invite', $messageDetail, 0, 0);
				//exit;
				/* --- end ---	*/								
				/* =============================================== */
			}
			
			$redirect = "profile.php?ptab=members&qst=24";
		}
		
	}
	
	echo "<script language='javascript'>location.href=\"$redirect\"; </script>";
	exit;

}



if($formname=="fm_profile")
{
	if (!empty($_SESSION['sess_dhub_member'])) 
	{ 
		//$us_id = $_SESSION['sess_dhub_member']['ac_id'];
	
		foreach($field_names as $field)
		{
			$field = strtolower($field);

			if(!in_array($field, $fields_ignore))
			{
				$fieldNam	= $field;
				$fieldVal	= $post[''.$field.''];

				if( $field == "published") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
				if( $field == "newsletter") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
				if( $field == "pay_years") { $fieldVal = $post['pay_years'] * 12; $fieldNam = 'pay_months'; } 
				if( $field == "userpass")  { $fieldVal = md5($post[''.$field.'']);  } 

				
				$myCols[] = " `$fieldNam` = ".q_si($fieldVal).""; 
				/*if ($formaction == "_edit" ) { 
					//
				} elseif ($formaction == "_new" ) { $myCols[] = "`$fieldNam`";	$myDats[] = "".q_si($fieldVal)."";}*/

			}
		}
		
		
		
		$sqpost = "UPDATE `dhub_reg_account` set  ".implode($myCols, ', ')." where (`account_id` = ".q_si($us_id)." )" ;		
		//echo $sqpost; exit;
		$rspost = $cndb->dbQuery($sqpost);
	
		/*$log_session = array(
			'u_fname' 		 => ''.$post['namefirst'].'',
			'u_lname' 		 => ''.$post['namelast'].'',
			'u_phone' 		 => ''.$post['phone'].'',
			'u_country' 	 => ''.$post['country'].'',
			'expires'		 => time()+(45*60)
		);*/
		$_SESSION['sess_dhub_member']['u_fname'] = ''.$post['namefirst'].'';
		$_SESSION['sess_dhub_member']['u_lname'] = ''.$post['namelast'].'';
		$_SESSION['sess_dhub_member']['u_phone'] = ''.$post['phone'].'';
		$_SESSION['sess_dhub_member']['u_country'] = ''.$post['country'].'';
		
		$redirect = "profile.php?ptab=profile&qst=7";
	}
	
	echo "<script language='javascript'>location.href=\"$redirect\"; </script>";
	exit;

}

/* ============================================================================== 
/*	@IMPREST - SURRENDER
/* ------------------------------------------------------------------------------ */

if($formname=="fm_member_avatar")
{		
	$email_name  = explode('@', $_SESSION['sess_dhub_member']['u_email']); 
	$doc_newname = cleanFileName(crc32($us_id).'_'.$email_name[0]); 
	
	$resp = '';
	if(isset($_FILES['idoc']) and is_array($_FILES['idoc']['name'])) 
	{		
		
		
		$dfile = $_FILES['idoc']['name'][0];
		if(strlen($dfile) > 4) 
		{
			$doc_result   = fileUpload($_FILES['idoc'], 0, $doc_newname, UPL_AVATARS);
			//displayArray($doc_result); exit;
			
			if($doc_result['result'] == 1) {
				$sq_files  = "UPDATE `dhub_reg_account` SET `avatar`= ".q_si($doc_result['name'])." WHERE `account_id` = ".q_si($us_id)."; ";
				$cndb->dbQuery($sq_files);
				$_SESSION['sess_dhub_member']['u_avatar'] = ''.$doc_result['name'].'';
				$resp = 'Uploaded';
			}
		}		
	}	
	echo $resp;
	/*?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php*/
exit;	

	
}










	
/******************************************************************
@begin :: REQUEST PRICE
********************************************************************/		
if($formname=="fm_conf_register")
{	
	$reg_type = $post['reg_type'];
	//$rmessage = html_entity_decode(stripslashes($post['rmessage']));
	
	$sqpost="insert into `dhub_reg_events_booking`  "
	."(`id_content` , `regnum` , `contactname` , `contactemail` , `contactphone` , `orgname` , `contactjob`) "
	." values "
	."('0', ".$postb['reg_type'].", ".$postb['fullname'].", ".$postb['email'].", ".$postb['phone'].", ".$postb['organization'].", ".$postb['jobtitle'].")";
	//echo $sqpost; exit;
	
	$type		= new posts;
	$type->inserter_plain($sqpost);
	
	
	$subject	= ' Conference Registration: ' . $reg_type;	
	$message	='<br>Hi,<br><br> You have recieved a Conference Registration from <b>'.SITE_TITLE_SHORT.'</b>:<br>'
			.'<blockquote><b>SENDER:</b> '.$post['fullname']
			.'<BR><BR><b>EMAIL:</b> '.$post['email']
			.'<BR><BR><b>TELEPHONE:</b> '.$post['phone']
			.'<BR><BR><b>ORGANIZATION:</b> '.$post['organization']
			.'<BR><BR><b>JOB TITLE:</b> '.$post['jobtitle']
			.'<BR><BR><b>REGISTRATION TYPE:</b> '.$reg_type
			.'</blockquote>'
			.'<br>Regards, <br> <b>Website Administrator</b><br>'
			. date("F j, Y, g:i a").'<br><hr>'
			.'Message sent from: '.$_SERVER['HTTP_HOST'].'<hr />';
	
	$sendto[]	= "hello@openinstitute.com";
	//$sendto[]	= "info@kenyachamber.co.ke";
	$sendto[]	= "".SITE_MAIL_TO_BASIC."";
		
		foreach($sendto as $i => $val) {
		//echo "<hr>".$val."<br>".$sendfrom."<br>".$subject."<br>".$message; exit;
		$mailer->form_alerts($val, $subject, $message);
		}
	//exit;
	
	//echo 'Request sent.';
	$redirect = 'register/?qst=8'; //cleanRedStr($redirect)."qst=1"; 	
	echo "<script language='javascript'>location.href=\"$redirect\"; </script>";/**/
	exit;
}
	


/* ============================================================================== 
/*	ACCOUNT ACCEPT INVITE
/* ------------------------------------------------------------------------------ */
	
if($formname=="fm_invite_accept")	
{
	$err_msg = '';
	if($post['password'] <> $post['password_r']) {
		$err_msg = $msge_array[116]; //exit;
		echo '<script type="text/javascript">alert("'.$msge_array[116].'");history.back();</script>'; exit;
	}
	
	$ac_salt 		= getSalt();
	$ac_password 	= sha1($_POST['password'] . $ac_salt);	
	$ac_auth	    = $post['auth'];
	
	$sq_post = "UPDATE `dhub_reg_account` SET `userpass` = ".q_si($ac_password).", `userauth` = ".q_si($ac_auth.'__').", `usersalt` = ".q_si($ac_salt)." , `uservalid` = 1 , `published` = 1  WHERE  `email` = ".q_si($post['email'])." and `userauth` = ".q_si($ac_auth)."; ";
	//echobr($sq_post); //exit;
	$cndb->dbQuery($sq_post);
	
	echo '<script type="text/javascript">location.href="action.php?fcall=signin&qst=106";</script>';
	
}



/* ============================================================================== 
/*	ACCOUNT SIGNUP || Organization
/* ------------------------------------------------------------------------------ */
	
if($formname=="ac_signup")	// _organization
{
	$formResponse = $msge_array[22];
	
	$email = filter_var($post['ac_email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo $msge_array[100]; exit;
	}
	if($post['ac_password'] <> $post['ac_passconfirm']) {
		echo $msge_array[116]; exit;
	}
	//$post['formtype'] = 'Individual'; 
	
	$ac_formtype 	 = $post['formtype'];	
	$ac_organization  = @$post['ac_organization'];
	$ac_email 		= $post['ac_email'];
	$ac_phone 		= @$post['ac_phone']; 
	$ac_namefirst	= $post['ac_namefirst'];
	$ac_namelast	 = $post['ac_namelast'];
	
	$ac_salt 		= getSalt();
	$ac_password 	= sha1($_POST['ac_password'] . $ac_salt);	
	$auth_code	    = 'SGN'.strtoupper(md5(uniqid(rand() . $ac_email)));
	
	$seqpost		 = array();
	$type			= new posts;
	
	//$organization_id  = ($ac_formtype == 'Corporate') ? $ddSelect->getAddUserOrganization($ac_organization) : '';
	
	$sq_check = "SELECT `email` FROM `dhub_reg_account` WHERE (`email` = ".q_si($ac_email).")";
	$rs_check = $cndb->dbQuery($sq_check);
	if($cndb->recordCount($rs_check)>=1)
	{ echo $msge_array[20]; exit; }

	
	/* =============================================== */	
	/* get Account, Category | Link Account to Category */
	$account_staff   = checkIfStaff($ac_email);
	$account_user_arr = array(/*"organization_id"  =>"".$organization_id."",*/
							  "namefirst"      =>"".$ac_namefirst."",
							  "namelast"   	   =>"".$ac_namelast."",
							  "phone"    	  =>"".$ac_phone."",
							  "staff"    	  =>"".$account_staff."",							  
							  "usersalt"   	   =>"".$ac_salt."",
							  "userpass"      =>"".$ac_password."",
							  "userauth"    	  =>"".$auth_code."",
							  );	//displayArray($account_user_arr); exit;
	$account_id  	  = $ddSelect->getAddUserAccount($ac_email, $account_user_arr);
	$account_user_cat = $ddSelect->getAddUserCat($post['formtype']);
	$ddSelect->addUserToCategory($account_user_cat, $account_id);
	
	if($ac_formtype == 'Corporate'){
		$organization_id  = $ddSelect->getAddUserOrganization($ac_organization, $account_id);
		$sq_upd = "update `dhub_reg_account` set `organization_id` = ".q_si($organization_id)." WHERE `account_id` = ".q_si($account_id)."; ";
		$cndb->dbQuery($sq_upd);
	}
	
	/* =============================================== */
	//echobr($account_id); //exit;
	
	if($account_id >= 1)
	{
		
	
	/* =============================================== */	
	/* @@ Activity Log   */
	$formLog_arr = array("id_account" => "".$ac_email."", "log_desc"=>"New ".$ac_formtype."", "log_cat_name"=>"".$ac_formtype."", "log_cat_id"=>"".$account_id."");
	$formLog->formsUserLogs('account_signup','account_signup',$account_id, $ac_email);	
	/* =============================================== */	
		
		
	$redirect = "index.php?qst=22";	//signin
	echo $msge_array[22];
	
	
	/* =============================================== */	
	/* @@ Request Verification User Message   */
	
		$confirm_link1 = SITE_DOMAIN_LIVE.'?ac='.$auth_code;
	    $confirm_link2 = '<a href="'.$confirm_link1.'" target="_blank">'.$confirm_link1.'</a>';
		$messageDetail = array("message_link"   	=>"".$confirm_link2."",
							   "message_subject" =>"Account Sign Up",
							   "contact_email"   =>"".$ac_email."",
							   "message_to"   	  =>"".$ac_email."" );
		//displayArray($messageDetail); exit;
		$messageContent = $mailer->messageTemplate('account_verify', $messageDetail, 1, 0);
	
	/* --- end ---	*/								
	/* =============================================== */
	
	}
	else
	{
		echo $msge_array[117];
	}
	/*echo "<script language='javascript'>location.href=\"$redirect\"; </script>";*/
	exit;

}




/* ============================================================================== 
/*	LOGIN FORM
/* ------------------------------------------------------------------------------ */

if ($formname=="ac_login") 
{	
	$result_msg = '';
	$password = trim($_POST['log_passw']); 	
	
	$sq_salt = "SELECT `dhub_reg_account`.* , `dhub_conf_organizations`.`organization`, `dhub_reg_groups`.`group_title` FROM `dhub_reg_account` LEFT JOIN `dhub_conf_organizations` ON (`dhub_reg_account`.`organization_id` = `dhub_conf_organizations`.`organization_id`) LEFT JOIN `dhub_reg_groups` ON (`dhub_reg_account`.`group_id` = `dhub_reg_groups`.`group_id`) WHERE (`dhub_reg_account`.`email` = ".$postb['log_email']."  AND `dhub_reg_account`.`uservalid` ='1' AND `dhub_reg_account`.`published` ='1')"; //echobr($sq_salt); exit;
	$rs_salt = $cndb->dbQueryFetch($sq_salt);
	
	if(count($rs_salt)==1)
	{
		$user_acc   = current($rs_salt);
		
		$u_id 	    = $user_acc['account_id'];
		$u_email    = $user_acc['email'];
		$u_email_arr= explode('@', $u_email);
		$u_fname    = ($user_acc['namefirst'] <> '') ? $user_acc['namefirst'] : $u_email_arr[0];
		
		$u_type_id 	= $user_acc['group_id'];		
		$u_org_id 	= $user_acc['organization_id'];
		$u_type 	= $user_acc['group_title'];
		$u_org		= $user_acc['organization'];
		
		$usersalt 	= $user_acc['usersalt'];
		$userpass 	= $user_acc['userpass'];		
		$log_pass	= sha1($password . $usersalt);
		
		if($log_pass == $userpass)
		{			
			$log_session = array(
				'u_id' 			 => ''.$u_id.'',
				'u_fname' 		 => ''.$u_fname.'',
				'u_lname' 		 => ''.$user_acc['namelast'].'',
				'u_type_id' 	 => ''.$user_acc['group_id'].'',
				'u_type' 		 => ''.$user_acc['group_title'].'',
				'u_email' 		 => ''.$user_acc['email'].'',
				'u_phone' 		 => ''.$user_acc['phone'].'',
				'u_country' 	 => ''.$user_acc['country'].'',
				'u_avatar' 		 => ''.$user_acc['avatar'].'',
				'u_organization_id'  => ''.$user_acc['organization_id'].'',
				'u_organization' 	 => ''.$user_acc['organization'].'',
				'u_staff' 		 => ''.$user_acc['staff'].'',
				'expires'		 => time()+(45*60)
			);
			
			$_SESSION['sess_dhub_member'] = $log_session;		
			$_SESSION['sess_dhub_member']['signed_in']    = true;	

			$sq_datelog	= "update `dhub_reg_account`  set `date_lastlog` = '".time()."' where `account_id` = ".quote_smart($u_id)." ";
			$cndb->dbQuery($sq_datelog);

			$redirect = 'profile.php?'.time();

			$result_msg = 'log_1';
		}
		else
		{ $result_msg = $msge_array[21]; }
	}
	else
	{ $result_msg = $msge_array[21]; }
	
	echo $result_msg;
	
	exit;
}		




/* ============================================================================== 
/*	ACCOUNT CHANGE PASSWORD FORM
/* ------------------------------------------------------------------------------ */	

if ($formname=="ac_pwchange")  
{
	$passnew 	= $post['passnew'];
	$passconf 	= $post['passconf'];
	//$passcurr 	= $post['passcurr'];
	$passauth 	= $post['passauth'];
	
	if($passnew <> $passconf) { 
	?> <script language='javascript'> location.href="action.php?ac=<?=$passauth?>&qst=116"; </script>  <?php exit; }
	
	$pass_salt 	= getSalt();
	$pass_new 	= sha1($passconf . $pass_salt);	
	
	//$pass_old 	= md5($post['passcurr']);
	//$pass_new 	= md5($post['passnew']);
	
	$sq_check = "SELECT * FROM `dhub_reg_account` WHERE (`userauth`=".q_si($passauth)." )";
	$rs_check = $cndb->dbQuery($sq_check);
	
	if($cndb->recordCount($rs_check)==1)
	{ 	
		$cn_check      	= $cndb->fetchRow($rs_check);	
		$account_id   	= $cn_check['account_id'];	
		$account_name  	= clean_output($cn_check['namefirst']);
		$account_email  = clean_output($cn_check['email']);
		
		
		$sq_rst	="update `dhub_reg_account` set `usersalt`= ".q_si($pass_salt).", `userpass`= ".q_si($pass_new).", `userauth` = ".q_si($passauth."__")." where `account_id` = ".quote_smart($account_id)."; ";
		$rs_rst = $cndb->dbQuery($sq_rst);
	
	
		/* =============================================== */	
		/* @@ Activity Log   */
		$formLog->formsUserLogs('accounts','Password changed',$account_id, $account_email);	
		/* =============================================== */
	
	
		/* =============================================== */	
		/* @@ User Email Notification   */
		$messageDetail = array("message_subject" =>"Password Changed",
							   "contact_email"   =>"".$account_email."",
							   "contact_name"    =>"".$account_name."",
							   "message_to"   	 =>"".$account_email."" );		
		$messageContent = $mailer->messageTemplate('account_passchange', $messageDetail, '',0); //, $debugmail
		/* =============================================== */
	
		?><script>location.href="action.php?fcall=signin&tk=<?php echo time(); ?>&qst=27";</script> <?php exit;
		
		
	}
	else
	{ ?><script>location.href="index.php?ac=<?=$passauth?>&qst=115";</script> <?php exit; }
	
	
}	


/* ============================================================================== 
/*	ACCOUNT RESET PASSWORD REQUEST
/* ------------------------------------------------------------------------------ */	

if ($formname=="ac_pwreset")  
{
	$ac_email = filter_var($post['rf_email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($ac_email, FILTER_VALIDATE_EMAIL)) {
		echo $msge_array[100]; exit;
	}
	
	
	$auth_code	   = 'RST'.strtoupper(md5(uniqid(rand() . $ac_email)));
	
	$sq_check ="SELECT `account_id`,`email` FROM `dhub_reg_account` WHERE (`email`=".quote_smart($ac_email).")"; //echo $sq_check; exit;
	$rs_check = $cndb->dbQuery($sq_check);
	
	if($cndb->recordCount($rs_check)==1)
	{ 	
		$cn_check      = $cndb->fetchRow($rs_check);	
		$account_id    = $cn_check['account_id'];	
		$account_name  = clean_output($cn_check['email']);; //clean_output($cn_check['account_name']);
		
		echo $msge_array[26];
		
		$sq_rst	="update `dhub_reg_account` set `userauth` = '".$auth_code."' where `account_id` = ".quote_smart($account_id)."; ";
		//echo $sq_rst; exit;
		$rs_rst = $cndb->dbQuery($sq_rst);
	
		/* ========= @@ Activity Logger ================== */	
		$log_detail = 'Reset Password request: '. $ac_email . '';
		$formLog->formsUserLogs('accounts', $account_id, $log_detail, 7);
		/* =============================================== */	
	
	
		/* =============================================== */	
		/* @@ User Email Notification  */		
		//$confirm_link1 = SITE_DOMAIN_LIVE.'?ac='.$auth_code;
		$confirm_link1 = SITE_DOMAIN_LIVE.'/action.php?ac='.$auth_code;
		$confirm_link2 = '<a href="'.$confirm_link1.'" target="_blank">'.$confirm_link1.'</a>'; //echo $confirm_link2;
		$messageDetail = array("message_link"   	=>"".$confirm_link2."",
							   "message_subject" =>"Reset Password",
							   "contact_email"   =>"".$ac_email."",
							   "contact_name"    =>"".$account_name."",
							   "message_to"   	  =>"".$ac_email."" );		
		$messageContent = $mailer->messageTemplate('account_passreset', $messageDetail, 1, 0); //, $debugmail
		/* =============================================== */
	
		//exit;
	}
	else
	{
		echo $msge_array[21];
	}
	
	exit;
}	



	
/******************************************************************
@begin :: FUNCTIONS
********************************************************************/	


function passGenerator($len = 6, $upper = 0)
{
	$number = 1; $pass='';
	$salt = "abcdefghjklmnpqrstuvwxyz!@";
	$uppercase = "ABCDEFGHJKLMNPQRSTUVWXYZ";
	$numbers   = "123456789";
		if ($upper) $salt .= $uppercase;
		if ($number) $salt .= $numbers;
		
		srand((double)microtime()*1000000);
		$i = 0;
			while ($i <= $len) {
			$num = rand() % strlen($salt);
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
			}
	return $pass; //strtoupper($pass);	
}







/* ============================================================================== 
/*	MAILING SUBSCRIPTION DETAILED
/* ------------------------------------------------------------------------------ */

if($formname=="mailingdetail")
{
	//displayArray($post);//exit;
	$email = filter_var($post['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$formReject = $ref_back."qst=100#fm-subscribe";
		echo "<script language='javascript'>location.href=\"$formReject\"; </script>";
	}
	
	
	
	$authcode 	= md5(uniqid(rand())); //round(microtime(true),0) + rand(101,999);
	$accemail	= $posts[2];

	$type		= new posts;
	
	if(empty($_SESSION['email_mailing']))
	{

	/*$sq_check = "SELECT `email` FROM `dhub_reg_users` WHERE (`email` = ".$postb['email'].")";
	$rs_check = $cndb->dbQuery($sq_check);
	
		if($cndb->recordCount($rs_check)>=1)
		{ ?>
			<script>
			alert("An account already exists with the specified Email Address.")
			history.back(-1);
			</script>
			<?php exit;
		}*/
	
	/* =============================================== */
	/* get Account, Category | Link Account to Category */
	$county_staff   = checkIfStaff($email);
	$account_user_arr = array("ac_type"	    =>"mail",
							  "firstname"      =>"".$post['firstname']."",
							  "lastname"       =>"".$post['lastname']."",
							  "phone"   		  =>"".$post['phone']."",
							  "organization"   =>"".$post['ac_organization']."",
							  "country"        =>"".$post['ac_country']."",
							  "ipaddress"      =>"".$_SERVER['REMOTE_ADDR']."",
							  "newsletter"     =>"1",
							  "id_user_type"   =>"4",
							  "is_countystaff" =>"".$county_staff.""
							  );
		//displayArray($account_user_arr); exit;
	$account_user_id  = $ddSelect->getAddUserAccount($email, $account_user_arr, 1); //echo $account_user_id; exit;
	$account_user_cat = $ddSelect->getAddUserCat($post['formtype']);
	$ddSelect->addUserToCategory($account_user_cat, $account_user_id);
	/* =============================================== */
		
		
		
	/*$county_staff   = checkIfStaff($u_email);
	$sqpost = "insert into `dhub_reg_users`  "
	."(`ac_type`,`firstname`, `lastname`, `email`, `phone`, `organization`, `country`, `ipaddress`, `newsletter`, `published`, `is_countystaff`)  values "
	."('mail', ".$postb['firstname'].", ".$postb['lastname'].", ".$postb['email'].", ".$postb['phone'].", ".$postb['ac_organization'].", ".$postb['ac_country'].", '".$_SERVER['REMOTE_ADDR']."', 1, 1, '".$county_staff."')"; 	
	$type->inserter_plain($sqpost);
	$id_user = $type->qLastInsert;*/
	
	
	}
	else
	{

	$email = $_SESSION['email_mailing'];
	
	$sqpost = "update `dhub_reg_users` set `firstname` = ".$postb['firstname'].", `lastname` = ".$postb['lastname'].", `phone` = ".$postb['phone'].", `organization` = ".$postb['ac_organization'].", `country` = ".$postb['ac_country']." WHERE (`email` = '".$email."' and `ac_type` = 'mail' )";
	$type->inserter_plain($sqpost);
	
	}
	//echo $sqpost; exit;
	
	
		
	if($redirect == "") { $redirect = "action.php";}
	$redirect = "result/?qst=2"; //cleanRedStr($redirect)."qst=2";
		
		//$redirect .= $redstr."";
	
	?> <script language='javascript'> location.href="<?php echo $redirect; ?>"; </script> <?php
	exit;
}
	
	
	
/* ============================================================================== 
/*	MAILING SUBSCRIPTION
/* ------------------------------------------------------------------------------ */	

if($formname=="mailingtiny")
{
	//exit;
	$email = filter_var($post['email_nl'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$formReject = $ref_back."qst=100#fm-subscribe";
		echo "<script language='javascript'>location.href=\"$formReject\"; </script>";
	}
	
	
	$email = $post['email_nl'];
	
	
	/* =============================================== */
	/* get Account, Category | Link Account to Category */
	$post['formtype'] = 'Mailing List';
	$county_staff   	= checkIfStaff($email);
	$account_pref 		= array("pref_dataset" 	=> "".@$post['datasets'].""
							  );
	$account_user_arr 	= array("newsletter"    => "1",
							    "staff" 		=> "".$county_staff.""
							  );
	$account_user_id  = $ddSelect->getAddUserAccount($email, $account_user_arr, 1); //echo $account_user_id; exit;
	$account_user_cat = $ddSelect->getAddUserCat($post['formtype']);
	$ddSelect->addUserToCategory($account_user_cat, $account_user_id, $account_pref);
	/* =============================================== */
	
	//echobr($GLOBALS['EXISTS_MAILING_ACCOUNT']); exit;
	if($GLOBALS['EXISTS_MAILING_ACCOUNT'] == false) 
	{ 
		$redirect = "mailing.php?com=1&opt=mail";
		$_SESSION['email_mailing'] = $post['email_nl'];
	/* ==================================================
	@start - inform admin
	**************************************************** */
	
		$subject	= 'New mailing list subscription '; 
		$message	='<br><br> New Mailing list subscription was received from:<br>'
			.'<blockquote><b>EMAIL:</b> '.$email
			.'</blockquote>'
			.'<em>***<font size="2">Please do not reply to this email as we are not able to respond to messages sent to this address.</font></em><br/>'
			.'<br>Regards, <br> <b>Website Administrator</b><br>'
			. date("F j, Y, g:i a").'<br><hr>'
			.'Message sent from: '.$_SERVER['HTTP_HOST'].'<hr />';
		
		$sendto[0]	= "hello@openinstitute.com";
		$sendto[1]	= "".SITE_MAIL_TO_BASIC."";
	
		$i=0;
		for($i==0; $i<=(count($sendto)-1); $i++ )
		{	//echo "<hr>".$sendto[$i]."<br>".$sendfrom."<br>".$subject."<br>".$message; exit;
			$mailer->form_alerts($sendto[$i], $subject, $message);	
		}
	/* ****************************************************
	@end - inform admin
	====================================================== */
		$redirect = "index.php?qst=2"; 
	}
	else { $redirect = "index.php?qst=4"; }
	
	//exit;
	?> <script language='javascript'>location.href="<?php echo $redirect; ?>"; </script> 
	<?php exit;
	
}
	
	
	
/* ============================================================================== 
/*	FEEDBACK FORM
/* ------------------------------------------------------------------------------ */	

if($formname=="feedback")
{	
	//displayArray($post);
	$email = filter_var($post['email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$formReject = $ref_back."qst=100#fm-feedback";
		echo "<script language='javascript'>location.href=\"$formReject\"; </script>";
	}
	
	//`subject`,,".$postb['subject']."
	$sendfrom = $email;
	$sqpost="insert into `dhub_dt_feedback`  "
	."(`name`, `email`, `phone`,  `details`, `ipaddress`) "
	." values "
	."(".$postb['fullname'].", ".$postb['email'].", ".$postb['phone'].", ".$postb['details'].", '".$_SERVER['REMOTE_ADDR']."')";
	//echo $sqpost; exit;
	
	$type		= new posts;
	$type->inserter_plain($sqpost);
	
	
	$u_name 		 = preg_split("/ /", $post['fullname']);	
	$u_name_first   = @$u_name[0];
	$u_name_last    = @$u_name[1];
	//if(strlen($u_name[0]) > 3) {	$u_name_first  = $u_name[0]; }
	//if(strlen($u_name[1]) > 3) {	$u_name_last   = $u_name[1]; }
	
	/* get Account, Category | Link Account to Category */
	$account_staff   = 0; /*checkIfStaff($post['email']);*/
	$account_user_arr = array("namefirst"=>"".$u_name_first."",
							  "namelast"=>"".$u_name_last."",
							  "staff"=>"".$account_staff."",
							  "phone"=>"".$post['phone'].""
							  );
	//exit;
	$account_user_id  = $ddSelect->getAddUserAccount($post['email'], $account_user_arr);
	$account_user_cat = $ddSelect->getAddUserCat($post['formtype']);
	$ddSelect->addUserToCategory($account_user_cat, $account_user_id);
	/* =============================================== */
	
	
	/* =============================================== */	
	/* @@ FEEDBACK POST - Admin Notification   */
	
		$message_notify_admin = array("post_name" =>"feedback_post_notify", 
						        "contact_name"  =>"".$post['fullname']."",
								"contact_email"  =>"".$post['email']."",
								"contact_phone"  =>"".$post['phone']."",
								"message_detail"  =>"".html_entity_decode(stripslashes($post['details']))."",
								"message_subject" =>"- New Online Feedback",
							    "message_to"   	=>"".SITE_MAIL_TO_BASIC."" );
		
		$mailer->messageTemplate('feedback_post_notify', $message_notify_admin, 1);	
		
	/* --- end ---	*/								
	/* =============================================== */	
	
	
	$redirect = cleanRedStr($redirect, "qst=1"); 
	//exit;
	echo "<script language='javascript'>location.href=\"$redirect\"; </script>";
	exit;
}
	

			
?>
