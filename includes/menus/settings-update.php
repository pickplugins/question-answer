<?php
if (!defined('ABSPATH')) exit;  // if direct access



wp_enqueue_style('font-awesome-5');



$qa_question_item_per_page = get_option('qa_question_item_per_page');

$qa_reCAPTCHA_site_key = get_option('qa_reCAPTCHA_site_key');
$qa_reCAPTCHA_secret_key = get_option('qa_reCAPTCHA_secret_key');

$qa_options_filter_badwords = get_option('qa_options_filter_badwords');
$qa_options_badwords = get_option('qa_options_badwords');
$qa_options_badwords_replacer = get_option('qa_options_badwords_replacer');

$question_answer_settings = get_option('question_answer_settings');
$archive_notice = isset($question_answer_settings['archive_notice']) ? $question_answer_settings['archive_notice'] : '';

$question_answer_settings = get_option('question_answer_settings');
$question_submission_notice = isset($question_answer_settings['question_submission_notice']) ? $question_answer_settings['question_submission_notice'] : '';
$qa_enable_poll = get_option('qa_enable_poll');
$qa_account_required_post_question = get_option('qa_account_required_post_question');
$qa_submitted_question_status = get_option('qa_submitted_question_status');
$qa_page_question_post_redirect = get_option('qa_page_question_post_redirect');

$qa_reCAPTCHA_enable_question = get_option('qa_reCAPTCHA_enable_question');

$qa_options_quick_notes = get_option('qa_options_quick_notes');
$qa_who_can_see_quick_notes = get_option('qa_who_can_see_quick_notes', []);
$qa_answer_item_per_page = get_option('qa_answer_item_per_page');
$qa_account_required_post_answer = get_option('qa_account_required_post_answer');
$qa_submitted_answer_status = get_option('qa_submitted_answer_status');
$qa_show_answer_filter = get_option('qa_show_answer_filter');
$qa_answer_filter_options = get_option('qa_answer_filter_options', []);
$access_to_private_answer = get_option('access_to_private_answer', []);

$qa_who_can_answer = get_option('qa_who_can_answer', []);
$qa_who_can_comment_answer = get_option('qa_who_can_comment_answer', []);
$qa_can_edit_answer = get_option('qa_can_edit_answer');
$qa_answer_editor_type = get_option('qa_answer_editor_type');
$qa_answer_editor_media_buttons = get_option('qa_answer_editor_media_buttons');
$qa_answer_reply_order = get_option('qa_answer_reply_order');

$qa_page_question_post = get_option('qa_page_question_post');
$qa_page_question_archive = get_option('qa_page_question_archive');
$qa_page_user_profile = get_option('qa_page_user_profile');
$qa_page_myaccount = get_option('qa_page_myaccount');
$qa_enable_poll = get_option('qa_enable_poll');
$qa_enable_poll = get_option('qa_enable_poll');
$qa_enable_poll = get_option('qa_enable_poll');
$qa_enable_poll = get_option('qa_enable_poll');

$question_answer_settings = get_option('question_answer_settings');
$single_question_notice = isset($question_answer_settings['single_question_notice']) ? $question_answer_settings['single_question_notice'] : '';
$single_question_access_role = get_option('single_question_access_role', []);
$qa_allow_question_comment = get_option('qa_allow_question_comment');


$qa_myaccount_show_login_form = get_option('qa_myaccount_show_login_form');
$qa_myaccount_login_redirect_page = get_option('qa_myaccount_login_redirect_page');
$qa_myaccount_show_register_form = get_option('qa_myaccount_show_register_form');
$qa_allow_question_comment = get_option('qa_allow_question_comment');
$qa_enable_poll = get_option('qa_enable_poll');

$question_answer_settings = get_option('question_answer_settings');
$dashboard_notice = isset($question_answer_settings['dashboard_notice']) ? $question_answer_settings['dashboard_notice'] : '';


$qa_color_archive_answer_count = get_option('qa_color_archive_answer_count');

$qa_color_archive_view_count = get_option('qa_color_archive_view_count');
$qa_color_single_user_role = get_option('qa_color_single_user_role');
$qa_color_single_user_role_background = get_option('qa_color_single_user_role_background');
$qa_color_add_comment_background = get_option('qa_color_add_comment_background');
$qa_ask_button_bg_color = get_option('qa_ask_button_bg_color');
$qa_color_best_answer_background = get_option('qa_color_best_answer_background');
$qa_vote_button_bg_color = get_option('qa_vote_button_bg_color');
$qa_ask_button_text_color = get_option('qa_ask_button_text_color');
$qa_flag_button_bg_color = get_option('qa_flag_button_bg_color');


$class_qa_emails = new class_qa_emails();
$templates_data_default = $class_qa_emails->qa_email_templates_data();
$email_templates_parameters = $class_qa_emails->email_templates_parameters();

$qa_logo_url = get_option('qa_logo_url');
$qa_from_email = get_option('qa_from_email');
$templates_data_saved = get_option('qa_email_templates_data', $templates_data_default);


?>
<div class="wrap">


    <h2>Question Answer - Settings Migrate</h2>



</div>