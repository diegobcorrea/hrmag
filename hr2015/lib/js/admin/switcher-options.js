jQuery.noConflict();
(function($) {

$(document).ready(function() {

	// Theme Switcher
	jQuery('.theme_switcher_class a').on('click', function(e){
		e.preventDefault();

		var ID 		= jQuery(this).parent().attr('id');
		var status 	= ID.replace('wp-admin-bar-', '');

		var data = {
			'action': 'change_switcher',
			'status': status
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(data) {
			$('#wp-admin-bar-'+data).addClass('active').siblings('li').removeClass('active')
		});

		console.log(status);
	});

	var data = {
		'action': 'get_theme_status',
	};

	$.get(ajaxurl, data, function(data) {
		$('#wp-admin-bar-'+data).addClass('active');
		console.log(data);
	});

});

})(jQuery);