<?php
require("../classes/cls.condb.php"); 

function displayArray($array)    { echo "<pre>"; print_r($array); echo "</pre><hr />"; }

$db = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die ('Could not connect to the database.');
mysql_select_db(DB_NAME);


$query = "SELECT `id`  , `account_name` as `name`, `account_category` as `category`, `contacts` , `telephone` as `phone` , `email`,`county`, concat_ws(' ' , `sub_county` , `location`) as `location` , `account_speciality` as `speciality`, `published` as `active` FROM `dhub_app_vw_directory` ";
//echo $query;

$result 	= $cndb->dbQuery($query); 
$rs_fields = mysqli_num_fields($result);

if( $cndb->recordCount($result)) {
	while($post = $cndb->fetchRow($result)) {
		//$posts[] = array('post'=>$post);
		$fData = array();
		for ($i = 0; $i<$rs_fields; $i++)
		{
			$field_names[$i] = mysql_fetch_field($result, $i);			
			$fData[] = $post[$field_names[$i]->name];
		}	
		$posts[] = $fData;
	}
}

//displayArray($posts); //exit;
header('Content-type: application/json');
echo json_encode(array('aaData'=>$posts));
		

?>