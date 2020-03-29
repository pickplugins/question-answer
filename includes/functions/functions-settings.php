<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


add_action('qa_settings_tabs_content_general', 'qa_settings_tabs_content_general');

if(!function_exists('qa_settings_tabs_content_general')) {
    function qa_settings_tabs_content_general($tab){

        $settings_tabs_field = new settings_tabs_field();

        $qa_question_item_per_page = get_option('qa_question_item_per_page');

        $reCAPTCHA_site_key = get_option('reCAPTCHA_site_key');

        $qa_options_filter_badwords = get_option('qa_options_filter_badwords');
        $qa_options_badwords = get_option('qa_options_badwords');
        $qa_options_badwords_replacer = get_option('qa_options_badwords_replacer');



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('General settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose some general setting to get started.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'qa_question_item_per_page',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Item per page','question-answer'),
                'details'	=> __('Set custom number of items(question, answer, comments) per page on archive','question-answer'),
                'type'		=> 'text',
                'value'		=> $qa_question_item_per_page,
                'default'		=> 10,
                'placeholder'		=> 10,
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'reCAPTCHA_site_key',
                //'parent'		=> 'qa_settings',
                'title'		=> __('reCAPTCHA site key','question-answer'),
                'details'	=> __('reCAPTCHA site key, please go <a href="google.com/reCAPTCHA">google.com/reCAPTCHA</a> and register your site to get site key.','question-answer'),
                'type'		=> 'text',
                'value'		=> $reCAPTCHA_site_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_options_filter_badwords',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Filter bad words','question-answer'),
                'details'	=> __('Do you want to filter bad words automatically?','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_options_filter_badwords,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_options_badwords',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Define bad words','question-answer'),
                'details'	=> __('Add all the possible bad words here, use comma(,) to separated. ex: <code>Fuck, Asshole, Shit</code>','question-answer'),
                'type'		=> 'textarea',
                'value'		=> $qa_options_badwords,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_options_badwords_replacer',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Bad words replacer','question-answer'),
                'details'	=> __('What you want to show in the place of any bad-words. You can use HTML formatting also.','question-answer'),
                'type'		=> 'text',
                'value'		=> $qa_options_badwords_replacer,
                'default'		=> '',
                'placeholder'		=> '***',
            );

            $settings_tabs_field->generate_field($args);





            ?>


        </div>
        <?php


    }
}


add_action('qa_settings_tabs_content_archive', 'qa_settings_tabs_content_archive');

if(!function_exists('qa_settings_tabs_content_archive')) {
    function qa_settings_tabs_content_archive($tab){

        $settings_tabs_field = new settings_tabs_field();

        $question_answer_settings = get_option('question_answer_settings');
        $archive_notice = isset($question_answer_settings['archive_notice']) ? $question_answer_settings['archive_notice'] : '';



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Archive settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose some setting for archive pages.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'archive_notice',
                'parent'		=> 'question_answer_settings',
                'title'		=> __('archive notice','question-answer'),
                'details'	=> __('Set custom text for archive notice','question-answer'),
                'type'		=> 'text',
                'value'		=> $archive_notice,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            ?>
        </div>
        <?php
    }
}


add_action('qa_settings_tabs_content_single_question', 'qa_settings_tabs_content_single_question');

if(!function_exists('qa_settings_tabs_content_single_question')) {
    function qa_settings_tabs_content_single_question($tab){

        $settings_tabs_field = new settings_tabs_field();

        $question_answer_settings = get_option('question_answer_settings');
        $single_question_notice = isset($question_answer_settings['single_question_notice']) ? $question_answer_settings['single_question_notice'] : '';



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Archive settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose some setting for archive pages.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'single_question_notice',
                'parent'		=> 'question_answer_settings',
                'title'		=> __('Single question notice','question-answer'),
                'details'	=> __('Set custom text for single question notice','question-answer'),
                'type'		=> 'text',
                'value'		=> $single_question_notice,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            ?>
        </div>
        <?php
    }
}



add_action('qa_settings_tabs_content_question_submission', 'qa_settings_tabs_content_question_submission');

if(!function_exists('qa_settings_tabs_content_question_submission')) {
    function qa_settings_tabs_content_question_submission($tab){

        $settings_tabs_field = new settings_tabs_field();

        $question_answer_settings = get_option('question_answer_settings');
        $question_submission_notice = isset($question_answer_settings['question_submission_notice']) ? $question_answer_settings['question_submission_notice'] : '';



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Question submission settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose some setting for question submission page.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'question_submission_notice',
                'parent'		=> 'question_answer_settings',
                'title'		=> __('Question submission notice','question-answer'),
                'details'	=> __('Set custom text for question submission notice','question-answer'),
                'type'		=> 'text',
                'value'		=> $question_submission_notice,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            ?>
        </div>
        <?php
    }
}





