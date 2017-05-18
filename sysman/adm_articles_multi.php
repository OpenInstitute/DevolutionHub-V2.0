<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php
if($op=="new")
{

	$pgtitle				="<h2>New Content</h2>";
	
	$id					= "";
	$id_menu			= "";
	$id_menu2			= "";
	
	$title				= "";
	$title_sub	= '';
	$article			= "";
	$created			= date("m/d/Y");
	
	$parent = "";  	//array('7','54'); //
	$id_section = 1; //1
	
	if(@$newsec == "news") { $parent[0] = 64; $id_section = 2; }
	
	$published			= "checked ";
	$approved			 = "checked ";
	$frontpage			= "";
	$yn_gallery		= ""; 
	$yn_static		= "";
	$position			= "9";
	
	$upload_picn	="";
	$upload_picy	=" checked ";
		
	$photo_box = "none";
	$video_box = "block";
	$video = "checked "; $photo = "";
	
	$hasgallery="";
	$gallery="";
	$sidebar="";	
	$formname			= "article_multi_new";
}

//$dropSection = $ddSelect->dropper_select("dhub_dd_sections", "id", "title", $id_section);
 ?>

<div style="width:90%; margin:0 auto; border:0px solid">
	
<div style="padding:10px;">

  
  
<?php
include("includes/adm_form_article_multi.php");

?> 


</div>
</div>
	
	

</div>
<!-- @end :: content area -->
	
</div>
</div>
		
		
<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
		
		
<script type="text/javascript">
$(document).ready(function()
{ 
	$("select#id_parent").change(function () {
	  var valTitle = $("input#article_title").val();
	  var valSlash = /(.+)(\/)/g; 
	  var valClean, str = "";
	  $("select#id_parent option:selected").each(function () { str += $(this).text() + " ";  });	  
	  if(str.search(valSlash) == 0) { valClean = str.replace(valSlash,""); } else { valClean = str; }	  
	  if(valTitle == "") { $("input#article_title").attr("value", valClean); }
	});	
});
</script>
<script src="scripts/jquery.datepick.js"></script>
<script type="text/javascript" src="../scripts/validate/jquery.validate.js"></script>	

<script type="text/javascript">

$(document).ready(function() {	

	if( $('#cont_multi').length ) 
	{ 
	 
	/* ============= @@ additional toggles ======================== */
	
	var template_doc = jQuery.validator.format($.trim($("#file_filler").val()));
	function addRow_doc() { $(template_doc(j++)).appendTo("#file tbody");  }
	function delRow_doc() { j= j-1; $(".tr_file_"+j).remove();  }
	var j = 1; addRow_doc(); 
	$("#add_file").click(addRow_doc);
	$("#del_file").click(delRow_doc);
	
	/* ============= @@ validations ======================== */
	
	var validator = $("#cont_multi").validate(); 
	
	$('input.date-pick').live('click', function() {
		$(this).datepick('destroy').datepick({showOn:'focus'}).focus();
	});
	
	}	
		
		
});


</script>	
<link rel="stylesheet" href="../scripts/jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="../scripts/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript">
jQuery(document).ready(function ($)  {
  if( $('.wysiwyg').length ) { $('.wysiwyg').wysiwyg(); }
  
   $('.wysiwyg').live('click', function() {
		$(this).wysiwyg('destroy').wysiwyg().focus();
	});
	
});
</script>
</body>
</html>
