<?php include("sec__head.php"); ?>


<style type="text/css">.plain { display:inline; margin:0; padding:0;}</style>
<!-- @begin :: content area -->
<div>


<?php

	$ths_page="?d=$dir&op=$op";
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

	if($id){
	
	
	$sqdata = " SELECT `id_content` as `event title`,
     `regnum` as `registration code`,  DATE_FORMAT(`date_record` ,'%b %d, %Y %r') as `registration date`, 'blank1',  `orgname` AS `organization`, `country` AS `country`, `orgaddress` AS `postal address`, `pay_type` AS `payment mode`, 'blank2', concat_ws(' ', `contacttitle`, `contactname`) as `contact name`, `contactphone` AS `contact phone`, `contactjob` AS `contact job title`, `contactemail` AS `contact email`, 'blank3', `reference`, `book_booth` AS `exhibition booth`, `participants`
   FROM 
      `dhub_reg_events_booking`  WHERE  (`id` = ".quote_smart($id).") "; 
	  
	//echo $sqdata;
	
	
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		$detailEntry = "";
		
		if($rsdata_count==1)
		{
		
		
		$cndata = $cndb->fetchRow($rsdata, 'assoc');
		
		$pgtitle				="<h2>Online Event Registrations</h2>";
		
			
			foreach ($cndata as $key => $value) 
			{
				$postDetail = trim(html_entity_decode(stripslashes(nl2br($value))));
				
				if($key == 'event title') {
					$postDetail = "<h3 class=\"plain\">".$dispData->contMain[$value]['title']."</h3>";
				}
				
				if($key == 'country') {
					$postDetail = $ddSelect->selectCountry($value);
				}
				
				if($key == 'contact email') {
					$postDetail = "<a href='mailto:".$postDetail."'>".$postDetail."</a>";
				}
				
				if($key == 'exhibition booth' or $key == 'confirmed') {
					if($value == 0) $postDetail = "No"; else $postDetail = "Yes";
				}
				
				if($key <> "participants") {	
					if(substr($key,0,5) == 'blank') 
					{ $detailEntry .= "<tr><th>&nbsp;</th><td>&nbsp;</td></tr>"; } 
					else 
					{ $detailEntry .= "<tr><th> $key: &nbsp;</th><td> $postDetail &nbsp;</td></tr>"; }
				}
			}
		
		
			//$parti = 	trim(stripslashes($cndata['participants'])); 
			$parties = 		unserialize($cndata['participants']);
			$parties_num = count($parties);
			
			$detailParties = ""; 
			
			for ($i = 1; $i <= $parties_num ; $i++) {
				$parti_name = $parties[$i]['title'].' '.$parties[$i]['name'];
				$parti_mail = '<a href="mailto:'.$parties[$i]['email'].'">'.$parties[$i]['email'].'</a>';
				
				$detailParties .=  '<tr>
										<td>'.$i.'</td>
										<td>'.$parti_name.'</td>
										<td>'.$parties[$i]['jobtitle'].'</td>
										<td>'.$parties[$i]['phone'].'</td>
										<td>'.$parti_mail.'</td>
									</tr>';
			}
		
		
		}
	}
}
 ?>

	<!-- content here [end] -->	<br />
	<form class="admform" name="rage" id="form_articles" method="post"  >
	  <table  border="1" cellspacing="1" cellpadding="4" align="center" width="800">
        <tr> <td colspan="2"><?php echo $pgtitle; ?></td> </tr>
		
		<?php
		
		echo $detailEntry;
		
		?>
		
		<tr>
			<td colspan="2">
			<div>&nbsp; <h2>Participant List</h2></div>
			
			<table id="list_parties">
			<tr>
				<th style="width:20px;"></th>
				<th>Name</th><th>Job Title</th>
				<th>Phone No.</th><th>Email</th>
			</tr>
			<?php
				echo $detailParties;
			?>
			</table>
			
			
			
			</td>
		</tr>
		<tr>
			<td colspan="2"><p>&nbsp;</p>
			<input type="button" value="Print Registration Details" onClick="javascript: window.print()" class="btn_print" /></td>
		</tr>
      </table>
	</form>

	<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>
</div>
	
	

<div>
<!-- @end :: content area -->
	
</div>
</div>
		
		
		<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</body>
</html>
