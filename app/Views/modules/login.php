<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<!-- Start Banner -->
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Start Your Item Listing Now</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<!-- start comparison section -->
	<section class="registration">
		<div class="row">
			<div class="column no-float">
				<h2> Account Information</h2>

				<div style="margin-bottom:20px; background-color:lightgreen">
					<?php echo !empty(session()->getFlashdata('success_smg')) ? session()->getFlashdata('success_smg') : ""; ?>
				</div>

				<br>

				<div class="registration-inner">
					<div class="registration-left">
						<h3>Create a New Account</h3>

						<p>For the best user experience, use Edge, Firefox or Chrome web browsers.</p>

						<form class="registration-wrap" name="registration" id="registration">
							<div class="registration-form-filed">
								<input type="text" name="first_name" id="first_name" maxlength="30"
									placeholder="*First NAME">
							</div>

							<div class="registration-form-filed">
								<input type="text" name="last_name" id="last_name" maxlength="30"
									placeholder="*Last Name">
							</div>

							<div class="registration-form-filed">
								<input type="email" name="email" id="email" maxlength="60" placeholder="*Email Address">
							</div>

<!--							<div class="registration-form-filed">
								<input type="text" name="estate_id" id="estate_id" maxlength="20"
									placeholder="*Real Estate ID">
							</div>-->

<!--							<div class="registration-form-filed">
								<input type="text" name="company" id="company" maxlength="50" placeholder="*Company">
							</div>-->

							<div class="registration-form-filed">
								<input type="text" name="mobile" id="mobile" maxlength="15" placeholder="*Phone">
							</div>

							<div class="registration-form-filed">
								<input type="password" name="password" id="password" maxlength="50"
									placeholder="*Password">
							</div>

							<div class="registration-form-filed">
								<input type="password" name="confirm_password" id="confirm_password" maxlength="50"
									placeholder="*Confirm Password">
							</div>

							

							<div class="registration-form-filed w-100">
								<button type="submit" class="button">Register Now <i class="fa-light"></i></button>
							</div>
						</form>
					</div>

					<div class="registration-right">
						<h3>Existing Account login</h3>

						<p>If you are already registered and are adding a new inventory, then please login:</p>

						<h4>Already Registered?</h4>

						<p>Login to your account now:</p>

						<form name="login" id="login">
							<div class="registration-form-filed">
								<input type="email" name="email" id="" placeholder="Email Address">
							</div>

							<div class="registration-form-filed">
								<input type="password" name="password" id="password" placeholder="Password">
							</div>

							<div class="registration-form-filed">
								<button type="submit" class="button">Login Now <i class="fa-light fa-arrow-right"></i>
								</button>
							</div>
						</form>

						<a href="<?php echo base_url().'forget-password'; ?>" class="registration-forget-password">Forgot Password?</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end comparison section -->
</main>
<!-- end main  -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
	$().ready(function () {
		$("#registration").validate({
			rules: {
				first_name: "required",
				last_name: "required",
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				},
				mobile: {
					required: true

				}

			},

			messages: {
				first_name: " Please enter your first name",
				last_name: " Please enter your last name",
				email: {
					required: " Please enter an email"

				},
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
				},
				
				mobile: " Please enter phone number",
				

			},
			errorPlacement: function (error, element) {

				var placement = $(element).data('error');
				if (placement) {
					$(placement).append(error)
				} else if (element.attr("name") == "term") {
					error.appendTo(".checkbox_error");
				} else {
					error.insertAfter(element);
				}
			},
			submitHandler: function (form) {
				var formData = $("#registration").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'register'; ?>",
					cache: false,
					data: formData,
					success: function (b) {
						var c = $.parseJSON(b);
						console.log(c);
						if (c.status == 1) {
							$('#registration').trigger("reset");
							//alert(c.message);
							window.location.href = c.URL;
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

		$("#login").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 5
				}

			},

			messages: {

				email: {
					required: " Please enter an email"

				},
				password: {
					required: " Please enter a password"

				}

			},
			submitHandler: function (form) {
				var formData = $("#login").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'signin'; ?>",
					cache: false,
					data: formData,
					success: function (b) {
						var c = $.parseJSON(b);

						if (c.status == 1) {
							$('#login').trigger("reset");
							window.location.href = "<?= base_url() . 'dashboard' ?>";
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