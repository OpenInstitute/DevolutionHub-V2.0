<?php 
//phpinfo();
echo('62a77805e85ef4d5776e64336d48fdc18d11c7b6');
exit;	
require("classes/cls.constants.php"); 
include("classes/cls.paths.php");

/*displayArray($_SERVER);
displayArray(master::$menusSeo);
displayArray(master::$contMain);
exit;*/
$dispData->siteDocuments();
displayArray(master::$listResources['full']);
exit;

/*$password = 'ellipsis2015@@cave_';
$salt  = '1f3f72';
echobr( $salt . substr(sha1($salt . $password), 0, 6)); //-$this->salt_length
echobr(sha1($password . $salt));*/

exit;




$sq_d = "SELECT
    `oc_county`.`county_id`, `oc_county`.`county`
FROM
    `oc_county`;";
$rs_d = $cndb->dbQueryFetch($sq_d);
echobr('rage');
foreach($rs_d as $c => $carr){
	echo '<li><a href="county.php?cid='.$carr['county'].'" >'.$carr['county'].'</a> </li> ';
}	






//unset($_SESSION); session_destroy();

/* $sq = "SELECT * FROM `dhub_conf_choices` where `choice_cat` = 'county'";
$rs = $cndb->dbQueryFetch($sq);
$kev= '';
foreach($rs as $k => $cc){
	$kev .= '<a href="?tag='.strtolower($cc['choice_item']).'" class="btn btn-primary">'.$cc['choice_item'].'</a> &nbsp; ';
}
echobr($kev);
displayArray($rs);*/


displayArray($_SESSION);exit;
//displayArray($_SERVER);exit;
//$productDetail = $dispShop->get_product_detail($pd);

displayArray($_SESSION['sess_jtsl_shop_order']); exit;
displayArray(master::$menuBundle); exit;
		
displayArray(master::$shopCategories['full']);
//displayArray(master::$contMain['full'][501]);


/*$rage = array_merge_recursive(master::$contMain['section'][6],master::$contMain['section'][7]);

displayArray(master::$contMain['section'][7]);
displayArray($rage);*/
//

/*if(count(master::$contJsonNews) == 0)		//$dispData->contNews
{ $dispData->siteNewsJson(); }
displayArray(master::$contJsonEvents);
displayArray(master::$contJsonNews); exit;
*/
//$dispData->buildContent_Arr();
//displayArray(master::$menuToContents); 
//displayArray(master::$contMainNew);





?>



<table width="100%" border="1" cellspacing="2" cellpadding="2">
	<tr>
		<?php /*?><td style="width:400px">contMain</td>
		<td style="width:400px">contLong</td>
		<td style="width:400px">contMainNew</td><?php */?>
		
		<td style="width:200px">menusFull</td>
		<td>menusType</td>
		<td>menusChild</td>
		<td>menusMom</td>
		<td>listGallery</td>
		<td>listGallery_top</td>
		<td>listGallery_long</td>
	</tr>
	<tr>
		<?php /*?><td valign="top" style="width:400px !important;"><?php displayArray($dispData->contMain); ?></td>
		<td valign="top"><?php displayArray($dispData->contLong); ?></td>
		<td valign="top"><?php displayArray(master::$contMainNew); ?></td>
		<?php */?>
		<td valign="top"><?php displayArray(master::$menusFull); ?></td>
		<td valign="top"><?php displayArray(master::$menusType); ?></td>
		<td valign="top"><?php displayArray(master::$menusChild); ?></td>
		<td valign="top"><?php displayArray(master::$menusMom); ?></td>
		<td valign="top"><?php displayArray(master::$listGallery); ?></td>
		<td valign="top"><?php $dispData->siteGalleryTop(); displayArray(master::$listGallery_top); ?></td>
		<td valign="top"><?php displayArray(master::$listGallery['full']); ?></td>
	</tr>
</table>
