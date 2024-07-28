(function ($) {
	$(document).on("ready", function () {


		$(document).on('click', '.advance-toggle', function () {

			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$('.advance-input').css('display', 'none');

			} else {
				$(this).addClass('active');
				$('.advance-input').css('display', 'grid');
			}

		})

		var qa_type_delay = (function () {
			var timer = 0;
			return function (callback, ms) {
				clearTimeout(timer);
				timer = setTimeout(callback, ms);
			};
		})();

		$(document).on('change keyup submit', '#qa-search-form', function (ev) {

			ev.preventDefault();

			form_data = $(this).serializeArray();
			qa_keyword = $('#qa_keyword').val();


			//if(qa_keyword.length > 0 && qa_keyword.length <= 4) return;

			//console.log(form_data);

			qa_type_delay(function () {

				//console.log(form_data);

				$('.loading').fadeIn();
				$('.question-list').css('opacity', 0.5);

				$.ajax({
					type: 'POST',
					context: this,
					url: qa_ajax.qa_ajaxurl,
					data: {
						"action": "question_answer_archive_ajax_search",
						"form_data": form_data,
					},
					success: function (response) {

						var data = JSON.parse(response);
						qa_keyword = data['qa_keyword'];
						html = data['html'];
						pagination = data['pagination'];
						posts_per_page = data['posts_per_page'];

						console.log(data);


						$('.question-list').html(html);
						$('.qa-paginate').html(pagination);

						//if( question_permalink.length > 0 ) window.location.href = question_permalink;

						$('.loading').fadeOut();
						$('.question-list').css('opacity', 1);
					}
				});


			}, 1000);







		})


		$('.questions-archive #qaKeyword').autocomplete({

			//search:keyword,
			classes: {
				"ui-autocomplete": "highlight"
			},

			source: function (keyword, response) {
				//console.log(keyword);

				$.ajax({
					type: 'POST',
					context: this,
					url: qa_ajax.qa_ajaxurl,
					data: {
						"action": "qa_ajax_get_keyword_suggestion",
						"keyword": keyword,
					},
					success: function (data) {

						data = JSON.parse(data);
						response(data);

					}
				});

			}
		});

		$(document).on('click', '.qa-paginate a', function (e) {

			e.preventDefault();

			form_data = $('#qa-search-form').serializeArray();
			qa_keyword = $('#qa_keyword').val();

			var page = $(this).text();


			//if(qa_keyword.length > 0 && qa_keyword.length <= 4) return;


			qa_type_delay(function () {

				////console.log(qa_keyword.length);

				$('.loading').fadeIn();
				$('.question-list').css('opacity', 0.5);

				$.ajax({
					type: 'POST',
					context: this,
					url: qa_ajax.qa_ajaxurl,
					data: {
						"action": "question_answer_archive_ajax_search",
						"form_data": form_data,
						"page": page,

					},
					success: function (response) {

						var data = JSON.parse(response);
						qa_keyword = data['qa_keyword'];
						html = data['html'];
						pagination = data['pagination'];

						//console.log(pagination);

						$('.question-list').html(html);
						$('.qa-paginate').html(pagination);

						//if( question_permalink.length > 0 ) window.location.href = question_permalink;

						$('.loading').fadeOut();
						$('.question-list').css('opacity', 1);
					}
				});


			}, 1000);







		})









	});
})(jQuery);