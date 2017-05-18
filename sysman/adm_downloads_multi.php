<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>

<style type="text/css">

/*-------------------------------------------------------------------------------------------------------
@ FORMS - UPLOADER INPUT-FILE
-------------------------------------------------------------------------------------------------------*/

div.uploader { background-color:#FFFFFF; height: 28px; border:1px solid #C5C5C5; position:relative;}
div.uploader span.action { height: 26px; line-height: 24px;}
div.uploader span.filename {  height: 26px; margin: 0px 0px 2px 2px; line-height: 26px; background-color:#FFFFFF;}
/* Uploader */
div.uploader { width: 295px; cursor: pointer;}
div.uploader span.action { width: 91px; text-align: center; background-color: #0077A4; font-size: 11px; font-weight: normal; color:#FFFFFF;}
div.uploader span.filename { color: #999; width: 200px; border-right: solid 1px #bbb; font-size: 11px;}
div.uploader input { width: 190px;}
div.uploader.disabled span.action { color: #000;}
div.uploader.disabled span.filename { border-color: #ddd; color: #000;}
.uploader { display: -moz-inline-box; display: inline-block; vertical-align: middle; zoom: 1; *display: inline;}
.uploader input:focus { outline: 0;}
/* Uploader */
div.uploader { position: relative; overflow: hidden; cursor: default; }
div.uploader span.action { float: left; display: inline; padding: 2px 0px; overflow: hidden; cursor: pointer;}
div.uploader span.filename { padding: 0px 5px; float: left; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; cursor: default;}
div.uploader input { opacity: 0; filter: alpha(opacity:0); position: absolute; top: 0; right: 0; bottom: 0; float: right; height: 25px; border: none; cursor: default;}
</style>
    

<?php
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }

//$id_portal = $adm_portal_id;



$parent_menu = '';
	
if($op=="edit"){ $title_new	= "Edit "; } elseif($op=="new") { $title_new	= "New "; }
	
	
$position			= "9";
$date_posted		= ""; //date("m/d/Y");
$formname			= "download_new";
$published			="checked ";	
$file_box_stat	= "";



include("includes/adm_form_resource_multi.php");
?>

	
		
  

</div>
<!-- @end :: content area -->
	
</div>
</div>
<link rel="stylesheet" href="scripts/jquery.datepick.css" id="theme">
<script src="scripts/jquery.datepick.js"></script>
<script type="text/javascript" src="../scripts/validate/jquery.validate.js"></script>	

<script type="text/javascript">

$().ready(function() {	
	$('label.required').append('<span class="rq"> *</span>');

	if( $('#adm_med_uploader').length ) 
	{ 
	 
	/* ============= @@ additional toggles ======================== */
	
	var template_doc = jQuery.validator.format($.trim($("#file_filler").val()));
	function addRow_doc() { $(template_doc(j++)).appendTo("#file tbody");  }
	function delRow_doc() { j= j-1; $(".tr_file_"+j).remove();  }
	var j = 1; addRow_doc(); 
	$("#add_file").click(addRow_doc);
	$("#del_file").click(delRow_doc);
	
	/* ============= @@ validations ======================== */
	
	var validator = $("#adm_med_uploader").validate(); /*{
		errorContainer: ".errorBox" , errorPlacement: function(error, element) { }
	}*/
	
	$('input.date-pick').live('click', function() {
		//$(this).datepicker('destroy').datepicker({showOn:'focus', changeYear: true}).focus();
		$(this).datepick('destroy').datepick({showOn:'focus'}).focus();
	});
	
	}	
		
		
});



function setFilename(upBox, upField, upKey)
{
 $(document).ready(function(){
  	var fileDefaultText = 'No file selected';
	
  	var filenameTag = $('div#'+upBox+' span.filename');
	var filenameBtn = $('div#'+upBox+' span.action');
	
	var fileLabel = $('input#file_title_'+upKey+'');
	
	
	var $el = $('#'+upField+''); 
	var filename = $el.val();
	var filenameC = $el.val();
	
	filenameC = filenameC.split(".");
	filenameC = filenameC[(filenameC.length-1)].toUpperCase();
	
		if (filename === '') {	filename = fileDefaultText;	}
		else
		{ filename = filename.split(/[\/\\]+/); filename = filename[(filename.length-1)];	
	
	filenameTag.html(filename);
	fileLabel.attr("value", filename.substr(0,filename.length-4)).focus();
			
			/*if (filenameC === "PDF" || filenameC === "DOC" || filenameC === "DOCX") {   
				filenameTag.html(filename);
				fileLabel.attr("value", filename.substr(0,filename.length-4));
			} else {
				alert("Select a valid MP3 file.");
			}*/
	
		}
	});
};

</script>	
</body>
</html>
