<?php session_start();
require('../classes/cls.config.php');
require("includes/adm_functions.php");

if (isset($_POST['value'])){ $value=$_POST['value'];} else {$value=NULL;}
if (isset($_POST['act'])){ $act=$_POST['act'];} else {$act=NULL;}
if (isset($_POST['id'])){ $id=$_POST['id'];} else {$id=NULL;}
if (isset($_POST['wrappa'])){ $wrappa=$_POST['wrappa'];} else {$wrappa=NULL;}

$lebo_color_y = ' label-success';
$lebo_title['yes'] = ' Hide Article';
$lebo_color_n = ' label-danger';
$lebo_title['no'] = ' Show Article';
							
	//echo $act; exit;
if($act == 'togg_no' or $act == 'togg_yes')
{
	if($value == 'menus') { $h_tb = 'dhub_dt_menu'; }
	if($value == 'contents' or $value == 'events') { $h_tb = 'dhub_dt_content'; }
	if($value == 'image-and-video-uploads') { $h_tb = 'dhub_dt_gallery_photos'; }
	if($value == 'resource-library') { $h_tb = 'dhub_dt_downloads'; }
	
	
	$fieldLebo = '';
	
	$fieldAction = new hitsLog;	
	$result      = $fieldAction->togglePublished($h_tb,$id, $act);	
	
	$lebo_action = 'togg_'.$result;
	$lebo_text   = ucwords($result);
	$lebo_color  = ' class="label label-'.$result.'" ';
	
	
	if($value == 'menus') { saveJsonMenu(); }
	if($value == 'contents' or $value == 'events' or $value == 'profiles') { saveJsonContent(); }
	
	$fieldLebo = '<span id="visible__'.$id.'"><span'.$lebo_color.'><a href="javascript:;" onclick="javascript:Article_Operations(\'visible__'.$id.'\',\''.$lebo_action.'\', \''.$id.'\', \''.$value.'\');">'.$lebo_text.'</a></span></span>';
	
	
	echo $fieldLebo;
}
	
if($act == 'pos_add' or $act == 'pos_minus' )
{
	if($value == 'menus') 	{ $h_tb = 'dhub_dt_menu'; }
	if($value == 'contents') { $h_tb = 'dhub_dt_content'; }
	
	$posLebo = '';
	
	$posAction = new hitsLog;	
	$posNew    = $posAction->posUpdate($h_tb,$id, $act);	
	
	
	$posLebo = '<span id="pos__'.$id.'">'.$posNew.' <a href="javascript:;" onclick="javascript:Article_Operations(\'pos__'.$id.'\',\'pos_minus\', \''.$id.'\', \''.$value.'\');">-</a> <a href="javascript:;" onclick="javascript:Article_Operations(\'pos__'.$id.'\',\'pos_add\', \''.$id.'\', \''.$value.'\');">+</a></span>';
	
	
	echo $posLebo;
}



/*else 
{ //if($act)

	if($act == 'article') { $h_tb = 'kbicdc_dt_content'; }
	if($act == 'comment') { $h_tb = 'kbicdc_dt_content_posts'; }
	
	//echo $value; 
	$booking_lebo = '';
	$hitsUpdate = new hitsLog;	
	$result = $hitsUpdate->togglePublished($h_tb,$id, $value);	
	
	if($result == 'no') { $lebo_disp = 'No'; $send = 0; $lebo_color = $lebo_color_n; } 
	else { $lebo_disp = 'Yes';  $send = 1; $lebo_color = $lebo_color_y; }
	
	$booking_lebo = '<span class="label '.$lebo_color.'"><a href="javascript:;" onclick="javascript:Article_Operations(\'visible__'.$id.'\',\''.$act.'\', \''.$id.'\', \''.$result.'\');">'.ucwords($result).'</a></span>';
	//  title="'.$lebo_title[$result].'"
	echo $booking_lebo;
	
}*/

?>