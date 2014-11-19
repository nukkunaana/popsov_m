$(function() {
	// показывает и скрывает ответ на соответствующий вопрос
	$(document).on("click", ".select", function(){
		// получаем атрибут у выбранного вопроса
		var question = $(this).data("question");
		// получаем ответ с таким же атрибутом
		var answer = $("dd[data-answer=" + question+ "]");

		var arrow = $("i[data-arrow=" + question+ "]");

		var arrowMenu = $("i[data-arrowM=" + question+ "]");
		// показывает или скрывает ответ
		answer.slideToggle(200);

		if (arrow.hasClass('sprite-down_blue')){
			arrow
				.removeClass('sprite-down_blue')
				.addClass('sprite-up_blue');
		}
		else {
			arrow
				.removeClass('sprite-up_blue')
				.addClass('sprite-down_blue');
		}


		//МЕНЮ

		if (arrowMenu.hasClass('sprite-down')){
			arrowMenu
				.removeClass('sprite-down')
				.addClass('sprite-up');
		}
		else {
			arrowMenu
				.removeClass('sprite-up')
				.addClass('sprite-down');
		}
	});
	// при клике на ответ, сворачивается
	// $('dd').click(function(){
	// 	$(this).slideUp(200);
	// });

// при клике на кнопку "up", сворачивается
	$(document).on("click", ".sprite-up_blue", function(){
		var $this = $(this)
		var arrow = $this.data("arrow");
		var answer = $("dd[data-answer=" + arrow+ "]");

		$this
			.removeClass('sprite-up_blue')
			.addClass('sprite-down_blue');
		answer.slideUp(200);
	});

// при клике на кнопку "down", сворачивается
	$(document).on("click", ".sprite-down_blue", function(){
		var $this = $(this)
		var arrow = $this.data("arrow");
		var answer = $("dd[data-answer=" + arrow+ "]");


		$this
			.removeClass('sprite-down_blue')
			.addClass('sprite-up_blue');
		answer.slideDown(200);
	});



	//История
	$(document).on("click", ".select_history", function(){

		var question = $(this).data("question");
		// получаем ответ с таким же атрибутом
		var answer= $("dd[data-answer=" + question+ "]");
		
		answer.slideToggle(200);

	});

	$(document).on("click", ".arrow_history", function(){

		var arrow = $(this).data("arrow");
		// получаем ответ с таким же атрибутом
		var answer= $("dd[data-answer=" + arrow + "]");

		answer.slideUp(200);
	});	

});