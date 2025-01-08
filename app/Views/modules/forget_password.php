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
	<div style="margin-bottom:20px; color:red">
					<?php echo !empty(session()->getFlashdata('error_msg')) ? session()->getFlashdata('error_msg') : ""; ?>
				</div>
		<div class="content column">
						<form name="forgetpassword" id="forgetpassword">
								<div class="registration-form-filed">
									<input type="email" name="email" id="" placeholder="Email Address">
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
		$("#forgetpassword").validate({
			rules: {
				email: {
					required: true,
					email: true
				}

			},

			messages: {

				email: {
					required: " Please enter an email"

				}

			},
			submitHandler: function (form) {
				var formData = $("#forgetpassword").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'send-password-link'; ?>",
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
