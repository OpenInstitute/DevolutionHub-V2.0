<?php 
require("../classes/cls.constants.php"); 
include("includes/adm_functions.php"); 


setlocale(LC_ALL, 'en_US.UTF8');



$sq_qry = "SELECT `organization_id` , `organization` FROM `dhub_conf_organizations` ";
//$sq_qry = "SELECT `nid`, `title` FROM `_news`  WHERE isnull(`url_title_article`) or `url_title_article` = '';";
//$sq_qry = "SELECT `pr_id`, `title` FROM `_press_articles`  WHERE isnull(`url_title_article`) or `url_title_article` = '';";

$rs_qry = $cndb->dbQuery($sq_qry);
$rs_qry_count =  $cndb->recordCount($rs_qry);

if($rs_qry_count > 0)
{
	while($cndata =  $cndb->fetchRow($rs_qry))
	{
	$id 	        = trim($cndata[0]);	
	$organization 	= clean_output($cndata['organization']);
	$org_seo 	 = generate_seo_title($organization, '-');	
	
	$seq_update[] = " update `dhub_conf_organizations` set `organization_seo` = ".q_si($org_seo)." where `organization_id` = ".q_si($id)."; ";
		
	//$seq_update[] = "INSERT IGNORE INTO `dhub_dt_content_parent`(`id_content`, `id_parent`) values (".quote_smart($id).",".quote_smart($id_menu).") ";
	
	//$title	  = strip_tags(trim(html_entity_decode(stripslashes($cndata[1]))));	
	//$link_seo   = generate_seo_link($title, '-');	
	//$seq_update[] = " update `_news` set `url_title_article` = ".quote_smart($link_seo)." where `nid` = '".$id."'; ";			
	//$seq_update[] = " update `_press_articles` set `url_title_article` = ".quote_smart($link_seo)." where `pr_id` = '".$id."'; ";
	}

	//displayArray($seq_update); exit;
	
	
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

