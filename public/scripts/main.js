// Wrap all custom JS in an anonymous function that passes the alias "$" to everything so that "jQuery" doesn't have to be used
(function( $ ) {
	// Global variables
	var mobileMenuInitialized = false; // Flag that mobile menu is already set up
	var megaMenuTarget = $( ".menu-item-360" ); // Where the mega menu is placed - remove if no mega menu

	// Begin JavaScript/jQuery setup
	// The "on ready"
	$( function() {
		checkScroll();
		setupYouTube();
		initializeSliders();
		makeListenersPassive();

		// Initialize geolocation tracking cookie (if needed)
		setupGeolocation();

		// Prepare links within the body content with the scroll-to class if they point to internal ID anchors
		$( '.content a[href^="#"]' ).each( function() {
			// Add class 'scroll-to' to the link
			$( this ).addClass( "scroll-to" );

			// Extract the anchor target and set it as a data attribute, minus the hashtag
			var anchorTarget = $( this ).attr( "href" ).substring( 1 );
			$( this ).attr( "data-scroll-to-id", anchorTarget );
		} );

		// Video gallery category filter
		if ( $( "#video-category-filter" ).exists() ) {
			$( "#video-category-filter" ).on( "change", function() {
				var selectedCategory = $( this ).val();

				$( ".videos-single" ).each( function() {
					var categories = $( this ).data( "category" ).split( " " );
					if ( selectedCategory == "" || categories.includes( selectedCategory ) ) {
						$( this ).show();
					} else {
						$( this ).hide();
					}
				} );

				animateScroll( "videos-container" );
			} );
		}

		// Prevent empty searches on forms with the "prevent-blank-search" class
		document.querySelectorAll( ".prevent-blank-search" ).forEach( function( element ) {
			element.addEventListener(
				"submit",
				function( e ) {
					var value = $( this ).find( "input" ).val().trim();

					// Test for whitespace values
					if ( !value || !/\S/.test( value ) ) {
						alert( "Please enter a search term." );

						e.preventDefault();
					}
				},
				{ passive: false }
			);
		} );

		// Initialize mega menu (if needed)
		if ( megaMenuTarget && isDesktopScreen() ) {
			$( megaMenuTarget ).addClass( "static" );
			$( "#mega-menu" ).detach().appendTo( megaMenuTarget );
		}

		// Scroll to ID from a select dropdown. Useful on mobile
		$( ".scroll-to-select" ).on( "change", function( e ) {
			// Get selected option then scroll to it
			var selectedOption = $( this ).find( ":selected" ).val();
			animateScroll( $( selectedOption ).offset().top );
		} );

		// Copies content from a selected area to a target; used only on some modules
		$( ".content-selector" ).on( "click", function() {
			$( this ).toggleClass( "active" );
			$( this ).siblings().removeActive();

			$( "#content-selector-target" ).removeClass( "animated fast fadeIn" );
			$( "#content-selector-target" ).html( $( this ).html() );

			setTimeout( function() {
				$( "#content-selector-target" ).addClass( "animated fast fadeIn" );
			}, 200 );
		} );

		// Accessibility: Ensures main navigation dropdowns remain open for keyboard focus
		$( ".main-navigation-menu li" )
			.on( "focusin mouseover", function() {
				$( this ).addActive();
				$( this ).siblings().removeActive();
			} )
			.on( "mouseleave", function() {
				$( this ).removeActive();
			} );

		// SPECIALIZED LIBRARIES

		// Custom scroll bar - SimpleBar
		// Styling is done in CSS: https://github.com/Grsmto/simplebar/tree/master/packages/simplebar
		if ( $( "#custom-scrollbar" ).exists() && typeof SimpleBar === "function" ) {
			new SimpleBar( document.getElementById( "custom-scrollbar" ), {
				autoHide: false,
			} );
		}

		// Blog Grid - Masonry and move pagination
		if ( $( "#blog-grid" ).exists() ) {
			if ( isDesktopScreen() ) {
				// Initializes Masonry layout; see: https://masonry.desandro.com/options.html
				$( "#blog-grid-inner" ).masonry( {
					fitWidth: true,
					gutter: 30, // Horizontal space between layout items
					itemSelector: ".post", // Target specific class to avoid other elements being repositioned
				} );
			}

			// Move pagination to final position, outside of grid
			$( ".blog-grid .wp-pagenavi" ).detach().appendTo( "#blog-grid-pagination" );
		}

		// Initialize sticky elements (if needed)
		if ( $( ".make-sticky" ).exists() ) {
			// Top margin and "on sticky" class are added in HTML
			new Sticky( ".make-sticky" );
		}

		// END SPECIALIZED LIBRARIES

		// LAZY LOADING WITH LOZAD
		// Use class "lazy-img" and attribute "data-img-src" to lazy load an <img> and "data-animation-class" to animate
		// To randomly pick an image from a set, use attribute "data-img-srcs" like so: data-img-srcs="imageurl.jpg, imageurl.jpg"
		var imageLazyLoader = lozad( ".lazy-img", {
			rootMargin: "10px 0px",
			threshold: 0.1,
			load: function( elementInView ) {
				if ( $( elementInView ).attr( "data-img-srcs" ) ) {
					var imagesList = $( elementInView ).attr( "data-img-srcs" ).split( "," );
					var imageToLoad = imagesList[ Math.floor( Math.random() * imagesList.length ) ];
					console.log( "Lazy loading a randomly-selected image: " + imageToLoad );
				} else {
					var imageToLoad = $( elementInView ).attr( "data-img-src" );
					console.log( "Lazy loading an image: " + imageToLoad );
				}

				$( elementInView ).attr( "src", imageToLoad );

				// Optionally, add animation classes at the same time
				if ( $( elementInView ).attr( "data-animation-class" ) ) {
					var animateClass = "animated " + $( elementInView ).attr( "data-animation-class" );
					$( elementInView ).addClass( animateClass );
				}
			},
		} );
		imageLazyLoader.observe();

		// Use class "lazy-bg" and attribute "data-bg-src" on any element using a CSS background image lazy load
		// To randomly pick background image from a set, use attribute "data-bg-srcs" like so: data-bg-srcs="imageurl.jpg, imageurl.jpg"
		var backgroundImageLazyLoader = lozad( ".lazy-bg", {
			rootMargin: "10px 0px",
			threshold: 0.1,
			load: function( elementInView ) {
				if ( $( elementInView ).attr( "data-bg-srcs" ) ) {
					var imagesList = $( elementInView ).attr( "data-bg-srcs" ).split( "," );
					var imageToLoad = imagesList[ Math.floor( Math.random() * imagesList.length ) ];
					console.log( "Lazy loading a randomly-selected background image: " + imageToLoad );
				} else {
					var imageToLoad = $( elementInView ).attr( "data-bg-src" );
					console.log( "Lazy loading a background image: " + imageToLoad );
				}

				$( elementInView ).css( "background-image", "url(" + imageToLoad + ")" );
			},
		} );
		backgroundImageLazyLoader.observe();

		// Add an active class to an element when it enters view
		// Optionally, add a "data-delay" attribute equal to milliseconds, e.g. 500 for 0.5 seconds
		var activeInViewTrigger = lozad( ".active-in-view", {
			rootMargin: "10px 0px",
			threshold: 0.1,
			load: function( elementInView ) {
				var delayActive = 0;

				if ( $( elementInView ).attr( "data-delay" ) ) {
					delayActive = $( elementInView ).attr( "data-delay" );
				}

				setTimeout( function() {
					$( elementInView ).addActive();
					$( elementInView ).removeClass( "active-in-view" );
				}, delayActive );
			},
		} );
		activeInViewTrigger.observe();

		// Trigger animate in view with a specific animation class added
		// TO USE: Add class "animate-in-view" to an element plus a data attribute "data-animation-class" equal to an animation class name
		var specificAnimateInViewTrigger = lozad( ".animate-in-view", {
			rootMargin: "10px 0px",
			threshold: 0.1,
			load: function( elementInView ) {
				var animToUse = $( elementInView ).attr( "data-animation-class" );
				$( elementInView ).addClass( "animated " + animToUse );
			},
		} );
		specificAnimateInViewTrigger.observe();

		// Lazy load Google Map
		// Requires data attribute "data-embed-map-link" to be set
		var mapLoadInViewTrigger = lozad( ".load-map-in-view", {
			rootMargin: "10px 0px",
			threshold: 0.1,
			load: function( elementInView ) {
				var embedMapWidth = $( elementInView ).attr( "data-embed-map-width" )
					? $( elementInView ).attr( "data-embed-map-width" )
					: 600;
				var embedMapHeight = $( elementInView ).attr( "data-embed-map-height" )
					? $( elementInView ).attr( "data-embed-map-height" )
					: 450;

				// Add live <iframe> containing Google Map once the element is in view
				$( elementInView ).append(
					'<iframe src="' +
					$( elementInView ).attr( "data-embed-map-link" ) +
					'" width="' +
					embedMapWidth +
					'" height="' +
					embedMapHeight +
					'" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>'
				);
			},
		} );
		mapLoadInViewTrigger.observe();

		// On page print, download images
		window.onbeforeprint = function() {
			$( ".lazy-img" ).each( function() {
				var src = $( this ).attr( "data-img-src" );
				$( this ).attr( "src", src );
			} );

			$( ".lazy-bg" ).each( function() {
				var src = $( this ).attr( "data-bg-src" );
				$( this ).css( "background-image", src );
			} );
		};

		// END LAZY LOADING WITH LOZAD
	} );

	// Window *Load = Entire page including the DOM is loaded
	$( window ).on( "load", function() {
		setupMobileMenu();
		setupExternalLinks();
		checkBrowserSupport();

		// On page load, check inputs for text to add active
		$( "input, textarea" ).each( function() {
			activateInputLabel( $( this ).attr( "id" ) );
		} );

		// INPUT ACTIVE CLASS CONTROL
		// On text inputs, add class when the field holds a value
		$( "input, textarea" ).on( "input", function() {
			activateInputLabel( $( this ).attr( "id" ) );
		} );

		// Detects text inside inputs to activate or deactivate label styling
		function activateInputLabel( inputElementSelector ) {
			if ( !inputElementSelector ) {
				return;
			}

			thisInput = $( "#" + inputElementSelector );
			thisInputValue = $( thisInput ).val();

			if ( thisInput && thisInputValue && $( thisInput ).isActive() == false ) {
				$( thisInput ).addActive();
			} else if ( thisInputValue == "" ) {
				$( thisInput ).removeActive();
			}
		}

		// On dropdowns, add class when <select> is used
		$( "select" ).on( "change", function() {
			$( this ).addActive();
		} );

		$( "select" ).on( "focusin focusout", function() {
			$( this ).closest( ".select-wrapper" ).toggleClass( "active" );
		} );
		// END INPUT ACTIVE CLASS CONTROL

		// ATTORNEY SEARCH HELPERS
		// Prevent empty-value form inputs from sending data
		$( "#attorney-search-form" ).submit( function() {
			$( 'input[value=""]:not(.active)' ).attr( "disabled", true );
			$( 'option[value=""]' ).attr( "disabled", true );
		} );

		// If attorney search results are present, scroll to the section
		if ( $( "#attorney-search-bar" ).exists() ) {
			animateScroll( "attorney-search-bar", 300 );
			$( "#attorney-search-inner" ).attr( "tabindex", "0" );
			$( "#attorney-search-inner" ).focus();
		}
		// END ATTORNEY SEARCH HELPERS

		// SIDEBAR JUMP LINKS
		// Generate list for table of contents and select options for mobile
		if ( $( "#sidebar-jump-links" ).exists() ) {
			$( ".content h2" ).each( function() {
				// Get text from heading
				var thisHeadingText = $( this ).text();

				// Convert text to lowercase, replace spaces with dashes, get rid of everything else
				thisHeadingID =
					"jump-" +
					thisHeadingText
						.toLowerCase()
						.replace( / /g, "-" )
						.replace( /[^\w-]+/g, "" );

				// Give each heading a unique identifier
				$( this ).attr( "id", thisHeadingID );

				// Dynamically create list item within table of contents
				// Select is used on mobile
				$( "#sidebar-jump-links-list" ).append(
					'<li><button class="scroll-to no-button" data-scroll-to-id="' +
					thisHeadingID +
					'">' +
					thisHeadingText +
					"</button></li>"
				);
				$( "#sidebar-jump-links-select" ).append(
					'<option value="#' + thisHeadingID + '">' + thisHeadingText + "</option>"
				);
			} );
		}
		// END SIDEBAR JUMP LINKS

		// CONTENT TAB BUTTONS
		// Used on attorney bios
		$( ".content-tab-activate" ).on( "click", function() {
			$( ".content-tab-activate, .content-tab" ).removeActive();
			$( "[data-content-tab='" + $( this ).attr( "data-content-tab" ) + "']" ).addActive();
			$( this ).addActive();
		} );

		$( ".mobile-tab" ).on( "click", function() {
			animateScroll( "main" );
		} );
		// END CONTENT TAB BUTTONS

		// ACCORDION CONTROL
		// Toggle accordion open and closed
		if ( $( ".accordion-item" ).length ) {
			// If there are accordions on this page, set their ARIA properties
			$( ".accordion-item-title" ).attr( "aria-expanded", "false" );

			// Event listener for accordion items
			$( ".accordion-item-title" ).on( "click", function() {
				var parentAccordionItem = $( this ).closest( ".accordion-item" );

				// Check data attribute values on the clicked accordion
				var autoScroll = $( this ).data( "auto-scroll" ) !== false;
				var closeSiblings = $( this ).data( "close-siblings" ) !== false;

				// Close sibling accordions, if the data attribute allows it
				if ( closeSiblings ) {
					parentAccordionItem.siblings().removeClass( "active" );
					parentAccordionItem
						.siblings()
						.find( ".accordion-item-title" )
						.attr( "aria-expanded", "false" );
				}

				if ( !parentAccordionItem.hasClass( "active" ) ) {
					// Open the clicked accordion
					parentAccordionItem.addClass( "active" );
					$( this ).attr( "aria-expanded", "true" );

					// Scroll to opened accordion's content, if the data attribute allows it
					if ( autoScroll ) {
						var scrollPosition = parentAccordionItem.offset().top - getScrollAdjustValue();
						animateScroll( scrollPosition );
					}
				} else {
					// Close the clicked accordion
					parentAccordionItem.removeClass( "active" );
					$( this ).attr( "aria-expanded", "false" );
				}
			} );
		}

		// Open first accordion on load
		if ( $( ".open-first" ).exists() ) {
			$( ".open-first" ).each( function() {
				$( this )
					.find( ".accordion-item:first-of-type .accordion-item-title" )
					.addClass( "active" )
					.attr( "aria-expanded", true );
			} );
		}
		// END ACCORDION CONTROL
	} );

	// Sets up all slick sliders present on the page
	function initializeSliders() {
		$( "#results-slider" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				autoplay: false,
				fade: true,
				speed: 500,
				arrows: true,
				prevArrow: $( "#results-slider-previous" ),
				nextArrow: $( "#results-slider-next" ),
				dots: false,
			} );

		$( "#posts-slider" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				autoplay: false,
				fade: true,
				speed: 500,
				arrows: true,
				prevArrow: $( "#posts-slider-previous" ),
				nextArrow: $( "#posts-slider-next" ),
				dots: false,
			} );

		//  MODULE-SPECIFIC SLIDERS
		$( "#slider-practices-g" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				pauseOnHover: false,
				responsive: [
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 1,
						},
					},
				],
				autoplay: false,
				fade: false,
				speed: 400,
				cssEase: "ease",
				dots: false,
				arrows: true,
				slidesToShow: 2,
				slidesToScroll: 1,
				prevArrow: $( "#slider-practices-g-prev" ),
				nextArrow: $( "#slider-practices-g-next" ),
			} );

		$( "#slider-testimonials-a" ).not( ".slick-initialized" ).slick( {
			infinite: true,
			pauseOnHover: false,
			autoplay: true,
			autoplaySpeed: 4000,
			fade: true,
			speed: 500,
			dots: true,
			arrows: false,
		} );

		$( "#slider-testimonials-b" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				autoplay: false,
				fade: false,
				speed: 300,
				dots: false,
				arrows: true,
				prevArrow: $( "#slider-testimonials-b-prev" ),
				nextArrow: $( "#slider-testimonials-b-next" ),
			} );

		$( "#slider-blog-c" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				pauseOnHover: false,
				responsive: [
					{
						breakpoint: 640,
						settings: {
							slidesToShow: 1,
						},
					},
				],
				autoplay: false,
				fade: false,
				speed: 300,
				cssEase: "ease",
				dots: false,
				arrows: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				prevArrow: $( "#slider-blog-c-prev" ),
				nextArrow: $( "#slider-blog-c-next" ),
			} );

		$( "#slider-blog-d" ).not( ".slick-initialized" ).slick( {
			infinite: true,
			pauseOnHover: false,
			autoplay: false,
			fade: true,
			speed: 500,
			dots: false,
			arrows: false,
		} );

		$( "#slider-results-a" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				pauseOnHover: false,
				responsive: [
					{
						breakpoint: 640,
						settings: {
							slidesToShow: 1,
						},
					},
				],
				autoplay: false,
				fade: false,
				speed: 300,
				cssEase: "ease",
				dots: false,
				arrows: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				prevArrow: $( "#slider-results-a-prev" ),
				nextArrow: $( "#slider-results-a-next" ),
			} );

		$( "#slider-results-b" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				pauseOnHover: false,
				responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
						},
					},
					{
						breakpoint: 768,
						settings: {
							slidesToShow: 2,
						},
					},
					{
						breakpoint: 639,
						settings: {
							slidesToShow: 1,
						},
					},
				],
				autoplay: false,
				fade: false,
				speed: 300,
				cssEase: "ease",
				dots: false,
				arrows: true,
				slidesToShow: 4,
				slidesToScroll: 1,
				prevArrow: $( "#slider-results-b-prev" ),
				nextArrow: $( "#slider-results-b-next" ),
			} );

		$( "#slider-badges-a" )
			.not( ".slick-initialized" )
			.slick( {
				infinite: true,
				pauseOnHover: false,
				pauseOnHover: false,
				responsive: [
					{
						breakpoint: 640,
						settings: {
							slidesToShow: 1,
						},
					},
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 3,
						},
					},
				],
				autoplay: false,
				fade: false,
				speed: 300,
				cssEase: "ease",
				dots: false,
				arrows: true,
				slidesToShow: 5,
				slidesToScroll: 1,
				prevArrow: $( "#slider-badges-a-prev" ),
				nextArrow: $( "#slider-badges-a-next" ),
			} );
	}

	// hero and banner space from top
	function adjustMargin() {
		var headerHeight = $('.header').outerHeight();
		$('.hero, .banner').css('margin-top', headerHeight);
	}

	adjustMargin(); // Call on page load

	////////////////////////
	//  General Listeners //
	////////////////////////

	// On window resize
	$( window ).resize( function() {
		setupMobileMenu();
		adjustMargin();
	} );

	///////////////////////////////////
	// Scrolls and On-Screen Reveals //
	///////////////////////////////////

	// Gradually scrolls window to element on click of any element with the "scroll-to" class
	$( "body" ).on( "click", ".scroll-to", function( e ) {
		e.preventDefault();
		var elementToScrollToID = $( this ).attr( "data-scroll-to-id" );

		if ( !elementToScrollToID ) {
			return;
		}

		animateScroll( elementToScrollToID );

		if ( elementToScrollToID == "main" ) {
			// After scrolling completes, temporarily add tabindex and focus #main
			$( elementToScrollToID ).attr( "tabindex", "-1" ).focus().removeAttr( "tabindex" );
		}
	} );

	// Scrolls window back to top of page
	$( ".scroll-to-top" ).on( "click", function( e ) {
		e.preventDefault();
		animateScroll( 0 );
	} );

	$( window ).on( "scroll", function() {
		// Constant scroll detection with no debounce - Be careful with performance impact!
		checkScroll();
	} );

	function checkScroll() {
		// Add class to body when scrolled beyond top of page
		if ( $( window ).scrollTop() > 0 ) {
			$( "body" ).addClass( "scrolled" );
		} else {
			$( "body" ).removeClass( "scrolled" );
		}
	}

	var checkScrollDebounce = debounce( function() {
		// Debounced scroll detection - Occurs on every scroll but at a limited rate

		// If scrolled to bottom, activate slideout feature in footer
		if ( $( "#bottom-slideout" ).exists() ) {
			// Detect page bottom
			if ( getScrollPercent() > 0.98 ) {
				$( "#bottom-slideout" ).addActive();
			} else {
				$( "#bottom-slideout" ).removeActive();
			}
		}

		// Check elements that are revealed on scroll
		$( ".scroll-reveal" ).each( function() {
			// If element is on screen and not yet revealed, add classes
			var cur = $( this );
			if ( cur.isOnScreen() ) {
				if ( !cur.hasClass( "animated" ) ) {
					cur.addClass( "animated fadeInUp" );
				}
			}
		} );
	}, 25 );
	window.addEventListener( "scroll", checkScrollDebounce );

	// The "debounce" function slows down occurrence of frequent checks like on-scrolls for improved performance
	// https://davidwalsh.name/javascript-debounce-function
	function debounce( func, wait, immediate ) {
		var timeout;
		return function() {
			var context = this,
				args = arguments;
			var later = function() {
				timeout = null;
				if ( !immediate ) {
					func.apply( context, args );
				}
			};
			var callNow = immediate && !timeout;
			clearTimeout( timeout );
			timeout = setTimeout( later, wait );
			if ( callNow ) {
				func.apply( context, args );
			}
		};
	}

	/////////////////////
	//  YouTube Embeds //
	/////////////////////

	function addVideoMetadata() {
		var videoData;
		var apiKey = "AIzaSyCZ31XxRuVs421sDbf8uBxVOBNVGj3E2dI"; // Google API key
		var endpoint =
			"https://www.googleapis.com/youtube/v3/videos?id=" +
			$( ".youtube-player" ).attr( "data-id" ) +
			"&key=" +
			apiKey +
			"&part=snippet,contentDetails,statistics,status";

		$.getJSON( endpoint, function( json ) {
			$( "#data-video-info" ).append( json );
		} );
	}

	function setupYouTube() {
		// Prepare YouTube video placeholders that turn into iframe on click
		if ( $( ".youtube-player" ).length == 0 ) {
			return;
		}

		var div;
		var n;
		var v = document.getElementsByClassName( "youtube-player" );

		for ( n = 0; n < v.length; n ++ ) {
			div = document.createElement( "div" );
			div.setAttribute( "data-id", v[ n ].dataset.id );
			div.setAttribute( "data-list", v[ n ].dataset.list );
			div.innerHTML =
				'<img src="https://img.youtube.com/vi/' + v[ n ].dataset.id + '/hqdefault.jpg" alt="">';

			// Add attributes and classes to the div to make interactive
			$( div ).addClass( "youtube-player-inner" ).attr( "tabindex", "0" );
			$( div ).addClass( "youtube-player-inner" ).attr( "aria-label", "Play video" );
			$( div ).on( "click keypress", getYouTubeFrame );

			// Add div to this player
			v[ n ].appendChild( div );
		}
	}

	function getYouTubeFrame() {
		var iframe = document.createElement( "iframe" );
		var embed = "https://www.youtube.com/embed/ID?autoplay=1&rel=0";

		iframe.setAttribute( "src", embed.replace( "ID", this.dataset.id ) );
		iframe.setAttribute( "frameborder", "0" );
		iframe.setAttribute( "allow", "autoplay;" );
		iframe.setAttribute( "allowfullscreen", "1" );

		this.parentNode.replaceChild( iframe, this );
	}

	//////////////////
	//  Mobile Menu //
	//////////////////

	// Sets up mobile menu - only once
	function setupMobileMenu() {
		if ( mobileMenuInitialized == true || isMobileScreen() == false ) {
			// Only set up once, and only if on a mobile screen size
			return;
		}

		// Copy each top-level menu item that contains a sub-menu into the sub-menu
		$( "#mobile-navigation .menu-item-has-children" ).each( function() {
			// Add class "no-sub" in WordPress menu for no "Overview" link
			if ( $( this ).hasClass( "no-sub" ) ) {
				return;
			}

			var linkElement = $( this ).children( "a" );
			var linkElementText = $( linkElement ).text();
			var linkElementURL = $( linkElement ).attr( "href" );
			var linkElementSubMenu = $( linkElement ).next( ".sub-menu" );

			// Label the link to indicate it will open a sub-menu
			$( linkElement ).attr( "aria-label", "Open " + linkElementText + " sub-menu" );

			// Create list item and link within sub-menu
			$( linkElementSubMenu ).prepend(
				'<li class="menu-item hide-for-large"><a href="' +
				linkElementURL +
				'">' +
				linkElementText +
				"</a></li>"
			);
		} );

		// Insert previous buttons and title in mobile menu
		$( "#mobile-navigation .sub-menu" ).prepend(
			'<li class="mobile-navigation-previous"><button><i class="fas fa-arrow-left small-margin-right"></i>Back</button></li>'
		);
		$( '<div id="mobile-navigation-top"></div>' ).insertBefore( "#mobile-navigation > ul#menu-main-navigation" );

		// Move mobile navigation top into place
		$( "#mobile-navigation-top-inner" ).detach().appendTo( "#mobile-navigation-top" );

		mobileMenuInitialized = true;
	}

	// Mobile menu: Open and close
	$( ".mobile-menu-toggle" ).on( "click", function() {
		toggleMobileMenu();
	} );

	// Allow any clicks on container to close an open mobile menu
	$( "#container" ).on( "click", function() {
		if ( $( this ).isActive() ) {
			toggleMobileMenu();
		}
	} );

	// Opens or closes mobile menu, changing necessary classes
	function toggleMobileMenu() {
		$( "#mobile-navigation" ).toggleClass( "active" );
		$( "#mobile-navigation li" ).removeClass( "sub-menu-open" );

		setTimeout( function() {
			$( "#container" ).toggleClass( "active" );
		}, 100 );
	}

	// Mobile menu interaction: Back button paging controls
	// Because the buttons are created after page load, events handled by delegation
	$( "#mobile-navigation" ).on( "click", ".mobile-navigation-previous button", function( e ) {
		e.preventDefault();
		$( this ).closest( ".menu-item-has-children" ).removeClass( "sub-menu-open" );
	} );

	// Mobile navigation links with children do not directly link to the landing page, but activate the sub-menu
	$( "#mobile-navigation .menu-item-has-children > a" ).on( "click", function( e ) {
		e.preventDefault();
		$( this ).next( ".mobile-navigation-next" ).trigger( "click" );
		$( this ).parent().toggleClass( "sub-menu-open" );
	} );

	////////////////////////
	//  Passive Listeners //
	////////////////////////

	// Informs browser that event listeners will never prevent scrolling
	// https://web.dev/uses-passive-event-listeners/
	function makeListenersPassive() {
		var supportsPassive = eventListenerOptionsSupported();

		if ( supportsPassive ) {
			var addEvent = EventTarget.prototype.addEventListener;
			overwriteAddEvent( addEvent );
		}
	}

	function overwriteAddEvent( superMethod ) {
		var defaultOptions = {
			passive: true,
			capture: false,
		};

		EventTarget.prototype.addEventListener = function( type, listener, options ) {
			var usesListenerOptions = typeof options === "object";
			var useCapture = usesListenerOptions ? options.capture : options;

			options = usesListenerOptions ? options : {};
			options.passive = options.passive !== undefined ? options.passive : defaultOptions.passive;
			options.capture = useCapture !== undefined ? useCapture : defaultOptions.capture;

			superMethod.call( this, type, listener, options );
		};
	}

	function eventListenerOptionsSupported() {
		var supported = false;

		try {
			var opts = Object.defineProperty( {}, "passive", {
				get: function() {
					supported = true;
				},
			} );
			window.addEventListener( "test", null, opts );
		} catch ( e ) {
		}

		return supported;
	}

	////////////
	//  Misc. //
	////////////

	// Returns true if on homepage
	// Requires WordPress body classes to be in effect
	function isHomepage() {
		if ( jQuery( "body.home" ).length ) {
			return true;
		}
		return false;
	}

	// Returns true no homepage class is present
	function isSubpage() {
		if ( jQuery( "body.home" ).length ) {
			return false;
		}
		return true;
	}

	// Returns true if element is on screen
	// Usage: element.isOnScreen()
	function isOnScreen() {
		var viewport = {};
		viewport.top = jQuery( window ).scrollTop();
		viewport.bottom = viewport.top + jQuery( window ).height();
		var bounds = {};
		bounds.top = this.offset().top;
		bounds.bottom = bounds.top + this.outerHeight();
		return bounds.top <= viewport.bottom && bounds.bottom >= viewport.top;
	}

	// Add attributes specifically to external links
	function setupExternalLinks() {
		$( "a" )
			.filter( function() {
				return this.hostname && this.hostname !== location.hostname;
			} )
			.attr( "target", "_blank" )
			.attr( "rel", "noopener" )
			.addClass( "external-link" );

		// Also open PDFs in new tab
		$( 'a[href$=".pdf"]' ).each( function() {
			$( this ).attr( "target", "_blank" );
		} );
	}

	// Using Modernizr, scan for browser capabilities
	function checkBrowserSupport() {
		if ( Modernizr == null ) {
			return;
		}

		// WebP test
		Modernizr.on( "webp", function( result ) {
			if ( result ) {
				$( "body" ).addClass( "webp-support" );
			} else {
				$( "body" ).addClass( "webp-no-support" );
			}
		} );
	}

	// Optional geolocation feature
	// Adds geolocation and other information to contact emails
	function setupGeolocation() {
		if ( sessionStorage.geolocationReady ) {
			return;
		}

		// Make AJAX request to store PHP SESSION variables containing geolocation data; requires API key
		setTimeout( function() {
			jQuery.ajax( {
				type: "get",
				url: "/wp-content/themes/paperstreet/includes/include-geolocation.php",
				success: function( response ) {
				},
			} );

			console.log( "Geolocation data saved for this session." );
			sessionStorage.geolocationReady = "true";
		}, 2000 );
	}
})( jQuery );
