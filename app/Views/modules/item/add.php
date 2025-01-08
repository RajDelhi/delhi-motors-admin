<?= $this->extend( 'layout/default' ) ?>
<?= $this->section( 'content' ) ?>

<!-- ****************************** -->
<?php // echo "asdfasdf <pre>"; print_r($state_list); die; ?>

<!-- Start Banner -->
<div class="banner" id="banner">
	<div class="row">
		<div class="banner-inner columns">
			<h1 class="banner-title">Add Inventory</h1>
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
                    
			<?php helper( 'form' ); ?>

			<form id="addListingForm" style="width:80%">
				<!-- <h2>Add New Listing</h2> -->
                                
                                <div class="form-input-group">
					<label for="item_name">*Product:</label>
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
					<label for="price">*Price:</label>
					<input type="text" id="price" name="price">
				</div>
                                
                                <div class="form-input-group">
					<label for="quantity">*Quantity:</label>
					<input type="number" id="quantity" name="quantity">
				</div>
                                
                                <div class="form-input-group">
					<label for="item_purchase_date">Billing/Purchase Date:</label>
					<input type="date" id="item_purchase_date" name="item_purchase_date">
                                        
				</div>

				<div class="form-input-group">
					<label for="item_description">Product Description:</label>
					<textarea id="item_description" name="item_description"></textarea>
				</div>

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

	$().ready( function() {

		$( "#addListingForm" ).validate( {
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
			submitHandler: function( form ) {
				var formData = $( "#addListingForm" ).serialize();
				$.ajax( {
					type: "POST",
					url: "<?= base_url() . 'add-list'; ?>",
					cache: false,
					data: formData,
					success: function( b ) {
						var c = $.parseJSON( b );
						console.log( c );
						if ( c.status == 1 ) {
							$( '#addListingForm' ).trigger( "reset" );
							//alert(c.message);
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
