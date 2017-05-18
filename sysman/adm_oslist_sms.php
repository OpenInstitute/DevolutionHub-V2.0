<?php
require '../classes/cls.constants.php';
if (!isset($sys_us_admin['adminname'])) 
	{ 
	?> <script language="javascript">location.href="index.php";</script> <?php
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin:: <?php echo SITE_TITLE_LONG; ?></title>
<link rel="stylesheet" href="styles/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.multiselect.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.multiselect.filter.css" />
<link rel="stylesheet" type="text/css" href="styles/smoothness/jquery-ui-1.8.4.custom.css" />

<script type="text/javascript" src="../scripts/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-ui-1.10.2.min.js"></script>
<script type="text/javascript" src="../scripts/validate/jquery.validate.js"></script>
<script type="text/javascript" src="scripts/jquery.countable.js"></script>

<script type="text/javascript"> 
jQuery(document).ready(function($) {
	$("textarea#message").countable({maxLength: 140});
	$("#form_sms").validate();
});
</script>



<style type="text/css">
.ui-multiselect { width: 600px !important;}
.ui-multiselect-checkboxes li { width: 280px; clear:none; float:left; }

div.multicheck {background: none; overflow:auto; height:120px;padding:5px 1px;border: 1px solid #C5C5C5; width: 930px;}
div.multicheck p { padding-top:10px; padding-bottom: 3px; color:#0066CC; margin:0; text-transform:uppercase; }
 
div.multicheck label {
width: 300px; text-align:left  !important;border-bottom:1px dotted #D7D7D7;font: 11px 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; color: #999; text-indent: 10px; display:inline-block; padding:2px 0 5px;}
</style>
</head>

<body>

<table border="0" cellspacing="0" cellpadding="1" align="center" class="container_admin">
  <tr>
    <td colspan="2" valign="top">
	<?php include("includes/adm__banner.php"); ?></td>
  </tr>
  <tr>
   <td colspan="2" valign="top">
	<?php include("includes/adm__links_top.php"); ?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="content">
	
	
	<!-- content here -->
	
	
<?php
	
	
if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op="new"; }
if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }

$ths_page="?d=$dir&op=$op";

if($op=="new")
{
	$pgtitle	 = "<h2>Portal Bulk SMS</h2>";
	$send_to_sms = $_SESSION['report_phones'];
	//displayArray($send_to_sms);
	$send_to	 = '';
	
	foreach ($send_to_sms as $smskey => $smsvalue) 
	{
		//<label><input type="checkbox" name="discipline[81]" value="Art (Fine arts, Performing arts)"/>&nbsp;Art  (Fine arts, Performing arts)</label>
		//$send_to .= ' <option value="'.$smskey.'" selected="selected">'.$smsvalue.'</option>';
		
		$send_to .= '<label><input type="checkbox" name="id_sendto[]" checked value="'.$smskey.'" class="radio" />&nbsp; '.$smsvalue.'</label>';
	}
}


	
	 if($op=="new") {
	?>
<form class="admform" name="form_sms" id="form_sms" method="post" action="adm_posts.php" enctype="multipart/form-data" >

<table border="0" cellspacing="0" cellpadding="0" align="center" width="700">
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $pgtitle; ?></td>
  </tr>
  <tr>
	<td><b>Send To: </b></td>
	<td>
	<?php /*?><select name="id_sendto[]" multiple="multiple" class="multipleX" size="10" style="height:100px;">
	<?php echo $send_to; ?> </select><?php */?>
	<div class='multicheck'><?php echo $send_to; ?></div>
	</td>
	</tr>
  
	<tr>
		<td><b>Message</b></td>
		<td><textarea name="message" id="message"  class="required text_full" placeholder="Enter Message..."></textarea></td>
	</tr>
  <!--<tr><td>&nbsp;</td>
	<td><input type="checkbox" name="testmode" id="testmode"  class="radio" checked >&nbsp; 
	Send <strong>test only</strong></td></tr>
  -->
  <tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="submit" value="Send" style="padding:10px;">
	<input type="hidden" name="formname" value="adm_bulk_sms">
	 <input type="hidden" name="redirect" value="<?php echo "home.php?d=".$dir; ?>" />				</td>
	
	</tr>
</table>
</form>	
	
	<?php }
	?>




	<!-- content here [end] -->	
	
	
	</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>



</body>
</html>
