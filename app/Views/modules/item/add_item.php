<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<!-- ****************************** -->
<?php // echo "asdfasdf <pre>"; print_r($state_list); die; ?>

<!-- Start Banner -->
<div class="banner" id="banner"  style="height: 90px">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Add Item</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<div class="content-buttons">
				<a href="<?php echo base_url() . 'item-list'; ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> Go To Item List
				</a>
			</div>

			<?php helper('form'); ?>

			<form id="addListingForm" style="width:80%">
				<!-- <h2>Add New Listing</h2> -->

				<div class="form-input-group">
					<label for="item_name">*Name:</label>
					<input type="text" id="item_name" name="item_name">
				</div>

				<div class="form-input-group">
					<label for="item_HSN_code">*HSN Code:</label>
					<input type="text" id="item_HSN_code" name="item_HSN_code">
				</div>

				<div class="form-input-group">
					<label for="confirm_item_HSN_code">*Confirm HSN Code:</label>
					<input type="text" id="confirm_item_HSN_code" name="confirm_item_HSN_code">
				</div>

				<div class="form-input-group">
					<label for="unit_type">*Unit Type:</label>
					<select name="unit_type" id="unit_type">
						<option value="PCS">PCS</option>
						<option value="LTR">LTR</option>
						<option value="SET">SET</option>
						<option value="GRAM">GRAM</option>
						<option value="UNIT">UNIT</option>
					</select>
				</div>

				<div class="form-input-group">
					<label for="price">*CGSC Tax Rate:</label>
					<input type="text" id="cgst_tax_rate" name="cgst_tax_rate">
				</div>

				<div class="form-input-group">
					<label for="price">*SGSC Tax Rate:</label>
					<input type="text" id="sgst_tax_rate" name="sgst_tax_rate">
				</div>
				<div style="color:red;font-size:12px">Note: For other state billing, ICGST will be addition of CGST & SGST</div>
				<button type="submit">Add</button>
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

		$("#addListingForm").validate({
			rules: {
				item_name: {
					required: true
				},
				item_HSN_code: {
					required: true
				},
				confirm_item_HSN_code: {
					required: true,
					minlength: 3,
					equalTo: "#item_HSN_code"
				},
				cgst_tax_rate: {
					required: true
				},
				sgst_tax_rate: {
					required: true
				}

			},

			messages: {

				item_name: {
					required: " Please enter a item name "

				},
				item_HSN_code: {
					required: " Please enter a HSN code",
					minlength: " Your HSN code must be consist of at least 3 characters",
					equalTo: " Please enter the same HSN code "
				},
				cgst_tax_rate: {
					required: " Please enter cgst tax rate"
				},
				sgst_tax_rate: {
					required: " Please enter sgst tax rate"
				}


			},
			submitHandler: function (form) {
				var formData = $("#addListingForm").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'add-item'; ?>",
					cache: false,
					data: formData,
					success: function (b) {
						var c = $.parseJSON(b);
						console.log(c);
						if (c.status == 1) {
							$('#addListingForm').trigger("reset");
							//alert(c.message);
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