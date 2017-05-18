<?php
require '../classes/cls.constants.php';
ini_set("display_errors", "off");
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



<style type="text/css">
.ui-multiselect { width: 600px !important;}
.ui-multiselect-checkboxes li { width: 280px; clear:none; float:left; }

div.multicheck {background: none; overflow:auto; height:120px;padding:5px 1px;border: 1px solid #C5C5C5; width: 630px;}
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
	$pgtitle				="<h2>Portal Bulk E-Mail</h2>";
	$send_to 		= $_SESSION['report_emails'];
	
	/*$send_to_arr 	= explode(";", $send_to);
	$send_to_email  = '';
	
	
	foreach ($send_to_arr as $send_to_value) 
	{
		$send_to_email .= '<label><input type="checkbox" name="id_sendto[]" checked value="'.$send_to_value.'" class="radio" />&nbsp; '.$send_to_value.'</label>';
	}*/
	//displayArray($send_to_arr);
}


	
	 if($op=="new") {
	?>
<form class="admform" name="form_newsletter" id="form_newsletter" method="post" action="adm_posts.php" enctype="multipart/form-data" >

<table border="0" cellspacing="0" cellpadding="0" align="center" width="700">
  <tr>
  <td>&nbsp;</td>
  <td><?php echo $pgtitle; ?></td>
  </tr>
  <tr>
	<td><b>Send To: </b></td>
	<td><textarea name="sendto" id="sendto"  class="required text_full"><?php echo $send_to; ?></textarea>
	
	</td>
	</tr>
  <tr>
	<td><b>Subject</b></td>
	<td><input type="text" name="title"  id="title" class="required text_full" maxlength="100"  ></td>
	</tr>

  
	<tr>
		<td><b>Message</b></td>
		<td><?php include("fck_rage/article_sm.php");  ?></td>
	</tr>
  <!--<tr><td>&nbsp;</td>
	<td><input type="checkbox" name="testmode" id="testmode"  class="radio" checked >&nbsp; 
	Send <strong>test only</strong></td></tr>
  -->
  <tr>
	<td>&nbsp;</td>
	<td><input type="submit" name="submit" value="Send" style="padding:10px;">
	<?php /*?><input type="button" name="preview" value="Preview" style="padding:10px;" ><?php */?>
	<input type="hidden" name="formname" value="adm_bulk_email">
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

<script type="text/javascript">
jQuery(document).ready(function() {
	$("#form_email").validate({ ignore: '' });
});


function getAccounts()
	{
	window.open('pop.mailinglist.php','popup','location=0,status=0,scrollbars=1,resizable=0,width=690,height=550');
	}
	
function insertHTML(html, n) 
{
	//alert(html);
  var browserName = navigator.appName;
	 	 
	if (browserName == "Microsoft Internet Explorer") {	  
	 	document.form_newsletter.sendto.value=html;
	} 
	 
	else {
		document.form_newsletter.sendto.value=html;
	}
	
}
</script>


</body>
</html>
