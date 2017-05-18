<div style="padding:2px; text-align:right; font-size:14px; font-weight:bold;"> <a href="adm_polls.php?d=<?php echo $dir; ?>&op=new" style="color:#FF0000">[ Add New ]</a> </div>
<?php


	$sqList = "SELECT
    `dhub_poll_questions`.`qid` AS `id`
    , `dhub_poll_questions`.`date` as `date created`
    , `dhub_poll_questions`.`question` AS `title`
    , SUM(`dhub_poll_responses`.`votes`) AS `votes`
    , `dhub_poll_questions`.`show` AS `current`
FROM
    `dhub_poll_questions`
    INNER JOIN `dhub_poll_responses` 
        ON (`dhub_poll_questions`.`qid` = `dhub_poll_responses`.`qid`)
GROUP BY `id`, `dhub_poll_questions`.`date`, `title`
ORDER BY `votes` DESC, `dhub_poll_questions`.`date` DESC;"; 
	//echo $sqList; //`subject` AS `category`, 
	
	echo $m2_data->getData($sqList,"adm_polls.php?d=$dir&");
		  

?>
