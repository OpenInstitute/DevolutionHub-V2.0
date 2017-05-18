<?php
require '../classes/cls.constants.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo SITE_TITLE_LONG; ?> Mailing List</title>
<link rel="stylesheet" href="styles/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="styles/data_table.css" />
<link rel="stylesheet" type="text/css" href="styles/smoothness/jquery-ui-1.8.4.custom.css" />
</head>

<script type="text/javascript" src="scripts/jquery-1.5.2.min.js"></script>


<body style="background-color:#E9F3DD">
<div>

<div style="background:#76B729; color:#FFFFFF; text-align:center; padding:10px 0; border-bottom:4px solid #009900; margin-bottom:10px;">
	<h2 style="color:#FFFFFF">Newsletter Mailing List</h2>
	<span style="font-size:11px">Select intended recipients below:</span>  
</div>

<div style="padding:0 10px;">
<form name="mailaccounts" id="mailaccounts" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="1">
<tr>
  <td><input type="submit" name="submit" value="Insert Selected Addresses" style="background-color:#009900" ></td>
  <td>&nbsp;</td>
  <td style="text-align:right;">
  <input type="button" name="close" value=" Close Window " style="background-color:#990000"  onClick="javascript:window.close();"></td>
</tr>
</table>
	  
	  
  <table width="100%" border="0" cellspacing="0" cellpadding="3"  class="display" id="example" align="center">
   <thead>
    <tr id="display_titles_2">
      <th style="width:25px"><input name="allbox" id="allbox" value=""  type="checkbox"><!--onClick="checkAll('mailaccounts');"--> </th>
      <th style="width:300px; text-align:left;">Account Email</th>
      <th>Account Name </th>
    </tr>
	</thead>
	<tbody>
    <?php //`newsletter`=1 and
	$sqAcc="SELECT `id`, concat_ws(' ', `firstname`, `lastname`) as `fullname`, `email` FROM `dhub_reg_users` WHERE  `published`=1 ORDER BY  `email`, `fullname` "; 
	  
	$rsAcc=$cndb->dbQuery($sqAcc) or trigger_error('SQL', E_USER_ERROR);
	
	$rn=1;
		while ($cnAcc=$cndb->fetchRow($rsAcc)){
		$name = trim(html_entity_decode(stripslashes($cnAcc[1])));
		$email = trim(html_entity_decode(stripslashes($cnAcc[2])));
		$username= substr($email, 0, stripos($email,"@"));
		if(strlen($name) <= 4) { $name = $username; }
	
	?>
    <tr>
      <td>
      <input type="checkbox" value="<?php echo $name." <".$email.">"; ?>" id="cb<?php echo $cnAcc[0]; ?>" name="acc[]"></td>
      <td><?php echo $email; ?></td>
      <td><?php echo $name; ?>&nbsp;</td>
    </tr>
    
    <?php
	$rn += 1;
	}
	?>
	
	</tbody>
  </table>
</form>
</div>



</div>

</body>
</html>


<script type="text/javascript" src="scripts/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		
		oTable = $('#example').dataTable({
			"bJQueryUI": true,
			"bStateSave": true
		});
		
		$('#allbox').click( function() {
			var n = $("input#allbox:checked").length;
			//alert("rage" + n);
			if(n == 1){
				$('input', oTable.fnGetNodes()).each( function() {
					$('input', oTable.fnGetNodes()).attr('checked','checked');
				});
			}
			if(n == 0){
				$('input', oTable.fnGetNodes()).each( function() {
					$('input', oTable.fnGetNodes()).attr('checked','');
				});
			}
			
		} );
	});
	
	
</script>


<?php
if(isset($_POST['submit'])) { 
if(isset($_POST['acc'])) { 
	$acc 		= $_POST['acc'];
	
	//this function stores ur values 
		function print_selected_values($acc) {
			$accNgapi 	= count($acc);
			$query ="";
			$p=0;
			foreach($acc as $email){
				  $query .= $email;
			$p +=1;
				if ($p<$accNgapi) { $query .= ",";}
			 }
		 ?>
			 <script language="javascript">
				function insertAdd() {
				  var add='<?php echo $query; ?>' ;
				  window.opener.insertHTML(add, 'addresses');
				  window.close();
				}
				insertAdd();
			 </script>
		<?php
		}
	print_selected_values($acc); 
} else {
	echo "<script>alert('You need to select addresses to insert!')</script>";
}
}
?>