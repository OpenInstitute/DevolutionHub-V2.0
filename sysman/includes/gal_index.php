<?php

require 'config.php';
require 'functions.php';

if(isset($_FILES['fupload'])) {
	
	$img_mimetypes = array("image/jpeg","image/jpe","image/jpg","image/pjpeg","image/gif","image/png","image/x-png");
	$image_details = getimagesize($_FILES['fupload']['tmp_name']);
//	var_dump($image_details);
	$mimetype = $image_details['mime'];
	$image_size = $_FILES['fupload']['size'];
	
	$img_ext = ".".getFileExtension(strtolower($_FILES['fupload']['name']));
	$img_new_name =  getRandomName().$img_ext;
	//echo $img_new_name; exit;
	
	if(in_array($mimetype, $img_mimetypes))
	{
		$filename = $img_new_name; //$_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];	
		$target = $path_to_image_directory . $filename;
		
		move_uploaded_file($source, $target);
		
		createThumbnail($filename, $image_details);		
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="" />
	<title>Dynamic Thumbnails</title>
</head>

<body>
	<h1>Upload A File, Man!</h1>
	<form enctype="multipart/form-data" action="" method="post">
		<input type="file" name="fupload" />
		<input type="submit" value="Go!" />
	</form>
</body>
</html>
