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

	var qa_type_delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$(document).on('change keyup submit', '#qa-search-form', function (){

		form_data = $(this).serializeArray();
		qa_keyword = $('#qa_keyword').val();


		if(qa_keyword.length > 0 && qa_keyword.length <= 4) return;


		qa_type_delay(function(){

			//console.log(qa_keyword.length);

			$('.loading').fadeIn();
			$('.question-list').css('opacity', 0.5);

			$.ajax({
				type: 'POST',
				context: this,
				url:qa_ajax.qa_ajaxurl,
				data: {
					"action" 	: "question_answer_ajax_search",
					"form_data" : form_data,
				},
				success: function( response ) {

					var data = JSON.parse( response );
					qa_keyword = data['qa_keyword'];
					html = data['html'];
					pagination = data['pagination'];

					//console.log(html);

					$('.question-list').html(html);
					$('.qa-paginate').html(pagination);

					//if( question_permalink.length > 0 ) window.location.href = question_permalink;

					$('.loading').fadeOut();
					$('.question-list').css('opacity', 1);
				}
			});


		}, 1000 );







	})




	$(document).on('click', '.qa-paginate a', function (e){

		e.preventDefault();

		form_data = $('#qa-search-form').serializeArray();
		qa_keyword = $('#qa_keyword').val();

		page = $(this).text();

		console.log(parseInt(page));


		if(qa_keyword.length > 0 && qa_keyword.length <= 4) return;


		qa_type_delay(function(){

			//console.log(qa_keyword.length);

			$('.loading').fadeIn();
			$('.question-list').css('opacity', 0.5);

			$.ajax({
				type: 'POST',
				context: this,
				url:qa_ajax.qa_ajaxurl,
				data: {
					"action" 	: "question_answer_ajax_search",
					"form_data" : form_data,
					"page" : page,

				},
				success: function( response ) {

					var data = JSON.parse( response );
					qa_keyword = data['qa_keyword'];
					html = data['html'];
					pagination = data['pagination'];

					console.log(pagination);

					$('.question-list').html(html);
					$('.qa-paginate').html(pagination);

					//if( question_permalink.length > 0 ) window.location.href = question_permalink;

					$('.loading').fadeOut();
					$('.question-list').css('opacity', 1);
				}
			});


		}, 1000 );







	})









});
