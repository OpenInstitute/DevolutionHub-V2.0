<?php ini_set("display_errors", "off");
require_once("../classes/cls.formats.php");
require_once("../classes/cls.config.php");

$post = array_map("clean_request", $_REQUEST);

$rtype 		= (isset($post['rtype'])) ? $post['rtype'] : 'org';
$user_key  	= (isset($post['key'])) ? $post['key'] : '';
					
$response = array();
$response["success"] = 0;
$response["latest"] = '';
$response["items"] = 0;
$response["resources"] = array();

			  
switch ($rtype) {
  	case 'docs':
  		$sq_recs = "SELECT count(`resource_id`) as `num_records`  FROM `dhub_dt_downloads` WHERE `published` = '1';";
		$rs_recs = current($cndb->dbQueryFetch($sq_recs)); 
		$response = $rs_recs['num_records'];
		echo $response;
		//displayArray($rs_recs);
  		break;
  	case 'orgs':
  		$sq_recs = "SELECT `dhub_conf_organizations`.`organization_id`, `dhub_conf_organizations`.`organization` FROM `dhub_conf_organizations` INNER JOIN `dhub_dt_downloads_parent` ON (`dhub_conf_organizations`.`organization_id` = `dhub_dt_downloads_parent`.`organization_id`)WHERE (`dhub_conf_organizations`.`published` =1) GROUP BY `dhub_conf_organizations`.`organization_id`;";
		//$rs_recs = current($cndb->dbQueryFetch($sq_recs)); 
		//$response = $rs_recs['num_records'];
		$rO = current($cndb->dbQuery($sq_recs));
		$response = $cndb->recordCount($rO);
		echo $response;

	



		//displayArray($rs_recs);
  		break;
  	case 'cats':
  		$sq_recs = "SELECT count(`resource_id`) as `num_records`  FROM `dhub_dt_downloads` WHERE `published` = '1';";
		$rs_recs = current($cndb->dbQueryFetch($sq_recs)); 
		$response = $rs_recs['num_records'];
		echo $response;
		//displayArray($rs_recs);
  		break;
  	
  	default:
  		echo 'hanaku!';
  		break;
  }	


/*

$sqFile = "SELECT `dhub_dt_downloads`.* FROM `dhub_dt_downloads` $crit_county ORDER BY `dhub_dt_downloads`.`date_updated` DESC "; 
$rsFile = $cndb->dbQueryFetch($sqFile, 'county_id');
$response["items"] = count($rsFile);
$response["resources"] = $rsFile;*/

//echo json_encode($response);
?>