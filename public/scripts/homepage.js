// Scripts specifically for the homepage
(function( $ ) {
	// Homepage-specific global variables
	var enablePreloader = false;
	var preloaderDuration = 3800;

	// Document Ready = DOM is ready but content is not necessarily loaded
	$( function() {
		// Handle preloader
		if ( enablePreloader && $( "#preloader" ).exists() && !localStorage.getItem( "preloaderFinished" ) ) {
			startPreloader();
		} else {
			// Preloader not enabled; remove the element, if it exists
			$( "#preloader" ).remove();
		}

		// Begins preloader functionality and animations
		function startPreloader() {
			$( "#preloader, .preloader-part" ).addActive();

			anime( {
				targets: ".preloader-part-right p",
				opacity: [0, 1],
				translateY: [60, 0],
				duration: 1200,
				loop: false,
				easing: "easeOutSine",
				delay: anime.stagger( 500, { start: 700 } ),
			} );

			setTimeout( finishPreloader, preloaderDuration );
		}

		// Begins preloader exit; ensures it does not reappear in the session
		function finishPreloader() {
			// Set localStorage variable for this session
			localStorage.setItem( "preloaderFinished", 1 );

			// Begin preloader exit
			$( "#preloader" ).addClass( "preloader-remove" );

			setTimeout( function() {
				// At this point, preloader fade-out must be complete
				$( "#preloader" ).remove();
			}, 1500 );
		}
	} );

	$('.js-mobile-toggle').click(function( ){
		$(this).toggleClass('active');
		$('.listing-form').slideToggle();
	})

	$( window ).on( "load", function() {
		startHomeAnimations();

		// Initialize your main slider
		$('.hero-slider').not('.slick-initialized').slick({
			infinite: true,
			autoplay: true,
			fade: true,
			speed: 500,
			arrows: false,
		});

		// Get all buttons
		const buttons = document.querySelectorAll('.hero-buttons-list li span');

		// Add click event listener to each button
		buttons.forEach((button, index) => {
			button.addEventListener('click', () => {
				// Remove 'is-active' class from all buttons
				buttons.forEach(btn => btn.classList.remove('is-active'));

				// Add 'is-active' class to the clicked button
				button.classList.add('is-active');

				// Navigate to the corresponding slide
				$('.hero-slider').slick('slickGoTo', index);
			});
		});

		// Add event listener to the slick slider's afterChange event
		$('.hero-slider').on('afterChange', function(event, slick, currentSlide) {
			// Remove 'is-active' class from all buttons
			buttons.forEach(btn => btn.classList.remove('is-active'));

			// Add 'is-active' class to the current button
			buttons[currentSlide].classList.add('is-active');
		});

		// Intro slider
		$( '.intro-slider' ).not( '.slick-initialized' ).slick( {
			infinite: true,
			autoplay: true,
			arrows: true,
			fade: true,
			speed: 500,
			prevArrow: '<span class="intro-prev-arrow"><i class="fa-light fa-arrow-left"></i></span>',
			nextArrow: '<span class="intro-next-arrow"><i class="fa-light fa-arrow-right"></i></span>',
		} );
	} );

	function startHomeAnimations() {
		// If not on the homepage or on mobile, leave this function
		if ( isMobileScreen() ) {
			// Remove opacity0 to reveal hidden elements; start autoplay for slides
			$( ".opacity0" ).removeClass( "opacity0" );
			return;
		}

		// Animate homepage elements in on timers
		setTimeout( function() {
			//  $(".header").addClass("animated fadeInDown");
		}, 50 );
	}

	// Get all tabs
	document.addEventListener('DOMContentLoaded', () => {
		const tabs = document.querySelectorAll('.intro-tab li');
		const tabContents = document.querySelectorAll('.intro-content');

		if (tabs.length && tabContents.length) {
			tabs.forEach(tab => {
				tab.addEventListener('click', () => {
					tabs.forEach(t => t.classList.remove('is-active'));
					tabContents.forEach(content => content.style.display = 'none');

					tab.classList.add('is-active');
					const activeContent = document.querySelector(`#${tab.querySelector('span').dataset.tab}`);
					activeContent.style.display = 'block';

					// Reinitialize the Slick slider in the active tab
					$(activeContent).find('.intro-slider').slick('unslick').slick({
						infinite: true,
						autoplay: true,
						arrows: true,
						fade: true,
						speed: 500,
						prevArrow: '<span class="intro-prev-arrow"><i class="fa-light fa-arrow-left"></i></span>',
						nextArrow: '<span class="intro-next-arrow"><i class="fa-light fa-arrow-right"></i></span>',
					});
				});
			});

			tabs[0].click();
		}
	});

})( jQuery );
