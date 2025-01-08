
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
			estate_id: {
				required: true

			}, company: {
				required: true

			}, mobile: {
				required: true

			}, term: {
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
			estate_id: " Please enter real estate id",
			company: " Please enter company name",
			mobile: " Please enter phone number",
			term: "Please accept terms and conditions",

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