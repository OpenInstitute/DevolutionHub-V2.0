<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>



	<?php
	if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
	if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
	
	
	$article_title = '';
	$file_caption = '';
	$file_name_v	     = "https://www.youtube.com/watch?v=";
	
if($op=="edit"){

	if($id){
	
	
	//$dispData->siteContent();
	//displayArray($dispData->contMain); //[$id]
	$contArray = master::$contMain['full'][$id];
	
	$article_title = $contArray["title"];
	$article_parent = $contArray["parent"];
	$article_content = strip_tags(html_entity_decode($contArray["article"]));
	$article_content = smartTruncateNew($article_content, 100, ".", ".");
		
	if($article_title == "...") { $article_title = $article_parent;	}
			
	
		
	$gallery_id = str_pad($id, 4, "0", STR_PAD_LEFT); 
	
	/*$sqdata="SELECT   `id`, `id_menu`, `id_section`, `title`, `article`, `date_created`, `published`, `frontpage`, `sidebar`, `id_menu2`, `yn_gallery`, `yn_static`, `seq`, `title_sub`, `intro_home`   FROM `dhub_dt_content`  WHERE  (`id` = ".quote_smart($id).")";
	
	//echo $sqdata;
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata= $cndb->fetchRow($rsdata);
		
		
		$id					= $cndata[0];
		$id_menu			= $cndata[1];
		$id_menu2			= $cndata[9];
		$id_section			= $cndata[2];
		$title				= html_entity_decode(stripslashes($cndata[3]));
		$title_sub			= html_entity_decode(stripslashes($cndata[13]));
		$article			= html_entity_decode($cndata[4]);
		$article		   =	str_replace('image/', ''.SITE_DOMAIN_LIVE.'image/', $article);
		$article			= html_entity_decode(stripslashes($article));
		
		$published			= $cndata[6]; 
		$frontpage			= $cndata[7]; 
		$sidebar			= $cndata[8]; 
		$yn_gallery		= $cndata[10]; 
		$yn_static		= $cndata[11]; 
		$position			= $cndata[12];
		$intro_home			= $cndata[14];
				
		if($published==1) {$published="checked ";} else {$published="";}
		if($frontpage==1) {$frontpage="checked ";} else {$frontpage="";}
		if($sidebar==1) {$sidebar="checked ";} else {$sidebar="";}
		if($intro_home==1) {$intro_home="checked ";} else {$intro_home="";}
		if($yn_gallery==1) {$yn_gallery="checked ";} else {$yn_gallery="";}
		
		$formname			= "gallery_album_edit";
		
		$file_name_v	     = "http://www.youtube.com/embed/";
		
		}*/
	}
} elseif($op=="new")
	{
	
		/*$pgtitle				="<h2>New Image Category</h2>";
		
		$id					= "";
		$id_parent1			= "";
		$id_parent2			= "";
		$title				= "";
		$description			= "";
		$published			="checked ";		
		$formname			= "gallery_album_new";
		$file_name_v	     = "http://www.youtube.com/embed/";*/
	}
	?>

<div style="width:1050px; margin:0 auto; border:0px solid">

	<div style="padding:5px;">
		<h3><span style="color:#999">Parent Article: </span><?php echo strtoupper($article_title); ?> &raquo;</h3>
		
<?php
if($id)
	{
?>	

		<?php
				include("includes/adm_article_file_gallery.php") ;
			  ?>
		
		<br />
		
		
		<fieldset>
		<legend>Gallery Items &raquo;</legend>
		<form action="adm_posts.php" method="post"><!-- target="upload_target" -->
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<td>
				<p id="f1_upload_process" align="center">Loading...<br/><img src="image/loader.gif" /><br/></p>
				
				<ul id="files_long" ></ul>				
				</td>
			</tr>
			<tr>
				<td style="padding-left:150px">
				<input type="submit" value="Save Changes Made" name="submit" id="edit_photo_submit" />
				<input type="hidden" name="formname" value="edit_photo" />
				<input type="hidden" name="redirect" value="<?php echo $ref_page; ?>" />
				</td>
			</tr>
		</table>
		</form>
		</fieldset>
		</div>
	
<?php
}
?>	
	
	</div>



	

</div>
	
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$('label.required').append('&nbsp;<span class="rq">*</span>&nbsp;');
	$('textarea').autoResize({extraSpace : 10 });
	
	
	$("#add_video").click(function () { $("#file_box_video").toggle(); $("#file_box_photo").toggle();   });
	$("#add_photo").click(function () { $("#file_box_video").toggle(); $("#file_box_photo").toggle();   });
	
	//if( $('#cont_news').length ) 		{ $("#cont_news").validate(); }
	
});
</script>

<link rel="stylesheet" type="text/css" href="../scripts/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="../scripts/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) 
{
	$("#files_long").ajaxComplete(function() {
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
	});
});
</script>

<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</body>
</html>
