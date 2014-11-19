$(function() {
	$(document).on("click", ".ask", function(){
		// $(this).addClass("hide");
		// $(this).slideUp(200);
		$(this).css({
			'display': 'none'
		});

		$(".faq_form").slideDown(200);
	});
});