<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>

<!-- ****************************** -->

<?php  //echo "<pre>"; print_r($item_data); die; ?>

<!-- Start Banner -->
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Edit Inventory</h1>
		</div>
	</div>
</div>
<!-- End Banner -->

<!-- start main -->
<main id="main">
	<div class="row main-inner">
		<div class="content column">
			<h2>Your Item - #<?php echo $item_data['item_id']; ?></h2>

			<div class="content-buttons">
				<a href="<?php echo base_url() . 'add-list'; ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> Add a New Item
				</a>
                                <a href="<?php echo base_url() . 'item-list'; ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> Go To Item List
				</a>

<!--				<a href="<?= base_url() . 'agent-profile' ?>" id="add" class="button">
					<i class="fas fa-plus small-margin-right"></i> Update your Profile
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

			<form id="editListingForm" style="width:80%">
				<input type="hidden" name="item_id" value="<?php echo !empty($item_data['item_id']) ? $item_data['item_id'] : ''; ?> ">

				<!-- <h2>Add New Listing</h2> -->
				 <div class="form-input-group">
					<label for="item_name">*Product:</label>
					<input type="text" id="item_name" name="item_name" value ="<?php echo !empty($item_data['item_name']) ? $item_data['item_name'] : ''; ?>">
				</div>
                                
				<div class="form-input-group">
					<label for="item_HSN_code">*HSN Code:</label>
					<input type="text" id="item_HSN_code" name="item_HSN_code" value ="<?php echo !empty($item_data['item_HSN_code']) ? $item_data['item_HSN_code'] : ''; ?>">
				</div>


				<div class="form-input-group">
					<label for="price">*Price:</label>
					<input type="text" id="price" name="price" value ="<?php echo !empty($item_data['price']) ? $item_data['price'] : ''; ?>">
				</div>
                                
                                <div class="form-input-group">
					<label for="quantity">*Quantity:</label>
					<input type="number" id="quantity" name="quantity" value ="<?php echo !empty($item_data['quantity']) ? $item_data['quantity'] : ''; ?>">
				</div>
                                
                                <div class="form-input-group">
					<label for="item_purchase_date">Billing/Purchase Date:</label>
					<input type="date" id="item_purchase_date" name="item_purchase_date" value ="<?php echo !empty($item_data['item_purchase_date']) ? $item_data['item_purchase_date'] : ''; ?>">
                                        
				</div>

				<div class="form-input-group">
					<label for="item_description">Product Description:</label>
					<textarea id="item_description" name="item_description"> <?php echo !empty($item_data['item_description']) ? $item_data['item_description'] : ''; ?></textarea>
				</div>

                                <button type="submit">Update</button> <a href="<?= base_url() . 'item-list' ?>"> <button type="button">cancel</button></a>
			</form>
		</div>

<!--		<div class="sidebar column">
			<div class="sidebar-inner">
				<section class="sidebar-block">
					<h2>Quick links</h2>

					<ul>
						<li><a href="<?= base_url() . 'nar-resources-start-date-august-17-2024'; ?>">NAR Resources:
								Start Date August 17th 2024</a></li>
						<li><a href="<?= base_url() . 'nar-resources-mandatory-buyers-broker-agreements'; ?>">NAR
								Resources: Mandatory Buyers Broker Agreements</a></li>
						<li><a href="<?= base_url() . 'nar-resources-contract-signed-prior-to-august-17'; ?>">NAR
								Resources: Contract Signed Prior to August 17th</a></li>
						<li><a href="<?= base_url() . 'nar-resources-written-buyer-agreements'; ?>">NAR Resources:
								Written Buyer Agreements</a></li>
					</ul>
				</section>
			</div>
		</div>-->
	</div>
</main>
<!-- start main  -->

<!-- ****************************** -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>

	$().ready(function () {

		$("#editListingForm").validate({
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
				price: {
					number: true,
                                        required: true
				},quantity: {
					number: true,
                                        required: true
				}

			},

			messages: {

				item_name: {
					required: " Please enter a item name id"
					
				},
				confirm_item_HSN_code: {
					required: " Please enter a HSN code",
					minlength: " Your HSN code must be consist of at least 3 characters",
					equalTo: " Please enter the same HSN code "
				},
				price: {
                                    required:" Please enter item price",
                                    number:" Please enter valid price"
                                },
				quantity: {
                                    required:" Please enter item quantity",
                                    number:" Please enter valid quantity"
                                }
				

			},
			submitHandler: function (form) {
				var formData = $("#editListingForm").serialize();
				$.ajax({
					type: "POST",
					url: "<?= base_url() . 'edit-list-ajax'; ?>",
					cache: false,
					data: formData,
					success: function (b) {
						var c = $.parseJSON(b);
						console.log(c);
						if (c.status == 1) {
							$('#editListingForm').trigger("reset");
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