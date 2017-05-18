<?php //if(@$dir == ''){ } else { $redirect = 'product.php?pd='.$_REQUEST['product']; }
$redirect = $_SERVER['REQUEST_URI']; //REF_ACTIVE_URL; ?>
<a id="fm-feedback"></a>
<h2 class="txtgray">Send us your Feedback or Enquiries</h2>
<p>To make an Enquiry and/or Suggestion, please fill in the Form below:-</p>
<?php  ?>




<div >
<form class="rwdform rwdfull rwdvalid"  action="posts.php" method="post" name="feedback" id="feedback">

  <div>
    <label class="required" id="title1" for="fullname">Full Name</label>
    <div>
      <input name="fullname" id="fullname" type="text" class="field text fn required" value="" size="8" tabindex="1" placeholder="Full Name" >
    </div>
  </div>
  
  <div>
    <label class="required" id="title3" for="email" >Email</label>
    <div>
      <input id="email" name="email" type="email" spellcheck="false" value="" maxlength="255" tabindex="2" class="required" placeholder="Email" > 
    </div>
  </div>
  
  <div>
    <label class="desc" id="title2" for="phone">Phone</label>
    <div>
      <input id="phone" name="phone" type="text"  class="mask_phone" value="" size="15" tabindex="3" placeholder="e.g. +254 777 123456">
    </div>
  </div>
  

  <div>
    <label class="required" id="title4" for="details">Message</label>
    <div>
      <textarea id="details" name="details"  class="required" spellcheck="true" tabindex="4" placeholder="Message"></textarea>
    </div>
  </div>

   <div>
    <div>
    <?php include("includes/form.captchajx.php"); ?>
    </div>
  </div>
  
  <div>
    <div>
		<?php /*?><input type="reset" name="reset" id="resetbtn" class="resetbtn" value="Reset"><?php */?>
		<input id="saveForm" name="saveForm" type="submit" value="Submit" tabindex="7" />
		<input name="formname" type="hidden" value="feedback" />
		<input name="id_product" type="hidden" value="<?php echo @$_REQUEST['product']; ?>" />
		<input name="formtype" type="hidden" value="Feedback Post" />
		<input name="nah_snd" id="nah_snd" type="text" />  
		<input name="redirect" type="hidden" value="<?php echo $redirect; ?>" />
    </div>
  </div>
  
<div>
	
</div>
</form>


</div>
<div class="clearfix padd10"></div>