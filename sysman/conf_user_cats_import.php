<?php 
require("../classes/cls.constants.php"); 

if (!isset($sys_us_admin['adminname'])) 
{  echo "Your session has expired. <p><a href=\"index.php\">Click here</a> to log in again."; exit; }

$sqstaff_prof = "SELECT `id`, `import_cat` FROM `dhub_reg_users` WHERE (`import_cat` <> '0')"; // and `published` = '1'

$rsstaff_prof = $cndb->dbQuery($sqstaff_prof);
$rsstaff_prof_count =  $cndb->recordCount($rsstaff_prof);

if($rsstaff_prof_count > 0)
{
	while($cndata =  $cndb->fetchRow($rsstaff_prof))
	{
		$id_user 	   = $cndata[0];
		$id_user_cat	 = $cndata[1];
		
		$seq_update[] = " insert IGNORE into `dhub_reg_cats_links` (`id_user_cat`,`id_user` ) values ('".$id_user_cat."',  '".$id_user."') ; ";
		
			
	}

	//displayArray($seq_update); exit;
	$user_updates = count($seq_update);
	if( $user_updates > 0)
	{
		$type = new posts;
		$type->inserter_multi($seq_update);
		unset($seq_update);	
		echo "Updated ".$user_updates." Records.";
		exit;
	}
	else
	{
		echo "No Update.";
		exit;
	}
}
else
{ echo "Empty recordset!"; exit; }



?>

