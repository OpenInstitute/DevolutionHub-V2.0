<?php require("cls.config.php"); 

function displayArray($array)    { echo "<pre>"; print_r($array); echo "</pre><hr />"; }
function clean_output($str, $useBreak=0) { if($useBreak){ $str = nl2br($str); } $patterns[0] = "/`/"; $patterns[1] = "/’/";  $str = trim(html_entity_decode(stripslashes($str),ENT_QUOTES,'UTF-8'));	 $str = iconv("ISO-8859-15", "UTF-8", iconv("UTF-8", "ISO-8859-15//IGNORE", $str));  return $str; } 
function clean_escape($value) { $cndb = new master(); $value = $cndb->quote_si($value);  return $value; }
	

$masterResource = array();
$sq_resource_date = "SELECT UNIX_TIMESTAMP(MAX(`date_updated`)) FROM `dhub_dt_downloads`; ";
$rs_resource_date = $cndb->dbQuery($sq_resource_date);
$cn_resource_date = $cndb->fetchRow($rs_resource_date);
$date_update 	 = $cn_resource_date[0];


/*
`dhub_dt_downloads`.`resource_id`
    , `dhub_dt_downloads_parent`.`id_menu`
    , `dhub_dt_downloads_parent`.`id_content`
    , `dhub_dt_downloads`.`date_created`
    , `dhub_dt_downloads`.`resource_title` as `title`
    , `dhub_dt_downloads`.`resource_description` AS `description`
    , `dhub_dt_downloads`.`resource_file` AS `filename`
    , `dhub_dt_downloads`.`resource_extension` AS `filetype`
    , `dhub_dt_downloads`.`resource_size` AS `filesize`
    , `dhub_dt_downloads`.`featured`
    , `dhub_dt_downloads`.`hits`
	, `dhub_dt_downloads`.`resource_slug` as `link_seo`
	, `dhub_dt_downloads`.`date_updated`
	, `dhub_dt_downloads`.`resource_image` as `attachment`
	, `dhub_dt_downloads`.`publisher` as `author`
	, `dhub_dt_downloads`.`language`
*/
		
$sq_resource = "SELECT
    dhub_dt_downloads.*
    , `dhub_dt_downloads_parent`.`id_menu`
    , `dhub_dt_downloads_parent`.`id_content`
FROM
    `dhub_dt_downloads`
    LEFT JOIN `dhub_dt_downloads_parent` 
        ON (`dhub_dt_downloads`.`resource_id` = `dhub_dt_downloads_parent`.`resource_id`)
WHERE (`dhub_dt_downloads`.`published` =1)
ORDER BY `dhub_dt_downloads`.`date_updated` DESC; ";


$rs_resource = $cndb->dbQuery($sq_resource);
$rs_resource_count = $cndb->recordCount($rs_resource);

if($rs_resource_count>=1)
{
	
	while($cn_resource = $cndb->fetchRow($rs_resource, 'assoc'))
	{
		
		
			$mod_date = strtotime($cn_resource['date_updated']);
			
			$id_file			= $cn_resource['resource_id'];
			$item_date		   	= strtotime($cn_resource['date_created']);
			
			$item_name		   	= clean_output($cn_resource['resource_file']);
			$item_title		  	= clean_output($cn_resource['resource_title']);
			$item_type		  	= clean_output($cn_resource['content_type']);
			$item_article		= clean_output($cn_resource['resource_description']);
			$item_brief			= htmlentities(strip_tags($item_article, '<img>'));
			
			$item_author		= clean_output($cn_resource['publisher']);
			$item_language		= clean_output($cn_resource['language']);
			$item_cover			= clean_output($cn_resource['resource_image']);
			
			$id_content   		= $cn_resource['id_content'];
			$id_link 	  		= $cn_resource['id_menu'];	
			
			$featured 	 		= $cn_resource['featured'];		
			$file_seo	 		= $cn_resource['resource_slug'];
			
						
			if($id_link <> 0)      { $pic_parent = '_link'; $pic_parent_id = $id_link; }
			if($id_content <> 0)   { $pic_parent = '_cont'; $pic_parent_id = $id_content; }
			
			$pic_parent = '_link'; $pic_parent_id = 5;
		
			$files 	= array(
				'cont_id' 	 		=> ''.$id_file.'',
				'cont_date'     	=> ''.$item_date.'',
				'cont_title'    	=> ''.$item_title.'',
				'cont_name'    		=> ''.$item_name.'',
				'cont_type'    		=> ''.$item_type.'',
				'cont_brief' 		=> ''.$item_brief.'',
				'cont_author' 		=> ''.$item_author.'',
				'cont_language' 	=> ''.$item_language.'',
				'cont_parent_type' 	=> ''.$pic_parent.'',
				'cont_parent_id'  	=> 	''.$pic_parent_id.'',				
				'cont_seo'       	=> 	''.$file_seo.'',
				'cont_cover'       	=> 	''.$item_cover.'',
				
				'source_url' 		=> ''.clean_output($cn_resource['source_url']).'',
				'resource_size' 		=> ''.clean_output($cn_resource['resource_size']).'',
				'resource_tags' 		=> ''.clean_output($cn_resource['resource_tags']).'',
				'county' 		=> ''.clean_output($cn_resource['county']).'',
				'resource_extension' 		=> ''.clean_output($cn_resource['resource_extension']).'',
				'devolved_functions' 		=> ''.clean_output($cn_resource['devolved_functions']).'',
				'alternative_title' 		=> ''.clean_output($cn_resource['alternative_title']).'',
				'year_published' 		=> ''.clean_output($cn_resource['year_published']).''
			);
			
			$masterResource['full'][$id_file] = $files; 
			$masterResource['_seo'][$file_seo] = $id_file;
			$masterResource[''.$pic_parent.''][$pic_parent_id][$id_file] = $id_file; 
							
				if($featured == 1)
				{   $masterResource['_feat'][$id_file] = $id_file; }						
						
		//displayArray($cn_resource);
		//displayArray($masterResource); exit;
	}
}
		
$masterResource['_modstamp'] = $date_update;	
//displayArray($masterResource); exit;

$cachResource = serialize($masterResource);	
$sq_cach_resource  = " replace into `dhub_cache_vars` ( `cache_id`, `cache_date`, `cache_data` ) values ('resourceChest', ".$cndb->quote_si($date_update).", ".$cndb->quote_si($cachResource).");";
$rs_cach_resource  = $cndb->dbQuery($sq_cach_resource);
echo $date_update .' - '. date('Y-m-d H:i:a',$date_update); 

?>