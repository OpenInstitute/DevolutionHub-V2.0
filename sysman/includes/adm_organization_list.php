<div style="padding:10px 2px; text-align:right; font-size:14px; font-weight:bold;">
<?php /*?>
<a href="adm_profiles.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ ADD NEW ]</a> 
<?php */?>
</div>
<?php

$sqCrit ="";



$sqList = "SELECT
    `dhub_conf_organizations`.`organization_id` as `id`
	, `dhub_conf_organizations`.`date_update` as `dated`
    , `dhub_conf_organizations`.`organization` as `title`
    , `dhub_conf_organizations`.`organization_website` as `website`
	, `dhub_conf_organizations`.`organization_phone` as `phone`
	, `dhub_conf_organizations`.`organization_email` as `org_email`
    , concat_ws(' ', `dhub_reg_account`.`namefirst` , `dhub_reg_account`.`namelast`) as `contact`
    , `dhub_reg_account`.`email` as `contact email`
    , `dhub_conf_organizations`.`is_partner` as `partner`
    , `dhub_conf_organizations`.`published` as `active`
FROM
    `dhub_conf_organizations`
    LEFT JOIN `dhub_reg_account` ON (`dhub_conf_organizations`.`contact_id` = `dhub_reg_account`.`account_id`)
ORDER BY `dhub_conf_organizations`.`organization_id` DESC;";


  echo $m2_data->getData($sqList,"hforms.php?d=$dir&");
		  

?>
