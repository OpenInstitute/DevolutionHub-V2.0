<?php 
require("../classes/cls.constants.php"); 

//if (!isset($sys_us_admin['adminname'])) 
//{  echo "Your session has expired. <p><a href=\"index.php\">Click here</a> to log in again."; exit; }


setlocale(LC_ALL, 'en_US.UTF8');

/* takes the input, scrubs bad characters */
function generate_seo_link($str, $delimiter='-', $remove_words = true, $words_array = array()) {
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));	
	if($remove_words) { $clean = remove_words($clean, $delimiter, $words_array); }	
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

/* takes an input, scrubs unnecessary words */
function remove_words($input,$replace,$words_array = array(),$unique_words = true)
{
	$input_array = explode(' ',$input);
	$return = array();

	//loops through words, remove bad words, keep good ones
	foreach($input_array as $word)
	{
		//if it's a word we should add...
		if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
		{
			$return[] = $word;
		}
	}
	return implode($replace,$return);
}

$bad_words = array('a','and','the','an','it','is','with','can','of','why','not');




$sqstaff_prof = "SELECT `id`, `title`, `link_seo` FROM `".$pdb_prefix."dt_downloads`  ;"; //WHERE isnull(`link_seo`) or `link_seo` = ''

$rsstaff_prof = $cndb->dbQuery($sqstaff_prof);
$rsstaff_prof_count =  $cndb->recordCount($rsstaff_prof);

if($rsstaff_prof_count > 0)
{
	while($cndata =  $cndb->fetchRow($rsstaff_prof))
	{
	$id 	     = trim($cndata[0]);
	$title	  = trim(html_entity_decode(stripslashes($cndata[1])));
	
	//$link_seo   = generate_seo_link($title, '-', true, $bad_words);
	//$seq_update[] = " update `".$pdb_prefix."dt_downloads` set `link_seo` = ".quote_smart($link_seo)." where `id` = '".$id."'; ";
			
		$seq_update[] = " insert into `".$pdb_prefix."dt_downloads_parent` (`id_download`,`id_content`) values ('".$id."', '".rand(1,20)."'); ";
			
	}

	//displayArray($seq_update); exit;
	
	
	$num_updates = count($seq_update);
	if( $num_updates > 0)
	{
		$type = new posts;
		$type->inserter_multi($seq_update);
		unset($seq_update);	
		echo "Updated ".$num_updates." Records.";
		exit;
	}
	else
	{
		echo "URL Codes valid. No Update.";
		exit;
	}
}
else
{ echo "Empty recordset!"; exit; }



?>

