<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php

	$ths_page="?d=$dir&op=$op";
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

	if($id){
	
	/*$sqdata=" SELECT 
      DATE_FORMAT(`date_record` ,'%b %d, %Y %r') as `date posted`, `name` as `sender`, `email`, `phone`, `subject`, `details`
   FROM 
      `dhub_dt_feedback` WHERE  (`id` = ".quote_smart($id).")";*/
	
	$sqdata = "SELECT DATE_FORMAT(`date_record` ,'%b %d, %Y %r') AS `date posted`, `qf_firstname` as `firstname`, `qf_lastname` as `lastname`, `qf_email` AS `email`, `qf_mobile` AS `mobile`, `qf_phone` AS `landline`, `qf_organization` AS `organization`, `qf_jobtitle` AS `job title`, `qf_enquiry_topic` AS `topic`, `qf_enquiry_details` AS `details`, `qf_find_us` AS `found us`
   FROM 
      `dhub_dt_service_request`  WHERE  (`id` = ".quote_smart($id).")";
	
	//echo $sqdata;
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		$detailEntry = "";
		
		if($rsdata_count==1)
		{
		
		
		$cndata = $cndb->fetchRow($rsdata, 'assoc');
		
		$pgtitle				="<h2>Consultation Request Details</h2>";
		
		foreach ($cndata as $key => $value) {
			$postDetail = html_entity_decode(stripslashes(nl2br($value)));
			$detailEntry .= "<tr><th> $key &nbsp;</th><td> $postDetail &nbsp;</td></tr>";
		}
		
		}
	}
}
 ?>

	<!-- content here [end] -->	<br />
	<form class="admform" name="rage" id="form_articles" method="post"  >
	  <table  border="1" cellspacing="1" cellpadding="3" align="center" width="60%">
        <tr> <td colspan="2" style="background: #DFDFDF">&nbsp;<?php echo $pgtitle; ?></td> </tr>
		
		<?php
		
		echo $detailEntry;
		
		?>
      </table>
	</form>

	</div>
</div>
	
	

<div>
<p>&nbsp;</p><p>&nbsp;</p>
<!-- @end :: content area -->
	
</div>
</div>
<p>&nbsp;</p><p>&nbsp;</p>		
		
		<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</body>
</html>
