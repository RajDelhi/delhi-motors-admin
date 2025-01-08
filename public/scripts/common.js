// Global utility functions that may be used by different script files - loaded early
var desktopScreenSize = 1025; // Mobile-desktop screen size cutoff in pixels
var scrollFixedPadding = 30; // Static pixels distance above a scrolled-to target

// jQuery-based scroll position animation
// Target can be a number (y-position) OR a string (element ID)
function animateScroll(target, scrollTimeMilliseconds) {
	// Set default value for time if none provided
	scrollTimeMilliseconds = scrollTimeMilliseconds || 400;

	var targetOffsetTop;

	// Check type of target
	if (typeof target === "number") {
		// Target is a y-position
		targetOffsetTop = target;
	} else if (typeof target === "string") {
		// Target is an element ID, find the element and its offset top

		// Add hashtag if needed
		var targetSelector = target.startsWith("#") ? target : "#" + target;

		targetOffsetTop = jQuery(targetSelector).offset().top;
	} else {
		// If target is neither a number nor a string, log an error or handle as needed
		console.error("Invalid target to scroll to. Please provide a numeric value or an element ID.");
		return;
	}

	// Calculate adjustment value
	var adjustment = getScrollAdjustValue();

	// Apply adjustment if target is not a numeric position
	if (typeof target !== "number") {
		targetOffsetTop -= adjustment;
	}

	jQuery("html, body").animate(
		{
			scrollTop: targetOffsetTop,
		},
		scrollTimeMilliseconds
	);
}

// Returns a pixel height adjustment based precisely on header height
function getScrollAdjustValue() {
	var scrollAdjust = jQuery("#header-desktop").height();

	if (isMobileScreen()) {
		scrollAdjust = jQuery("#header-mobile").height();
	}

	// Add to the returned value to prevent flush against header scroll
	return scrollAdjust + scrollFixedPadding;
}

// Returns true if window is above mobile size
function isDesktopScreen() {
	if (window.innerWidth >= desktopScreenSize) {
		return true;
	}
	return false;
}

// Returns true if window is mobile size
function isMobileScreen() {
	if (window.innerWidth < desktopScreenSize) {
		return true;
	}
	return false;
}

// Returns a random integer between a minimum and maximum
// Minimum is INCLUSIVE, maximum is EXCLUSIVE (min. 1, max. 3 will returns 1s and 2s)
function getRandomInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min) + min);
}

// Returns TRUE if page contains any of selected elements
// Usage: if ($(selector).exists())
jQuery.fn.exists = function () {
	return this.length !== 0;
};

// Adds "active" class to an element
// Usage: $(selector).addActive()
jQuery.fn.addActive = function () {
	jQuery(this).addClass("active");
};

// Removes "active" class from an element
jQuery.fn.removeActive = function () {
	jQuery(this).removeClass("active");
};

// Adds OR removes "active" class to an element, depending on current state
// Usage: $(selector).toggleActive()
jQuery.fn.toggleActive = function () {
	if (jQuery(this).hasClass("active")) {
		jQuery(this).removeClass("active");
		return;
	}
	jQuery(this).addClass("active");
};

// Returns TRUE if an element has the "active" class
// Usage: if ($(selector).isActive())
jQuery.fn.isActive = function () {
	return jQuery(this).hasClass("active");
};

// Sorts elements based on data attribute after load
// Call in document ready like so: $('.search-results-attorneys').sortItems("li", "relevance", true);
// HTML setup has parent container with class "search-results-attorneys" and list items with custom data attribute, e.g. <li data-relevance="50">
jQuery.fn.sortItems = function sortItems(elementType, dataAttribute, ascending) {
	if (ascending) {
		jQuery("> " + elementType, this[0])
			.sort(asc_sort)
			.appendTo(this[0]);
	} else {
		jQuery("> " + elementType, this[0])
			.sort(desc_sort)
			.appendTo(this[0]);
	}

	function asc_sort(a, b) {
		return jQuery(b).data(dataAttribute) > jQuery(a).data(dataAttribute) ? 1 : -1;
	}
	function desc_sort(a, b) {
		return jQuery(b).data(dataAttribute) < jQuery(a).data(dataAttribute) ? 1 : -1;
	}
};

// Resets a form's input and select fields
function resetFormFields(formId) {
	// Get the form element by its ID
	const form = document.getElementById(formId);

	// Check if the form element exists
	if (form) {
		// Get all input and select elements within the form
		const formElements = form.querySelectorAll("input, select");

		// Loop through selected inputs and reset
		formElements.forEach((element) => {
			if (element.tagName === "SELECT") {
				// For <select> elements, set the selected index to the default option (usually index 0)
				element.selectedIndex = 0;
			} else {
				element.value = "";
			}
		});

		console.log("Form #" + formId + " values reset.");
	} else {
		console.error('Form #"' + formId + '" not found; cannot reset.');
	}
}

// Returns value between 0-1 indicating how far down the page the user is scrolled
function getScrollPercent() {
	var h = document.documentElement,
		b = document.body,
		st = "scrollTop",
		sh = "scrollHeight";
	return (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight);
}

// Check "GET" variable in URL
// http://dummy.com/?technology=jquery&blog=jquerybyexample
// var tech = getURLParameter('technology');
var getURLParameter = function getURLParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split("&"),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split("=");

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
};
