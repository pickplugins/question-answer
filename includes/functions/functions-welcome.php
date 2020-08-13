<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 





add_action('qa_welcome_tabs_content_start', 'qa_welcome_tabs_content_start');

if(!function_exists('qa_welcome_tabs_content_start')) {
    function qa_welcome_tabs_content_start($tab){



        ?>

        <h2><?php echo __('Welcome to Question Answer Setup', 'question-answer'); ?></h2>
        <p><?php echo __('Thanks for choosing question answer for your site, Please go step by step and choose some options to get started.', 'question-answer'); ?></p>
        <p><?php echo __('If you have any issue during setup please contact us for help and you can post on our forum by creating support tickets.', 'question-answer'); ?></p>
        <p><a target="_blank" class="button" href="https://www.pickplugins.com/forum/"><?php echo __('Create Ticket', 'question-answer'); ?></a></p>

        <p><?php echo sprintf(__('We spend thousand hours to build this plugin for you, continuously updating, fixing bugs, add new features, creating add-ons, solving user issues and many more. we do live by creating plugin like question answer, we hope your wise feedback and reviews on plugin page. Give us %s','question-answer'),'<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>')?> </p>
        <p><a target="_blank" class="button" href="https://wordpress.org/support/plugin/question-answer/reviews/#new-post"><?php echo __('Write a reviews', 'question-answer'); ?></a></p>
    <?php


    }
}



add_action('qa_welcome_tabs_content_general', 'qa_welcome_tabs_content_general');

