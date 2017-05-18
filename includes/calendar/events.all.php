<?php	
require_once("../../classes/cls.config.php");
require_once("../../classes/cls.formats.php");
require_once("../../classes/cls.sessions.php");

//displayArray($sess_mbr);


	$sq_crit = " WHERE `dhub_dt_content`.`published` = '1'  AND `dhub_dt_content`.`approved` = '1' ";

$sq_events_up = "SELECT `dhub_dt_content_dates`.`id_content`
    ,    UNIX_TIMESTAMP(`dhub_dt_content_dates`.`date`) AS `date`
    ,  `dhub_dt_content`.`arr_extras` AS `location`
	 ,  `dhub_dt_content`.`url_title_article`
	 ,  `dhub_dt_content`.`article`
	, `dhub_dt_content`.`title`
	, DATE_FORMAT(`dhub_dt_content_dates`.`date`, '%Y%m%d') as `ev_date`
	, DATE_FORMAT(`dhub_dt_content_dates`.`date`,'%l:%i %p') AS `ev_time_start`
FROM
    `dhub_dt_content_dates`
    INNER JOIN `dhub_dt_content` 
        ON (`dhub_dt_content_dates`.`id_content` = `dhub_dt_content`.`id`)
   ".$sq_crit."
ORDER BY `dhub_dt_content_dates`.`date` DESC ;"; 
//echo $sq_events_up;
/*GROUP BY `dhub_dt_content`.`title`, `dhub_dt_content_dates`.`id_content`*/



	//echo $sq_events_up;
	//`dhub_dt_content_dates`.`date` >=CURRENT_DATE() and 
	$rs_events_up=$cndb->dbQuery($sq_events_up);
	$rs_events_up_count=$cndb->recordCount($rs_events_up);
	
	$eventContent = '';
	$eventContentb = array();

	if($rs_events_up_count>0)
	{
		$r=1;	
	while($cn_events_up=$cndb->fetchRow($rs_events_up))
		{
			$evid       = $cn_events_up['id_content'];
			$evdate     = date('Y-m-d H:i:00', $cn_events_up['date']); 
			$evtime     = $cn_events_up['ev_time_start'];
			$evcom      = $evid;
			
			$evtitle 	= clean_output($cn_events_up['title']); 
			$evurl 	  	= $cn_events_up['url_title_article'];
			$evarticle  = strip_tags_clean(clean_output($cn_events_up['article'])); 
			$evbrief 	= smartTruncateNew($evarticle, 250);
			
			
			$eventContent .= '  { "date": "'.$evdate.'000", "type": "event", "title": "'.$evtitle.'", "description": "'.$evbrief.'", "url": "'.$evid.'/'.$evurl.'/", "time": "'.$evtime.'" }';
			
			/*$eventContent .= '  { "date": "'.$evdate.'000", "type": "event", "title": "'.$evtitle.'", "description": "'.$evbrief.'", "datahref": "ajforms.php?d=cont_event&item='.$evid.'" }';*/
			
			$eventContentb[] = array(
				"date" => "".$evdate."000", 
				"type" => "event", 
				"title"=> "".$evtitle."", 
				"description"=> "".$evbrief."", 
				"url"=> "".$evid."/".$evurl."/", 
				"time"=> "".$evtime.""
			);
			
			
			if($r < $rs_events_up_count) { $eventContent .= ','; }
			$r++;
		}

		//displayArray($eventContentb);
/*echo '[';
echo $eventContent;
echo ']';*/
		echo json_encode($eventContentb);
	}
?>

   
