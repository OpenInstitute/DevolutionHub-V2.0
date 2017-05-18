<form class="rwdform rwdfull rwdvalid " name="fm_vds" id="fm_avatar" method="post"  enctype="multipart/form-data"> 
<input type="hidden" name="formtab" value="member_avatar" />
<input type="hidden" name="formaction" value="_new" />
<input type="hidden" name="formname" value="fm_member_avatar" />
<input type="hidden" name="redirect" value="profile.php?ptab=profile" />
	<div id="upload_response"></div>
	<div class="modal-bodyX">
		<h3>Upload a New Avatar Image.<em class="txtgray txt10"> Allowed Avatar File Types: jpg, jpeg, png</em></h3>
	</div>
	
		<div class="form-group">
			<label for="file">Select New Avatar</label>
			<div>
			<input type="file" id="file" name="idoc[]" accept="image/*"  class="required width-full" >
			<p class="help-block">All Avatars will be displayed at a max-height of 150 pixels</p>
			</div>
		</div>
	
	<div class="modal-footerX txtcenter">
		<input type="hidden" name="avatarName" id="avatarName" value="avatarName" />
		<button type="input" name="submit" value="updateAvatar" class="btn btn-success btn-icon"><i class="fa fa-check-square-o"></i> Upload</button>
		<button type="button" class="btn btn-warning btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
	</div>
</form>

<script>
jQuery(document).ready(function($)
{
	var files; $('input[type=file]').on('change', prepareUpload);	/* Add events */
	function prepareUpload(event){ files = event.target.files; } /* Grab the files and set them to our variable*/
	
	$("#fm_avatar").validate({
		errorPlacement: function(error, element) { },
		submitHandler: function(form) {			
			var dataArr  = $(form).serializeArray(); 
			var formData = new FormData($("#fm_avatar"));
			for (var i in dataArr) { formData.append(dataArr[i].name, dataArr[i].value); }
			$.each(files, function(key, value) { formData.append('idoc[]', value); });
			
			$.ajax({
				url: 'posts.php',
				type: form.method,
				data: formData, 
				processData: false, 
				contentType: false,
				beforeSend: function() { $('#upload_response').html('Uploading...'); },
				success: function(response) { $('#upload_response').html(response); location.reload(); }
			});
		}
	}); 
});
</script>

