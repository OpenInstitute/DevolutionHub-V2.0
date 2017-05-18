<style type="text/css">
	
</style>
<?php
$qrow 			= 0;
$res_county 	= $dispDt->get_resCounties(); 
$county_links	= array();
foreach ($res_county as $rc => $rc_arr) { 	
	$ct_name 	= $rc_arr['county'];
	$ct_seo 	= $rc_arr['county_seo'];
	$ct_docs 	= $rc_arr['num_resources']; /*county.php*/
	
	$rs_qry_active = ($com_county == $ct_seo) ? ' class="current" ' : '';
	if($com_county == '' and $qrow == 0){ $rs_qry_active = ' class="current" '; $com_county = $ct_seo; }
	
	$link 		= '<li><a href="counties/?county='.$ct_seo.'" title="Resources: '.$ct_docs.'" '.$rs_qry_active.'>'.$ct_name.'   <span class="nav_count">&nbsp;'.$ct_docs.'&nbsp;</span></a> </li> ';
	$county_links[] = $link;
	
	$qrow += 1;
}

echo '<div class="nano" style="height:300px;overflow:hidden;"><div class="nano-content padd10_r">';
echo '<ul class="nav_side">';
echo implode('',$county_links);
echo '</ul>';
echo '</div></div>';

?>