<?php
if (isset($_GET['id'])) {
	$user = $conn->query("SELECT * FROM artist_list where id ='{$_GET['id']}' ");
	foreach ($user->fetch_array() as $k => $v) {
		$meta[$k] = $v;
	}
}
?>
<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-purple">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-artist">
				<input type="hidden" name="id" value="<?= isset($meta['id']) ? $meta['id'] : '' ?>">
				<div class="form-group">
					<label for="name">Display Name</label>
					<input type="text" name="stage_name" id="stagename" class="form-control" value="<?php echo isset($meta['stage_name']) ? $meta['stage_name'] : '' ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="password"><?= isset($meta['id']) ? "New" : "" ?> Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
					<?php if (isset($meta['id'])) : ?>
						<small><i>Leave this blank if you dont want to change the password.</i></small>
					<?php endif; ?>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
						<input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))" accept="image/png, image/jpeg">
						<label class="custom-file-label" for="customFile">Choose file</label>
					</div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
				<div class="form-group">
					<label for="about_artist" class="control-label">Tell us about You</label>
					<textarea rows="3" name="about_artist" id="about_artist" class="form-control form-control-sm rounded-0" value="" required><?php echo isset($about_artist) ? $about_artist : ''; ?></textarea>
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
		<div class="col-md-12">
			<div class="row">
				<button class="btn btn-lg btn-success rounded-0 mr-3" form="manage-artist">Sign Up</button>
				<a href="./?page=user/list" class="btn btn-sm btn-default border rounded-0" form="manage-artist"><i class="fa fa-angle-left"></i> Cancel</a>
			</div>
		</div>
	</div>
</div>
<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input, _this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#cimg').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		} else {
			$('#cimg').attr('src', "<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>");
		}
	}
	$('#manage-artist').submit(function(e) {
		e.preventDefault();
		start_loader()
		$.ajax({
			url: _base_url_ + 'classes/Artist.php?f=save',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					location.href = '/?page=login2'
				} else {
					$('#msg').html('<div class="alert alert-danger">Email already exist</div>')
					end_loader()
				}
			}
		})
	})
</script>