if(!function_exists('qa_welcome_tabs_content_general')) {
    function qa_welcome_tabs_content_general($tab){

        $settings_tabs_field = new settings_tabs_field();

        $qa_account_required_post_question = get_option('qa_account_required_post_question');
        $qa_submitted_question_status = get_option('qa_submitted_question_status');


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('General settings', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('Choose some general option.', 'question-answer'); ?></p>

            <?php

            $args = array(
                'id'		=> 'qa_account_required_post_question',
                //'parent'		=> '',
                'title'		=> __('Account required to question?','question-answer'),
                'details'	=> __('Account required to submit question.','question-answer'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $qa_account_required_post_question,
                'default'		=> 'yes',
                'args'		=> array( 'yes'=>__('Yes','question-answer'), 'no'=>__('No','question-answer'),),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_submitted_question_status',
                //'parent'		=> '',
                'title'		=> __('Submitted question status','question-answer'),
                'details'	=> __('Choose post status for newly submitted question.','question-answer'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $qa_submitted_question_status,
                'default'		=> 'yes',
                'args'		=> array( 'pending'=>__('Pending','question-answer'), 'publish'=>__('Publish','question-answer'),  'draft'=>__('Draft','question-answer'),  'private'=>__('Private','question-answer'), ),
            );

            $settings_tabs_field->generate_field($args);



            ?>


        </div>
        <?php


    }
}




add_action('qa_welcome_tabs_content_create_pages', 'qa_welcome_tabs_content_create_pages');

if(!function_exists('qa_welcome_tabs_content_create_pages')) {
    function qa_welcome_tabs_content_create_pages($tab){

        $settings_tabs_field = new settings_tabs_field();

        $qa_page_question_post = get_option('qa_page_question_post');
        $qa_page_question_archive = get_option('qa_page_question_archive');
        $qa_page_user_profile = get_option('qa_page_user_profile');
        $qa_page_myaccount = get_option('qa_page_myaccount');


        $page_list = qa_page_list_id();

        $page_list['create_new'] = __('-- Create new page --', 'question-answer');

        //$page_list = array_merge($page_list, array('create_new'=> '-- Create new page --'));


        //echo '<pre>'.var_export($page_list, true).'</pre>';


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Create pages', 'question-answer'); ?></div>
            <p class="description section-description"><?php echo __('You can create some basic pages or choose from existing. please choose <b>-- Create new page --</b> to create.', 'question-answer'); ?></p>

            <?php


            $args = array(
                'id'		=> 'qa_page_question_post',
                //'parent'		=> '',
                'title'		=> __('Question submission page','question-answer'),
                'details'	=> __('Select the page where you want display question submission form, where the shortcode <code>[qa_add_question]</code> used.','question-answer'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $qa_page_question_post,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_page_question_archive',
                //'parent'		=> '',
                'title'		=> __('Question archive page','question-answer'),
                'details'	=> __('Select the page where you want to display all question archive list, where the shortcode <code>[question_archive]</code> used.','question-answer'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $qa_page_question_archive,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'qa_page_user_profile',
                //'parent'		=> '',
                'title'		=> __('User profile page','question-answer'),
                'details'	=> __('Select the page where you want to display user profile, where the shortcode <code>[qa_user_profile]</code> used.','question-answer'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $qa_page_user_profile,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'qa_page_myaccount',
                //'parent'		=> '',
                'title'		=> __('Dashboard page','question-answer'),
                'details'	=> __('Select the page where you want to display dashboard, where the shortcode <code>[qa_dashboard]</code> used.','question-answer'),
                'type'		=> 'select',
                //'multiple'		=> true,
                'value'		=> $qa_page_myaccount,
                'default'		=> '',
                'args'		=> $page_list,
            );

            $settings_tabs_field->generate_field($args);






            ?>


        </div>
        <?php


    }
}






add_action('qa_welcome_tabs_content_done', 'qa_welcome_tabs_content_done');

if(!function_exists('qa_welcome_tabs_content_done')) {
    function qa_welcome_tabs_content_done($tab){

        $hidden = isset($_POST['qa_hidden']) ? $_POST['qa_hidden'] : '';

        //var_dump($hidden);

        ?>
        <div class="section">

            <h3 style="text-align: center" class=""><?php echo __('Click to save settings.', 'question-answer'); ?></h3>
            <p style="text-align: center"><?php echo __('You can review settings by clicking next and previous button', 'question-answer'); ?></p>
            <div class="submit-wrap">
                <?php wp_nonce_field( 'qa_nonce' ); ?>
                <input class="button" type="submit" name="submit" value="<?php _e('Save Settings','question-answer' ); ?>" />
            </div>


        </div>
        <?php


    }
}


add_action('qa_welcome_submit', 'qa_welcome_submit_after_html');

if(!function_exists('qa_welcome_submit_after_html')) {
    function qa_welcome_submit_after_html($form_data){

        $qa_page_question_post           = get_option('qa_page_question_post');
        $question_submit_page_url                 = get_permalink($qa_page_question_post);


        ?>
        <div class="welcome-tabs">
            <div class="tab-content active" style="text-align: center">
                <h3 ><?php echo sprintf(__('%s Great, All looks good.','question-answer' ), '<i class="far fa-thumbs-up"></i>') ; ?></h3>
                <p><?php echo __('You have successfully completed welcome setup <br>and you are almost ready to start your job site, go and visit created pages.','question-answer'); ?></p>
                <p>
                    <a class="button" target="_blank" href="<?php echo esc_url($question_submit_page_url); ?>"><?php echo __('Post a question','question-answer'); ?></a>
                    <a class="button" target="_blank" href="<?php echo esc_url(admin_url('edit.php?post_type=question&page=settings')); ?>"><?php echo __('Check settings','question-answer'); ?></a>
                    <a class="button" target="_blank" href="<?php echo esc_url(admin_url()); ?>"><?php echo __('Go dashboard','question-answer'); ?></a>

                </p>

                <h5><?php echo __('Write a reviews','question-answer'); ?></h5>
                <p><?php echo sprintf(__('We spend most of our work hours to build WordPress plugin, <br>we expect your few minutes to provide your wise feedback and suggestions. and give us %s','question-answer'),'<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>'); ?></p>
                <p><a class="button" href="https://wordpress.org/support/plugin/question-answer/reviews/#new-post"><?php echo __('Write a reviews','question-answer'); ?> </a></p>




            </div>
        </div>
        <?php


    }
}


add_action('qa_welcome_submit', 'qa_welcome_submit');

if(!function_exists('qa_welcome_submit')) {
    function qa_welcome_submit($form_data){

        $qa_page_question_post = get_option('qa_page_question_post');
        $qa_page_question_archive = get_option('qa_page_question_archive');
        $qa_page_user_profile = get_option('qa_page_user_profile');
        $qa_page_myaccount = get_option('qa_page_myaccount');


        $qa_account_required_post_question = isset($form_data['qa_account_required_post_question']) ? $form_data['qa_account_required_post_question'] : '';
        update_option('qa_account_required_post_question', $qa_account_required_post_question);

        $qa_submitted_question_status = isset($form_data['qa_submitted_question_status']) ? $form_data['qa_submitted_question_status'] : '';
        update_option('qa_submitted_question_status', $qa_submitted_question_status);

        $qa_page_question_post = isset($form_data['qa_page_question_post']) ? $form_data['qa_page_question_post'] : '';
        $qa_page_question_archive = isset($form_data['qa_page_question_archive']) ? $form_data['qa_page_question_archive'] : '';
        $qa_page_user_profile = isset($form_data['qa_page_user_profile']) ? $form_data['qa_page_user_profile'] : '';
        $qa_page_myaccount = isset($form_data['qa_page_myaccount']) ? $form_data['qa_page_myaccount'] : '';


        if($qa_page_question_post =='create_new'){

            $page_id = wp_insert_post(
                array(
                    'post_title'    => __('Question archive','question-answer'),
                    'post_content'  => '[question_archive]',
                    'post_status'   => 'publish',
                    'post_type'   	=> 'page',

                )
            );

            update_option('qa_page_question_archive', $page_id);

        }else{
            update_option('qa_page_question_archive', $qa_page_question_archive);

        }


        if($qa_page_question_post =='create_new'){

            $page_id = wp_insert_post(
                array(
                    'post_title'    => __('Question Submit','question-answer'),
                    'post_content'  => '[qa_add_question]',
                    'post_status'   => 'publish',
                    'post_type'   	=> 'page',

                )
            );

            update_option('qa_page_question_post', $page_id);

        }else{
            update_option('qa_page_question_post', $qa_page_question_post);

        }



        if($qa_page_user_profile =='create_new'){

            $page_id = wp_insert_post(
                array(
                    'post_title'    => __('User profile','question-answer'),
                    'post_content'  => '[qa_user_profile]',
                    'post_status'   => 'publish',
                    'post_type'   	=> 'page',

                )
            );

            update_option('qa_page_user_profile', $page_id);

        }else{
            update_option('qa_page_user_profile', $qa_page_user_profile);

        }



        if($qa_page_myaccount =='create_new'){

            $page_id = wp_insert_post(
                array(
                    'post_title'    => __('QA Dashboard','question-answer'),
                    'post_content'  => '[qa_dashboard]',
                    'post_status'   => 'publish',
                    'post_type'   	=> 'page',

                )
            );

            update_option('qa_page_myaccount', $page_id);

        }else{
            update_option('qa_page_myaccount', $qa_page_myaccount);

        }




        update_option('qa_welcome', 'done');




    }
}




