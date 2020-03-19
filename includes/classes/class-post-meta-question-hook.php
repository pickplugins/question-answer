<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('qa_question_metabox_content_general','qa_question_metabox_content_general');
function qa_question_metabox_content_general($post_id){


    $settings_tabs_field = new settings_tabs_field();

    $qa_question_options = get_post_meta($post_id,'qa_question_options', true);

    $_status = isset($qa_question_options['_status']) ? $qa_question_options['_status'] : '';
    $_featured = isset($qa_question_options['_featured']) ? $qa_question_options['_featured'] : '';

    $class_qa_functions = new class_qa_functions();
    $question_status = $class_qa_functions->qa_question_status();


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Admin actions', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some admin actions.', 'team'); ?></p>


        <?php






        $args = array(
            'id'		=> '_featured',
            'parent'		=> 'qa_question_options',
            'title'		=> __('Featured question?','team'),
            'details'	=> __('Choose is question featured or not','team'),
            'type'		=> 'select',
            'value'		=> $_featured,
            'default'		=> '',
            'args'		=> array('no'=>'No', 'yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}




add_action('qa_question_metabox_content_admin_action','qa_question_metabox_content_admin_action');
function qa_question_metabox_content_admin_action($post_id){


    $settings_tabs_field = new settings_tabs_field();

    $qa_question_options = get_post_meta($post_id,'qa_question_options', true);

    $_status = isset($qa_question_options['_status']) ? $qa_question_options['_status'] : '';
    $_featured = isset($qa_question_options['_featured']) ? $qa_question_options['_featured'] : '';

    $class_qa_functions = new class_qa_functions();
    $question_status = $class_qa_functions->qa_question_status();


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Admin actions', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some admin actions.', 'team'); ?></p>


        <?php



        $args = array(
            'id'		=> '_status',
            'parent'		=> 'qa_question_options',
            'title'		=> __('Question status','team'),
            'details'	=> __('Choose question status','team'),
            'type'		=> 'select',
            'value'		=> $_status,
            'default'		=> '',
            'args'		=> $question_status,
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'mark_as_close',
            'parent'		=> 'qa_question_options',
            'title'		=> __('Marked as close','team'),
            'details'	=> __('Choose mark as closed, user will not able to answer or comments','team'),
            'type'		=> 'select',
            'value'		=> $_featured,
            'default'		=> '',
            'args'		=> array('no'=>'No', 'yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);




        ob_start();
        ?>


        <div class="assign-to-list">
            <div class="item" title="Nur hasan">
                <img width="50" src="http://2.gravatar.com/avatar/b6e75caf7388bb6978612a75487bdc1e?s=60&d=mm&r=g">
                <span>Nur hasan</span>
                <input type="hidden" name="qa_question_options[assign_to][]">
            </div>
            <div class="item" title="">
                <img width="50" src="http://2.gravatar.com/avatar/b6e75caf7388bb6978612a75487bdc1e?s=60&d=mm&r=g">
                <span>Nirjhar</span>
            </div>


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
            'id'		=> '_featured',
            'parent'		=> 'qa_question_options',
            'title'		=> __('Featured question?','team'),
            'details'	=> __('Choose is question featured or not','team'),
            'type'		=> 'select',
            'value'		=> $_featured,
            'default'		=> '',
            'args'		=> array('no'=>'No', 'yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}






add_action('team_meta_box_save_team','team_meta_box_save_team');

function team_meta_box_save_team($job_id){

    $qa_question_options = isset($_POST['qa_question_options']) ? stripslashes_deep($_POST['qa_question_options']) : '';
    update_post_meta($job_id, 'qa_question_options', $qa_question_options);

}

