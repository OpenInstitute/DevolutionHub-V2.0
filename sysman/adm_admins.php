<?php include("sec__head.php"); ?>



<!-- @begin :: content area -->
<div>


<?php
	if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
	if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

	if($id){
	
	$sqdata="SELECT 
      `admin_id`, `admin_fname`, `admin_uname`, `admin_email`, `admin_pword`, `admintype_id`, `published`
   FROM 
      `dhub_admin_accounts`
   WHERE 
      (`admin_id`  = $id)";
	//echo $sqdata;
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata= $cndb->fetchRow($rsdata);
		
		$pgtitle				="<h2>Edit Account Details </h2>";
		
		$admin_id					= $cndata[0];
		$admin_fname			= html_entity_decode(stripslashes($cndata[1]));
		$admin_uname			= html_entity_decode(stripslashes($cndata[2]));
		$admin_email			= html_entity_decode(stripslashes($cndata[3]));
		$admin_pword			= html_entity_decode(stripslashes($cndata[4]));
		$admintype_id			= $cndata[5]; 
		$published			= $cndata[6]; 
		
		$requiredField		= "";
		
		if($published==1) {$published="checked ";} else {$published="";}
				
		$formname			= "admins_edit";
		}
	}
} elseif($op=="new")
	{
	
		$pgtitle				="<h2>New Admin Account</h2>";
		
		$id					= "";
		$title				= "";
		
		$published			="checked ";		
		$formname			= "admins_new";
		
		$requiredField		= " required ";
		
	}
	?>



	<div style="margin:auto; width: 600px;">
	<form class="admform" id="admin_accounts" name="rage" method="post" action="adm_posts.php">
    <?php echo $pgtitle; ?>
	<table width="600px" border="0" cellspacing="0" cellpadding="3" align="center" class="tims">
      
      <tr>
        <td>&nbsp;</td>
        <td>Admin Type: </td>
        <td><select name="admintype_id" id="admintype_id" class="required">
		 	<?php echo $ddSelect->dropper_select("dhub_admin_types", "admintype_id", "title", $admintype_id) ?>
		   </select></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>  Admin Name:</td>
        <td><input type="text" name="admin_fname" id="admin_fname" value="<?php echo $admin_fname; ?>" class="required" /></td>
      </tr>
      <tr>
         <td>&nbsp;</td>
        <td>  Admin Email:</td>
        <td><input type="text" name="admin_email" id="admin_email" value="<?php echo $admin_email; ?>" class="required email" /></td>
      </tr>
      
	  <tr>
	     <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      
      <?php if($op=="edit"){ ?>
      <tr>
	     <td colspan="3"><div class="important txtcenter">To Change account's password, enter the New Password and Confirmation below:</div></td>
      </tr>
      <?php } ?>
      
      <tr>
         <td>&nbsp;</td>
        <td>   Username:</td>
        <td><input type="text" name="admin_uname" id="admin_uname" value="<?php echo $admin_uname; ?>" class="required" /></td>
      </tr>
	  
      
	  <tr>
	     <td></td>
        <td>  New Password:</td>
        <td><input type="password" id="admin_pass" name="admin_pass" value="" class="<?php echo $requiredField; ?>" /></td>
      </tr>
      <tr>
         <td></td>
        <td>  Repeat New Password:</td>
        <td><input type="password" id="admin_pass_c" name="admin_pass_c" value="" class="<?php echo $requiredField; ?>" /></td>
      </tr>
     <tr>
       <td>&nbsp;</td>
        <td>Is Active:</td>
        <td><input type="checkbox" name="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Submit" />
		<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
		<input type="hidden" name="id" value="<?php echo $admin_id; ?>" />
		<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" /></td>
      </tr>
    </table>
	</form>

	</div>
</div>
	
	

<div>
<!-- @end :: content area -->
	
</div>
</div>
		
		
<script src="scripts/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#admin_accounts").validate({
			rules: {
				admin_pass: 	{ minlength: 6 },
				admin_pass_c: 	{ equalTo: "#admin_pass" }
				},
			onkeyup: false
			});
	});
</script>
</body>
</html>
