<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>



<?php

$sector_id = '';
$project_id = '';
	
	//displayArray(master::$menusFull);
	
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }


	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; $id = 60;}
	
if($op=="edit")
{

// ############################################################
	include("includes/adm_form_gallery_edit.php");
// ############################################################		
	
} 
elseif($op=="new")
{
	$article_title = '';
	$file_caption = '';
	$id					= "";
		$id_parent1			= "";
		$id_parent2			= "";
		$title				= "";
		$description			= "";
		$published			="checked ";		
		$formname			= "gallery_album_new";
		$file_name_v	     = "https://www.youtube.com/watch?v=";
		
		
		$checked_vid = "";
		$checked_pic = "";
		
		$checked_vid_box = '  style="display: none; " ';
		$checked_pic_box = ''; //'  style="display: none; " ';
		$require_pic_title = '';
		$require_vid_title = '';
		
	if($dir == "video gallery") { $checked_vid = " checked "; $checked_vid_box = ''; $require_vid_title = 'required'; }
	if($dir == "photo gallery") {} $checked_pic = " checked "; $checked_pic_box = ''; $require_pic_title = 'required'; 


include("includes/adm_form_gallery_add.php");

}

	?>


	
</div>
</div>

<script type="text/javascript" src="../scripts/validate/jquery.validate.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$('label.required').append('&nbsp;<span class="rq">*</span>&nbsp;');
	$('textarea').autoResize({extraSpace : 10 });
	
	
	$("#add_video").click(function () { 
		$("#file_box_video").show(); $("#file_box_photo").hide(); 
		$("#video_title").addClass("required"); $("#photo_title").removeClass("required");   });
	$("#add_photo").click(function () { $("#file_box_video").hide(); $("#file_box_photo").show();   });
	
	$("#adm_gallery_form").validate();
	
	$("select#id_parent").change(function () {
	  var valTitle = $("input#photo_title").val();
	  var valSlash = /(.+)(\/)/g; 
	  var valClean, str = "";
	  $("select#id_parent option:selected").each(function () { str += $(this).text() + " ";  });	  
	  if(str.search(valSlash) == 0) { valClean = str.replace(valSlash,""); } else { valClean = str; }	  
	  if(valTitle == "") { $("input#photo_title").attr("value", valClean); }
	});	
	
});


function show_projects()
{ 
	jQuery(document).ready(function($) {
		sector_id = $('#sector_id option:selected').val(); 
		
		$.ajax({
			type: 'GET',
			url: 'ad_picks.php', 
			data: 'fcall=app_projects&sector_id='+ sector_id +'&project_id=<?php echo $project_id; ?>',
			dataType: 'html',
			beforeSend: function() {
				$('#box_project').html('<?php echo $loader_icon; ?>');
			},
			success: function(response) {
				$('#box_project').html(response);
			}
		});
			
	});
}

<?php if($op == 'edit' and $sector_id <> 0) { echo 'show_projects();'; } ?>
</script>

<link rel="stylesheet" type="text/css" href="../scripts/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="../scripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) 
{
	//$(".vidPop").ajaxComplete(function() {
		$(".vidPop").click(function() {
			$.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'none',
				'transitionOut'	: 'none',
				'title'			: this.title,
				'width'			: 640,
				'height'		: 385,
				//'href'		  : this.href,
				'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				'type'			: 'swf',
				'swf'			: {
				'wmode'				: 'transparent',
				'allowfullscreen'	: 'true'
				}
			});
	
			return false;
		});
	//});
	
	
});
</script>

<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</body>
</html>
