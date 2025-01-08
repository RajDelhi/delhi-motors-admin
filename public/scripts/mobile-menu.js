(function ($) {
	// Global variables
	var mobileMenuInitialized = false; // Flag that mobile menu is already set up

	// Window Load = Entire page including the DOM is ready
	$(window).load(function () {
		setupMobileMenu();
	});

	// On window resize
	$(window).resize(function () {
		setupMobileMenu();
	});

	// Initialize mobile menu based on body class
	function setupMobileMenu() {
		if (mobileMenuInitialized === true || !isMobileScreen()) {
			// Only set up once, and only if on a mobile screen size
			return;
		}

		var bodyClass = $("body").attr("class");
		var isAccordionMenu = bodyClass.includes("mobile-menu-accordion");

		// Copy each top-level menu item that contains a sub-menu into the sub-menu
		$("#mobile-navigation .menu-item-has-children").each(function () {
			var linkElement = $(this).children("a");
			var linkElementText = isAccordionMenu ? "Overview" : $(linkElement).text();
			var linkElementURL = $(linkElement).attr("href");
			var linkElementSubMenu = $(linkElement).next(".sub-menu");

			if (!$(this).hasClass("no-sub")) {
				// Create list item and link within sub-menu
				$(linkElementSubMenu).prepend(
					'<li class="menu-item hide-for-large"><a href="' +
					linkElementURL +
					'">' +
					linkElementText +
					"</a></li>"
				);
			}

			// Label the link to indicate it will open a sub-menu
			$(linkElement).attr("aria-label", "Open " + linkElementText + " sub-menu");
		});

		// Insert "Back" button if using paged style
		if (!isAccordionMenu) {
			$("#mobile-navigation .sub-menu").prepend(
				'<li class="mobile-navigation-previous"><button class="alt-01"><i class="fas fa-arrow-left small-margin-right"></i>Back</button></li>'
			);
		}

		$('<div id="mobile-navigation-top"></div>').insertBefore("#mobile-navigation > ul");

		// Move mobile navigation top into place
		$("#mobile-navigation-top-inner").detach().appendTo("#mobile-navigation-top");

		console.log("Initialized mobile menu JS");

		mobileMenuInitialized = true;
	}

	// Mobile menu: Open and close
	$(".mobile-menu-toggle").on("click", function () {
		toggleMobileMenu();
	});

	// Allow any clicks on container to close an open mobile menu
	$("#container").on("click", function () {
		if ($(this).isActive()) {
			toggleMobileMenu();
		}
	});

	// Opens or closes mobile menu, changing necessary classes
	function toggleMobileMenu() {
		$("#mobile-navigation").toggleClass("active");
		$("#mobile-navigation li").removeClass("sub-menu-open");

		setTimeout(function () {
			$("#container").toggleClass("active");
		}, 100);
	}

	// Mobile menu interaction: Back button paging controls
	// Because the buttons are created after page load, events handled by delegation
	$("#mobile-navigation").on("click", ".mobile-navigation-previous button", function (e) {
		e.preventDefault();
		$(this).closest(".menu-item-has-children").removeClass("sub-menu-open");
	});

	// Mobile navigation links with children do not directly link to the landing page, but activate the sub-menu
	$("#mobile-navigation .menu-item-has-children > a").on("click", function (e) {
		e.preventDefault();
		$(this).next(".mobile-navigation-next").trigger("click");
		$(this).parent().toggleClass("sub-menu-open");
	});
})(jQuery);
