<?php

include('../classes/cls.constants.php');

$dispData->siteGallery();

 $id=$_REQUEST['id']; 

$pic_list = '';

if($id)
{
	/* ************************************************************** 
	@ get images
	****************************************************************/
	
	if (array_key_exists($id, master::$listGallery['equip'])) 
	{ 
		foreach(master::$listGallery['equip'][$id] as $picVal)
		{
			$picArr 		= master::$listGallery['full'][$picVal]; //displayArray($picArr);
			$pic_id	    = $picArr['id'];
			$pic_title	  = $picArr['title'];
			$pic_name	   = $picArr['filename'];
			$pic_src 		= DISP_CA_GALLERY.$pic_name;
			$pic_disp	 = '<a href="#pic'.$pic_id.'" rel="modal:open" title="'.$pic_title.'"><img src="'.$pic_src.'" style="width:60px; height:40px;" /></a>';

			$pic_modal = '<div class="modal" id="pic'.$pic_id.'" ><div class="txtcenter"><img src="'.$pic_src.'" alt="" ><br>'.$pic_title.'</div></div>';
			
			$pic_list 	.= '<li>'.$pic_disp.'</li>'.$pic_modal.'';
		}
	}
	else
	{
		$pic_list = '<li> No Items </li>';
	}
	
}
echo $pic_list;
?>

