<?php
if ( ! defined('ABSPATH')) exit;  // if direct access






add_action('qa_question_metabox_content_general','qa_question_metabox_content_general');
function qa_question_metabox_content_general($post_id){


    $settings_tabs_field = new settings_tabs_field();

    $qa_question_status = get_post_meta($post_id,'qa_question_status', true);
    $qa_featured_questions = get_post_meta($post_id,'qa_featured_questions', true);
    $mark_as_close = get_post_meta($post_id,'mark_as_close', true);
    $qa_assign_to = get_post_meta($post_id,'qa_assign_to', true);
    $qa_assign_to = !empty($qa_assign_to) ? $qa_assign_to : array();



    $class_qa_functions = new class_qa_functions();
    $question_status = $class_qa_functions->qa_question_status();

    //var_dump($qa_question_options);

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Admin actions', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some admin actions.', 'team'); ?></p>


        <?php



        $args = array(
            'id'		=> 'qa_question_status',
            //'parent'		=> 'qa_question_options',
            'title'		=> __('Question status','team'),
            'details'	=> __('Choose question status','team'),
            'type'		=> 'select',
            'value'		=> $qa_question_status,
            'default'		=> '',
            'args'		=> $question_status,
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'mark_as_close',
            //'parent'		=> 'qa_question_options',
            'title'		=> __('Marked as close','team'),
            'details'	=> __('Choose mark as closed, user will not able to answer or comments','team'),
            'type'		=> 'select',
            'value'		=> $mark_as_close,
            'default'		=> '',
            'args'		=> array('no'=>'No', 'yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);


//var_dump($assign_to);

        ob_start();
        ?>


        <div class="assign-to-list">
            <?php

            foreach ($qa_assign_to as $userId){
                $user = get_user_by('id', $userId);
                $avatar_url = get_avatar_url($userId);
                ?>
                <div class="item" title="<?php echo $user->display_name; ?>">
                    <span class="remove" onclick="jQuery(this).parent().remove();"><i class="fas fa-times"></i></span>
                    <img width="50" src="<?php echo $avatar_url; ?>">
                    <span><?php echo $user->display_name; ?></span>
                    <input type="hidden" name="qa_assign_to[]" value="<?php echo $userId; ?>">
                </div>
                <?php

            }

            ?>



        </div>
        <form class="assign-to-form">
            <input class="assign-to-keyword" type="search" value="" placeholder="Search user...">
        </form>
        <p>Search suggestion:</p>
        <div class="assign-to-suggestion">

        </div>

        <style type="text/css">
            .assign-to-list{}
            .assign-to-list .item{
                display: block;
                /* width: 50px; */
                overflow: hidden;
                vertical-align: top;
                margin: 5px;
                position: relative;
            }
            .assign-to-list .item .remove{
                background: #fb4c4c;
                padding: 4px 7px;
                color: #fff;
                cursor: pointer;
            }

            .assign-to-list img{
                height: auto;
                vertical-align: middle;
                margin: 5px 0;
                width: 35px;
            }

            .assign-to-suggestion .item{
                cursor: pointer;
            }
            .assign-to-suggestion img{
                height: auto;
                vertical-align: middle;
                margin: 5px 0;
                width: 35px;
            }

        </style>

        <?php

        $html = ob_get_clean();

        $args = array(
            'id'		=> 'assign_to',
            'details'	=> __('Assign users to give answer.','team'),
            'title'		=> __('Assign to','accordions'),

            'type'		=> 'custom_html',
            'html'		=> $html,

        );

        $settings_tabs_field->generate_field($args);




        $args = array(
            'id'		=> 'qa_featured_questions',
            //'parent'		=> 'qa_question_options',
            'title'		=> __('Featured question?','team'),
            'details'	=> __('Choose is question featured or not','team'),
            'type'		=> 'select',
            'value'		=> $qa_featured_questions,
            'default'		=> '',
            'args'		=> array('no'=>'No', 'yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}






add_action('qa_post_meta_save_question','qa_post_meta_save_question');

function qa_post_meta_save_question($job_id){


    $qa_question_status = isset($_POST['qa_question_status']) ? sanitize_text_field($_POST['qa_question_status']) : '';
    update_post_meta($job_id, 'qa_question_status', $qa_question_status);

    $qa_featured_questions = isset($_POST['qa_featured_questions']) ? sanitize_text_field($_POST['qa_featured_questions']) : '';
    update_post_meta($job_id, 'qa_featured_questions', $qa_featured_questions);

    $mark_as_close = isset($_POST['mark_as_close']) ? sanitize_text_field($_POST['mark_as_close']) : '';
    update_post_meta($job_id, 'mark_as_close', $mark_as_close);

    $qa_assign_to = isset($_POST['qa_assign_to']) ? stripslashes_deep($_POST['qa_assign_to']) : '';
    update_post_meta($job_id, 'qa_assign_to', $qa_assign_to);

}

