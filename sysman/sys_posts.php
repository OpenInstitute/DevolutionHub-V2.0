<?php
require("../classes/cls.constants.php"); 
//require("classes/cls.functions_gallery.php");
require("../classes/cls.functions_misc.php");
require("includes/adm_functions.php");

/* ============================================================================== 
/*	SIGN OUT
/* ------------------------------------------------------------------------------ */
if(isset($_GET['signout']) and ($_GET['signout'] == "on")) 
{
	unset($_SESSION['sess_pom_member']); 
	unset($_SESSION['sess_pom_pet']); 
	
	$_SESSION['redirect_login'] = NULL; 
	$_SESSION['captcha_id'] = NULL;
	
	echo "<script language='javascript'>location.href=\"index.php?qst=199&token=".md5(rand())."\"; </script>"; 
	exit;
}

/* ============================================================================== 
/*	SPAM BLOCK! 
/* ------------------------------------------------------------------------------ */
if($_SERVER['REQUEST_METHOD'] !== 'POST') { 
echo "<script language='javascript'>location.href=\"index.php?qst=401&token=".$conf_token."\"; </script>"; exit; }

if (isset($_POST['nah_snd'])){$nah_snd=$_POST['nah_snd'];} else {$nah_snd='';}
if(strlen($nah_snd)>0) {echo "<script language='javascript'>location.href=\"index.php\"; </script>"; exit; }

/* ============================================================================== */




/* ============================================================================== 
/*	FORM FUNCTIONS
/* ------------------------------------------------------------------------------ */

$debugmail = $GLOBALS['NOTIFY_DEBUG'];
//echobr($GLOBALS['EMAIL_TEMPLATE']);

$post	 = array_map("filter_data", $_POST);
$postb 	= array_map("q_si", $post);

$formname    = (isset($post['formname']))  ? $post['formname'] : '';
$formaction  = (isset($post['formaction']))  ? $post['formaction'] : '';
$redirect    = (isset($post['redirect'])) ? $post['redirect'] : 'home.php';
$formtab     = (isset($post['formtab']))  ? $post['formtab'] : '';
$post_by     = (isset($post['post_by'])) ? $post['post_by'] : @$sys_us_admin['admin_id'];

$log_desc	= ($formaction <> '') ? clean_title($formaction): 'User action: ';
$log_notify  = 1;

$published = yesNoPost(@$post['published']);
$admissible  = yesNoPost(@$post['admissible']);
$approved  = yesNoPost(@$post['approved']);
$mailing   = yesNoPost(@$post['mailing']);

if(strripos($redirect,"?")){ $redstr="&"; } else {$redstr="?";}


//echobr($sess_mbr['m_name']);

/*$post		= array_map("filter_data",$_POST);
$postb		= array_map("q_si", $post);*/
$field_names = array_keys($post);

//displayArray($sys_us_admin);	
//displayArray($post); 
//displayArray($_FILES); 
//exit;

$type 	= new posts;
$formLog = new hitsLog;
$sq_files   = array();

$fields_ignore = array("formname","formaction","formtab","id","redirect","saveform","publishval","post_by","date_post","submit","resource_attr", "change_image", "petitioner_id", "representative_id", "pr_code", "status_old");
	
$adminuser = $sys_us_admin['adminuser'];


/* ============================================================================== 
/*	RESOURCES
/* ------------------------------------------------------------------------------ */

if($formname=="fm_resources")
{
	
	$file_seo 	 = generate_seo_title($post['resource_title'], '-');	
	
	// displayArray($tag_names); exit;
	
	if($post['resource_key'] == ''){ $post['resource_key'] = hash("ripemd128", $file_seo); }
	if($post['status'] == 'live' and $post['status_old'] <> $post['status']){ $post['admin_approve'] = $sys_us_admin['admin_id']; }
	if($post['status'] == 'live'){ $post['published'] = 1; } else { $post['published'] = 0; }
	
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
		$sq_post = "INSERT IGNORE INTO `dhub_dt_downloads` (".implode($col_names, ', ').") values (".implode($col_values, ', ')."); "; 
		$log_detail = 'Name: '.$post['resource_title'].' [Status: '.$post['status'].']';
	} 
	elseif($formaction=="_edit") 
	{ 
		$post_id = $post['id'];
		$sq_post = "UPDATE `dhub_dt_downloads` set  ".implode($col_names, ', ')." where (`resource_id` = ".q_si($post_id)." )" ;
		$log_detail = 'Name: '.$post['resource_title'].' [Status: '.$post['status'].']';
	}
	
	//echobr($sq_post); exit;		
	$rs_post = $cndb->dbQuery($sq_post);
	
	if($formaction=="_new") { 
		$post_id = $cndb->insertId($rs_post);  
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
	$formLog->formsUserLogs('resource', $formaction, $post_id, $log_detail . ' [By: '.$adminuser.']' );
	/* =============================================== */
	
	saveJsonResources();
	
	//exit;
	$redirect 	= 'home.php?d=resources&tk='.time();
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}




/* ============================================================================== 
/*	PETITION MILESTONE: RECOMMENDATION
/* ------------------------------------------------------------------------------ */

