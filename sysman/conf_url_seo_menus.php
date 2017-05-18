<?php 
require("../classes/cls.constants.php"); 
require("includes/adm_functions.php");

//if (!isset($sys_us_admin['adminname'])) 
//{  echo "Your session has expired. <p><a href=\"index.php\">Click here</a> to log in again."; exit; }




//$sq_qry = "SELECT `id`, `title`, `title_seo` FROM `dhub_dt_menu`;";
$sq_qry = "SELECT `id`, `title`, `url_title_article` FROM `dhub_dt_content`;";
$rs_qry = $cndb->dbQuery($sq_qry); 
$rs_qry_count =  $cndb->recordCount($rs_qry);

if($rs_qry_count > 0)
{
	while($cndata =  $cndb->fetchRow($rs_qry))
	{
	$id 	     	= trim($cndata[0]);
	$title	  	 = trim(html_entity_decode(stripslashes($cndata[1])));
	$seo_title     = generate_seo_link($title);
	
			
	//$seq_update[] = " update `dhub_dt_menu` set `title_seo` = ".quote_smart($seo_title)." where `id` = ".quote_smart($id)."; ";
			
	$seq_update[] = " update `dhub_dt_content` set `url_title_article` = ".quote_smart($seo_title)." where `id` = ".quote_smart($id)."; ";
			
	}

	displayArray($seq_update); exit;
	
	
	$num_updates = count($seq_update);
	if( $num_updates > 0)
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
	}
}
else
{ echo "Empty recordset!"; exit; }



?>

