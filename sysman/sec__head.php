<?php
require '../classes/cls.constants.php';

if (!isset($sys_us_admin['adminname'])) 
	{ 
	echo "Your session has expired. <p><a href=\"index.php\">Click here</a> to log in again.";
	exit;
	}
$admLinksTop = array();
	if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
	if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	if(isset($_REQUEST['fcall'])) { $fcall=$_REQUEST['fcall']; } else { $fcall=NULL; }
	if($op=="edit"){ $title_new	= "Edit "; } elseif($op=="new") { $title_new	= "New "; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="shortcut icon" href="../image/logo_favicon.png" type="image/png" />

<title>Admin:: <?php echo SITE_TITLE_LONG; ?></title>

<link rel="stylesheet" type="text/css" href="../styles/base_styles.css" />
<link rel="stylesheet" type="text/css" href="styles/style.css" />

<link rel="stylesheet" type="text/css" href="../styles/base_forms_new.css" />
<link rel="stylesheet" type="text/css" href="../styles/fonts/font-awesome/font-awesome.css" />
<link rel="stylesheet" type="text/css" href="../scripts/multiselect/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="../scripts/multiselect/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="../scripts/datatable/jquery.dataTables.css" />

<link rel="stylesheet" type="text/css" href="../styles/smoothness/jquery-ui-1.10.2.css" />
<link rel="stylesheet" type="text/css" href="../styles/smoothness/jquery-ui-1.8.4.custom.css" />
<link rel="stylesheet" type="text/css" href="../scripts/datatable/jquery.dataTables.override.css" />
<link rel="stylesheet" type="text/css" href="../styles/base_overrides.css" />
  
<script type="text/javascript" src="../scripts/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.2.min.js"></script>

<script type="text/javascript" src="../scripts/multiselect/jquery.multiselect.js"></script>
<script type="text/javascript" src="../scripts/multiselect/jquery.multiselect.filter.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){ $("select.multiple").multiselect().multiselectfilter(); });
</script>
<style type="text/css">
label { line-height: 34px;}
.rwdform.rwdfull .form-group label {/* max-width: 180px;*/ border:0px solid; font-weight: 700; padding-left: 5px;}
.rwdform.rwdfull .form-group label small {color: #999;
    display: inline-block;
    font-size: 11px;
    font-weight: normal;
    line-height: 13px;
    margin-top: 3px;
    text-transform: none;}
.rwdform.rwdfull .form-group div { float:left; }

select option.op_notpublished,
option.op_notpublished { text-decoration:line-through !important; color:#009900 !important;  }
</style>

<style type="text/css" media="all">
@import url('../styles/reset.css');
@import url('../scripts/bootstrap/css/bootstrap.min.css');

@import url('../styles/base_styles.css');
@import url('../styles/base_forms.css');
@import url('../styles/base_grid.css');
@import url('../styles/base_overrides.css');

</style>

<?php
if($this_page <> "home.php") {
//$dispData->siteMenu_portal(1);
}
?>
<link rel="stylesheet" href="../scripts/datepick/jquery.datepick.css" id="theme"> 
<script type="text/javascript" src="../scripts/datepick/jquery.plugin.js"></script>
<script type="text/javascript" src="../scripts/datepick/jquery.datepick.js"></script>

<!-- page specific scripts -->
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){ $('.date-pick').datepick({dateFormat: 'mm/dd/yyyy' }); });
</script>



<?php
if(	$this_page == "adm_profiles.php" or $this_page == "adm_articles.php" or 
	$this_page == "adm_gallery_albums.php" or $this_page == "adm_gallery_video.php")
{
?>
<script type="text/javascript">
	<!--
	function startUpload(){
		  document.getElementById('f1_upload_process').style.visibility = 'visible';
		  //document.getElementById('f1_upload_form').style.visibility = 'hidden';
		  return true;
	}
	
	function stopUpload(success, the_file){
		  var result = '';
		  if (success == 1){
			 result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
		  }
		  else {
			 result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
		  }
		  
		  $(function(){
		  	var isuccess = success;
			var ifile = the_file;
			
			if (success == 1){
		  		showUpload();
				$('<li></li>').appendTo('#files').html('<img src="<?php //echo DISP_GALLERY; ?>'+ifile+'" alt="" /><br />'+ifile).addClass('success');
			 }
		  	else {
				$('<li></li>').appendTo('#files').text(ifile).addClass('error');
			}
		  });
		  document.getElementById('f1_upload_process').style.visibility = 'hidden';   
		  document.getElementById('image_title').value = '';   
		  document.getElementById('image_myfile').value = '';  
		  return true;   
	}
	
	function showUpload(){
		  $(document).ready(function(){
				<?php if($this_page == "adm_gallery_albums.php") { ?>
				
				$.get('adm_gallery_pics_long.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
					$('#files_long').html(data);
					var loadedpics = data.length;
					if(loadedpics < 10) { $('#edit_photo_submit').css("display", "none"); }
				});
				
				<?php } elseif($this_page == "adm_gallery_video.php") { ?>
				
				$.get('adm_gallery_vids_long.php?idp=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
				 $('#files_long').html(data);
				});
				
				<?php } elseif($this_page == "adm_articles.php") { ?>
				
				$.get('adm_gallery_pics.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
				$('#files').html(data);
				});
				<?php }  elseif($this_page == "adm_profiles.php") { ?>
				
				$.get('adm_profiles_pics.php?id=<?php echo $id; ?>&token=<?php echo time(); ?>', function(data) {
				$('#files_long').html(data);
				});
				<?php } ?>
				
				  
		   });
	}
	
	$(document).ready(function(){
		showUpload();
	 });
	//-->
</script>
<?php
}
?>

<script src="scripts/adm_validation.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="../scripts/jquery.validate.js"></script>-->
<script type="text/javascript" src="scripts/jquery.autoresize.js"></script>

<?php $loader_icon = '<img src="../image/icons/a-loader.gif" alt="loading..."  />'; ?>

</head>

<body>


<?php
if( $this_page == "adm_menus.php" or $this_page == "adm_articles.php" or $this_page == "adm_gallery_singles.php" or 
    $this_page == "adm_downloads.php" or $this_page == "adm_events.php" or $this_page == "adm_articles_multi.php")
{ $dispData->buildMenu_Arr(); }


if( $this_page == "adm_gallery_singles.php" or $this_page == "adm_downloads.php"  or $this_page == "adm_gallery_albums.php")
{ $dispData->buildContent_Arr(); }

?>
<div id="paging_wrap">
<!-- @begin :: admin banner -->
<div style="padding-bottom:10px;" class="ui-helper-clearfix">
	<?php include("includes/adm__banner.php"); ?>
	<?php include("includes/adm__links_top.php"); ?>
	<div class="clear"></div>
</div>
<!-- @end :: admin banner -->

<div style="margin:0px auto; padding:0px; width:95%;">

<!-- @begin :: admin menu -->
<!--<?php //include("includes/adm__links_top.php"); ?>-->
<!-- @end :: admin menu -->

<div class="clear"></div>
