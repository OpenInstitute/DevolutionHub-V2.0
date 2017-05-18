<?php 
require("../classes/cls.constants.php"); 
require("includes/adm_functions.php");

//if (!isset($sys_us_admin['adminname'])) 
//{  echo "Your session has expired. <p><a href=\"index.php\">Click here</a> to log in again."; exit; }

/* ****************************************
 @Automation  - GET /ADD GALLERY IMAGE
****************************************** */ 

function getAddGalleryImage($filename, $account_arr=array(), $id_parent) {
	//$cnType->connect() or trigger_error('SQL', E_USER_ERROR);
	
	$file_id	= '';
	$auth_code  = strtoupper(uniqid(time()));	
		
	if($filename <> '')
	{
		$sq_check = "SELECT `id`, `filename` FROM `dhub_dt_gallery_photos` WHERE (`filename` = ".quote_smart($filename).")";
		$rs_check = $cndb->dbQuery($sq_check); //, $this->dbconnect
		if( $cndb->recordCount($rs_check)>=1)
		{ 
			$cn_check =  $cndb->fetchRow($rs_check);
			$file_id  = $cn_check[0];	//'iko '.$filename; //	
		}
		else
		{	
		
		
		/* ----------------------------------------- */	
			$field_title = "";
			$field_value = "";
		
			if(is_array($account_arr))
			{
				foreach($account_arr as $col=>$value)
				{	
					$field_title .= " `$col`, ";
					$field_value .= " ".quote_smart($value).", ";
				}
			}
		/* ----------------------------------------- */
			
			$rec_stamp = strtotime($account_arr['date_posted']);
			
			$sqpost = "insert into `dhub_dt_gallery_photos` ($field_title  `published`) values 
			($field_value  '1' ) ";				//".quote_smart($account_email).",
			echo $sqpost ; exit;
			$result = $cndb->dbQuery($sqpost);	//, $this->dbconnect
			$file_id = mysql_insert_id();	
		}	
		
		
		$sq_checkb = "SELECT * FROM `dhub_dt_gallery_photos_parent` WHERE (`id_photo` = ".quote_smart($file_id).") and (`id_equipment` = ".quote_smart($id_parent).") "; 
		$rs_checkb = $cndb->dbQuery($sq_checkb); //echo  $cndb->recordCount($rs_checkb) ; exit;
		if( $cndb->recordCount($rs_checkb) < 1)
		{ 
			$sqpostb = "INSERT IGNORE INTO `dhub_dt_gallery_photos_parent`(`id_photo`, `id_equipment`, `rec_stamp`) values 
			(".quote_smart($file_id).",".quote_smart($id_parent).",".quote_smart($rec_stamp)." ) ";	
			echo $sqpostb ; exit;
			$resultb = $cndb->dbQuery($sqpostb);	
			$file_id = 'added '.$file_id;		
		}
		
	
	}
	return $file_id;	
}




$seq_update = array();

$sq_qry = "SELECT `id_equipment` , `eq_title` , `eq_image`, `date_record` FROM `dhub_reg_equipment` WHERE (`eq_image` <> ''); ";
$rs_qry = $cndb->dbQuery($sq_qry); 
$rs_qry_count =  $cndb->recordCount($rs_qry);

if($rs_qry_count > 0)
{
	while($cndata = $cndb->fetchRow($rs_qry))
	{
	$id_equipment 	     	= trim($cndata[0]);
	$title	  	 = trim(html_entity_decode(stripslashes($cndata[1])));
	$file     	  = trim($cndata['eq_image']);
	$date_record     	  = trim($cndata['date_record']);
	
	$file_arr = array("id_gallery_cat"      =>"7",
					  "title"   	   =>"".$cndata['eq_title']."",
					  "filename"   	   =>"".$file."",							  
					  "date_posted"     =>"".$cndata['date_record'].""
					  );
							  
	$seq_update[]  = getAddGalleryImage($file, $file_arr, $id_equipment);
	
	//echobr($seq_update);	
	//$seq_update[] = " update `dhub_dt_content` set `url_title_article` = ".quote_smart($seo_title)." where `id` = ".quote_smart($id)."; ";
			
	}
	
	echobr(count($seq_update));
	displayArray($seq_update); 
	exit;
	
	
	$num_updates = count($seq_update);
	/*if( $num_updates > 0)
	{
		$type = new posts;
		$type->inserter_multi($seq_update);
		unset($seq_update);	
		echo "Updated ".$num_updates." Records.";
		exit;
	}
	else
	{
		echo "URL Codes valid. No Update.";
		exit;
	}*/
}
else
{ echo "Empty recordset!"; exit; }



?>

