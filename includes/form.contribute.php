<div>
<div class="padd10">
	<p>Did you know you can contribute a resource to DevolutionHub.or.ke?</p>
	
<?php
if(!isset($_SESSION['sess_dhub_member'])) {	
?>
	<p>To constribute, <A data-href="ajforms.php?d=account" id="ft-contribute" title="Sign In / Sign Up" rel="modal:open">Register</A> as a member.</p>
<?php
} else {
	echo '<p>Click <a href="profile.php?ptab=resources&op=new">here</a> to contribute.</p>';
}
?>
</div>
<?php /*
<form  name="fm_contribute"  id="fm_contribute" class="rwdform rwdvalid" action="posts.php" method="post" onsubmit="return false;" >
<!--<div class="errorBoxX" id="errorReg">All fields are required!</div>  onsubmit="return false;"-->

<div class="form-group form-row">
<INPUT TYPE="text"  id="ac_name" NAME="ac_name"  class="required form-control col-md-6 " maxlength="50" placeholder="Your Name"  />
<input type="text" name="ac_email" id="ac_email" class="required email form-control col-md-6" maxlength="50" placeholder="Your Email" value="" autocomplete="off" />
</div>


<div class="form-group form-row">
	<input type="file" name="ac_file" id="ac_file" class="required form-control col-md-12" maxlength="50" placeholder="Attach resource" accept="application/pdf" />
</div>


<div class="form-group form-row">
	<textarea name="ac_brief" id="ac_brief" class="form-control col-md-12 required" placeholder="Enter resource description" style="height:40px;"></textarea>
</div>


<div class="form-group form-row">
	<div class="col-md-8 nopadd"><?php include("includes/form.captchajx.sm.php"); ?></div>
	<div class="col-md-4 nopadd pull-right">
		<input id="contribute_submit" NAME="contribute_submit" class="form-control col-md-12" style="width:100%" type="submit" value="Submit Resource"/>
		<input  NAME="formname" type="hidden" value="fm_contribute" />
		<input  NAME="formtype" type="hidden" value="Contribute Resource" />
		<input  NAME="nah_snd" id="nah_snd" type="text">  
		<input name="redirect" type="hidden" value="result.php<?php echo $ref_qrystr; ?>" />
	</div>
</div>


</form>
*/ ?>

</div>