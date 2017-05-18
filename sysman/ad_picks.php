<?php
require("../classes/cls.constants.php"); 


$drop_counties_sub = '';

if (!empty($_GET['required'])) { $required = trim($_GET['required']); } 
if (!empty($_GET['sector_id']))   { $sector_id = trim(htmlentities($_GET['sector_id'])); } else { $sector_id = ''; }
if (!empty($_GET['project_id']))   { $project_id = trim(htmlentities($_GET['project_id'])); } else { $project_id = ''; }
if (!empty($_GET['fcall']))    { $fcall = trim(htmlentities($_GET['fcall'])); } else { $fcall = ''; }
if (!empty($_GET['furl']))    { $furl = trim(htmlentities($_GET['furl'])); } else { $furl = ''; }
if (!empty($_GET['op']))       { $op = trim(htmlentities($_GET['op'])); } else { $op = ''; }



$opts  = "";
$out   = 'Previous Field Required.';



/*-------------------------------------------------------------------------------------------------------
	@@ APP PROJECTS
-------------------------------------------------------------------------------------------------------*/
if ($fcall == 'app_projects') 
{
	$ad_items = '<option value="">Select Project</option>';
	
	
	$sqdata_m = "SELECT `project_id`, `pname` FROM `dhub_app_project` WHERE (`published`=1 and `sector_id` = ".quote_smart($sector_id)."); ";
	
	$rsdata_m=$cndb->dbQuery($sqdata_m);
	if( $cndb->recordCount($rsdata_m)) 
	{
		while($cndata_m = $cndb->fetchRow($rsdata_m))
		{
			$selected = '';
			if($cndata_m[0] == $project_id) { $selected = ' selected '; }
			$ad_items .= '<option value="'.$cndata_m[0].'" '.$selected.'>'.clean_output($cndata_m[1]).'</option>'; 
		}
		
		$out = '<select name="project_id" id="project_id" class="form-control" >';
		$out .= $ad_items;
		$out .= '</select>';
	}	
	else
	{
		$out = '<input name="project_id" id="project_id" type="text" readonly placeholder="Select Project" />';
	}
}	



/*-------------------------------------------------------------------------------------------------------
	@@ CA EQUIPMENTS GALLERY
-------------------------------------------------------------------------------------------------------*/
if ($fcall == 'eq_pics') 
{
	$pic_list = '';
	
	if($eqp_id)
	{
		/* ************************************************************** 
		@ get images
		****************************************************************/
		
		if (array_key_exists($eqp_id, master::$listGallery['equip']) and count(master::$listGallery['equip'][$eqp_id]) > 1) 
		{ 
			foreach(master::$listGallery['equip'][$eqp_id] as $picVal)
			{
				$picArr 		= master::$listGallery['full'][$picVal]; //displayArray($picArr);
				$pic_id	    = $picArr['id'];
				$pic_title	  = $picArr['title'];
				$pic_name	   = $picArr['filename'];
				$pic_src 		= DISP_CA_GALLERY.$pic_name;
				$pic_disp	 = '<a href="#pic'.$pic_id.'" rel="modal:open" title="'.$pic_title.'"><img src="'.$pic_src.'" alt="" /></a>';
	
				$pic_modal = '<div class="modal modal-white" id="pic'.$pic_id.'" ><div class="txtcenter"><img src="'.$pic_src.'" alt="" ><br>'.$pic_title.'</div></div>';
				
				$pic_list 	.= '<li>'.$pic_disp.'</li>'.$pic_modal.'';
			}
		}
		
	}
	
	$out = '';
	if($pic_list <> ''){
		$out = '<ul class="mini-column">';
		$out .= $pic_list;
		$out .= '</ul>';
	} 
	
}




echo $out;

?>

