<?php 
require("../classes/cls.constants.php"); 

/*if (!isset($sys_us_admin['adminname'])) 
{  echo "Your session has expired. <p><a href=\"index.php\">Click here</a> to log in again."; exit; }*/



$sqstaff_prof = "SELECT `id`, `email`, `published`, `password` FROM `afp_conf_person_list`";

$rsstaff_prof = $cndb->dbQuery($sqstaff_prof);
$rsstaff_prof_count =  $cndb->recordCount($rsstaff_prof);

if($rsstaff_prof_count > 0)
{
	while($cndata = $cndb->fetchRow($rsstaff_prof))
	{
		$id_user   = $cndata[0];
		$email	 = $cndata[1];
		$password	 = $cndata['password'];
		$published	 = $cndata['published'];
		
		if($password == '') { $password = '123456'; }
		$passhash  = md5($password);
		
		
		$seq_update[] = " insert IGNORE into `afp_conf_person_login` (`id_account`, `ac_username`, `ac_password`, `published` ) values ('".$id_user."',  ".quote_smart($email).", '".$passhash."', '".$published."') ; ";
		
			
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

