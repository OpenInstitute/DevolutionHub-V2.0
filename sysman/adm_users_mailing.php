<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php

$ths_page="?d=$dir&op=$op";

if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }



/*if($op=="edit"){

	if($id)
	{
	
	//$sqdata = "SELECT `id`, `firstname`, `lastname`, `email`, `phone`, `organization`, `address`, `country`, `newsletter`, `published`, `currentpost` FROM  `dhub_reg_users` WHERE  (`id` = ".quote_smart($id).")";
	
	$sqdata = "SELECT `account_id` , `namefirst` , `namelast` , `email` , `phone` , `country` , `city` , `profile` , `newsletter` , `published` FROM `dhub_reg_account` where `account_id` = ".quote_smart($id)."; ";
	
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata=$cndb->fetchRow($rsdata);
		
		$pgtitle				="<h2>Account Details</h2>";
		
		$id					= $cndata['account_id'];
		$firstname			= html_entity_decode(stripslashes($cndata['namefirst']));
		$lastname			= html_entity_decode(stripslashes($cndata[2]));
		$email				= html_entity_decode(stripslashes($cndata[3]));
		$phone				= html_entity_decode(stripslashes($cndata[4]));
		$organization		= html_entity_decode(stripslashes($cndata[5]));
		$address			= nl2br(html_entity_decode(stripslashes($cndata[6])));
		$currentpost		= html_entity_decode(stripslashes($cndata[10]));
		$country			= $cndata[7];
		
		$newsletter			= $cndata[8]; 
		$published			= $cndata[9]; 
		
		if($published==1) {$published="checked ";} else {$published="";}
		if($newsletter==1) {$newsletter="checked ";} else {$newsletter="";}
		
		
		
		$sqdata_m="SELECT `id_user_cat` , `id_user` FROM `dhub_reg_cats_links` WHERE (`id_user` = ".quote_smart($id)."); ";
	
		$rsdata_m=$cndb->dbQuery($sqdata_m);
		if( $cndb->recordCount($rsdata_m)) 
		{
			while($cndata_m = $cndb->fetchRow($rsdata_m))
			{
			$user_cats[] = $cndata_m[0];
			}
		}
	
		//displayArray($user_cats);
		$formname			= "account_edit";
		
		$is_editable = ' readonly="readonly" ';
		}
	}


} 
elseif($op=="new")
	{
	
		$pgtitle				="<h2>New Account</h2>";
		
		$id					= "";
		$newsletter			= "checked ";
		$published			= "checked ";
		$formname			= "account_new";
		
		$is_editable	= '';
	}
	
	*/
 ?>

	<!-- content here [end] -->	<br />
	
	<?php include("includes/adm_form_mailing.php"); ?>

	<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>
</div>
	
	

<div>
<!-- @end :: content area -->
	
</div>
</div>
		
<script type="text/javascript">
$(document).ready(function(){
	if($('#register').length){
		$('#register').validate({
			rules: { password: {	required: true,	minlength: 5 },
					 confirm: { required: true, equalTo: "#password" }	},
			onkeyup: false
		});
	}
 });
	 
</script>		
</body>
</html>
