<style type="text/css">
	
</style>
<?php
//$sq_qry = "SELECT `download_type`, `res_type_seo` FROM `dhub_dt_downloads_type`  WHERE `download_type` <> '' and `published` ='1' order by `download_type`;";
$sq_qry = "SELECT
    `dhub_dt_downloads_type`.`download_type`
    , `dhub_dt_downloads_type`.`res_type_seo`
    , COUNT(`dhub_dt_downloads_parent`.`resource_id`) AS `num_resources`
FROM
    `dhub_dt_downloads_type`
    INNER JOIN `dhub_dt_downloads_parent` 
        ON (`dhub_dt_downloads_type`.`res_type_id` = `dhub_dt_downloads_parent`.`res_type_id`)
GROUP BY `dhub_dt_downloads_type`.`res_type_id` order by `dhub_dt_downloads_type`.`download_type` ASC;";
$rs_qry = $cndb->dbQuery($sq_qry);

$type_links = array();

$qrow = 0;
while ($cn_qry_a = $cndb->fetchRow($rs_qry, 'assoc')) 
{
	$cn_qry  	= array_map("clean_output", $cn_qry_a);
	
	$type_name 	= $cn_qry['download_type'];
	$type_seo 	= $cn_qry['res_type_seo'];
	$type_docs 	= $cn_qry['num_resources'];
	
	$rs_qry_active = ($com_cat_seo == $type_seo) ? ' class="current" ' : '';
	if($com_cat_seo == '' and $qrow == 0){ $rs_qry_active = ' class="current" '; $com_cat_seo = $type_seo; }
	//echo '<li><a href="rescat.php?com=5&formname=tag&county='.$county.'&dir_type='.$carr['download_type'].'" >'.$carr['download_type'].'</a> </li> ';
	$link = '<li><a href="'.RDR_REF_PATH.'?rsc='.$type_seo.'" '.$rs_qry_active.'>'.$type_name.'  <span class="nav_count">&nbsp;'.$type_docs.'&nbsp;</span></a> </li> ';
	$type_links[] = $link;
	
	$qrow += 1;
}

echo '<ul class="nav_side">';
echo implode('',$type_links);
echo '</ul>';
?>