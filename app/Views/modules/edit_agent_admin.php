<?= $this->extend( 'layout/default' ) ?>
<?= $this->section( 'content' ) ?>

<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">User Profile Edit</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<?php //echo "<pre>"; print_r($agent_arr); die; ?>

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>Your Profile</h2>

			<div class="content-buttons">
				<a href="<?php echo base_url() . 'add-list'; ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> Add a New Listing
				</a>

				<a href="<?= base_url() . 'dashboard' ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> User Dashboard
				</a>
				<?php if(is_admin()):?>
				<a href="<?= base_url() . 'all-list' ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> View All Listing
				</a>

				<a href="<?= base_url() . 'all-user' ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> View All Users
				</a>
			<?php endif; ?>	
			</div>

			<?php helper( 'form' ); ?>

			<form id="edit_profile">
				<input type="hidden" name ="agent_id" value = "<?php echo ! empty( $agent_arr['agent_id'] ) ? $agent_arr['agent_id'] : ''; ?>" >
				<div class="form-input-group">
					<label for="agent_real_estate_id">*Real Estate Id:</label>
					<input type="text" id="agent_real_estate_id" name="agent_real_estate_id" value="<?php echo ! empty( $agent_arr['agent_real_estate_id'] ) ? $agent_arr['agent_real_estate_id'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="agent_email">Email:</label>
					<input type="text" id="agent_email" name="agent_email" value="<?php echo ! empty( $agent_arr['agent_email'] ) ? $agent_arr['agent_email'] : ''; ?>" readonly>
				</div>

				<div class="form-input-group">
					<label for="password">Password:( Leave blank if you don't want to change it )</label>
					<input type="password" id="agent_password" name="agent_password"
						value="">
				</div>

				<div class="form-input-group">
					<label for="confirm_password">Confirm Password:</label>
					<input type="password" id="confirm_password" name="confirm_password"
						value="">
				</div>

				<div class="form-input-group">
					<label for="agent_first_name">First Name:</label>
					<input type="text" id="agent_first_name" name="agent_first_name" value="<?php echo ! empty( $agent_arr['agent_first_name'] ) ? $agent_arr['agent_first_name'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="agent_last_name">*Last Name:</label>
					<input type="text" id="agent_last_name" name="agent_last_name" value="<?php echo ! empty( $agent_arr['agent_last_name'] ) ? $agent_arr['agent_last_name'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="agent_phone">Phone:</label>
					<input type="text" id="agent_phone" name="agent_phone" value="<?php echo ! empty( $agent_arr['agent_phone'] ) ? $agent_arr['agent_phone'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="agent_company">*Company:</label>
					<input type="text" id="agent_company" name="agent_company" value="<?php echo ! empty( $agent_arr['agent_company'] ) ? $agent_arr['agent_company'] : ''; ?>">
				</div>

				<div class="form-input-group">
					<label for="agent_company">*Status:</label>
					<?php $agent_status = array(0=>'Deactive', 1=>'Active'); ?>
					<?php echo form_dropdown( 'agent_active', $agent_status, ! empty( $agent_arr['agent_active'] ) ? $agent_arr['agent_active'] : '', [ 'id=>agent_active' ] ); ?>
					
				</div>

				<button class="button" type="submit">Update Profile</button>
			</form>
		</div>

		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<li><a href="#">Lorem ipsum</a></li>
						<li><a href="#">Lorem ipsum dolor sit amet</a></li>
						<li><a href="#">Lorem ipsum dolor sit</a></li>
						<li><a href="#">Lorem ipsum dolor </a></li>
						<li><a href="#">Terms & Conditions</a></li>
						<li><a href="#">Lorem ipsum dolor sit amet</a></li>
					</ul>
				</section>
			</div>
		</div>
	</div>
</main>
<!-- start main  -->

<!-- ****************************** -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
	$().ready( function() {
		$( "#edit_profile" ).validate( {
			rules: {
				agent_first_name: "required",
				agent_last_name: "required",
				agent_email: {
					required: true,
					email: true
				},agent_password: {
					minlength: 5
				},
				confirm_password: {
					minlength: 5,
					equalTo: "#agent_password"
				},
				agent_real_estate_id: {
					required: true

				},
				agent_company: {
					required: true

				},
				agent_phone: {
					required: true

				}

			},

			messages: {
				agent_first_name: " Please enter your first name",
				agent_last_name: " Please enter your last name",
				agent_email: {
					required: " Please enter an email"

				},

				agent_real_estate_id: " Please enter real estate id",
				agent_company: " Please enter company name",
				agent_phone: " Please enter phone number",

			},
			submitHandler: function( form ) {
				var formData = $( "#edit_profile" ).serialize();
				$.ajax( {
					type: "POST",
					url: "<?= base_url() . 'agent-user-ajax'; ?>",
					cache: false,
					data: formData,
					success: function( b ) {
						var c = $.parseJSON( b );
						if ( c.status == 1 ) {
							$( '#edit_profile' ).trigger( "reset" );
							window.location.href = c.URL;
						} else {
							alert( c.message );

						}
					},
					error: function( b, d, c ) {
						alert( "Error: There is some problem in processing. Please try again" );
					},
				} );
			}
		} );
	} );
</script>

<?= $this->endSection() ?>
