<?php include("sec__head.php"); ?>
<style type="text/css">
#gradient-style
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	margin: 10px 15px;
	/*width: 480px;*/
	text-align: left;
	border-collapse: collapse;
	border: 2px solid #d3ddff;
}
#gradient-style th
{
	font-size: 13px;
	font-weight: normal;
	padding: 8px;
	background: #b9c9fe;
	border-top: 2px solid #d3ddff;
	border-bottom: 1px solid #fff;
	color: #039;
}
#gradient-style td
{
	padding: 4px; 
	border-bottom: 1px solid #fff;
	color: #669;
	border-top: 1px solid #fff;
	/*background: #e8edff;*/
	vertical-align:top;
}
#gradient-style tfoot tr td
{
	background: #e8edff;
	font-size: 12px;
	color: #99c;
}
#gradient-style tbody tr:hover td
{
	background: #d0dafd url('table-images/gradhover.png') repeat-x;
	color: #339;
}
#gradient-style tfoot tr td
{
	background: #e8edff;
	font-size: 12px;
	color: #99c;
}
#gradient-style tbody tr:hover td
{
	background: #d0dafd url('table-images/gradhover.png') repeat-x;
	color: #339;
}

</style>


<!-- @begin :: content area -->
<div>

<?php
if($id) 
{ 

/* ====== #MEMBER ======= */

$sq_poster = "SELECT `id`, concat_ws(' ',`dhub_reg_users`.`firstname`, `dhub_reg_users`.`lastname`) as `name`, `email`, `country` FROM `dhub_reg_users` WHERE (`id` = ".quote_smart($id)."); ";
$rs_poster = $cndb->dbQuery($sq_poster);
$cn_poster = $cndb->fetchRow($rs_poster, 'assoc');
$name_poster = trim(html_entity_decode(stripslashes($cn_poster['name'])));

/* ====== END #MEMBER ======= */


echo '<h1 style="padding:20px 10px">Posts for <b>'.$name_poster.'</b></h1> ';
}

if(isset($_REQUEST['post_id'])) { $entry_id=$_REQUEST['post_id']; } else { $entry_id=NULL; }


if($op == 'view') {
	if($entry_id) 
	{ 
	include("includes/adm_list_forum_post_form.php");
	}
} else {
	include("includes/adm_list_forum_users_posts.php");
}

?>


<?php


if($_POST['formname'] == 'forum_edit_posts')
{
	//displayArray($_POST); //exit;
		
$post_id    = $_POST['post_id'];
$published  = $_POST['published'];
$ddd 		= $_POST['dir'];
$f_ac_id    = $_POST['f_ac_id'];

if($published=='on' or $published=='1') { $published=1;	} else { $published=0; }

$sq_post = "UPDATE `dhub_forum_posts` SET `post_content` = " . quote_smart($_POST['post_content']) . ", `post_published` = '".$published."'  WHERE `post_id` = " . quote_smart($_POST['post_id']) . " "; 
 //echo $sq_post; exit;
$rs_post = $cndb->dbQuery($sq_post);


if(!$rs_post)
{
	echo 'An error occured while updating your post. Please try again later.<br /><br />' . mysql_error();
	$sql = "ROLLBACK;";
	$result = $cndb->dbQuery($sql);
}
else
{
	$sql = "COMMIT;";
	$result = $cndb->dbQuery($sql);	
	
	echo 'You have succesfully updated the member post.';
	
}	
$redirect = 'adm_forum_posts.php?d='. $ddd . '&op=edit&id='.$f_ac_id;		
	?>
<script language="javascript">	
function resultRedirect(){ location.href="<?php echo $redirect; ?>"; } window.setTimeout("resultRedirect()", 3000);
</script>			
	<?php

	
}	

?>


<div>
<!-- @end :: content area -->
	
</div>
</div>
		

<script type="text/javascript" src="scripts/jquery.dataTables-1.9.1.js"></script><!--jquery.dataTables-1.7.4.min.js-->
<script type="text/javascript" charset="utf-8">

(function($) {
/*
 * Function: fnGetColumnData
 * Purpose:  Return an array of table values from a particular column.
 * Returns:  array string: 1d data array
 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
 *           int:iColumn - the id of the column to extract the data from
 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
 */
$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return new Array();
     
    // by default we only wany unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;
     
    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;
     
    // by default we do not wany to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
     
    // list of rows which we're going to loop through
    var aiRows;
     
    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers
 
    // set up data array   
    var asResultData = new Array();
     
    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var aData = this.fnGetData(iRow);
        var sValue = aData[iColumn];
         
        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;
 
        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
         
        // else push the value onto the result data array
        else asResultData.push(sValue);
    }
     
    return asResultData;
}}(jQuery));
 
 
function fnCreateSelect( aData )
{
    var r='<select style="width:170px"><option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r+'</select>';
}
 
	$(document).ready(function(){
		var oTable = $('#example').dataTable({
			"bProcessing": true,
			"bJQueryUI": true, "bStateSave": true,
			"sPaginationType": "full_numbers", "iDisplayLength": 25/*, "aaSorting": [[ 1, "asc" ]]*/
		<?php if($dirListOne <> 'online services' and 
				 $dirListOne <> 'menus') { ?> 
				,"aaSorting": [[ 1, "desc" ]] 
		<?php }  ?>
			<?php if($dirListOne == 'online services') { ?> ,"bPaginate": false <?php }  ?>
		});

<?php if($dirListOne == 'online services') { ?>
		$("tfoot th").each( function ( i ) {
		<?php if($dir == 'online services:registrations') { ?>	
			if(i==2 || i==6 /*|| i==7*/) {
		<?php } elseif($dir == 'online services:reports') { ?>
			if(i==2) {
		<?php } elseif($dir == 'online services:applications') { ?>
			if(i==2 || i==3) {
		<?php } else { ?>
			if(i==2 || i==6 || i==7) {
		<?php }  ?>		
				this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
				$('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); } );
			}
		} );
<?php } ?>

		if( $('#check_all').length )  { 
			$('#check_all').click(function() {
				var n = $('#check_all:checked').length; 
				if( n == 1) { $(":checkbox").attr("checked", true); } else { $(":checkbox").attr("checked", false); }
			});
		}
	
	
		$('#fm_selection').change(function()
		 {
			 var fl_action = $(this).val();			 	
		 });
	
			
	});
	
	
</script>

<link rel="stylesheet" href="../scripts/jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="../scripts/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript">
jQuery(document).ready(function ($)  {
  if( $('.wysiwyg').length ) { $('.wysiwyg').wysiwyg(); }
});
</script>
				
</body>
</html>
