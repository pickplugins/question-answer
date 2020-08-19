jQuery(document).ready(function($) {


	$(document).on('click', '.advance-toggle', function (){

		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$('.advance-input').css('display','none');

		}else{
			$(this).addClass('active');
			$('.advance-input').css('display','grid');
		}

	})


});
