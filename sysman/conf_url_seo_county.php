<?php 
require("../classes/cls.constants.php"); 
include("includes/adm_functions.php"); 


setlocale(LC_ALL, 'en_US.UTF8');



$sq_qry = "SELECT `county_id`, `county` FROM `dhub_conf_county` ";


$rs_qry = $cndb->dbQuery($sq_qry);
$rs_qry_count =  $cndb->recordCount($rs_qry);

if($rs_qry_count > 0)
{
	while($cndata =  $cndb->fetchRow($rs_qry))
	{
	$id 	        = trim($cndata[0]);	
	$organization 	= clean_output($cndata['county']);
	$org_seo 	 	= generate_seo_title($organization, '-');	
	
	$seq_update[] = " update `dhub_conf_county` set `county_seo` = ".q_si($org_seo)." where `county_id` = ".q_si($id)."; ";
		
	}

	//displayArray($seq_update); exit;
	
	
	$num_updates = count($seq_update);
	if( $num_updates > 0)
	{
		$cndb->dbQueryMulti($seq_update);
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

