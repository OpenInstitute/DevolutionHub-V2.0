
<?php
$sq_org = "SELECT resource_id, publisher FROM `dhub_dt_downloads` where `published` =1 ";
$rs_org = $cndb->dbQuery($sq_org);
//$link	= '';

while ($cn_org_a = $cndb->fetchRow($rs_org, 'assoc')) 
{
	$cn_org  	= array_map("clean_output", $cn_org_a);
	
	$q_Ins 		= array(); //[];
	$rid 		= $cn_org['resource_id'];
	$ct 		= $cn_org['publisher'];
	$q_Ins 		= explode(PHP_EOL, $ct);

	foreach($q_Ins as $ky => $org){				
		$orgn 	= clean_output($org);
		if($orgn <> ''){
			$org_seo 	= generate_seo_title($orgn, '-');	
			
			$rs_org_active = ($com_org_seo == $org_seo) ? ' class="current" ' : '';
			//$link = '<li><a href="organizations.php?com=5&formname=tag&dir_type='.$orgn.'&organization='.$orgn.'" >'.$orgn.' </a> </li> ';
			$link = '<li><a href="organizations.php?com=5&rso='.$org_seo.'" '.$rs_org_active.'>'.$orgn.' </a> </li> ';
			$org_name[''.$orgn.''] = $link;
		}
		
	}
}


asort($org_name);
//displayArray($org_name);
echo '<ul class="nav_side">';
echo implode('',$org_name);
echo '</ul>';
?>