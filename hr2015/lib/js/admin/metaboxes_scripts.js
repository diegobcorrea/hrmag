jQuery.noConflict();

(function($) {

	$(document).ready(function() {

		var count = 1,
			noncename = $("#img_tag_noncename").val();

		$(".temp .wPsticky").clone().appendTo(".tag-container");
		$(".temp .wPsticky").remove();

		$(".temp .drawnBox").clone().appendTo("#map-container");
		$(".temp .drawnBox").remove();

		if( $('.show_box input[type=checkbox]').is(':checked') ) {
			$(".hide_box").css({"display":"inline-block"});
		};

		$('.show_box input[type=checkbox]').click(function() {
			if( $(this).is(':checked') ) {
		    	$(".hide_box").css({"display":"inline-block"});
		    }else{
		    	$(".hide_box").css({"display":"none"});
		    };
		});

		var active_slide = $("#slide_value").val();

		$('.people_list[data-slide="'+active_slide+'"]').show().siblings('.people_list').hide();

		$("#slide_value").on('change', function() {
			var slideID = $(this).val();

			$('.people_list[data-slide="'+slideID+'"]').show().siblings('.people_list').hide();
		});

	});

})(jQuery);

