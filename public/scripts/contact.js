// Contact form and reCAPTCHA processing
(function ($) {
	var captchaLoaded = false; // Flags when Google reCAPTCHA script has been added to the page

	// Define constraints for form error checking here; please see: https://validatejs.org/
	var constraints = {
		// Each is the "name" field of the input!
		name: {
			presence: {
				message: "^Please enter your name",
			},
		},
		email: {
			presence: {
				message: "^Please enter your email address",
			},
			email: {
				message: "^Invalid email address",
			},
		},
		phone: {
			presence: {
				message: "^Please enter your phone number",
			},
			format: {
				pattern: "^[0-9/-]+$",
				message: "^Phone number can only contain numbers and dashes",
			},
			length: {
				minimum: 7,
				tooShort: "^Please enter at least %{count} characters",
			},
		},
	};

	$(function () {
		// Load reCAPTCHA script when certain form field is focused
		$(".contact-form input, .contact-form textarea").on("focus", function () {
			// Check that the script hasn't already loaded
			if (captchaLoaded) {
				return;
			}

			console.log("reCAPTCHA script loading.");

			var head = document.getElementsByTagName("head")[0];
			var script = document.createElement("script");
			script.type = "text/javascript";
			script.src = "https://www.google.com/recaptcha/api.js";
			head.appendChild(script);
			captchaLoaded = true; // Set flag to only load once
		});

		$(".contact-form input").on("focusout", function (event) {
			// "Live validation" - Validates form input when it loses focus
			errors = validate($(this).closest("form"), constraints);

			// Look for matching errors specific to this input
			applyInputErrors($(this), errors);
		});

		// Remove input error when it is focused
		$("input").on("focusin", function (event) {
			resetInputErrors($(this));
		});
	});

	$(".contact-form").submit(function (e) {
		// This BLOCKS submission of the form. The reCAPTCHA callback function submits
		e.preventDefault();
		console.log("Contact form submitted.");

		// On form submit, run validate.js on the form using defined constraints
		errors = validate($(this), constraints);

		// If errors are found, prevent form submission and provide feedback
		if (errors) {
			$(this)
				.find("input")
				.each(function () {
					// Loop through inputs on the form, finding any error corresponding to this field's "name"
					applyInputErrors($(this), errors);
				});
		} else {
			var captchaID = getCaptchaID($(this).find(".g-recaptcha").attr("id"));

			grecaptcha.reset(captchaID);
			grecaptcha.execute(captchaID);
		}
	});

	// In case of multiple forms, returns unique ID of a specific reCAPTCHA so correct one is submitted
	function getCaptchaID(containerID) {
		var returnedID = -1;

		$(".g-recaptcha").each(function (index) {
			if (this.id == containerID) {
				returnedID = index;
				return;
			}
		});

		return returnedID;
	}

	// Input validation: Searches any error corresponding to this field's "name"
	function applyInputErrors(inputToCheck, errorsList) {
		var matchingError = errorsList[$(inputToCheck).attr("name")];

		if (matchingError) {
			// If there IS an error on this input, add styling and error text
			resetInputErrors($(inputToCheck)); // Remove existing errors
			$(inputToCheck).addClass("has-error");
			$(inputToCheck)
				.parent()
				.append("<p class='error-text'>" + matchingError + "</p>");
		}
	}

	// Input validation: Reset errors shown on input
	// Called when input is focused and when a new error is being applied
	function resetInputErrors(inputToReset) {
		$(inputToReset).removeClass("has-error");
		$(inputToReset).siblings("p.error-text").remove();
	}
})(jQuery);

// Handle invisible reCAPTCHA on submit
function submitContactStandard(token) {
	console.log("Invisible reCAPTCHA submitted: #contact-formStandard");
	document.getElementById("contact-formStandard").submit();
}

// Handle additional contact form on same page
function submitContactFooter(token) {
	document.getElementById("contact-formFooter").submit();
}
