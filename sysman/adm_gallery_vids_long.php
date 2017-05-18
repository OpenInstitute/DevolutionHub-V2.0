<?php

include('../classes/cls.constants.php');

if(isset($_REQUEST['idp'])){
	$id=$_REQUEST['idp'];
	}else { $id=$_REQUEST['id']; }

if($id)
{
	
	$sqdata="SELECT `id`, `id_link`, `filename`, `title`, `description`, `published`, `filetype`, DATE_FORMAT(`date_posted`,'%b %d, %Y') as `date_posted`,  `id_gallery_cat` FROM `dhub_dt_gallery_photos` WHERE  (`id_link` = $id)";
	//echo $sqdata;
	
	$rsdata=$cndb->dbQuery($sqdata);
	$rsdata_count= $cndb->recordCount($rsdata);
	
	$gallery = '';
		if($rsdata_count>=1)
		{
			while($cndata= $cndb->fetchRow($rsdata))
			{
				$feat_lebo	="";
				$feat_chek	="";
				
				$id_photo			= $cndata[0];
				$id_content			= $cndata[1];
				
				$filename			= trim(html_entity_decode(stripslashes($cndata[2])));
				$title				= trim(html_entity_decode(stripslashes($cndata[3])));
				$description		= trim(html_entity_decode(stripslashes($cndata[4])));
				
				$date_posted		= $cndata[7];
				
				$galtype			= trim($cndata[6]);  if($galtype=='p') {$filetype = 'Picture';} else  {$filetype = 'Video';}
				
				$featured			= $cndata[8];
				$published			= $cndata[5]; 
				
				if($published==1) {$published="checked ";} else {$published="";}
				if($featured==1)  {$featured ="checked "; $feat_lebo = "color: red; font-weight: bold; "; }  else {$featured="";} 
				
				
			if($galtype=='p') 
			{
				$image				= $filename;
				$smallpic_insert 	= strrpos($image , ".");
				$smallpic			= substr_replace($image, '_t.', $smallpic_insert, 1);
				
				$image_title		= $image; //smartTruncateNew($image, 10, "", "...", "no");
				
				$image_disp	 = '<a rel="gal_group" href="'.DISP_GALLERY.$image.'"  title="'.$title.' -- '.$description.'">';
				$image_disp	.= '<img src="'.DISP_GALLERY.$smallpic.'" alt="" title="'.$image_title.'" />';
				$image_disp	.= '</a>';
			}
			elseif($galtype=='v') 
			{
					$v_insert 		= strrpos($filename, '/');
					$v_pic			= substr($filename, $v_insert);
					
					//$bImage	 		= 'http://i3.ytimg.com/vi'.$v_pic.'/mqdefault.jpg';
					//$bImageThmb		= $bImage;
					
					$image_disp = '<iframe src="http://img.youtube.com/vi'.$v_pic.'/mqdefault.jpg" height="70" width="110" style="padding:0; margin:0;" frameborder="0" scrolling="no"></iframe>';
					
			}
				
$gallery 	.= '<li><table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="4">'.$image_disp.'
	<div style="margin-top:10px;text-align:center"><!--<label>Type: '.$filetype.' </label>--></div> &nbsp;
	</td>
    <td>Title:</td>
    <td>
	<input type="text" name="caption['.$id_photo.']" value="'.$title.'" style="width:230px" />
	<input type="hidden" name="image['.$id_photo.']" value="'.$filename.'"/>
	<input type="hidden" name="galtype['.$id_photo.']" value="'.$galtype.'"/>
	
	</td>
  </tr>
  <tr>
    <td>Caption:</td>
    <td><textarea name="desc['.$id_photo.']"  style="width:230px; height:40px"> '.$description.'</textarea></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan=2>
	<label>Active: <input type="checkbox" name="show['.$id_photo.']" '.$published.' class="radio"/> </label> &nbsp;
	<label>Featured: <input type="radio" name="id_gallery_cat" '.$featured.' value="'.$id_photo.'" class="radio"/> </label>
	</td>
  </tr>

</table></li>';
	//<label>Featured: <input type="checkbox" name="id_gallery_cat['.$id_photo.']" '.$featured.' class="radio"/> </label>
			}
		}
	echo $gallery;
}
//echo $_REQUEST['idp'];
?>