add_action('qa_settings_tabs_content_answers', 'qa_settings_tabs_content_answers');

if(!function_exists('qa_settings_tabs_content_answers')) {
    function qa_settings_tabs_content_answers($tab){

        $settings_tabs_field = new settings_tabs_field();

        $qa_options_quick_notes = get_option('qa_options_quick_notes');
        $qa_who_can_see_quick_notes = get_option('qa_who_can_see_quick_notes');
        $qa_answer_item_per_page = get_option('qa_answer_item_per_page');
        $qa_account_required_post_answer = get_option('qa_account_required_post_answer');
        $qa_submitted_answer_status = get_option('qa_submitted_answer_status');
        $qa_show_answer_filter = get_option('qa_show_answer_filter');
        $qa_who_can_answer = get_option('qa_who_can_answer');
        $qa_who_can_comment_answer = get_option('qa_who_can_comment_answer');
        $qa_can_edit_answer = get_option('qa_can_edit_answer');
        $qa_answer_editor_type = get_option('qa_answer_editor_type');
        $qa_answer_editor_media_buttons = get_option('qa_answer_editor_media_buttons');
        $qa_answer_reply_order = get_option('qa_answer_reply_order');




        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Answer Settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for answers.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'qa_options_quick_notes',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Quick notes on answer','question-answer'),
                'details'	=> __('Display quick notes on answer submit form.','question-answer'),
                'type'		=> 'text_multi',
                'value'		=> $qa_options_quick_notes,
                'default'		=> 10,
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_who_can_see_quick_notes',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Who can see quick notes?','question-answer'),
                'details'	=> __('Choose user roles to see quick notes on answer submit form.','question-answer'),
                'type'		=> 'select',
                'multiple'		=> true,
                'value'		=> $qa_who_can_see_quick_notes,
                'default'		=> array(),
                'args'		=> qa_all_roles(),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_answer_item_per_page',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Answer per page','question-answer'),
                'details'	=> __('Set number of answer display per page.','question-answer'),
                'type'		=> 'text',
                'value'		=> $qa_answer_item_per_page,
                'default'		=> 10,
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_account_required_post_answer',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Account required to answer?','question-answer'),
                'details'	=> __('Set is account request to submit answers.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_account_required_post_answer,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_submitted_answer_status',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Submitted answer status','question-answer'),
                'details'	=> __('Choose post status for newly submitted answer.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_submitted_answer_status,
                'default'		=> 'pending',
                'args'		=> array( 'draft'=>__('Draft', 'question-answer'), 'pending'=>__('Pending', 'question-answer'), 'publish'=>__('Published', 'question-answer'), 'private'=>__('Private', 'question-answer'), 'trash'=>__('Trash', 'question-answer')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_who_can_answer',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Who can post answer (by role)?','question-answer'),
                'details'	=> __('You can select roles to set who can only post answer for question.','question-answer'),
                'type'		=> 'select',
                'multiple'		=> true,
                'value'		=> $qa_who_can_answer,
                'default'		=> array('administrator'),
                'args'		=> qa_all_roles(),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_who_can_comment_answer',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Who can comment on answer?','question-answer'),
                'details'	=> __('You can select roles to set who can only post comment on answer.','question-answer'),
                'type'		=> 'select',
                'multiple'		=> true,
                'value'		=> $qa_who_can_comment_answer,
                'default'		=> array('administrator'),
                'args'		=> qa_all_roles(),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_can_edit_answer',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Can user edit answer?','question-answer'),
                'details'	=> __('Allow user to edit their own answer.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_can_edit_answer,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_answer_editor_type',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Editor type for answer posting','question-answer'),
                'details'	=> __('Choose editor type on answer posting.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_answer_editor_type,
                'default'		=> 'wp_editor',
                'args'		=>array('textarea'=>'Textarea', 'wp_editor'=>'WP Editor'),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_answer_editor_media_buttons',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Enable media upload button on editor','question-answer'),
                'details'	=> __('Enable media upload button on editor.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_answer_editor_media_buttons,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_answer_reply_order',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Answer reply order','question-answer'),
                'details'	=> __('Set order to display answer comments.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_answer_reply_order,
                'default'		=> 'DESC',
                'args'		=> array('DESC'=>'DESC', 'ASC'=>'ASC'),
            );

            $settings_tabs_field->generate_field($args);






            ?>


        </div>
        <?php


    }
}





add_action('qa_settings_tabs_content_pages', 'qa_settings_tabs_content_pages');

