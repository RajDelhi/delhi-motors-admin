// Wrap all custom JS in an anonymous function that passes the alias "$" to everything so that "jQuery" doesn't have to be used
(function ($) {
	// Global variables
	var firstPopOpened = false;
	var searchCanStart = true;
	var timeBetweenSearchTriggerMs = 100;
	var searchCanTrigger = true;

	// Document Ready = DOM is ready but content is not necessarily loaded
	$(document).ready(function () {
		console.log("Lazy search functionality ready.");

		// Extra buttons in select pops - close and reset
		$("#attorney-search-clear").on("click", function () {
			document.getElementById("attorney-search-form-ajax").reset();
			$(
				"#attorney-search-form-ajax input, #attorney-search-form-ajax select"
			).removeActive();
			triggerAttorneyFormSearch();
		});

		// Attorney search form select change triggers search
		$("#attorney-search-form-ajax select").on("change", function () {
			triggerAttorneyFormSearch();
		});

		// Letter buttons also trigger search
		$(".attorney-search-letters-single").on("click", function () {
			$("#attorney-hidden-letter").val($(this).data("letter"));
			triggerAttorneyFormSearch();
		});
	});

	// Window Load = Entire page including the DOM is ready
	$(window).load(function () {});

	// Prepares a attorney search, but on a timer
	function delayedSearchTrigger() {
		if (searchCanTrigger == false) {
			return;
		} else {
			searchCanTrigger = false;
		}

		setTimeout(function () {
			triggerAttorneyFormSearch();
			searchCanTrigger = true;
		}, 300);
	}

	// Initiates a attorney search, possibly with gates/conditions
	function triggerAttorneyFormSearch() {
		$("#attorney-search-form-ajax").trigger("submit");
	}

	// Temporarily prevents attorney search trigger
	function disableAttorneySearch() {
		searchCanStart = false;
		setTimeout(enableAttorneySearch, timeBetweenSearchTriggerMs);
	}

	// Re-flags search as triggerable
	function enableAttorneySearch() {
		searchCanStart = true;
		console.log("Lazy search can trigger again");
	}

	$("#attorney-search-form-ajax").on("submit", function (e) {
		e.preventDefault();

		if (searchCanStart == false) {
			return;
		} else {
			console.log("AJAX search form submit...");

			$("#attorney-search-inner").addClass("search-running");
			disableAttorneySearch();
		}

		var formSubmitActionURL = $(this).attr("data-ajax-action"); // Points to file handling AJAX request
		var submittedFormData = $(this).serializeArray();
		var submittedFormDataProcessed = Array();

		// Prep the data for the web server
		submittedFormData.forEach(function (row) {
			submittedFormDataProcessed[row.name] = row.value;
		});

		submittedFormDataProcessed = Object.assign({}, submittedFormDataProcessed);

		jQuery.ajax({
			url: formSubmitActionURL,
			type: "POST",
			data: {
				action: "attorneys_search_change", // PHP hears this action and responds
				attorneysSearchData: submittedFormDataProcessed,
			},
			success: function (response) {
				$("#attorney-search-inner")
					.html(response)
					.removeClass("search-running");
				$("body").addClass("search-results-displayed");
			},
		});
	});
})(jQuery);
