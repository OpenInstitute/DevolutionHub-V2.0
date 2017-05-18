<?php
if($op == 'edit')
{
	include("includes/members/mem_profile_form.php");
	
}
else
{
	
/*$sq_acc = "SELECT `account_id`, concat_ws(' ',`namefirst`, `namelast`) as `name`, `email`, `phone`, `country`, `avatar` FROM `dhub_reg_account` where `account_id` = ".q_si($us_id)."; "; //echobr($sq_acc);
$rs_qry = $cndb->dbQueryFetch($sq_acc);	*/
$mem_arr = $_SESSION['sess_dhub_member']; //current($rs_qry);


$cols_ignore = array('account_id','id_member_type','id_member_post','id_ward','id_jobgroup','id_userlevel','avatar', 'published_member');

/* if($mem_arr['id_member_type'] == 7) 
{ array_push($cols_ignore, 'ward'); } else 
{ array_push($cols_ignore, 'member_post', 'jobgroup');  }*/ 


$tb_key      = 'id_imprest';
$formtitle   = 'Imprest Request';

$picsrc = substr($mem_arr['u_avatar'],0,3);	//EXTERNAL
	if($picsrc == 'htt' or $picsrc == 'www' or $picsrc == 'ftp' or $picsrc == 'ww2') 
	{ 
		$m_pic = $mem_arr['u_avatar']; 
	}
	else
	{

$m_pic = ($mem_arr['u_avatar'] <> '') ? DISP_AVATARS.$mem_arr['u_avatar'] : DISP_AVATARS.'avatar_generic.png'; //;	
}

?>
<div class="subcolumns">
	<div class="c75l">
	<div class="padd15 padd0_t">
	
		<?php //echo display_PageTitle('Account Profile', 'h3', 'txtgray'); ?>
		<div class="subcolumns">
		
		<div>
		<div class="padd10_t">
		<form class="rwdform rwdfull">
			<div><label class="label-auto">Name: </label>
				 <div class="form-control form-mimic" style=""><div><?php echo @$mem_arr['u_fname'].' '.$mem_arr['u_lname']; ?> &nbsp;</div></div>
			</div>
			<div><label class="label-auto">Email: </label>
				 <div class="form-control form-mimic" style=""><div><?php echo @$mem_arr['u_email']; ?> &nbsp;</div></div>
			</div>
			<div><label class="label-auto">Phone: </label>
				 <div class="form-control form-mimic" style=""><div><?php echo @$mem_arr['u_phone']; ?> &nbsp;</div></div>
			</div>
			<div><label class="label-auto">Country: </label>
				 <div class="form-control form-mimic" style=""><div><?php echo @$mem_arr['u_country']; ?> &nbsp;</div></div>
			</div>
			<div><label class="label-auto">Organization: </label>
				 <div class="form-control form-mimic" style=""><div><?php echo @$mem_arr['u_organization']; ?> &nbsp;</div></div>
			</div>	  
					  
		<?php
		/*foreach ($mem_arr as $ckey => $cval)
		{
			if(!in_array($ckey, $cols_ignore)) {
				$clabel = $ckey;
				
				if($ckey == 'residence_distance') { $clabel = 'Distance From Assembly (km)'; }
				if($ckey == 'date_birth') { $cval = (strtotime($cval) > 0)? date('F j, Y', strtotime($cval)): ''; }
				
				echo '<div><label class="label-auto">'.clean_title($clabel).': </label>
					  <div class="form-control form-mimic" style=""><div>'.clean_title($cval).' &nbsp;</div></div></div>';
			}
			
		}*/
		
		?>
		<div><p>&nbsp;</p></div>
		</form>
		</div>
		</div>
		
		
		</div>
	
	
	</div>
	</div>
	
	
	<div class="c25r">
	<div class="padd10">
		
		<div>
		<div class="subcolumns padd10_0 ">
			<span class="avatar-wrap">
			<img src="<?php echo $m_pic; ?>" class="avatar" style="" />
			</span>
		</div>
		</div>
		
		
		<div>
        <div class="list-group">
			<a class="list-group-item primary">Personal Account Information</a>
			<a href="profile.php?ptab=profile&op=edit" class="list-group-item">Update Account Information</a>
			<a rel="modal:open" data-href="ajforms.php?d=member_avatar"  class="list-group-item">Profile Avatar</a>			
			<?php /*?><a rel="modal:open" href="#profileAvatar" class="list-group-item">Bank Details</a>
			<a rel="modal:open" data-href="ajmore.php?fcall=member_password" class="list-group-item">Change Password</a><?php */?>
        </div>
			<?php /*?><a data-toggle="modal" href="#emailTenant" class="btn btn-block btn-primary btn-icon"><i class="fa fa-envelope"></i> Email John Smith</a><?php */?>
		</div>
			
	</div>
	</div>
	
	
</div>



<?php
}
?>
