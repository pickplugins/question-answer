document.addEventListener("DOMContentLoaded", function (event) {

	var qaCreateAccount = document.querySelector("input[name=qa_create_account]");
	var qaUsername = document.querySelector("input[name=qa_username]");
	var qaPassword = document.querySelector("input[name=qa_password]");



	qaCreateAccount.addEventListener('change', function () {
		if (this.checked) {
			qaUsername.style.display = 'block';
			qaPassword.style.display = 'block';

		} else {
			qaUsername.style.display = 'none';
			qaPassword.style.display = 'none';
		}
	});

})


	(function ($) {
		$(document).on("ready", function () {

			$(".poll-items").sortable({
				handle: '.sort-hndle'
			});
			$(document).on('click', '.poll-field-wrap .remove', function (e) {

				e.preventDefault();

				$(this).parent().remove();


			})
			$(document).on('click', '.poll-field-wrap .add-poll', function (e) {

				e.preventDefault();
				var id = $.now();

				var html = '<div class="item">';
				html += '<input type="text" name="polls[]" value=""/>';
				html += '<span class="sort-hndle"> ... </span>';
				html += '<button class="remove" > X </button>';
				html += '</div>';


				$('.poll-items').append(html);


			})


			$(document).on('keyup', ".question-submit #post_title", function () {


				$(this).attr('autocomplete', 'off');
				title = $(this).val();
				$('.suggestion-title, .loading').fadeIn();


				$.ajax(
					{
						type: 'POST',
						context: this,
						url: qa_ajax.qa_ajaxurl,
						data: {
							"action": "qa_ajax_question_suggestion",
							"title": title,

						},
						success: function (data) {

							$('.suggestions-list').html(data);
							$('.loading').fadeOut();
						}
					});


			})




		});
	})(jQuery);