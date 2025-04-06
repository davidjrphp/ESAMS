<?php
// if (isset($_GET['id'])) {
// 	$user = $conn->query("SELECT * FROM artist_list where id ='{$_GET['id']}' ");
// 	foreach ($user->fetch_array() as $k => $v) {
// 		$meta[$k] = $v;
// 	}
// }
?>
<?php require_once('./config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="layout-top-nav layout-fixed control-sidebar-slide-open layout-navbar-fixed text-sm dark-mode" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
	<div class="wrapper">
		<?php require_once('inc/topBarNav.php') ?><br><br><br><br>
		<?php if ($_settings->chk_flashdata('success')) : ?>
			<script>
				alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
			</script>
		<?php endif; ?>
		<div class="card card-outline rounded-0 card-purple" style="width: 100rem; margin-left: 2rem">
			<div class="card-body">
				<div class="container">
					<div id="msg"></div>
					<form action="" id="manage-artist">
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="form-group">
							<label for="" class="control-label">Display Name</label>
							<input type="text" name="stage_name" class="form-control form-control-sm" required value="<?php echo isset($stage_name) ? $stage_name : '' ?>">
						</div>

						<div class="form-group">
							<label class="control-label">Email</label>
							<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>

						<div class="form-group">
							<label class="control-label">Password</label>
							<input type="password" class="form-control form-control-sm" name="password" <?php echo !isset($id) ? "required" : '' ?>>
						</div>

						<div class="form-group">
							<label for="sex">Sex:</label>
							<select class="form-control form-control-sm select2" name="sex" id="sex">
								<option value="<?php echo isset($sex) ? $sex : 'MALE' ?>">MALE</option>
								<option value="<?php echo isset($sex) ? $sex : 'FEMALE' ?>">FEMALE</option>
								<option value="<?php echo isset($sex) ? $sex : 'FEMALE' ?>">OTHERS</option>

							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">Date of Birth</label>
							<input class="form-control form-control-sm" id="dob" name="DOB" type="Date" required value="<?php echo isset($DOB) ? $DOB : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">Display Photo</label>
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
						<div class="form-group">
							<input type="hidden" name="type" id="type" class="form-control form-control-sm rounded-0" required value="3"></input>
						</div>
					</form>
				</div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-md-6">
						<button class="btn btn-lg btn-success rounded-0 mr-3" form="manage-artist">Sign Up</button>
					</div>
					<!-- <div class="col-md-6" style="margin-left: 25rem">
						<a href="./?page=user/list" class="btn btn-sm btn-default border rounded-0" form="manage-artist">Cancel</a>
					</div> -->
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
					url: 'classes/Artists.php?f=registration',
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					success: function(resp) {
						if (resp == 1) {
							location.href = '/?page=login2.php'
						} else {
							$('#msg').html('<div class="alert alert-danger">Email already exist</div>')
							end_loader()
						}
					}
				})
			})
		</script>
	</div>
	<!-- /.content-wrapper -->
	<?php require_once('inc/footer.php') ?>
</body>

</html>