// Runs general animation classes showcased in animations library
(function($) {
	// Global variables
	var mouseScrollTextUpperBound = 0; // No need to modify as this is set dynamically on load
	var mouseScrollTextLowerBound = 0;
	var mouseScrollTextMoveMultiplier = 1; // A higher value increases movement on mouse-scroll-moving element (try 0.5 or 1)

	$(function() {
		// Switch on or off on repeating timer
		setInterval(rotateActives, 3000);

		// Set values for scroll positions on scrolling element
		if ($('#scroll-move-text-container').exists())
		{
			var modifiedViewportHeight = (document.documentElement.clientHeight * 0.75);
			mouseScrollTextUpperBound = $('#scroll-move-text-container').offset().top - modifiedViewportHeight;
			mouseScrollTextLowerBound = $('#scroll-move-text-container').offset().top + modifiedViewportHeight;

			$('.scroll-move-text').each(function() {

			});

			if (mouseScrollTextLowerBound > $(document).height())
			{
				mouseScrollTextLowerBound = $(document).height();
			}
		}
	});

	// Toggles elements active and inactive for demo purposes
	function rotateActives() {
		$('.active-rotate').toggleActive();
	}

	// Window Load = Entire page including the DOM is loaded
	$(window).on("load", function() {
		anime({
			targets: '.animation-characters-fly-up span',
			opacity: [0, 1],
			translateY: [120, 0],
			duration: 800,
			loop: true,
			easing: 'easeOutSine',
			delay: anime.stagger(80, {start: 1000})
		});

		anime({
			targets: '.animation-characters-fade-right span',
			opacity: [0, 1],
			translateX: [-20, 0],
			duration: 500,
			loop: true,
			easing: 'easeOutSine',
			delay: anime.stagger(50, {start: 1000})
		});

		anime({
			targets: '.animation-words-fade-left span',
			opacity: [0, 1],
			translateX: [40, 0],
			duration: 1100,
			loop: true,
			easing: 'easeOutSine',
			delay: anime.stagger(300)
		});
	});

	$(window).on("scroll", function() {
		// Constant scroll detection with no debounce - Be careful with performance impact!
		if ($('.scroll-move-text').exists())
		{
			if ((window.pageYOffset > mouseScrollTextUpperBound) && (window.pageYOffset < mouseScrollTextLowerBound))
			{
				// Scrolling text will be repositioned; calculate how much
				var repositionValue = mouseScrollTextMoveMultiplier * (window.pageYOffset - mouseScrollTextUpperBound);


				$('.scroll-move-text').each(function() {
					if ($(this).hasClass('scroll-move-text-inverse'))
					{
						repositionValue *= -1;
					}

					$(this).css('transform', 'translateX(' + repositionValue + 'px)');
				});
			}
		}
	});
})(jQuery);