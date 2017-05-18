<div style="width:90%; margin:0 auto; border:0px solid">
	
	<div style="padding:10px;">
	
	<?php
	if(isset($_REQUEST['op'])) { $op=$_REQUEST['op']; } else { $op=NULL; }
	if(isset($_REQUEST['id'])) { $id=$_REQUEST['id']; } else { $id=NULL; }
	
	$confDir = ucwords($dir);
	
	if($op=="edit"){ $title_new	= "Edit "; } 
elseif($op=="new") { $title_new	= "New "; }
	
if($op=="edit"){

	if($id){
	
	$sqdata="SELECT `id_category`, `title`, `description`, `published`, `seq`, `title_url` FROM `dhub_reg_cats` WHERE (`id_category`  = ".quote_smart($id).")";
	//echo $sqdata;
	$rsdata=$cndb->dbQuery($sqdata);// ;
	$rsdata_count= $cndb->recordCount($rsdata);
		
		if($rsdata_count==1)
		{
		$cndata= $cndb->fetchRow($rsdata);
		
		$pgtitle				="<h2>Edit $confDir</h2>";
		
		$id					= $cndata[0];
		$title				= html_entity_decode(stripslashes($cndata[1]));
		$description		= html_entity_decode(stripslashes($cndata[2]));
		$published			= $cndata[3]; 
		$position			= $cndata[4]; 
						
		if($published==1) {$published="checked ";} else {$published="";}
				
		$formname			= "fm_usercat_edit";
		}
	}
} elseif($op="new")
	{
	
		$pgtitle				="<h2>New $confDir</h2>";
		
		$id					= "";
		$title				= "";
		$description		= "";
		$published			="checked ";
		$position			= 9;		
		
		$formname			= "fm_usercat_new";
	}
	
	
	?>



	<!-- content here [end] -->	
	<form class="admform" name="rage" method="post" action="adm_posts.php">
	<table width="600px" border="0" cellspacing="0" cellpadding="3" align="center" class="tims">
      <tr>
        <td colspan="3">&nbsp;<?php echo $pgtitle; ?></td>
        </tr>
     
      <tr>
        <td><span class="required">*</span></td>
        <td><strong>  Title:</strong></td>
        <td><input type="text" name="title" value="<?php echo $title; ?>" /></td>
      </tr>
     
      <tr>
        <td>&nbsp;</td>
        <td><strong>Category Details:</strong></td>
        <td>
		<textarea name="description" id="description"><?php echo $description; ?></textarea>		</td>
      </tr>
     <?php /*?> <tr>
        <td>&nbsp;</td>
        <td><strong>Position:</strong></td>
        <td><input type="text" name="position" value="<?php echo $position; ?>" class="radio" maxlength="2"/>&nbsp;&nbsp;</td>
      </tr><?php */?>
      <tr>
       <td>&nbsp;</td>
        <td><strong>Is Active:</strong></td>
        <td><input type="checkbox" name="published" <?php echo $published; ?> class="radio"/> <em>(Yes / No)</em></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Submit" />
		<input type="hidden" name="formname" value="<?php echo $formname; ?>" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="redirect" value="home.php?d=<?php echo $dir; ?>" /></td>
      </tr>
    </table>
	</form>
	
			

	</div>
</div>