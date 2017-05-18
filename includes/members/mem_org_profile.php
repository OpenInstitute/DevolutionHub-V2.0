<?php


$sqdata = "SELECT * FROM `dhub_conf_organizations` WHERE (`organization_id` = ".q_si($us_org_id)."); ";
$rsdata = $cndb->dbQueryFetch($sqdata);
if(count($rsdata))
{
	$fData  = current($rsdata); /*displayArray($fData);*/
	$formaction = "_edit";
	$showForm = true;
	
	$logoname = ($fData['logo'] <> '') ? $fData['logo'] : 'no_image.png';
	$logopath = DISP_LOGOS.$logoname;
	$logosrc  = substr($logoname, 0 , 3);	
	
	/** EXTERNAL IMAGE **/
	if($logosrc == 'htt' or $logosrc == 'www' or $logosrc == 'ftp' or $logosrc == 'ww2') 
	{ $logopath = $logoname;  }
	
}



?>
<style type="text/css">
#core { display: block; }
.profileinfo { /*background: #f8f8f8;*/ width: 100%; padding: 4px 10px; border: 0px solid #b3b3b3; }
.profileinfo h2 { position: relative; }

.gear { position: relative; display: block;  border-bottom: 1px dotted #E5E5E5; }
.gear a.editlink { display: none; }
.datainfo { margin-left: 10px; color: #333; }
label { display: inline-block; font-weight: bold; color: #696969; }
/** @group form inputs **/
.hlite { background: #e2e8f6; border: 1px solid #bdc7d8; width: 250px; margin-left: -7px; padding: 4px 7px; color: #565656; font-size: 12px; }

/** @group buttons **/
.savebtn { text-align: center; background: #5972a8; font-size: 1.2em; cursor: pointer; border: 1px solid #1a356e; color: #fff; -webkit-box-shadow: inset 0 1px 0 #8a9cc2; -moz-box-shadow: inset 0 1px 0 #8a9cc2; box-shadow: inset 0 1px 0 #8a9cc2; display: none; }
.savebtn:hover { color: #fff; background: #607db7; text-decoration: none; }
.savebtn:active { background: #556790; }
</style>

<section id="core">
	<div class="profileinfo">
		<h2></h2>
		
		<div class="gear row padd10_0">
			<label class="col-md-3">Organization Name:</label>
			<span id="organization" data-id="<?php echo $us_org_id; ?>" class="datainfo col-md-7"><?php echo @$fData['organization']; ?></span>
			<a href="#" class="editlink col-md-1 nopadd">Edit Info</a>
			<a class="savebtn col-md-1 nopadd">Save</a>
		</div>
		
		<div class="gear row padd10_0">
			<label class="col-md-3">Primary E-Mail:</label>
			<span id="email" data-id="<?php echo $us_org_id; ?>" class="datainfo col-md-7"><?php echo @$fData['email']; ?></span>
			<a href="#" class="editlink col-md-1 nopadd">Edit Info</a>
			<a class="savebtn col-md-1 nopadd">Save</a>
		</div>
		
		<div class="gear row padd10_0">
			<label class="col-md-3">Primary Phone:</label>
			<span id="phone" data-id="<?php echo $us_org_id; ?>" class="datainfo col-md-7"><?php echo @$fData['phone']; ?></span>
			<a href="#" class="editlink col-md-1 nopadd">Edit Info</a>
			<a class="savebtn col-md-1 nopadd">Save</a>
		</div>
		
		<div class="gear row padd10_0">
			<label class="col-md-3">Website:</label>
			<span id="website" data-id="<?php echo $us_org_id; ?>" class="datainfo col-md-7"><?php echo @$fData['website']; ?></span>
			<a href="#" class="editlink col-md-1 nopadd">Edit Info</a>
			<a class="savebtn col-md-1 nopadd">Save</a>
		</div>
		
		<div class="gear row padd10_0">
			<label class="col-md-3">Profile:</label>
			<span id="profile" data-id="<?php echo $us_org_id; ?>" class="datainfo col-md-7"><?php echo @$fData['profile']; ?></span>
			<a href="#" class="editlink col-md-1 nopadd">Edit Info</a>
			<a class="savebtn col-md-1 nopadd">Save</a>
		</div>
		
		<!--<div class="gear row padd10_0">
			<div class="col-md-12"><span class="avatar-wrap txtcenter noborder"><img src="<?php echo $logopath; ?>" class="avatarX" style="" /></span></div>
		</div>-->
		
		<!--<div class="gear row padd10_0">
			<label class="col-md-3">&nbsp;</label>
			<span id="logo" data-id="<?php echo $us_org_id; ?>" class="datainfo col-md-7"><?php echo @$fData['logo']; ?></span>
			<a href="#" class="editlink col-md-1 nopadd">Edit Info</a>
			<a class="savebtn col-md-1 nopadd">Save</a>
		</div>-->
		
		
	</div>
</section>
<div id="myResult"></div>

<?php //displayArray($fData); ?>


<script type="text/javascript">
jQuery(document).ready(function($){
	$(".editlink").on("click", function(e){
	  e.preventDefault();
		var dataset = $(this).prev(".datainfo");
		var savebtn = $(this).next(".savebtn");
		var theid   = dataset.attr("id");
		var newid   = theid+"-form";
		var currval = dataset.text();		
		
		dataset.empty();		
		$('<input type="text" name="'+newid+'" id="'+newid+'" value="'+currval+'" class="hlite">').appendTo(dataset);
		
		$(this).css("display", "none");
		savebtn.css("display", "block");
	});
	
	$(".savebtn").on("click", function(e){
		e.preventDefault();
		var elink   = $(this).prev(".editlink");
		var dataset = elink.prev(".datainfo");
		var newid   = dataset.attr("id");
		var currorg = dataset.attr("data-id"); 
		
		var cinput  = "#"+newid+"-form";
		var einput  = $(cinput);
		var newval  = einput.attr("value");
		var info = { formname: "frm_profile_org", fldnam: ""+newid+"", fldval: ""+newval+"", org_id: ""+currorg+"" };
		
		$.ajax({
			url: "posts.php", type: "POST", data: {info:info},
			success: function(response) { $('#myResult').html(response); }            
		});
		
		$(this).css("display", "none");
		einput.remove();
		dataset.html(newval);		
		elink.css("display", "block");
	});
});
</script>