if(!function_exists('qa_settings_tabs_content_pages')) {
    function qa_settings_tabs_content_pages($tab){

        $settings_tabs_field = new settings_tabs_field();
        $class_qa_functions = new class_qa_functions();


        $qa_page_question_post = get_option('qa_page_question_post');
        $qa_page_question_post_redirect = get_option('qa_page_question_post_redirect');
        $qa_page_question_archive = get_option('qa_page_question_archive');
        $qa_page_user_profile = get_option('qa_page_user_profile');
        $qa_page_myaccount = get_option('qa_page_myaccount');
        $qa_enable_poll = get_option('qa_enable_poll');
        $qa_enable_poll = get_option('qa_enable_poll');
        $qa_enable_poll = get_option('qa_enable_poll');
        $qa_enable_poll = get_option('qa_enable_poll');




        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Pages settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for pages.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'qa_page_question_post',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Question submission page','question-answer'),
                'details'	=> __('Select the page where you want display question submission form, put the shortcode <code>[qa_add_question]</code>','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_page_question_post,
                'default'		=> '',
                'args'		=> $class_qa_functions->qa_get_pages(),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_page_question_post_redirect',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Redirect after question submit','question-answer'),
                'details'	=> __('Select the page where redirect after submit question.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_page_question_post_redirect,
                'default'		=> '',
                'args'		=> $class_qa_functions->qa_get_pages(),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_page_question_archive',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Question archive page','question-answer'),
                'details'	=> __('Select the page where you want to display all question archive list, put the shortcode <code>[question_archive]</code>.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_page_question_archive,
                'default'		=> '',
                'args'		=> $class_qa_functions->qa_get_pages(),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_page_user_profile',
                //'parent'		=> 'qa_settings',
                'title'		=> __('User profile page','question-answer'),
                'details'	=> __('Select the page where you want to display user profile <code>[qa_user_profile]</code>.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_page_user_profile,
                'default'		=> '',
                'args'		=> $class_qa_functions->qa_get_pages(),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_page_myaccount',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Dashboard page','question-answer'),
                'details'	=> __('Select the page where you want to display dashboard, put the shortcode <code>[qa_dashboard]</code>.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_page_myaccount,
                'default'		=> '',
                'args'		=> $class_qa_functions->qa_get_pages(),
            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
        <?php


    }
}







add_action('qa_settings_tabs_content_questions', 'qa_settings_tabs_content_questions');

if(!function_exists('qa_settings_tabs_content_questions')) {
    function qa_settings_tabs_content_questions($tab){

        $settings_tabs_field = new settings_tabs_field();

        $qa_enable_poll = get_option('qa_enable_poll');

        $qa_account_required_post_question = get_option('qa_account_required_post_question');
        $qa_submitted_question_status = get_option('qa_submitted_question_status');
        $qa_allow_question_comment = get_option('qa_allow_question_comment');




        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Question settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for question settings.', 'question-answer'); ?></p>

            <?php


            $args = array(
                'id'		=> 'qa_account_required_post_question',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Account required to question?','question-answer'),
                'details'	=> __('Choose is account required to post question.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_account_required_post_question,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_submitted_question_status',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Submitted question status','question-answer'),
                'details'	=> __('Choose post status for newly submitted question.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_submitted_question_status,
                'default'		=> 'pending',
                'args'		=> array( 'draft'=>__('Draft', 'question-answer'), 'pending'=>__('Pending', 'question-answer'), 'publish'=>__('Published', 'question-answer'), 'private'=>__('Private', 'question-answer'), 'trash'=>__('Trash', 'question-answer')),
            );

            $settings_tabs_field->generate_field($args);









            $args = array(
                'id'		=> 'qa_allow_question_comment',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Allow comments on question?','question-answer'),
                'details'	=> __('Choose is comments allowed or not on question.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_allow_question_comment,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_enable_poll',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Enable poll?','question-answer'),
                'details'	=> __('Choose is poll enable or not.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_enable_poll,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);














            ?>


        </div>
        <?php


    }
}






add_action('qa_settings_tabs_content_dashboard', 'qa_settings_tabs_content_dashboard');

if(!function_exists('qa_settings_tabs_content_dashboard')) {
    function qa_settings_tabs_content_dashboard($tab){

        $settings_tabs_field = new settings_tabs_field();
        $class_qa_functions = new class_qa_functions();


        $qa_myaccount_show_login_form = get_option('qa_myaccount_show_login_form');
        $qa_myaccount_login_redirect_page = get_option('qa_myaccount_login_redirect_page');
        $qa_myaccount_show_register_form = get_option('qa_myaccount_show_register_form');
        $qa_allow_question_comment = get_option('qa_allow_question_comment');
        $qa_enable_poll = get_option('qa_enable_poll');

        $question_answer_settings = get_option('question_answer_settings');
        $dashboard_notice = isset($question_answer_settings['dashboard_notice']) ? $question_answer_settings['dashboard_notice'] : '';




        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Dashboard settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for dashboard page.', 'question-answer'); ?></p>

            <?php


            $args = array(
                'id'		=> 'dashboard_notice',
                'parent'		=> 'question_answer_settings',
                'title'		=> __('Dashboard notice','question-answer'),
                'details'	=> __('Set custom text for dashboard notice','question-answer'),
                'type'		=> 'text',
                'value'		=> $dashboard_notice,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_myaccount_show_login_form',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Display login form','question-answer'),
                'details'	=> __('Display login form on dashboard.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_myaccount_show_login_form,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_myaccount_login_redirect_page',
                //'parent'		=> 'qa_settings',
                'title'		=> __('After login redirect to page','question-answer'),
                'details'	=> __('You can set custom page to redirect after login.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_myaccount_login_redirect_page,
                'default'		=> 'pending',
                'args'		=> $class_qa_functions->qa_get_pages(),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_myaccount_show_register_form',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Display register form','question-answer'),
                'details'	=> __('Show registration form on dashboard area for logged out users.','question-answer'),
                'type'		=> 'select',
                'value'		=> $qa_myaccount_show_register_form,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);





            ?>


        </div>
        <?php


    }
}





add_action('qa_settings_tabs_content_style', 'qa_settings_tabs_content_style');

if(!function_exists('qa_settings_tabs_content_style')) {
    function qa_settings_tabs_content_style($tab){

        $settings_tabs_field = new settings_tabs_field();


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




        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Style settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose style settings.', 'question-answer'); ?></p>

            <?php



            $args = array(
                'id'		=> 'qa_color_archive_answer_count',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Answer count text color','question-answer'),
                'details'	=> __('Answer count text color on archive page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_archive_answer_count,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_color_archive_view_count',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Question view count color','question-answer'),
                'details'	=> __('View count text color','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_archive_view_count,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_color_single_user_role',
                //'parent'		=> 'qa_settings',
                'title'		=> __('User role text color','question-answer'),
                'details'	=> __('User role text color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_single_user_role,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_color_single_user_role_background',
                //'parent'		=> 'qa_settings',
                'title'		=> __('User role background color','question-answer'),
                'details'	=> __('User role background color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_single_user_role_background,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_color_add_comment_background',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Comment button background color','question-answer'),
                'details'	=> __('Comment button background color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_add_comment_background,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_ask_button_bg_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Best answer background color','question-answer'),
                'details'	=> __('Best answer background color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_ask_button_bg_color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_color_best_answer_background',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Ask button background color','question-answer'),
                'details'	=> __('Select background color for ask button on top.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_best_answer_background,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_ask_button_text_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Ask button text color','question-answer'),
                'details'	=> __('Select text color for ask button on top.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_ask_button_text_color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_vote_button_bg_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Vote button background color','question-answer'),
                'details'	=> __('Select Vote button background color.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_vote_button_bg_color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_flag_button_bg_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Flag button background color','question-answer'),
                'details'	=> __('Select Flag button background color.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_flag_button_bg_color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);







            ?>


        </div>
        <?php


    }
}

















add_action('qa_settings_tabs_right_panel_archive', 'qa_settings_tabs_right_panel_archive');

if(!function_exists('qa_settings_tabs_right_panel_archive')) {
    function qa_settings_tabs_right_panel_archive($id){

        ?>
        <h3>Help & Support</h3>
        <p>Please read documentation for customize Job Board Manger</p>
        <a target="_blank" class="button" href="https://www.pickplugins.com/documentation/question-answer/?ref=dashboard">Documentation</a>

        <p>If you found any issue could not manage to solve yourself, please let us know and post your issue on forum.</p>
        <a target="_blank" class="button" href="https://www.pickplugins.com/forum/?ref=dashboard">Create Ticket</a>

        <h3>Write Reviews</h3>
        <p>If you found Job Board Manger help you to build something useful, please help us by providing your feedback
            and five star reviews on plugin page.</p>
        <a target="_blank" class="button" href="https://wordpress.org/support/plugin/question-answer/reviews/#new-post">Rate Us <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></a>

        <h3>Shortcodes</h3>
        <p><code>[job_bm_applications]</code> <br> Display list of applications. <br><a href="http://www.pickplugins.com/demo/question-answer/job-dashboard/?tabs=applications">Demo</a> </p>
        <p><code>[job_bm_dashboard]</code> <br> Display job dashboard on front-end. <br><a href="http://www.pickplugins.com/demo/question-answer/job-dashboard/">Demo</a></p>
        <p><code>[job_bm_archive]</code> <br> Display job archive on front-end. <br><a href="http://www.pickplugins.com/demo/question-answer/">Demo</a></p>
        <p><code>[job_bm_job_edit]</code> <br> Display job edit form on front-end. <br><a href="http://www.pickplugins.com/demo/question-answer/job-edit/?job_id=4134">Demo</a></p>
        <p><code>[job_bm_job_submit]</code> <br> Display job submit form on front-end. <br><a href="http://www.pickplugins.com/demo/question-answer/job-submit/">Demo</a></p>
        <p><code>[job_bm_my_applications]</code> <br> Display logged-in user submitted applications. <br><a href="http://www.pickplugins.com/demo/question-answer/job-dashboard/?tabs=my_applications">Demo</a></p>
        <p><code>[job_bm_my_jobs]</code> <br> Display logged-in user submitted jobs. <br><a href="http://www.pickplugins.com/demo/question-answer/job-dashboard/?tabs=my_jobs">Demo</a></p>
        <p><code>[job_bm_registration_form]</code> <br> Display register form on front-end. <br><a href="http://www.pickplugins.com/demo/question-answer/job-dashboard/">Demo</a></p>




        <?php

    }
}


add_action('qa_settings_tabs_content_emails', 'qa_settings_tabs_content_emails');

if(!function_exists('qa_settings_tabs_content_emails')) {
    function qa_settings_tabs_content_emails($tab){

        $settings_tabs_field = new settings_tabs_field();
        $class_job_bm_emails = new class_qa_emails();
        $templates_data_default = $class_job_bm_emails->qa_email_templates_data();
        $email_templates_parameters = $class_job_bm_emails->email_templates_parameters();

        $qa_logo_url = get_option('qa_logo_url');
        $qa_from_email = get_option('qa_from_email');
        $templates_data_saved = get_option( 'qa_email_templates_data', $templates_data_default );
        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Email settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Customize email settings.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'qa_logo_url',
                //'parent'		=> '',
                'title'		=> __('Email logo','question-answer'),
                'details'	=> __('Email logo URL to display on mail.','question-answer'),
                'type'		=> 'media',
                'value'		=> $qa_logo_url,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_from_email',
                //'parent'		=> '',
                'title'		=> __('From email address','question-answer'),
                'details'	=> __('Write from email address.','question-answer'),
                'type'		=> 'text',
                //'multiple'		=> true,
                'value'		=> $qa_from_email,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);






            ob_start();


            ?>
            <div class="reset-email-templates button">Reset</div>
            <br><br>
            <div class="templates_editor expandable">
                <?php




                if(!empty($templates_data_default))
                    foreach($templates_data_default as $key=>$templates){

                        $templates_data_display = isset($templates_data_saved[$key]) ? $templates_data_saved[$key] : $templates;


                        $email_to = isset($templates_data_display['email_to']) ? $templates_data_display['email_to'] : '';
                        $email_from = isset($templates_data_display['email_from']) ? $templates_data_display['email_from'] : '';
                        $email_from_name = isset($templates_data_display['email_from_name']) ? $templates_data_display['email_from_name'] : '';
                        $enable = isset($templates_data_display['enable']) ? $templates_data_display['enable'] : '';
                        $description = isset($templates_data_display['description']) ? $templates_data_display['description'] : '';

                        $parameters = isset($email_templates_parameters[$key]['parameters']) ? $email_templates_parameters[$key]['parameters'] : array();


                        //echo '<pre>'.var_export($enable).'</pre>';

                        ?>
                        <div class="item template <?php echo $key; ?>">
                            <div class="header">
                        <span title="<?php echo __('Click to expand', 'question-answer'); ?>" class="expand ">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-compress"></i>
                        </span>

                                <?php
                                if($enable =='yes'):
                                    ?>
                                    <span title="<?php echo __('Enable', 'question-answer'); ?>" class="is-enable ">
                            <i class="fa fa-check-square"></i>
                            </span>
                                <?php
                                else:
                                    ?>
                                    <span title="<?php echo __('Disabled', 'question-answer'); ?>" class="is-enable ">
                            <i class="fa fa-times-circle"></i>
                            </span>
                                <?php
                                endif;
                                ?>


                                <?php echo $templates['name']; ?>
                            </div>
                            <input type="hidden" name="qa_email_templates_data[<?php echo $key; ?>][name]" value="<?php echo $templates['name']; ?>" />
                            <div class="options">
                                <div class="description"><?php echo $description; ?></div><br/><br/>


                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Enable?', 'question-answer'); ?></div>
                                    <div class="field-input">
                                        <select name="qa_email_templates_data[<?php echo $key; ?>][enable]" >
                                            <option <?php echo selected($enable,'yes'); ?> value="yes" ><?php echo __('Yes', 'question-answer'); ?></option>
                                            <option <?php echo selected($enable,'no'); ?>  value="no" ><?php echo __('No', 'question-answer'); ?></option>
                                        </select>
                                        <p class="description"><?php echo __('Enable or disable this email notification.', 'question-answer'); ?></p>
                                    </div>
                                </div>


                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Email To(Bcc)', 'question-answer'); ?></div>
                                    <div class="field-input">
                                        <input placeholder="hello_1@hello.com,hello_2@hello.com" type="text" name="qa_email_templates_data[<?php echo $key; ?>][email_to]" value="<?php echo $email_to; ?>" />
                                        <p class="description"><?php echo __('Email send to(copy)', 'question-answer'); ?></p>
                                    </div>
                                </div>

                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Email from name', 'question-answer'); ?></div>
                                    <div class="field-input">
                                        <input placeholder="hello_1@hello.com" type="text" name="qa_email_templates_data[<?php echo $key; ?>][email_from_name]" value="<?php echo $email_from_name; ?>" />
                                        <p class="description"><?php echo __('Email send from name', 'question-answer'); ?></p>
                                    </div>
                                </div>

                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Email from', 'question-answer'); ?></div>
                                    <div class="field-input">
                                        <input placeholder="hello_1@hello.com" type="text" name="qa_email_templates_data[<?php echo $key; ?>][email_from]" value="<?php echo $email_from; ?>" />
                                        <p class="description"><?php echo __('Email send from', 'question-answer'); ?></p>
                                    </div>
                                </div>

                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Email Subject', 'question-answer'); ?></div>
                                    <div class="field-input">
                                        <input type="text" name="qa_email_templates_data[<?php echo $key; ?>][subject]" value="<?php echo $templates['subject']; ?>" />
                                        <p class="description"><?php echo __('Write email subject', 'question-answer'); ?></p>
                                    </div>
                                </div>

                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Email Body', 'question-answer'); ?></div>
                                    <div class="field-input">
                                        <?php

                                        wp_editor( $templates['html'], $key, $settings = array('textarea_name'=>'qa_email_templates_data['.$key.'][html]','media_buttons'=>false,'wpautop'=>true,'teeny'=>true,'editor_height'=>'400px', ) );

                                        ?>
                                        <p class="description"><?php echo __('Write email body', 'question-answer'); ?></p>
                                    </div>
                                </div>

                                <div class="setting-field">
                                    <div class="field-lable"><?php echo __('Parameter', 'question-answer'); ?></div>
                                    <div class="field-input">

                                        <ul>


                                            <?php

                                            if(!empty($parameters)):
                                                foreach ($parameters as $parameterId=>$parameter):
                                                    ?>
                                                    <li><code><?php echo $parameterId; ?></code> => <?php echo $parameter; ?></li>
                                                <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </ul>

                                        <p class="description"><?php echo __('Available parameter for this email template', 'question-answer'); ?></p>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <?php

                    }


                ?>


            </div>
            <?php


            $html = ob_get_clean();




            $args = array(
                'id'		=> 'job_bm_email_templates',
                //'parent'		=> '',
                'title'		=> __('Email templates','question-answer'),
                'details'	=> __('Customize email templates.','question-answer'),
                'type'		=> 'custom_html',
                //'multiple'		=> true,
                'html'		=> $html,
            );

            $settings_tabs_field->generate_field($args);




            ?>


        </div>
        <?php


    }
}


add_action('qa_settings_save', 'qa_settings_save');

if(!function_exists('qa_settings_save')) {
    function qa_settings_save($tab){


        $qa_question_item_per_page = isset($_POST['qa_question_item_per_page']) ?  sanitize_text_field($_POST['qa_question_item_per_page']) : '';
        update_option('qa_question_item_per_page', $qa_question_item_per_page);

        $reCAPTCHA_site_key = isset($_POST['reCAPTCHA_site_key']) ?  sanitize_text_field($_POST['reCAPTCHA_site_key']) : '';
        update_option('reCAPTCHA_site_key', $reCAPTCHA_site_key);

        $qa_options_filter_badwords = isset($_POST['qa_options_filter_badwords']) ?  sanitize_text_field($_POST['qa_options_filter_badwords']) : '';
        update_option('qa_options_filter_badwords', $qa_options_filter_badwords);

        $qa_options_badwords = isset($_POST['qa_options_badwords']) ?  sanitize_text_field($_POST['qa_options_badwords']) : '';
        update_option('qa_options_badwords', $qa_options_badwords);

        $qa_options_badwords_replacer= isset($_POST['qa_options_badwords_replacer']) ?  sanitize_text_field($_POST['qa_options_badwords_replacer']) : '';
        update_option('qa_options_badwords_replacer', $qa_options_badwords_replacer);

        $qa_options_quick_notes = isset($_POST['qa_options_quick_notes']) ?  stripslashes_deep($_POST['qa_options_quick_notes']) : '';
        update_option('qa_options_quick_notes', $qa_options_quick_notes);

        $qa_who_can_see_quick_notes = isset($_POST['qa_who_can_see_quick_notes']) ?  stripslashes_deep($_POST['qa_who_can_see_quick_notes']) : '';
        update_option('qa_who_can_see_quick_notes', $qa_who_can_see_quick_notes);

        $qa_answer_item_per_page = isset($_POST['qa_answer_item_per_page']) ?  sanitize_text_field($_POST['qa_answer_item_per_page']) : '';
        update_option('qa_answer_item_per_page', $qa_answer_item_per_page);

        $qa_account_required_post_answer = isset($_POST['qa_account_required_post_answer']) ?  sanitize_text_field($_POST['qa_account_required_post_answer']) : '';
        update_option('qa_account_required_post_answer', $qa_account_required_post_answer);

        $qa_submitted_answer_status = isset($_POST['qa_submitted_answer_status']) ?  sanitize_text_field($_POST['qa_submitted_answer_status']) : '';
        update_option('qa_submitted_answer_status', $qa_submitted_answer_status);

        $qa_who_can_answer = isset($_POST['qa_who_can_answer']) ?  stripslashes_deep($_POST['qa_who_can_answer']) : '';
        update_option('qa_who_can_answer', $qa_who_can_answer);

        $qa_who_can_comment_answer = isset($_POST['qa_who_can_comment_answer']) ?  stripslashes_deep($_POST['qa_who_can_comment_answer']) : '';
        update_option('qa_who_can_comment_answer', $qa_who_can_comment_answer);

        $qa_can_edit_answer = isset($_POST['qa_can_edit_answer']) ?  sanitize_text_field($_POST['qa_can_edit_answer']) : '';
        update_option('qa_can_edit_answer', $qa_can_edit_answer);

        $qa_answer_editor_type = isset($_POST['qa_answer_editor_type']) ?  sanitize_text_field($_POST['qa_answer_editor_type']) : '';
        update_option('qa_answer_editor_type', $qa_answer_editor_type);

        $qa_answer_editor_media_buttons = isset($_POST['qa_answer_editor_media_buttons']) ?  sanitize_text_field($_POST['qa_answer_editor_media_buttons']) : '';
        update_option('qa_answer_editor_media_buttons', $qa_answer_editor_media_buttons);

        $qa_answer_reply_order = isset($_POST['qa_answer_reply_order']) ?  sanitize_text_field($_POST['qa_answer_reply_order']) : '';
        update_option('qa_answer_reply_order', $qa_answer_reply_order);

        $qa_page_question_post = isset($_POST['qa_page_question_post']) ?  sanitize_text_field($_POST['qa_page_question_post']) : '';
        update_option('qa_page_question_post', $qa_page_question_post);

        $qa_page_question_post_redirect = isset($_POST['qa_page_question_post_redirect']) ?  sanitize_text_field($_POST['qa_page_question_post_redirect']) : '';
        update_option('qa_page_question_post_redirect', $qa_page_question_post_redirect);

        $qa_page_question_archive = isset($_POST['qa_page_question_archive']) ?  sanitize_text_field($_POST['qa_page_question_archive']) : '';
        update_option('qa_page_question_archive', $qa_page_question_archive);

        $qa_page_user_profile = isset($_POST['qa_page_user_profile']) ?  sanitize_text_field($_POST['qa_page_user_profile']) : '';
        update_option('qa_page_user_profile', $qa_page_user_profile);

        $qa_page_myaccount = isset($_POST['qa_page_myaccount']) ?  sanitize_text_field($_POST['qa_page_myaccount']) : '';
        update_option('qa_page_myaccount', $qa_page_myaccount);

        $qa_account_required_post_question = isset($_POST['qa_account_required_post_question']) ?  sanitize_text_field($_POST['qa_account_required_post_question']) : '';
        update_option('qa_account_required_post_question', $qa_account_required_post_question);

        $qa_submitted_question_status = isset($_POST['qa_submitted_question_status']) ?  sanitize_text_field($_POST['qa_submitted_question_status']) : '';
        update_option('qa_submitted_question_status', $qa_submitted_question_status);

        $qa_allow_question_comment = isset($_POST['qa_allow_question_comment']) ?  sanitize_text_field($_POST['qa_allow_question_comment']) : '';
        update_option('qa_allow_question_comment', $qa_allow_question_comment);

        $qa_enable_poll = isset($_POST['qa_enable_poll']) ?  sanitize_text_field($_POST['qa_enable_poll']) : '';
        update_option('qa_enable_poll', $qa_enable_poll);

        $qa_myaccount_show_login_form = isset($_POST['qa_myaccount_show_login_form']) ?  sanitize_text_field($_POST['qa_myaccount_show_login_form']) : '';
        update_option('qa_myaccount_show_login_form', $qa_myaccount_show_login_form);

        $qa_myaccount_login_redirect_page = isset($_POST['qa_myaccount_login_redirect_page']) ?  sanitize_text_field($_POST['qa_myaccount_login_redirect_page']) : '';
        update_option('qa_myaccount_login_redirect_page', $qa_myaccount_login_redirect_page);

        $qa_myaccount_show_register_form = isset($_POST['qa_myaccount_show_register_form']) ?  sanitize_text_field($_POST['qa_myaccount_show_register_form']) : '';
        update_option('qa_myaccount_show_register_form', $qa_myaccount_show_register_form);

        $qa_color_archive_answer_count = isset($_POST['qa_color_archive_answer_count']) ?  sanitize_text_field($_POST['qa_color_archive_answer_count']) : '';
        update_option('qa_color_archive_answer_count', $qa_color_archive_answer_count);

        $qa_color_archive_view_count = isset($_POST['qa_color_archive_view_count']) ?  sanitize_text_field($_POST['qa_color_archive_view_count']) : '';
        update_option('qa_color_archive_view_count', $qa_color_archive_view_count);

        $qa_color_single_user_role = isset($_POST['qa_color_single_user_role']) ?  sanitize_text_field($_POST['qa_color_single_user_role']) : '';
        update_option('qa_color_single_user_role', $qa_color_single_user_role);

        $qa_color_single_user_role_background = isset($_POST['qa_color_single_user_role_background']) ?  sanitize_text_field($_POST['qa_color_single_user_role_background']) : '';
        update_option('qa_color_single_user_role_background', $qa_color_single_user_role_background);

        $qa_color_add_comment_background = isset($_POST['qa_color_add_comment_background']) ?  sanitize_text_field($_POST['qa_color_add_comment_background']) : '';
        update_option('qa_color_add_comment_background', $qa_color_add_comment_background);

        $qa_ask_button_bg_color = isset($_POST['qa_ask_button_bg_color']) ?  sanitize_text_field($_POST['qa_ask_button_bg_color']) : '';
        update_option('qa_ask_button_bg_color', $qa_ask_button_bg_color);

        $qa_color_best_answer_background = isset($_POST['qa_color_best_answer_background']) ?  sanitize_text_field($_POST['qa_color_best_answer_background']) : '';
        update_option('qa_color_best_answer_background', $qa_color_best_answer_background);

        $qa_ask_button_text_color = isset($_POST['qa_ask_button_text_color']) ?  sanitize_text_field($_POST['qa_ask_button_text_color']) : '';
        update_option('qa_ask_button_text_color', $qa_ask_button_text_color);

        $qa_vote_button_bg_color = isset($_POST['qa_vote_button_bg_color']) ?  sanitize_text_field($_POST['qa_vote_button_bg_color']) : '';
        update_option('qa_vote_button_bg_color', $qa_vote_button_bg_color);

        $qa_flag_button_bg_color = isset($_POST['qa_flag_button_bg_color']) ?  sanitize_text_field($_POST['qa_flag_button_bg_color']) : '';
        update_option('qa_flag_button_bg_color', $qa_flag_button_bg_color);


        $qa_logo_url = isset($_POST['qa_logo_url']) ?  sanitize_text_field($_POST['qa_logo_url']) : '';
        update_option('qa_logo_url', $qa_logo_url);

        $qa_from_email = isset($_POST['qa_from_email']) ?  sanitize_text_field($_POST['qa_from_email']) : '';
        update_option('qa_from_email', $qa_from_email);

        $qa_email_templates_data = isset($_POST['qa_email_templates_data']) ?  stripslashes_deep($_POST['qa_email_templates_data']) : '';
        update_option('qa_email_templates_data', $qa_email_templates_data);

        $question_answer_settings= isset($_POST['question_answer_settings']) ?  stripslashes_deep($_POST['question_answer_settings']) : '';
        update_option('question_answer_settings', $question_answer_settings);



    }
}
