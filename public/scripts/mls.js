$().ready(function () {

	$("#addListingForm").validate({
		rules: {
			mls_id: {
				required: true,
				minlength: 3
			},
			confirm_mls_id: {
				required: true,
				minlength: 3,
				equalTo: "#mls_id"
			},
			mls_commission:{
				number: true
			},
			mls_address1: {
				required: true
			
			},
			mls_city: {
				required: true

			},mls_state: {
				required: true

			},mls_zip: {
				required: true

			},mls_start_date: {
				required: true

			},mls_end_date: {
				required: true
				

			}

		},

		messages: {
			
			mls_id: {
				required: " Please enter a mls id",
				minlength:	" Your mls id must be consist of at least 3 characters"
			},
			confirm_mls_id: {
				required: " Please enter a mls id",
				minlength:" Your mls id must be consist of at least 3 characters",
				equalTo: " Please enter the same mls id "
			},
			mls_address1: " Please enter mls address",
			mls_city: " Please enter city",
			mls_state: " Please select state",
			mls_zip: " Please enter zip",
			mls_start_date: " Please select start date",
			mls_end_date:" Please select end date"

		},
		submitHandler: function (form) {
			var formData = $("#addListingForm").serialize();
			$.ajax({
				type: "POST",
				url: "<?= base_url() . 'add-mls'; ?>",
				cache: false,
				data: formData,
				success: function (b) {
					var c = $.parseJSON(b);
					console.log(c);
					if (c.status == 1) {
						$('#addListingForm').trigger("reset");
						alert(c.message);
					}
					else {
						alert(c.message);

					}
				},
				error: function (b, d, c) {
					alert("Error: There is some problem in processing. Please try again");
				},
			});
		}
	});

	//****************************************************************** */

	$("#editListingForm").validate({
		rules: {
			mls_id: {
				required: true,
				minlength: 3
			},
			mls_commission:{
				number: true
			},
			mls_address1: {
				required: true
			
			},
			mls_city: {
				required: true

			},mls_state: {
				required: true

			},mls_zip: {
				required: true

			},mls_start_date: {
				required: true

			},mls_end_date: {
				required: true
				

			}

		},

		messages: {
			
			mls_id: {
				required: " Please enter a mls id",
				minlength:	" Your mls id must be consist of at least 3 characters"
			},
			confirm_mls_id: {
				required: " Please enter a mls id",
				minlength:" Your mls id must be consist of at least 3 characters",
				equalTo: " Please enter the same mls id "
			},
			mls_address1: " Please enter mls address",
			mls_city: " Please enter city",
			mls_state: " Please select state",
			mls_zip: " Please enter zip",
			mls_start_date: " Please select start date",
			mls_end_date:" Please select end date"

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
						alert(c.message);
					}
					else {
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