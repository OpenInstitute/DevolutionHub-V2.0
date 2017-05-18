
<?php

$item_inst = array();
$curLetter = "";

$sqFilter	= "";

if($filter <> '') { 
	$sqFilter = "  and (`dhub_conf_organizations`.`organization` like '".$filter."%' ) ";
}

$sq_org = "SELECT
    `dhub_conf_organizations`.`organization_id`
    , `dhub_conf_organizations`.`organization`
    , `dhub_conf_organizations`.`organization_seo`
    , COUNT(`dhub_dt_downloads_parent`.`resource_id`) AS `num_resources`
    , `dhub_conf_organizations`.`logo`
FROM
    `dhub_conf_organizations`
    INNER JOIN `dhub_dt_downloads_parent` 
        ON (`dhub_conf_organizations`.`organization_id` = `dhub_dt_downloads_parent`.`organization_id`)
    INNER JOIN `dhub_dt_downloads` 
        ON (`dhub_dt_downloads_parent`.`resource_id` = `dhub_dt_downloads`.`resource_id`)
WHERE (`dhub_conf_organizations`.`published` =1) $sqFilter
GROUP BY `dhub_conf_organizations`.`organization_seo`
ORDER BY `dhub_conf_organizations`.`organization` ASC;";
//echo $sq_org;
$rs_org = $cndb->dbQuery($sq_org);

$rs_count = $cndb->recordCount($rs_org); 

if( $rs_count > 0)
{

	while ($cn_org_a = $cndb->fetchRow($rs_org, 'assoc')) 
	{
		$cn_org  	= array_map("clean_output", $cn_org_a);

		$org_name	= ucwords($cn_org['organization']);
		$org_seo	= $cn_org['organization_seo'];
		$org_files	= $cn_org['num_resources'];
		$org_link 	= 'organization.php?rso='.$org_seo.'';
		
		$org_extras = '<div class="padd5"><span class="scrollDate nocaps txt13">Resources: <strong>'.$org_files . '</strong></span></div>';
		
		$org_logo 	= DISP_LOGOS.$cn_org['logo'];
			if (!file_exists(UPL_LOGOS.$cn_org['logo']) or $cn_org['logo'] == '') 
			{ $org_logo = DISP_LOGOS.'no_image.png'; }
		
		//$item_inst[] = '<li><div class="block equalized"><a href="'.$org_link.'" class="txt15"><span class="carChopa"><img src="'.$org_logo.'"  alt="" /></span>'.$org_name.'</a>'.$org_extras.'</div></li>';
		
		$item_inst[] = '<li><div class="block equalized"><a href="'.$org_link.'" class="carTitle">'.$org_name.'</a>'.$org_extras.'</div></li>';
		
		
	}

	$item_display = '<ul id="" class="column column_third">'. implode('', $item_inst) .'</ul>';
}				
else 
{
	$item_display = '<div class="warning">No Records Found!</div>';
}	

echo $item_display;
?>