<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<!-- ****************************** -->
<?php // echo "asdfasdf <pre>"; print_r($state_list); die; ?>

<!-- Start Banner -->
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Edit Item</h1>
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
				<!-- <h2>Edit Listing</h2> -->
				<input type="hidden" name="id" value="<?php  echo $item_data['id'];  ?>" >	 

				<div class="form-input-group">
					<label for="item_name">*Name:</label>
					<input type="text" id="item_name" name="item_name" value="<?php  echo $item_data['name'];  ?>">
				</div>

				<div class="form-input-group">
					<label for="item_HSN_code">*HSN Code:</label>
					<input type="text" id="item_HSN_code" name="item_HSN_code" value="<?php  echo $item_data['hsn_code'];  ?>">
				</div>

				<div class="form-input-group">
					<label for="unit_type">*Unit Type:</label>
					<select name="unit_type" id="unit_type">
						<option value="PCS" <?php  echo !empty($item_data['unit']) && $item_data['unit'] =="PCS"?"Selected":"";  ?> >PCS</option>
						<option value="LTR" <?php  echo !empty($item_data['unit']) && $item_data['unit'] =="LTR"?"Selected":"";  ?>>LTR</option>
						<option value="UNIT" <?php  echo !empty($item_data['unit']) && $item_data['unit'] =="UNIT"?"Selected":"";  ?>>UNIT</option>
					</select>
				</div>


				<div class="form-input-group">
					<label for="price">*CGSC Tax Rate:</label>
					<input type="text" id="cgst_tax_rate" name="cgst_tax_rate" value="<?php  echo $item_data['cgst_tax_rate'];  ?>">
				</div>

				<div class="form-input-group">
					<label for="price">*SGSC Tax Rate:</label>
					<input type="text" id="sgst_tax_rate" name="sgst_tax_rate" value="<?php  echo $item_data['sgst_tax_rate'];  ?>">
				</div>
				<button type="submit">Update</button>
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
				cgst_tax_rate: {
					required: true
				},
				sgst_tax_rate: {
					required: true
				}

			},

			messages: {

				item_name: {
					required: " Please enter a item name id"

				},
				item_HSN_code: {
					required: " Please enter a HSN code"
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
					url: "<?= base_url() . 'edit-item-ajax'; ?>",
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