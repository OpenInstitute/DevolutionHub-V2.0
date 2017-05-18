<?php 
echo 'var ddData = '.scanDirectoryOne("../image/gallery/").''; 

function scanDirectoryOne($dirname)
{
	$html    = '';
	$fileArr = array();
	$images  = glob($dirname."*.*");
	$indx = 1;
	
	foreach($images as $key => $file) 
	{
		$supported_file = array( 'gif', 'jpg', 'jpeg', 'png' );
		
		$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		if (in_array($ext, $supported_file)) {
			
			$thumb = substr($file,-6,2);
			
			if($thumb <> '_t')
			{
				$filename = substr($file,strripos($file,"/" )+1);			
				//$html .= '<option value="'.$filename.'" data-imagesrc="'.$file.'">'.$filename.'</option>';
				
				$fileArr[] = array(
						'text' => ''.$filename.'',
						'value' => ''.$filename.'',
						'imageSrc' => ''.$file.''
					);
					
				$indx += 1;
			}
			
		} else {
			continue;
		}
	}
	return json_encode($fileArr);
}
?>