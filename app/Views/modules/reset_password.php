<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Forget Password</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
						<form name="resetpassword" id="resetpassword">
								<input type="hidden" name="agend_id" value ="<?php echo $agend_id; ?>" >
								<div class="registration-form-filed">
									<input type="password" name="password" id="password" placeholder="Password">
								</div>
								
								<div class="registration-form-filed">
									<input type="password" name="confirm_password" id="confirm_password" placeholder="confirm password">
								</div>
								
								<div class="registration-form-filed">
									<button type="submit" class="button">Submit <i class="fa-light fa-arrow-right"></i>
									</button>
								</div>
						</form>
		</div>
		
	</div>
</main>
<!-- start main  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
	$().ready(function () {
		$("#resetpassword").validate({
			rules: {
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				}

			},

			messages: {

				password: {
					required: " Please enter a password",
					minlength:
						" Your password must be consist of at least 5 characters"
				},
				confirm_password: {
					required: " Please enter a password",
					minlength:
						" Your password must be consist of at least 5 characters",
					equalTo: " Please enter the same password "
				}

			},
			submitHandler: function (form) {
				var formData = $("#resetpassword").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'reset-password-value'; ?>",
					cache: false,
					data: formData,
					success: function (b) {
						var c = $.parseJSON(b);

						if (c.status == 1) {
							$('#forgetpassword').trigger("reset");
							window.location.href = "<?= base_url() . 'forget-password' ?>";
						} else {
							window.location.href = c.URL;

						}
					},
					error: function (b, d, c) {
						alert("Error: There is some problem in processing. Please try again");
					},
				});
			}
		});
	});
</script>
<?= $this->endSection() ?>
