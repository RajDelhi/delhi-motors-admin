<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">User Profile Edit</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<?php //echo "<pre>"; print_r($emp_arr); die; ?>

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>Your Profile</h2>

			<div class="content-buttons">
<!--				<a href="<?php echo base_url() . 'add-list'; ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> Add a New Listing
				</a>

				<a href="<?= base_url() . 'dashboard' ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> User Dashboard
				</a>-->
				<?php if (is_admin()): ?>
<!--					<a href="<?= base_url() . 'all-list' ?>" id="add" class="button">
						<i class="fas fa-plus small-margin-right"></i> View All Listing
					</a>

					<a href="<?= base_url() . 'all-user' ?>" id="add" class="button">
						<i class="fas fa-plus small-margin-right"></i> View All Users
					</a>-->
				<?php endif; ?>
			</div>

			<?php helper('form'); ?>

			<form id="edit_profile">
				

				<div class="form-input-group">
					<label for="emp_email">Email:</label>
					<input type="text" id="emp_email" name="emp_email"
						value="<?php echo !empty($emp_arr['emp_email']) ? $emp_arr['emp_email'] : ''; ?>" readonly>
				</div>

				<div class="form-input-group">
					<label for="password">Password:( Leave blank if you don't want to change it )</label>
					<input type="password" id="emp_password" name="emp_password"
						value="">
				</div>

				<div class="form-input-group">
					<label for="confirm_password">Confirm Password:</label>
					<input type="password" id="confirm_password" name="confirm_password"
						value="">
				</div>
                            
                                <div class="form-input-group">
					<label for="emp_first_name">*First Name:</label>
					<input type="text" id="emp_first_name" name="emp_first_name"
						value="<?php echo !empty($emp_arr['emp_first_name']) ? $emp_arr['emp_first_name'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="emp_last_name">*Last Name:</label>
					<input type="text" id="emp_last_name" name="emp_last_name"
						value="<?php echo !empty($emp_arr['emp_last_name']) ? $emp_arr['emp_last_name'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="emp_phone">Phone:</label>
					<input type="text" id="emp_phone" name="emp_phone"
						value="<?php echo !empty($emp_arr['emp_phone']) ? $emp_arr['emp_phone'] : ''; ?>">
				</div>

				

				<button class="button" type="submit">Update Profile</button>
			</form>
		</div>


	</div>
</main>
<!-- start main  -->

<!-- ****************************** -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
	$().ready(function () {
		$("#edit_profile").validate({
			rules: {
				emp_first_name: "required",
				emp_last_name: "required",
				emp_email: {
					required: true,
					email: true
				},emp_password: {
					minlength: 5
				},
				confirm_password: {
					minlength: 5,
					equalTo: "#emp_password"
				},
				emp_phone: {
					required: true

				}

			},

			messages: {
				emp_first_name: " Please enter your first name",
				emp_last_name: " Please enter your last name",
				emp_email: {
					required: " Please enter an email"

				},
				emp_phone: " Please enter phone number",

			},
			submitHandler: function (form) {
				var formData = $("#edit_profile").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'agent-profile-ajax'; ?>",
					cache: false,
					data: formData,
					success: function (b) {
						var c = $.parseJSON(b);
						if (c.status == 1) {
							$('#edit_profile').trigger("reset");
							window.location.href = c.URL;
						} else {
							alert(c.message);

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