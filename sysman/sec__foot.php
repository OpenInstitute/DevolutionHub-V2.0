<script type="text/javascript" src="../scripts/validate/jquery.validate.js"></script>	
<link rel="stylesheet" type="text/css" href="../scripts/tagsinput/jquery.tagsinput.css" />
<script type="text/javascript" src="../scripts/tagsinput/jquery.tagsinput.js"></script>

<script type="text/javascript">
function urlTitle(text) {       
    text = text.replace(/[^a-zA-Z0-9]/g,"-").replace(/[-]+/g,"-").toLowerCase();
    return text;
}
	
jQuery(document).ready(function ($) {
	
	<?php if($dir <> '') { ?>
	var nav_curr = "<?php echo $dir; ?>";
	if( $("#nvm_"+nav_curr).length ) { $("#nvm_"+nav_curr).addClass("current"); }
	<?php } ?>
	
	$("ul.sf-menu li:has(ul)").children("a").addClass("sf-with-ul");
	$('ul.sf-menu li:has(a.current)').children(':first').addClass("current");	
	$("ul.sf-menu li").hover(function(){ $(this).addClass("sfHover"); }, function(){ $(this).removeClass("sfHover"); } );
	
	if( $('.tags-field').length ) {
		$('.tags-field').tagsInput({width:'100%'});
	}
	
}); 
</script>

<?php if($GLOBALS['FORM_JWYSWYG'] == true) { ?>
<link rel="stylesheet" type="text/css" href="../scripts/jwysiwyg/jquery.wysiwyg.css">
<script type="text/javascript" src="../scripts/jwysiwyg/jquery.wysiwyg.js"></script>	
<script type="text/javascript">
jQuery(document).ready(function ($)  {
  if( $('.wysiwyg').length ) {  $('.wysiwyg').wysiwyg();  }
});
</script>
<?php } ?>