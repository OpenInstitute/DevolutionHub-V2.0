
<?php echo display_PageTitle('Register For Conference'); ?>

<div>



<form  name="fm_conf_register"  id="fm_conf_register" class="rwdform rwdvalid" action="posts.php" method="post" >
<div class="errorBox" id="errorReg">Highlighted fields are required!</div>

<h3>Registration Type</h3> 
<div>
<label class="required" for="ac_name_first">Register As:</label>
<div class="radio_group wid50 require-onex">
<label><input type="radio" name="reg_type" value="Platinum Sponsor" class="radio require-one" /> Platinum Sponsor (Kshs  5,000,000)</label>
<label><input type="radio" name="reg_type" value="Gold Sponsor" class="radio require-one" /> Gold Sponsor (Kshs  3,000,000)</label>
<label><input type="radio" name="reg_type" value="Silver Sponsor" class="radio require-one" /> Silver Sponsor (Kshs  2,000,000)</label>
<label><input type="radio" name="reg_type" value="Dinner Sponsor" class="radio require-one" /> Dinner Sponsor (Kshs  1,500,000)</label>
<label><input type="radio" name="reg_type" value="Lunch Sponsor" class="radio require-one" /> Lunch Sponsor (Kshs  1,000,000)</label>
<label><input type="radio" name="reg_type" value="Welcome Reception" class="radio require-one" /> Welcome Reception (Kshs  700,000)</label>
<label><input type="radio" name="reg_type" value="Bag Sponsor" class="radio require-one" /> Bag Sponsor (Kshs  500,000)</label>
<label><input type="radio" name="reg_type" value="Exhibitor" class="radio require-one" /> Exhibitor (Kshs  120,000)</label>
<label><input type="radio" name="reg_type" value="USB Sponsor" class="radio require-one" /> USB Sponsor</label>
<label><input type="radio" name="reg_type" value="Delegate" class="radio require-one" /> Delegate</label>
</div>
</div>

<h3>Basic Details</h3>

<div>
<label class="required" for="fullname">Full Name:</label>
<div>
  <input name="fullname" id="fullname" type="text" class="field text fn required" value="" size="8" tabindex="1" placeholder="Full Name" >
</div>
</div>
  
  <div>
    <label class="required" for="email" >Email:</label>
    <div>
      <input id="email" name="email" type="email" spellcheck="false" value="" maxlength="255" tabindex="2" class="required" placeholder="Email" > 
    </div>
  </div>
  
  <div>
    <label class="desc" for="phone">Mobile Number:</label>
    <div>
      <input id="phone" name="phone" type="text"  class="required mask_phone" value="" size="15" tabindex="3" placeholder="e.g. +254 777 123456">
    </div>
  </div>

<h3>Other Details</h3>  
  
<div>
<label class="required" for="organization">Organization / Institution Name:</label>
<div><input type="text" name="organization" id="organization" class="required" size="8" tabindex="" ></div>
</div> 

<div>
<label class="required" for="jobtitle">Job Title / Position:</label>
<div><input type="text" name="jobtitle" id="jobtitle" class="required" size="8" tabindex="" ></div>
</div> 

<div><div><?php include("includes/form.captchajx.php"); ?></div></div>


<div>&nbsp;</div>


<section class="important curvy txt95">
<div class="padd15X">
	<h4>Exhibition Booth Allocation</h4>
<ul><li>Sponsorship and exhibition packages, which may be limited in number, will be generally allocated to those organizations who
apply earliest. Allocation of sponsorship packages and booths regardless of the preference indicated, and alteration of the floor
plan is at the discretion of  the Conference Organizing Committee and Conference Organizer, whose decision will be final.</li></ul>

<h4>Cancellation Policy</h4>
<ul><li>Once an Acceptance Form has been received, any cancellation must be advised in writing to the organizing committee .
If the cancellation is received less than 2 weeks prior, no refund is applicable.</li></ul>

<h4>Detailed Requirements and Due Dates</h4>
<ul><li>The Conference Organizing Committee and Conference Organizer requirements regarding the artwork for logos and advertise-
ments, specifications and delivery details for branding arrangements for static display, or other arrangements will be sent to you
in a confirmation letter at a later date with relevant due dates.</li>

<li>In the event that materials, information or artwork required by the Conference Organizer are not received by the designated due date, their use for their intended purpose cannot be guaranteed. The value of these entitlements will not be refunded if this is the case.</li>

<li>Logos will be requested in PDF, .jpg and .eps format, at least high resolution 300dpi. Should an alternative format be received, the Conference Organizer cannot be held responsible for the quality of the logos displayed in any of the promotional material. </li></ul>
</div>
</section>


<div><div class="padd5"></div></div>

<?php /*?><div>
<div class="radio_group">
<label for="mailing"><input type="checkbox" class="radio" name="mailing" id="mailing" /> Subscribe to receive updates </label>
</div>
</div><?php */?>

<div>
<div class="radio_group">
<label for="ac_agreeterms" class="label-checkboxX required"><input type="checkbox" class="radio required" name="ac_agreeterms" id="ac_agreeterms" /> I HAVE READ, UNDERSTOOD AND ACCEPT THE <a>TERMS AND CONDITIONS</a> </label>
</div>
</div>



<div><div class="padd5"></div></div>

<div>
	<div>
	<button type="input" name="regSubmit" class="btn btn-success btn-icon width-half"> Submit</button>
	
	<input  NAME="formname" type="hidden" value="fm_conf_register" />
	<input  NAME="formtype" type="hidden" value="Conference Registration" />
	<input  NAME="nah_snd" id="nah_snd" type="text">  
	<input name="redirect" type="hidden" value="result.php<?php echo $ref_qrystr; ?>" />
</div>
</div>

</form>

<div id="reg_result"></div>


</div>

<script language="javascript">

jQuery(document).ready(function($)
{
	
});
</script>