if($formname=="frm_pet_recommend")
{
	$status_id = $post['status_id'];
	
	$sqpost[] = "update `pom_petition_details` SET `status_id`= ".q_si($post['status_id'])." WHERE `petition_id`=".q_si($pet_id)."; ";
	
	if($status_id == 10 or $status_id ==11)
	{	
	$sqpost[] = "insert into `pom_hearings`  (`hearing_date` , `hearing_time` , `prison_id` , `petition_id` , `comments`, `post_by`) values (".q_si($post['hearing_date']).", ".q_si($post['hearing_time']).",1,".q_si($pet_id).",".q_si($post['comments']).", ".q_si($post_by)." ); ";		
		
	}
	
	
	
	$sqpost[] = "insert into `pom_petition_comments` (`petition_id` , `post_by` , `comment`) values 
		(".q_si($post['pet_id']).", ".q_si($post_by).",".q_si('<b><em>[Recommendation]</em></b> '.$post['comments'])."); ";	
	
	//displayArray($sqpost); exit;	
	$cndb->dbQueryMulti($sqpost);
	
	if($status_id == 12) {
		/* CLOSE DELIBERATION MILESTONE*/	
		$dispDt->sys_statusMilestone($post['pet_id'], 7);
	}
	/* UPDATE MILESTONE*/	
	$dispDt->sys_statusMilestone($post['pet_id'], $post['mst'], $status_id);
	
	
	/* ========= @@ Activity Logger ================== */	
	$status_txt = $dispDt->get_statusList($status_id);
	$log_detail = 'Recommended status - ' . $status_txt. ': '. $post['comments'] . '';
	$formLog->formsUserLogs('milestone_update', $pet_id, $log_detail, $status_id );
	/* =============================================== */	
		
	
	/* ========= @@ Status Notification + LOG ================== */
	if($pet_dat_contact <> '') { 
		//$status_txt = $dispDt->get_statusList($status_id);
		$mailer->notifyPetitioner($pet_dat_number, $pet_dat_contact, $status_txt, 'Comments: '.$post['comments']);   
		$formLog->formsUserLogs('email_notify', $pet_id, 'TO: '.$pet_dat_contact.' NEW STATUS: '.$status_txt.'');
	}
	
	
	$redirect 	= 'index.php?tab=comments&pt='.$post['pet_id'].'&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}




/* ============================================================================== 
/*	PETITION MILESTONE: DELIBERATION VOTING
/* ------------------------------------------------------------------------------ */

if($formname=="frm_pet_voting")
{
	$status_id = 4;
	$sqpost[] = "update `pom_petition_details` SET `status_id`= '4' WHERE `petition_id`=".q_si($post['pet_id'])."; ";
	
	$sqpost[] = "replace into `pom_petition_committee` (`petition_id` , `account_id` , `rating` , `vote`) values 
		(".q_si($pet_id).", ".q_si($post_by).",".q_si($post['rating']).",".q_si($post['vote'])."); ";
		
	$sqpost[] = "insert into `pom_petition_comments` (`petition_id` , `post_by` , `comment`) values 
		(".q_si($post['pet_id']).", ".q_si($post_by).",".q_si('<b><em>[vote]</em></b> '.$post['comments'])."); ";	
	
	//displayArray($sqpost); exit;	
	$cndb->dbQueryMulti($sqpost);
	
	/* UPDATE MILESTONE*/	
	$dispDt->sys_statusMilestone($post['pet_id'], $post['mst'], 9);
	
	
	/* --------- @@ Activity Logger --------------- */	
	$log_detail = 'voted-' . $arrPetitionVote[$post['vote']]. ': '. $post['comments'] . '';
	$formLog->formsUserLogs('voting', $pet_id, $log_detail, $status_id );
	/* =============================================== */	
		//exit;
	// TODO - SEND NOTIFICATION
	
	
	$redirect 	= 'index.php?tab=comments&pt='.$post['pet_id'].'&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}




/* ============================================================================== 
/*	PETITION MILESTONE: DELIBERATION COMMENTS
/* ------------------------------------------------------------------------------ */

if($formname=="frm_pet_comments")
{
	//$invites = 
	$status_id = 4;
	$sqpost[] = "update `pom_petition_details` SET `status_id`= '4' WHERE `petition_id`=".q_si($post['pet_id'])."; ";
	
	$sqpost[] = "insert into `pom_petition_comments` 
		(`petition_id` , `post_by` , `rating` , `vote` , `comment`) values 
		(".q_si($post['pet_id']).", ".q_si($post_by).",".q_si($post['rating']).",".q_si($post['vote']).",".q_si($post['comments'])."); ";	
	
	//displayArray($sqpost); exit;	
	$cndb->dbQueryMulti($sqpost);
	
	/* UPDATE MILESTONE*/	
	$dispDt->sys_statusMilestone($post['pet_id'], $post['mst'], 9);
	
	
	/* ========= @@ Activity Logger ================== */	
	$log_detail = 'Petition Review: '. $post['comments'] . '';
	$formLog->formsUserLogs('milestone_update', $pet_id, $log_detail, $status_id );
	/* =============================================== */	
	
	// TODO - SEND NOTIFICATION
	
	
	$redirect 	= 'index.php?tab=comments&pt='.$post['pet_id'].'&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}


/* ============================================================================== 
/*	PETITION MILESTONE: HEARING
/* ------------------------------------------------------------------------------ */

if($formname=="frm_pet_hearing")
{
	$date_hearing = $post['hearing_date'] . ' ' . $post['hearing_time'];
	$prison_txt = $dispDt->get_prisonList($post['prison_id']);
	
	$members 	= $post['invite'];
	$status_id  = 3;
	
	
	$sqpost[] = "update `pom_petition_details` SET `status_id`= ".q_si($status_id)." WHERE `petition_id`=".q_si($post['pet_id'])."; ";	
	$sqpost[] = "insert into `pom_hearings`  (`hearing_date` , `hearing_time` , `prison_id` , `petition_id` , `comments`, `post_by`, `invites`) values (".q_si($post['hearing_date']).", ".q_si($post['hearing_time']).",".q_si($post['prison_id']).",".q_si($pet_id).",".q_si($post['comments']).", ".q_si($post_by).", ".q_si($post['invite'])."); ";	
	
	
	if(is_array($members)) 
	{
		foreach($members as $mem_id => $mem_email)  
		{
			$sqpost[] = "insert ignore into `pom_petition_committee` (`petition_id` , `account_id`) values (".q_si($pet_id).", ".q_si($mem_id)." ); ";			
		}
	}
	
	//displayArray($sqpost); exit;	
	$cndb->dbQueryMulti($sqpost);
	
	/* UPDATE MILESTONE*/	
	$dispDt->sys_statusMilestone($post['pet_id'], $post['mst']);
	
	
	/* ========= @@ Activity Logger ================== */	
	$log_detail = 'Hearing Schedule - Date: '. $date_hearing . ' &nbsp; Venue: '. $prison_txt.'';
	$formLog->formsUserLogs('milestone_update', $pet_id, $log_detail, $status_id );
	/* =============================================== */	
	
	// TODO - SEND NOTIFICATION
	/* ========= @@ Status Notification + LOG ================== */
	if($pet_dat_contact <> '') { 
		$status_txt = $dispDt->get_statusList($status_id);
		$mailer->notifyPetitioner($pet_dat_number, $pet_dat_contact, $status_txt, $log_detail);   
		$formLog->formsUserLogs('email_notify', $pet_id, 'TO: '.$pet_dat_contact.' NEW STATUS: '.$status_txt.'');
	}
	
	$redirect 	= 'index.php?tab=viewpetition&pt='.$post['pet_id'].'&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}




/* ============================================================================== 
/*	PETITION MILESTONE: ELIGIBILITY
/* ------------------------------------------------------------------------------ */

if($formname=="frm_pet_eligible")
{
	
	$status_id  = ($admissible == 1) ? 5 : 6;
	
	
	//$sqpost = "update `pom_petition_details` SET `admissible`= ".q_si($admissible).", `admissible_comments`= ".q_si($post['admissible_comments']).", `status_id`= ".q_si($status_id)." WHERE `petition_id`=".q_si($post['pet_id'])."; ";
	
	$sqpost[] = "update `pom_petition_details` SET `status_id`= ".q_si($status_id)." WHERE `petition_id`=".q_si($pet_id)."; ";
	$sqpost[] = "insert into `pom_petition_comments` (`petition_id`, `post_by`, `comment`) values 
		(".q_si($pet_id).", ".q_si($post_by).", ".q_si($post['admissible_comments'])."); ";		
	//displayArray($sqpost); exit;	
	$cndb->dbQueryMulti($sqpost);
	
	/* UPDATE MILESTONE*/	
	$dispDt->sys_statusMilestone($pet_id, $mst_id, $status_id);
	
	
	/* ========= @@ Activity Logger ================== */	
	$log_detail = 'Petition Eligibility: '. yesNoText($admissible) . ' - comments:'. $post['admissible_comments'].'';
	$formLog->formsUserLogs('milestone_update', $pet_id, $log_detail, $status_id);
	/* =============================================== */	
	
	
	/* ========= @@ Status Notification + LOG ================== */
	if($pet_dat_contact <> '') { 
		$status_txt = $dispDt->get_statusList($status_id);
		$mailer->notifyPetitioner($pet_dat_number, $pet_dat_contact, $status_txt);   
		$formLog->formsUserLogs('email_notify', $pet_id, 'TO: '.$pet_dat_contact.' NEW STATUS: '.$status_txt.'');
	}
	
	
	
	$redirect 	= 'index.php?tab=viewpetition&pt='.$post['pet_id'].'&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}



/* ============================================================================== 
/*	ASSIGN  PETITION NUMBER
/* ------------------------------------------------------------------------------ */

if($formname=="fm_pet_number")
{	
	$sqpost = "update `pom_petition_details` SET `petition_number`= ".q_si($post['petition_number'])." WHERE `petition_id`=".q_si($post['pet_id'])."; ";		
	$cndb->dbQuery($sqpost);
	
	/* UPDATE MILESTONE*/
	$dispDt->sys_statusMilestone($post['pet_id'], $post['mst']);
	
	// TODO - SEND NOTIFICATION
	
	$redirect 	= 'index.php?tab=viewpetition&pt='.$post['pet_id'].'&qst=242';
	?><script>location.href="<?php echo $redirect; ?>";</script> <?php exit;
}




/* ============================================================================== 
/*	EDIT PETITION
/* ------------------------------------------------------------------------------ */

if($formname=="fm_petition" and $formaction=="_edit")
{
	
	$date_post = (isset($post['date_petition'])) ? strtotime($post['date_petition']) : time();
	
	$petition_id   = $post['petition_id'];
	$petitioner_id = $post['petitioner_id'];
	$representative_id = $post['representative_id'];
	
	/*
	* SAVE PETITIONER AND REPRESENTATIVE DETAILS
	* ============================================================ */
	$post['bio']['prison_no'] = $post['pr_code']['pris_key'].$post['pr_code']['pris_no'];
	
	$bio = $post['bio'];
	$rep = $post['rep'];
	
	$bio_cols = array(); $bio_dats = array();
	$rep_cols = array(); $rep_dats = array();
		
	if(is_array($bio)) 
	{
		foreach($bio as $b_key => $b_val)  {
			$field = strtolower($b_key);		
			if(!in_array($field, $fields_ignore)) {
				$bio_cols[] = " `$field` = ".q_si($b_val).""; 
			}			
		}
		$sq_bio = "UPDATE `pom_petition_applicants` set  ".implode($bio_cols, ', ')." where (`petitioner_id` = ".q_si($petitioner_id)." )" ; //echobr($sq_bio); exit;	
		$rs_bio = $cndb->dbQuery($sq_bio);	
	}
	
	if(is_array($rep)) 
	{
		foreach($rep as $r_key => $r_val)  {
			$field = strtolower($r_key);		
			if(!in_array($field, $fields_ignore)) {
				$rep_cols[] = " `$field` = ".q_si($r_val).""; 
			}			
		}
		
		$sq_rep = "UPDATE `pom_representatives` set  ".implode($rep_cols, ', ')." where (`representative_id` = ".q_si($representative_id)." )" ; //echobr($sq_rep);
		$rs_rep = $cndb->dbQuery($sq_rep);
	}
	
	
	/*
	* UPLOAD ATTACHMENTS
	* ============================================================ */
	
	$petner_id_rec = str_pad($petitioner_id,5,'0',STR_PAD_LEFT);
	//.$bio['prison_no']
	$doc_title = $petner_id_rec.'_'.$bio['prison_no'].'_'.strtotime(date('d F Y')); //.'_off_'
	
	if(isset($_FILES['offence_attachments']) and is_array($_FILES['offence_attachments']['name'])) 
	{		
		foreach($_FILES['offence_attachments']['name'] as $dkey => $dfile) 
		{
            if(strlen($dfile) > 4) 
			{
				$doc_ext      = ".".strtolower(substr(strrchr($dfile,"."),1));
				$doc_checksum = 'offnat_'.$doc_title.'_'.$dkey; 
				$doc_newname  = preg_replace("/[^a-zA-Z0-9_|+]/", '', $doc_checksum).$doc_ext;
				$doc_temp     = $_FILES['offence_attachments']['tmp_name'][$dkey];
				
				$doc_target   = UPL_FILES . $doc_newname;
				//echobr($doc_target); exit;
				
				if(move_uploaded_file($doc_temp, $doc_target))
				{ $post['offence_attachments'][$dkey] = $doc_newname; }
			}
		}		
	}
	
	if(isset($_FILES['petition_support_files']) and is_array($_FILES['petition_support_files']['name'])) 
	{		
		foreach($_FILES['petition_support_files']['name'] as $dkey => $dfile) 
		{
            if(strlen($dfile) > 4) 
			{
				$doc_ext      = ".".strtolower(substr(strrchr($dfile,"."),1));
				$doc_checksum = 'petspt_'.$doc_title.'_'.$dkey; 
				$doc_newname  = preg_replace("/[^a-zA-Z0-9_|+]/", '', $doc_checksum).$doc_ext;
				$doc_temp     = $_FILES['petition_support_files']['tmp_name'][$dkey];
				
				$doc_target   = UPL_FILES . $doc_newname;
				//echobr($doc_newname); exit;
				
				if(move_uploaded_file($doc_temp, $doc_target))
				{ $post['petition_support_files'][$dkey] = $doc_newname; }
			}
		}		
	}
	
	/*
	* SAVE PETITION DETAILS
	* ============================================================ */
	
	$myCols = array(); $myDats = array();
	$field_names = array_keys($post); 
	
	foreach($field_names as $field)
	{
		$field = strtolower($field);
		
		if(!in_array($field, $fields_ignore))
		{
			$fieldNam	= $field;
			$fieldVal	= $post[''.$field.''];
			
			if( $field == "published") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
			if( $field == "is_happen") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
			if( $field == "pay_years") { $fieldVal = $post['pay_years'] * 12; $fieldNam = 'pay_months'; } 
			if( $field == "userpass")  { $fieldVal = md5($post[''.$field.'']);  } 
			
			$myCols[] = " `$fieldNam` = ".q_si($fieldVal).""; 
			
		}
	}
	
	$sq_pet = "UPDATE `pom_petition_details` set  `petition_lock`= '1', ".implode($myCols, ', ')." where (`petition_id` = ".q_si($petition_id)." )" ; 
	//echobr($sq_pet); exit;
	$rs_pet = $cndb->dbQuery($sq_pet);
	$pet_id = $petition_id; //$cndb->insertId($rs_pet);
	
	//$dispDt->sys_createMilestones($pet_id, (strtotime($post['date_petition'])));
	
	//$newPet = 'EP/'.date('Y/m/d').'/'.str_pad($pet_id,4,'0',STR_PAD_LEFT);
	//$sqmt = "update `pom_petition_details` SET `petition_number`= ".q_si($newPet)." WHERE `petition_id`=".q_si($pet_id)."; ";		
	//$cndb->dbQuery($sqmt);
	
	/* UPDATE MILESTONE*/
	//$dispDt->sys_statusMilestone($pet_id, 2);
	
	//exit;
	$redirect = 'index.php?tab=viewpetition&pt='.$pet_id.'&rd=12';
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
}



/* ============================================================================== 
/*	SUBMIT NEW PETITION
/* ------------------------------------------------------------------------------ */

if($formname=="fm_petition" and $formaction=="_new")
{
	$fields_ignore = array("formname","formaction","formtab","id","redirect","saveform","publishval","post_by","date_post","bio","rep", "offence_victim", "pr_code");
	
	//$post['offence_victim_detail'] = $post['offence_victim'];
	$date_post = (isset($post['date_petition'])) ? strtotime($post['date_petition']) : time();
	
	/*
	* SAVE PETITIONER AND REPRESENTATIVE DETAILS
	* ============================================================ */
	$post['bio']['prison_no'] = $post['pr_code']['pris_key'].$post['pr_code']['pris_no'];
	
	$bio = $post['bio'];
	$rep = $post['rep'];
	
	$bio_cols = array(); $bio_dats = array();
	$rep_cols = array(); $rep_dats = array();
	
		
	if(is_array($bio)) 
	{
		foreach($bio as $b_key => $b_val)  {
			$field = strtolower($b_key);		
			if(!in_array($field, $fields_ignore)) {
				$bio_cols[] = "`$field`";	
				$bio_dats[] = "".q_si($b_val)."";
			}			
		}
		
		if ($formaction == "_new" ) {}	
		$sq_bio = "insert into `pom_petition_applicants` (".implode($bio_cols, ', ').") values (".implode($bio_dats, ', ')."); ";		
		$rs_bio = $cndb->dbQuery($sq_bio);
		$petitioner_id = $cndb->insertId($rs_bio);  //echobr($petitioner_id); exit;		
	}
	
	if(is_array($rep)) 
	{
		foreach($rep as $r_key => $r_val)  {
			$field = strtolower($r_key);		
			if(!in_array($field, $fields_ignore)) {
				$rep_cols[] = "`$field`";	
				$rep_dats[] = "".q_si($r_val)."";
			}			
		}
		
		if ($formaction == "_new" ) {}	
		$sq_rep = "insert into `pom_representatives` (".implode($rep_cols, ', ').") values (".implode($rep_dats, ', ')."); ";		
		$rs_rep = $cndb->dbQuery($sq_rep);
		$representative_id = $cndb->insertId($rs_rep);  //echobr($petitioner_id); exit;		
	}
	
	
	/*
	* UPLOAD ATTACHMENTS
	* ============================================================ */
	
	$petner_id_rec = str_pad($petitioner_id,5,'0',STR_PAD_LEFT);
	//.$bio['prison_no']
	$doc_title = $petner_id_rec.'_'.$bio['prison_no'].'_'.strtotime(date('d F Y')); //.'_off_'
	
	if(isset($_FILES['offence_attachments']) and is_array($_FILES['offence_attachments']['name'])) 
	{		
		foreach($_FILES['offence_attachments']['name'] as $dkey => $dfile) 
		{
            if(strlen($dfile) > 4) 
			{
				$doc_ext      = ".".strtolower(substr(strrchr($dfile,"."),1));
				$doc_checksum = 'offnat_'.$doc_title.'_'.$dkey; 
				$doc_newname  = preg_replace("/[^a-zA-Z0-9_|+]/", '', $doc_checksum).$doc_ext;
				$doc_temp     = $_FILES['offence_attachments']['tmp_name'][$dkey];
				
				$doc_target   = UPL_FILES . $doc_newname;
				//echobr($doc_target); exit;
				
				if(move_uploaded_file($doc_temp, $doc_target))
				{ $post['offence_attachments'][$dkey] = $doc_newname; }
			}
		}		
	}
	
	if(isset($_FILES['petition_support_files']) and is_array($_FILES['petition_support_files']['name'])) 
	{		
		foreach($_FILES['petition_support_files']['name'] as $dkey => $dfile) 
		{
            if(strlen($dfile) > 4) 
			{
				$doc_ext      = ".".strtolower(substr(strrchr($dfile,"."),1));
				$doc_checksum = 'petspt_'.$doc_title.'_'.$dkey; 
				$doc_newname  = preg_replace("/[^a-zA-Z0-9_|+]/", '', $doc_checksum).$doc_ext;
				$doc_temp     = $_FILES['petition_support_files']['tmp_name'][$dkey];
				
				$doc_target   = UPL_FILES . $doc_newname;
				//echobr($doc_newname); exit;
				
				if(move_uploaded_file($doc_temp, $doc_target))
				{ $post['petition_support_files'][$dkey] = $doc_newname; }
			}
		}		
	}
	
	
	
	//exit;
	/*
	* SAVE PETITION DETAILS
	* ============================================================ */
	
	$myCols = array(); $myDats = array();
	$field_names = array_keys($post); 
	
	foreach($field_names as $field)
	{
		$field = strtolower($field);
		
		if(!in_array($field, $fields_ignore))
		{
			$fieldNam	= $field;
			$fieldVal	= $post[''.$field.''];
			
			if( $field == "published") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
			if( $field == "is_happen") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
			if( $field == "pay_years") { $fieldVal = $post['pay_years'] * 12; $fieldNam = 'pay_months'; } 
			if( $field == "userpass")  { $fieldVal = md5($post[''.$field.'']);  } 
			
			if ($formaction == "_edit" ) { 
				$myCols[] = " `$fieldNam` = ".q_si($fieldVal).""; 
			}		
				
			elseif ($formaction == "_new" ) {
				$myCols[] = "`$fieldNam`";	
				$myDats[] = "".q_si($fieldVal)."";
			}
			
		}
	}
	
	$sq_pet = "insert into `pom_petition_details` (`petitioner_id`, `representative_id`, ".implode($myCols, ', ').") values 
		(".q_si($petitioner_id).", ".q_si($representative_id).", ".implode($myDats, ', ')."); ";	
	//echobr($sq_pet); exit;
	$rs_pet = $cndb->dbQuery($sq_pet);
	$pet_id = $cndb->insertId($rs_pet);
	
	$dispDt->sys_createMilestones($pet_id, (strtotime($post['date_petition'])));
	
	$newPet = 'EP/'.date('Y/m/d').'/'.str_pad($pet_id,4,'0',STR_PAD_LEFT);
	
	$sqmt = "update `pom_petition_details` SET `petition_number`= ".q_si($newPet)." WHERE `petition_id`=".q_si($pet_id)."; ";		
	$cndb->dbQuery($sqmt);
	
	/* UPDATE MILESTONE*/
	$dispDt->sys_statusMilestone($pet_id, 2);
	
	
	/* ========= @@ Activity Logger ================== */	
	$log_detail = 'New Petition: '. $newPet . '';
	$formLog->formsUserLogs('milestone_update', $pet_id, $log_detail, 1);
	/* =============================================== */	
	
	//exit;
	$redirect = 'index.php?tab=editpetition&pt='.$pet_id.'&rd=12';
	?><script language="javascript">location.href = "<?php echo $redirect; ?>"; </script><?php
}




/* ============================================================================== 
/*	SYSTEM SETTINGS
/* ------------------------------------------------------------------------------ */

if ($formname=="fm_vds" ) 
{
	$tabDir 		= $post['formtab'];
	$formtable 	 = $adSysTabs[$tabDir]['tbn'];
	$formpkey 	  = $adSysTabs[$tabDir]['tbk'];
	$pdate		 = '';
	
	if(!isset($_POST['published']) and isset($_POST['publishval'])) {
		$pub = array("published" => "off");
		$post = array_merge_recursive($post, $pub );	
	}
	
	$field_names = array_keys($post); 
	$mySql  = "";	
	$myCols = array();
	$myDats = array();
	
	
	
	$fields_ignore = array("formname","formaction","formtab","id","redirect","submit","publishval","ac_password","ac_passconfirm","post_by");
	//displayArray($fields_ignore); exit;
	if($formtab=="members")  { 
		$account_pass = '';
		if($post['ac_password'] <> '' and $post['ac_password'] == $post['ac_passconfirm'])
		{ $account_pass = md5($post['ac_password']); }
		
		$fields_ignore[] = 'level_id';
		if ($formaction == "_new" ) {	
			$exists = $dispDt->account_checkExist($post['account_email']);
			if($exists == 1) { echo '<script language="javascript">location.href="'.$redirect.'&op=new&qst=20"; </script>'; exit; }
		}
	}
	
	foreach($field_names as $field)
	{
		$field = strtolower($field);
		
		if(!in_array($field, $fields_ignore))
		{
			$fieldNam	= $field;
			$fieldVal	= $post[''.$field.''];
			
			if( $field == "published") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
			if( $field == "is_happen") { $fieldVal = yesNoPost($post[''.$field.'']);  } 
			if( $field == "pay_years") { $fieldVal = $post['pay_years'] * 12; $fieldNam = 'pay_months'; } 
			if( $field == "userpass")  { $fieldVal = md5($post[''.$field.'']);  } 
			
			if ($formaction == "_edit" ) { 
				$myCols[] = " `$fieldNam` = ".q_si($fieldVal).""; 
			}		
				
			elseif ($formaction == "_new" ) {
				$myCols[] = "`$fieldNam`";	
				$myDats[] = "".q_si($fieldVal)."";
			}
			
		}
	}
	
	
	if ($formaction == "_edit" ) {	
		$sqpost = "UPDATE `$formtable` SET  ".implode($myCols, ', ')." WHERE (`$formpkey` = ".q_si($post['id'])." )" ;		
	}
	
	if ($formaction == "_new" ) {	
		$sqpost = "INSERT INTO `$formtable` (".implode($myCols, ', ').") VALUES (".implode($myDats, ', ')."); ";		
	}
	
	//echobr($sqpost); exit;
	$rspost = $cndb->dbQuery($sqpost);
	
	if 		( $formaction=="_new")  { $post_id = $cndb->insertId(); }
	elseif 	( $formaction=="_edit") { $post_id = $post['id']; }
	
	if($formtab=="members")  
	{ 	
		if(isset($post['level_id'])){
		 $levels = $post['level_id']; 
		 $dispDt->account_saveLevel($post_id, $levels);
		}
		
		 if($account_pass <> '') {
			 $sqpass = "UPDATE `$formtable` SET `account_pass`='".$account_pass."' WHERE (`$formpkey`=".q_si($post_id).")";
			 $rspass = $cndb->dbQuery($sqpass); //echobr($sqpass); exit;
		 }
	}
	//exit;
	
	$notify_id = 51;
	if($formtab=="member_accounts" or $formtab=="member_profile") {
		$log_notify = 0; $notify_id=''; $redirect = $redirect.'&id='.$post_id;
	}
	
	
	/* ========= @@ Activity Logger ================== */	
	if ( $formaction=="_new") { $log_detail = 'New: '. $formtab . ''; }
	if ( $formaction=="_edit") { $log_detail = 'Edit: '. $formtab . ''; }	
	$formLog->formsUserLogs($formtab, $post_id, $log_detail);
	/* =============================================== */	
	
	
	?> <script language='javascript'>location.href="<?php echo $redirect; ?>"; </script> <?php exit;
}

//exit;




/* ============================================================================== 
/*	ACCOUNT RESET PASSWORD FORM
/* ------------------------------------------------------------------------------ */	

if ($formname=="acpwchange")  
{
	$passcurr = $post['passcurr'];
	$passauth = $post['passauth'];
	
	if($post['passnew'] <> $post['passconf']) { 
	?> <script language='javascript'> location.href="index.php?ac=<?=$passauth?>&qst=116"; </script>  <?php exit; }
	
	$pass_old 	= md5($post['passcurr']);
	$pass_new 	= md5($post['passnew']);
	
	$sq_check = "SELECT * FROM `pom_reg_accounts` WHERE (`account_auth`=".q_si($passauth)." and `account_pass`=".q_si($pass_old).")";
	$rs_check = $cndb->dbQuery($sq_check);
	
	if($cndb->recordCount($rs_check)==1)
	{ 	
		$cn_check      = $cndb->fetchRow($rs_check);	
		$account_id   = $cn_check['account_id'];	
		$account_name  = clean_output($cn_check['account_name']);
		$account_email  = clean_output($cn_check['account_email']);
		
		
		$sq_rst	="update `pom_reg_accounts` set `account_pass`= ".q_si($pass_new).", `account_auth` = ".q_si($passauth."__")." where `account_id` = ".quote_smart($account_id)."; ";
		$rs_rst = $cndb->dbQuery($sq_rst);
	
	
		/* ========= @@ Activity Logger ================== */	
		$log_detail = 'Password change: '. $account_email . '';
		$formLog->formsUserLogs('accounts', $account_id, $log_detail, 7);
		/* =============================================== */	
	
	
		/* =============================================== */	
		/* @@ User Email Notification   */
		$messageDetail = array("message_subject" =>"Password Changed",
							   "contact_email"   =>"".$account_email."",
							   "contact_name"    =>"".$account_name."",
							   "message_to"   	  =>"".$account_email."" );		
		$messageContent = $mailer->messageTemplate('account_passchange', $messageDetail, ''); //, $debugmail
		/* =============================================== */
	
		?><script>location.href="index.php?tk=<?php echo time(); ?>&qst=27";</script> <?php exit;
		
		
	}
	else
	{ ?><script>location.href="index.php?ac=<?=$passauth?>&qst=115";</script> <?php exit; }
	
	
}	


/* ============================================================================== 
/*	ACCOUNT RESET PASSWORD REQUEST
/* ------------------------------------------------------------------------------ */	

if ($formname=="acpwreset")  
{
	$ac_email = filter_var($post['rf_email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($ac_email, FILTER_VALIDATE_EMAIL)) {
		echo $msge_array[100]; exit;
	}
	
	$auth_code	   = 'RST'.strtoupper(md5(uniqid(rand() . $ac_email)));
	
	$sq_check ="SELECT `account_id`,`account_name` FROM `pom_reg_accounts` WHERE (`account_email`=".quote_smart($ac_email).")";
	$rs_check = $cndb->dbQuery($sq_check);
	
	if($cndb->recordCount($rs_check)==1)
	{ 	
		$cn_check      = $cndb->fetchRow($rs_check);	
		$account_id   = $cn_check['account_id'];	
		$account_name  = clean_output($cn_check['account_name']);
		
		echo $msge_array[26];
		
		$sq_rst	="update `pom_reg_accounts` set `account_auth` = '".$auth_code."' where `account_id` = ".quote_smart($account_id)."; ";
		//echo $sqpostb; exit;
		$rs_rst = $cndb->dbQuery($sq_rst);
	
		/* ========= @@ Activity Logger ================== */	
		$log_detail = 'Reset Password request: '. $ac_email . '';
		$formLog->formsUserLogs('accounts', $account_id, $log_detail, 7);
		/* =============================================== */	
	
	
		/* =============================================== */	
		/* @@ User Email Notification  */		
		$confirm_link1 = SITE_DOMAIN_LIVE.'?ac='.$auth_code;
		$confirm_link2 = '<a href="'.$confirm_link1.'" target="_blank">'.$confirm_link1.'</a>';
		$messageDetail = array("message_link"   	=>"".$confirm_link2."",
							   "message_subject" =>"Reset Password",
							   "contact_email"   =>"".$ac_email."",
							   "contact_name"    =>"".$account_name."",
							   "message_to"   	  =>"".$ac_email."" );		
		$messageContent = $mailer->messageTemplate('account_passreset', $messageDetail, 1); //, $debugmail
		/* =============================================== */
	
		exit;
	}
	else
	{
		echo $msge_array[21];
	}
	
	exit;
}	




/* ============================================================================== 
/*	LOG IN FORM
/* ------------------------------------------------------------------------------ */

if ($formname=="aclogin") 
{	
	$ac_email = $post['email'];
	
	$sq_login = "SELECT `pom_reg_accounts`.`account_id` , `pom_reg_accounts`.`account_name` , `pom_reg_accounts`.`account_email` , `pom_reg_accounts`.`account_pass` , `pom_reg_accounts_to_levels`.`level_id` , `pom_reg_levels`.`level` FROM `pom_reg_accounts` LEFT JOIN `pom_reg_accounts_to_levels` ON (`pom_reg_accounts`.`account_id` = `pom_reg_accounts_to_levels`.`account_id`) LEFT JOIN `pom_reg_levels` ON (`pom_reg_accounts_to_levels`.`level_id` = `pom_reg_levels`.`level_id`) WHERE (`pom_reg_accounts`.`account_email` =".q_si($post['email'])." AND `pom_reg_accounts`.`account_pass` =".q_si(md5($post['password']))." AND `pom_reg_accounts`.`published` =1) LIMIT 0,1;"; 
	//echobr($sq_login); exit;
	$rs_login = $cndb->dbQuery($sq_login);	//
	$rs_login_count = $cndb->recordCount($rs_login);
	
	if ($rs_login_count==1) 
	{
		$cn_login      = $cndb->fetchRow($rs_login);
		
		$u_id          = $cn_login['account_id'];
		$u_name        = clean_output($cn_login['account_name']);
		$u_email 	   = $cn_login['account_email'];
		$u_level_id 	= $cn_login['level_id'];
		$u_level 	   = $cn_login['level']; //($u_level_id == 1)? 'admin':'user'; 
		
		//$u_type_id 	 = 1; //$cn_login['id_member_type'];
		//$u_type 	    = ($u_type_id == 1)? 'admin':'user'; 
		
		$sq_track = "UPDATE `pom_reg_accounts` set `login_last` = CURRENT_TIMESTAMP(), `login_count` = (`login_count`+1) WHERE `account_id` = ".q_si($u_id)."; ";
		$rs_track = $cndb->dbQuery($sq_track);	
		
		
		$redirect 	  = 'index.php?token='.$conf_token.'&qst=101';
		
		$log_session = array(
			'u_id' 		=> ''.$u_id.'',
			'u_level' 	 => ''.$u_level.'',
			'u_level_id'  => ''.$u_level_id.'',
			'u_name' 	  => ''.$u_name.'',
			'u_email' 	 => ''.$u_email.'',
			//'u_login' 	 => ''.$post['username'].'',
			//'u_dept_id'   => '1',
			//'u_post_id'   => '1',			
			'u_photo' 	  => '',
			'expires'	  => time()+(180*60));
		
		$_SESSION['sess_pom_member'] = $log_session;		
		$_SESSION['sess_pom_member']['signed_in']    = true;
		
		/* ========= @@ Activity Logger ================== */	
		$log_detail = 'Success: '. $ac_email . '';
		$formLog->formsUserLogs('accounts_login', $account_id, $log_detail, 7);
		/* =============================================== */	
		
		
		echo "<script language='javascript'>location.href=\"$redirect\"; </script>";
		
	}
	else {
		
		/* ========= @@ Activity Logger ================== */	
		$log_detail = 'Failed: '. $ac_email . '';
		$formLog->formsUserLogs('accounts_login', $account_id, $log_detail, 6);
		/* =============================================== */	
		
	 ?> <script language='javascript'> location.href="index.php?qst=114"; </script>  <?php
	}
	
}		
	
	
	


/* ============================================================================== 
/*	ACCOUNT SIGNUP 
/* ------------------------------------------------------------------------------ */

	
if($formname=="ac_signup")	// or $formname=="membership_upgrade"
{
	$formResponse = $msge_array[22];
	
	$email = filter_var($post['ac_email'], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo $msge_array[100]; exit;
	}
	if($post['ac_password'] <> $post['ac_passconfirm']) {
		echo $msge_array[116]; exit;
	}
	
	$ac_formtype 	 = $post['formtype'];	
	$ac_email 		= $post['ac_email'];
	$ac_phone 		= @$post['ac_phone']; //filter_var($post['ac_phone'], FILTER_SANITIZE_NUMBER_INT);
	$ac_namefirst	= @$post['ac_namefirst'];
	$ac_namelast	 = @$post['ac_namelast'];
	$ac_name 	 	 = $post['account_name']; //$post['ac_namefirst'].' '.$post['ac_namelast'];	
	$ac_password 	   = md5($post['ac_password']);	
	
	$auth_code	   = 'SGN'.strtoupper(md5(uniqid(rand() . $ac_email)));
	
	$seqpost		 = array();
	$type			= new posts;
	
		
	$sq_check = "SELECT `account_email` FROM `pom_reg_accounts` WHERE (`account_email` = ".$postb['ac_email'].")";
	$rs_check = $cndb->dbQuery($sq_check);
	if($cndb->recordCount($rs_check)>=1)
	{ echo $msge_array[20]; exit; }

	//echobr($debugmail);
	$sqpost = "insert into `pom_reg_accounts` (`account_name`, `account_email`, `account_pass`, `account_auth`, `published`) values 
		(".quote_smart($ac_name).", ".quote_smart($ac_email).", ".quote_smart($ac_password).", ".quote_smart($auth_code).", '0' ) ";				
		//echo $sqpost ; //exit;
		$result = $cndb->dbQuery($sqpost);
		$account_id = $cndb->insertId();			
	
		$sqlev = "insert into `pom_reg_accounts_to_levels` (`account_id`,`level_id`) values (".quote_smart($account_id).", '2') ";				
		$rslev = $cndb->dbQuery($sqlev);
	
	echo $msge_array[22];
	
	
	/* ========= @@ Activity Logger ================== */	
		$log_detail = 'New Registration: '. $ac_email . '';
		$formLog->formsUserLogs('accounts_signup', $account_id, $log_detail, 7);
	/* =============================================== */
		
	/* =============================================== */	
	/* @@ User Email Notification   */	
		$confirm_link1 = SITE_DOMAIN_LIVE.'?ac='.$auth_code;
	    $confirm_link2 = '<a href="'.$confirm_link1.'" target="_blank">'.$confirm_link1.'</a>';
		$messageDetail = array("message_link"   	=>"".$confirm_link2."",
							   "message_subject" =>"Account Sign Up",
							   "contact_email"   =>"".$ac_email."",
							   "message_to"   	  =>"".$ac_email."" );		
		$mailer->messageTemplate('account_verify', $messageDetail, 1);	//, $debugmail
	/* --- end ---	*/								
	/* =============================================== */
	
	/*echo "<script language='javascript'>location.href=\"$redirect\"; </script>";*/
	exit;

}
	

?>