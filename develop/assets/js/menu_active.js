$(function() {
	// выдвигает/скрывает меню при нажатии на иконку
	$(document).on("click", ".sprite-menu", function(){
		//если меню активировано, при клике на иконку скрывай 
		if($(this).hasClass("activeMenu")){
			$(".sprite-menu").css({
				'left': '20px'
			});
			$(".menu").css({
				'left': '-100%'
			});
			$(this).removeClass("activeMenu");
		}	
		//если нет, то выдвигай
		else {
			$(".menu").css({
				'left': '0',
				'z-index': '33'
			});
			$(this).addClass("activeMenu");
			activeMenuWidth();
		}
	});


	// при ресайзе меняет ширину меню и передвигает иконку хэдэра
	$(window).resize(function(){

		// http://api.jquery.com/width/
		// в переменную занести ширину у-ва - ширину иконки меню
		// менять ширину меню всегда на эту переменную
		// когда есть флажок из верхней функции также передвигай хэдер с иконкой на ширину у-ва + 20рх

		activeMenuWidth();
	});
});
	
//
function activeMenuWidth(){	
	//
	if ($(".sprite-menu").hasClass("activeMenu")){
		var window_width = $( window ).width();
		var menu_width = window_width - 34;
		var icon_left = window_width - 27;

		$(".menu").css({
			'width': menu_width
		});

		$(".sprite-menu").css({
			'left': icon_left
		});
	}
}