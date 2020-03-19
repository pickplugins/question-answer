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





        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Dashboard settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose option for dashboard page.', 'question-answer'); ?></p>

            <?php



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
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_color_archive_view_count',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Question view count color','question-answer'),
                'details'	=> __('View count text color','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_archive_view_count,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'qa_color_single_user_role',
                //'parent'		=> 'qa_settings',
                'title'		=> __('User role text color','question-answer'),
                'details'	=> __('User role text color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_single_user_role,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_color_single_user_role_background',
                //'parent'		=> 'qa_settings',
                'title'		=> __('User role background color','question-answer'),
                'details'	=> __('User role background color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_single_user_role_background,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_color_add_comment_background',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Comment button background color','question-answer'),
                'details'	=> __('Comment button background color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_add_comment_background,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_ask_button_bg_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Best answer background color','question-answer'),
                'details'	=> __('Best answer background color in single question page.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_ask_button_bg_color,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_color_best_answer_background',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Ask button background color','question-answer'),
                'details'	=> __('Select background color for ask button on top.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_color_best_answer_background,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_ask_button_text_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Ask button text color','question-answer'),
                'details'	=> __('Select text color for ask button on top.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_ask_button_text_color,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_vote_button_bg_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Vote button background color','question-answer'),
                'details'	=> __('Select Vote button background color.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_vote_button_bg_color,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_flag_button_bg_color',
                //'parent'		=> 'qa_settings',
                'title'		=> __('Flag button background color','question-answer'),
                'details'	=> __('Select Flag button background color.','question-answer'),
                'type'		=> 'colorpicker',
                'value'		=> $qa_flag_button_bg_color,
                'default'		=> '#999',
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



