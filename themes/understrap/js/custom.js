(function ($) {
	$(document).ready(function(){
		$('.nav-button').click(function (e) {
			e.preventDefault();
			$('body').toggleClass('nav-open');
			$('#side-panel-menu').toggleClass('visible');

		});
	});

	$(document).click(function (event) {
		if ($('body').hasClass('nav-open')) {
			if (!($(event.target).hasClass("side-menu") || $(event.target).is('#nav-icon3') || $(event.target).hasClass('side-panel-btn'))) {
				$('body').toggleClass('nav-open');
				$('#side-panel-menu').toggleClass('visible');
			}
		}
	});
})(jQuery);
