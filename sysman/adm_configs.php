<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>
<?php
$query = "SELECT `id`  , `account_name` as `name`, `account_category` as `category`, `contacts` , `telephone` as `phone` , `email`,`county`, concat_ws(' ' , `sub_county` , `location`) as `location` , `account_speciality` as `speciality`, `published` as `active` FROM `dhub_app_vw_directory` ";
//echo $query;

$result 	= $cndb->dbQuery($query); 
$rs_fields = mysqli_num_fields($result);
$dt_fields = mysqli_fetch_fields($result);

for ($i = 0; $i<$rs_fields; $i++)
{
	//$field_names[$i] = mysql_fetch_field($result, $i);			
	$field_titles[] = $dt_fields[$i]->name; //$field_names[$i]->name;
}	

$tbColumnsHead = '';
$tbColumnsFoot = '';

foreach($field_titles as $field_head)
{
	$tbWidth	= '';
	if($field_head == 'id') { 
		$tbWidth	= ' class="len-short"; '; 
		$field_head = '<input type="checkbox"  id="checkAll"  />';
		}
	$tbColumnsHead .= '<th '.$tbWidth.'>'.$field_head.'</th>';
	$tbColumnsFoot .= '<th>&nbsp;</th>';
}
	//displayArray($field_titles);
?>

<div id="dynamic">
<form id="adm_fm_services" action="adm_posts.php" method="post" target="_blank">
<div id="fChecked"></div>
<div style="text-align:; padding-bottom:1em;">
<input type="hidden" name="vselected" id="vselected" />
<input type="hidden" name="formname" value="adm_fm_services" />
<select name='fm_selection' id='fm_selection'>
	<option value=''>With Selected</option>
	<option value='#'>Export to Excel</option>
	<option value='adm_oslist_mail.php'>Send Email</option>
	<option value='adm_oslist_sms.php'>Send SMS</option>				
</select>
<button type="submit">Go</button>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<?php echo $tbColumnsHead; ?>
		</tr>
	</thead>
	
	<tbody class="tbody">
	<tr>
		<td colspan="<?php echo $rs_fields; ?>" class="dataTables_empty">Loading data from server</td>
	</tr>
	</tbody>
	
	<tfoot>
		<tr>
			<?php echo $tbColumnsFoot; ?>
		</tr>
	</tfoot>
</table>
</form>
</div>
	

</div>
<!-- @end :: content area -->
	
</div>
</div>
		
<?php
$appData->get_directoryCatsAccounts();
?>		
<script type="text/javascript" src="scripts/jquery.dataTables-1.9.1.js"></script>
<script type="text/javascript" src="scripts/jquery.dataTables.pipeline.js"></script>
<script type="text/javascript" src="scripts/jquery.dataTables.colFilter.js"></script>

<script type="text/javascript" charset="utf-8">
function fnCreateSelectCat( aData )
{
    var r='<select style="width:100%"><option value=""></option>', i, iLen=aData.length;
	r += '<?php echo $ddSelect->select_directoryCatsMenu($dir_type); ?>';
    return r+'</select>';
}

function fnCreateSelectReg( aData )
{
    var r='<select style="width:100%"><option value=""></option>', i, iLen=aData.length;
	r += '<?php echo $appData->build_counties($dir_region); ?>';
    return r+'</select>';
}

$(document).ready(function() {
	var aSelected = [];
	var vSelected = [];
	
	var oTable = $('#example').dataTable( {
		"bJQueryUI": true,
		"sPaginationType": "full_numbers", 
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": 'adm_directory_arrb.php',
		"fnServerData": fnDataTablesPipeline,
		"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': [0] }
		   ]
	});
	
	$("tfoot th").each( function ( i ) {
		if(i==2) {		
			this.innerHTML = fnCreateSelectCat( oTable.fnGetColumnData(i) );
			$('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); } );
		}
		
		if(i==6) {		
			this.innerHTML = fnCreateSelectReg( oTable.fnGetColumnData(i) );
			$('select', this).change( function () { oTable.fnFilter( $(this).val(), i ); } );
		}
	});
	
	
	oTable.on( 'draw', function () {
        $("input.selCheck").each(function(){
			var checkKey = $(this).prop('id');					
			if ( jQuery.inArray(checkKey, aSelected) !== -1 ) {
				$(this).prop('checked', true);
			}
		});
    });
	
	/* Click event handler */
    $('input.selCheck').live('click', function () {
        var id    	= this.id;
		var rval      = $(this).val();
        var index 	 = jQuery.inArray(id, aSelected);
       
        if ( index === -1 ) 
		{ aSelected.push( id );  		   vSelected.push( rval ); } else 
		{ aSelected.splice( index, 1 );  vSelected.splice( index, 1 ); }
       //alert(vSelected);
     });
	 
	 $("#checkAll").on('click',function() { 
        var status = this.checked;
        $(".selCheck").each( function() {
			$(this).trigger("click");
            //$(this).prop("checked",status);
        });
    });
	
	$('#adm_fm_services').submit( function() {
		$("#vselected").prop('value', vSelected);
		var fAction = $("select#fm_selection option:selected").val(); //alert(fAction);
		
		$(this).attr('action', fAction); 

        this.submit();
    	return false;
    });
});
</script>		
		
</body>
</html>
