<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


// Email notifications

add_action('qa_action_answer_comment', 'qa_action_answer_comment_send_email', 10);

function qa_action_answer_comment_send_email($comment_ID){

    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $site_url = get_bloginfo('url');
    $qa_logo_url = get_option('qa_logo_url');
    $qa_logo_url = wp_get_attachment_url($qa_logo_url);
    $qa_from_email = get_option('qa_from_email', $admin_email);

    $comment_data = get_comment($comment_ID);
    $comment_content = $comment_data->comment_content;
    $answer_ID = $comment_data->comment_post_ID;
    $answer_data = get_post( $answer_ID );


    if( $answer_data->post_type == 'answer' ):

        $qa_answer_question_id = get_post_meta( $answer_ID, 'qa_answer_question_id', true );

        $question_url = get_permalink($qa_answer_question_id);
        $answer_url = get_permalink($qa_answer_question_id);


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['answer_comment']['enable']) ? $qa_email_templates_data['answer_comment']['enable'] : 'no';

        if($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['answer_comment']['email_to']) ? $qa_email_templates_data['answer_comment']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['answer_comment']['email_from_name']) ? $qa_email_templates_data['answer_comment']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['answer_comment']['email_from']) ? $qa_email_templates_data['answer_comment']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['answer_comment']['subject']) ? $qa_email_templates_data['answer_comment']['subject'] : '';
            $email_html = isset($qa_email_templates_data['answer_comment']['html']) ? $qa_email_templates_data['answer_comment']['html'] : '';

            $vars = array(
                '{site_name}'=> get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar( $current_user->ID, 60 ),
                '{user_email}' => '',

                '{question_url}'  => $question_url,

                '{answer_title}'  => $answer_data->post_title,
                '{answer_url}'  => $answer_url,
                '{answer_edit_url}'  => get_admin_url().'post.php?post='.$answer_ID.'&action=edit',
                '{answer_id}'  => $answer_ID,
                '{answer_content}'  => $answer_data->post_content,

                '{comment_content}'  => $comment_content,
                '{comment_url}'  => $question_url.'#comment-'.$comment_ID,
            );

            $a_subscriber = get_post_meta($answer_ID, 'a_subscriber', true);
            if(is_array($a_subscriber))
                foreach($a_subscriber as $subscriber){
                    $subscriber_data = get_user_by('id', $subscriber);

                    $email_data['email_to'] =  $subscriber_data->user_email;
                    $email_data['email_bcc'] =  $email_to;
                    $email_data['email_from'] = $email_from ;
                    $email_data['email_from_name'] = $email_from_name;
                    $email_data['subject'] = strtr($email_subject, $vars);
                    $email_data['html'] = strtr($email_html, $vars);
                    $email_data['attachments'] = array();

                    $status = $class_qa_emails->qa_send_email($email_data);
                }
        endif;
    endif;


}


add_action( 'qa_action_comment_flag', 'qa_email_action_comment_flag_function', 10 );

if ( ! function_exists( 'qa_email_action_comment_flag_function' ) ) {
    function qa_email_action_comment_flag_function( $comment_ID ){

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $comment = get_comment( $comment_ID );
        $comment_content = $comment->comment_content;
        $question_ID = $comment->comment_post_ID ;
        $question_data = get_post( $question_ID );

        $question_url = get_permalink($question_ID);


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['comment_flag']['enable']) ? $qa_email_templates_data['comment_flag']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['comment_flag']['email_to']) ? $qa_email_templates_data['comment_flag']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['comment_flag']['email_from_name']) ? $qa_email_templates_data['comment_flag']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['comment_flag']['email_from']) ? $qa_email_templates_data['comment_flag']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['comment_flag']['subject']) ? $qa_email_templates_data['comment_flag']['subject'] : '';
            $email_html = isset($qa_email_templates_data['comment_flag']['html']) ? $qa_email_templates_data['comment_flag']['html'] : '';

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_title}'  => $question_data->post_title,
                '{question_url}'  => $question_url,
                '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',
                '{question_id}'  => $question_ID,
                '{question_content}'  => $question_data->post_content,

                '{comment_content}' => $comment_content,
                '{comment_url}' => $question_url . '#comment-' . $comment_ID,
            );



            $email_data['email_to'] =$comment->comment_author_email;
            $email_data['email_bcc'] = $email_to;
            $email_data['email_from'] = $email_from;
            $email_data['email_from_name'] = $email_from_name;
            $email_data['subject'] = strtr($email_subject, $vars);
            $email_data['html'] = strtr($email_html, $vars);
            $email_data['attachments'] = array();

            $status = $class_qa_emails->qa_send_email($email_data);

        endif;


    }
}

add_action( 'qa_action_comment_unflag', 'qa_email_action_comment_unflag_function', 10 );

if ( ! function_exists( 'qa_email_action_comment_unflag_function' ) ) {
    function qa_email_action_comment_unflag_function( $comment_ID ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $comment = get_comment( $comment_ID );
        $comment_content = $comment->comment_content;
        $question_ID = $comment->comment_post_ID ;
        $question_data = get_post( $question_ID );

        $question_url = get_permalink($question_ID);


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['comment_unflag']['enable']) ? $qa_email_templates_data['comment_unflag']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['comment_unflag']['email_to']) ? $qa_email_templates_data['comment_unflag']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['comment_unflag']['email_from_name']) ? $qa_email_templates_data['comment_unflag']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['comment_unflag']['email_from']) ? $qa_email_templates_data['comment_unflag']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['comment_unflag']['subject']) ? $qa_email_templates_data['comment_unflag']['subject'] : '';
            $email_html = isset($qa_email_templates_data['comment_unflag']['html']) ? $qa_email_templates_data['comment_unflag']['html'] : '';

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_title}'  => $question_data->post_title,
                '{question_url}'  => $question_url,
                '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',
                '{question_id}'  => $question_ID,
                '{question_content}'  => $question_data->post_content,

                '{comment_content}' => $comment_content,
                '{comment_url}' => $question_url . '#comment-' . $comment_ID,
            );



            $email_data['email_to'] =$comment->comment_author_email;
            $email_data['email_bcc'] = $email_to;
            $email_data['email_from'] = $email_from;
            $email_data['email_from_name'] = $email_from_name;
            $email_data['subject'] = strtr($email_subject, $vars);
            $email_data['html'] = strtr($email_html, $vars);
            $email_data['attachments'] = array();

            $status = $class_qa_emails->qa_send_email($email_data);

        endif;


    }
}


add_action('publish_question', 'qa_email_action_question_published_function', 10 );

if ( ! function_exists( 'qa_email_action_question_published_function' ) ) {
    function qa_email_action_question_published_function( $question_ID ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $question_data = get_post( $question_ID );

        $qa_answer_question_id = get_post_meta( $question_ID, 'qa_answer_question_id', true );
        $question_title = get_the_title($qa_answer_question_id);
        $answer_url = get_permalink($qa_answer_question_id);
        $answer_data = get_post( $question_ID );


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['new_question_published']['enable']) ? $qa_email_templates_data['new_question_published']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['new_question_published']['email_to']) ? $qa_email_templates_data['new_question_published']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['new_question_published']['email_from_name']) ? $qa_email_templates_data['new_question_published']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['new_question_published']['email_from']) ? $qa_email_templates_data['new_question_published']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['new_question_published']['subject']) ? $qa_email_templates_data['new_question_published']['subject'] : '';
            $email_html = isset($qa_email_templates_data['new_question_published']['html']) ? $qa_email_templates_data['new_question_published']['html'] : '';

            $user_name = !empty($current_user->display_name) ? $current_user->display_name : __('Anonymous','question-answer');


            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $user_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_title}'  => $question_data->post_title,
                '{question_url}'  => get_permalink($question_ID),
                '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',
                '{question_id}'  => $question_ID,
                '{question_content}'  => $question_data->post_content,
            );


            $email_data['email_to'] = $admin_email;
            $email_data['email_bcc'] = $email_to;
            $email_data['email_from'] = $email_from;
            $email_data['email_from_name'] = $email_from_name;
            $email_data['subject'] = strtr($email_subject, $vars);
            $email_data['html'] = strtr($email_html, $vars);
            $email_data['attachments'] = array();

            $status = $class_qa_emails->qa_send_email($email_data);

        endif;

    }
}



add_action( 'qa_question_submitted', 'qa_question_submitted_send_email', 10, 2 );

if ( ! function_exists( 'qa_question_submitted_send_email' ) ) {
    function qa_question_submitted_send_email( $question_ID, $post_data ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $question_data = get_post( $question_ID );


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['new_question_submitted']['enable']) ? $qa_email_templates_data['new_question_submitted']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['new_question_submitted']['email_to']) ? $qa_email_templates_data['new_question_submitted']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['new_question_submitted']['email_from_name']) ? $qa_email_templates_data['new_question_submitted']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['new_question_submitted']['email_from']) ? $qa_email_templates_data['new_question_submitted']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['new_question_submitted']['subject']) ? $qa_email_templates_data['new_question_submitted']['subject'] : '';
            $email_html = isset($qa_email_templates_data['new_question_submitted']['html']) ? $qa_email_templates_data['new_question_submitted']['html'] : '';

            $user_name = !empty($current_user->display_name) ? $current_user->display_name : __('Anonymous','question-answer');

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $user_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_title}'  => $question_data->post_title,
                '{question_url}'  => get_permalink($question_ID),
                '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',
                '{question_id}'  => $question_ID,
                '{question_content}'  => $question_data->post_content,
            );


            $email_data['email_to'] = $admin_email;
            $email_data['email_bcc'] = $email_to;
            $email_data['email_from'] = $email_from;
            $email_data['email_from_name'] = $email_from_name;
            $email_data['subject'] = strtr($email_subject, $vars);
            $email_data['html'] = strtr($email_html, $vars);
            $email_data['attachments'] = array();

            //var_dump($email_from);

            $status = $class_qa_emails->qa_send_email($email_data);
            //var_dump($status);
        endif;


    }
}


add_action( 'qa_action_question_solved', 'qa_email_action_question_solved_function', 10 );

if ( ! function_exists( 'qa_email_action_question_solved_function' ) ) {
    function qa_email_action_question_solved_function($question_ID) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $question_data = get_post( $question_ID );

        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['question_solved']['enable']) ? $qa_email_templates_data['question_solved']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['question_solved']['email_to']) ? $qa_email_templates_data['question_solved']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['question_solved']['email_from_name']) ? $qa_email_templates_data['question_solved']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['question_solved']['email_from']) ? $qa_email_templates_data['question_solved']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['question_solved']['subject']) ? $qa_email_templates_data['question_solved']['subject'] : '';
            $email_html = isset($qa_email_templates_data['question_solved']['html']) ? $qa_email_templates_data['question_solved']['html'] : '';

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_title}'  => $question_data->post_title,
                '{question_url}'  => get_permalink($question_ID),
                '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',
                '{question_id}'  => $question_ID,
                '{question_content}'  => $question_data->post_content,
            );


            $q_subscriber = get_post_meta($question_ID, 'q_subscriber', true);

            if(is_array($q_subscriber))
                foreach($q_subscriber as $subscriber){
                    $subscriber_data = get_user_by('id', $subscriber);

                    $email_data['email_to'] = $subscriber_data->user_email;
                    $email_data['email_bcc'] = $email_to;
                    $email_data['email_from'] = $email_from;
                    $email_data['email_from_name'] = $email_from_name;
                    $email_data['subject'] = strtr($email_subject, $vars);
                    $email_data['html'] = strtr($email_html, $vars);
                    $email_data['attachments'] = array();

                    $status = $class_qa_emails->qa_send_email($email_data);
                }




        endif;

    }
}


add_action( 'qa_action_question_not_solved', 'qa_email_action_question_unsolved_function', 10 );

if ( ! function_exists( 'qa_email_action_question_unsolved_function' ) ) {
    function qa_email_action_question_unsolved_function( $question_ID ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $question_data = get_post( $question_ID );

        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['question_unsolved']['enable']) ? $qa_email_templates_data['question_unsolved']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['question_unsolved']['email_to']) ? $qa_email_templates_data['question_unsolved']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['question_unsolved']['email_from_name']) ? $qa_email_templates_data['question_unsolved']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['question_unsolved']['email_from']) ? $qa_email_templates_data['question_unsolved']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['question_unsolved']['subject']) ? $qa_email_templates_data['question_unsolved']['subject'] : '';
            $email_html = isset($qa_email_templates_data['question_unsolved']['html']) ? $qa_email_templates_data['question_unsolved']['html'] : '';

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_title}'  => $question_data->post_title,
                '{question_url}'  => get_permalink($question_ID),
                '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',
                '{question_id}'  => $question_ID,
                '{question_content}'  => $question_data->post_content,
            );


            $q_subscriber = get_post_meta($question_ID, 'q_subscriber', true);

            if(is_array($q_subscriber))
                foreach($q_subscriber as $subscriber){
                    $subscriber_data = get_user_by('id', $subscriber);

                    $email_data['email_to'] = $subscriber_data->user_email;
                    $email_data['email_bcc'] = $email_to;
                    $email_data['email_from'] = $email_from;
                    $email_data['email_from_name'] = $email_from_name;
                    $email_data['subject'] = strtr($email_subject, $vars);
                    $email_data['html'] = strtr($email_html, $vars);
                    $email_data['attachments'] = array();

                    $status = $class_qa_emails->qa_send_email($email_data);
                }

        endif;

    }
}




add_action('publish_answer', 'qa_email_action_answer_published_function', 10 );

if ( ! function_exists( 'qa_email_action_answer_published_function' ) ) {
    function qa_email_action_answer_published_function( $answer_ID ){

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $qa_answer_question_id = get_post_meta( $answer_ID, 'qa_answer_question_id', true );
        $question_title = get_the_title($qa_answer_question_id);
        $answer_url = get_permalink($qa_answer_question_id);
        $answer_data = get_post( $answer_ID );


        $qa_answer_question_id = get_post_meta($answer_ID, 'qa_answer_question_id', true);

        $question_url = get_permalink($qa_answer_question_id);
        $answer_url = get_permalink($qa_answer_question_id);


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['new_answer_published']['enable']) ? $qa_email_templates_data['new_answer_published']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['new_answer_published']['email_to']) ? $qa_email_templates_data['new_answer_published']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['new_answer_published']['email_from_name']) ? $qa_email_templates_data['new_answer_published']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['new_answer_published']['email_from']) ? $qa_email_templates_data['new_answer_published']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['new_answer_published']['subject']) ? $qa_email_templates_data['new_answer_published']['subject'] : '';
            $email_html = isset($qa_email_templates_data['new_answer_published']['html']) ? $qa_email_templates_data['new_answer_published']['html'] : '';

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_url}' => $question_url,
                '{question_title}'  => $question_title,

                '{answer_title}'  => $answer_data->post_title,
                '{answer_url}'  => $answer_url.'#single-answer-'.$answer_ID,
                '{answer_edit_url}'  => get_admin_url().'post.php?post='.$answer_ID.'&action=edit',
                '{answer_id}'  => $answer_ID,
                '{answer_content}'  => $answer_data->post_content,
            );

            $a_subscriber = get_post_meta($answer_ID, 'a_subscriber', true);

            if (is_array($a_subscriber))
                foreach ($a_subscriber as $subscriber) {
                    $subscriber_data = get_user_by('id', $subscriber);

                    $email_data['email_to'] = $subscriber_data->user_email;
                    $email_data['email_bcc'] = $email_to;
                    $email_data['email_from'] = $email_from;
                    $email_data['email_from_name'] = $email_from_name;
                    $email_data['subject'] = strtr($email_subject, $vars);
                    $email_data['html'] = strtr($email_html, $vars);
                    $email_data['attachments'] = array();

                    $status = $class_qa_emails->qa_send_email($email_data);
                }
        endif;


    }
}




add_action('qa_answer_submitted', 'qa_answer_submitted_email', 10, 2 );

if ( ! function_exists( 'qa_answer_submitted_email' ) ) {
    function qa_answer_submitted_email( $answer_ID, $form_data_arr ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $qa_answer_question_id = get_post_meta( $answer_ID, 'qa_answer_question_id', true );
        $question_title = get_the_title($qa_answer_question_id);
        $answer_url = get_permalink($qa_answer_question_id);
        $answer_data = get_post( $answer_ID );



        $qa_answer_question_id = get_post_meta($answer_ID, 'qa_answer_question_id', true);

        $question_url = get_permalink($qa_answer_question_id);
        $answer_url = get_permalink($qa_answer_question_id);


        global $current_user;

        $email_data = array();
        $class_qa_emails = new class_qa_emails();
        $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
        $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

        $enable = isset($qa_email_templates_data['new_answer_submitted']['enable']) ? $qa_email_templates_data['new_answer_submitted']['enable'] : 'no';

        if ($enable == 'yes'):

            $email_to = isset($qa_email_templates_data['new_answer_submitted']['email_to']) ? $qa_email_templates_data['new_answer_submitted']['email_to'] : '';
            $email_from_name = isset($qa_email_templates_data['new_answer_submitted']['email_from_name']) ? $qa_email_templates_data['new_answer_submitted']['email_from_name'] : $site_name;
            $email_from = isset($qa_email_templates_data['new_answer_submitted']['email_from']) ? $qa_email_templates_data['new_answer_submitted']['email_from'] : $qa_from_email;
            $email_subject = isset($qa_email_templates_data['new_answer_submitted']['subject']) ? $qa_email_templates_data['new_answer_submitted']['subject'] : '';
            $email_html = isset($qa_email_templates_data['new_answer_submitted']['html']) ? $qa_email_templates_data['new_answer_submitted']['html'] : '';

            $vars = array(
                '{site_name}' => get_bloginfo('name'),
                '{site_description}' => get_bloginfo('description'),
                '{site_url}' => get_bloginfo('url'),
                '{site_logo_url}' => get_option('question_bm_logo_url'),

                '{user_name}' => $current_user->display_name,
                '{user_avatar}' => get_avatar($current_user->ID, 60),
                '{user_email}' => '',

                '{question_url}' => $question_url,
                '{question_title}'  => $question_title,

                '{answer_title}'  => $answer_data->post_title,
                '{answer_url}'  => $answer_url.'#single-answer-'.$answer_ID,
                '{answer_edit_url}'  => get_admin_url().'post.php?post='.$answer_ID.'&action=edit',
                '{answer_id}'  => $answer_ID,
                '{answer_content}'  => $answer_data->post_content,
            );

            $a_subscriber = get_post_meta($answer_ID, 'a_subscriber', true);

            if (is_array($a_subscriber))
                foreach ($a_subscriber as $subscriber) {
                    $subscriber_data = get_user_by('id', $subscriber);

                    $email_data['email_to'] = $subscriber_data->user_email;
                    $email_data['email_bcc'] = $email_to;
                    $email_data['email_from'] = $email_from;
                    $email_data['email_from_name'] = $email_from_name;
                    $email_data['subject'] = strtr($email_subject, $vars);
                    $email_data['html'] = strtr($email_html, $vars);
                    $email_data['attachments'] = array();

                    $status = $class_qa_emails->qa_send_email($email_data);
                }
        endif;

    }
}






add_action( 'qa_action_answer_vote_down', 'qa_email_action_answer_votedown_function', 10 );

if ( ! function_exists( 'qa_email_action_answer_votedown_function' ) ) {
    function qa_email_action_answer_votedown_function( $post_id ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $post_data = get_post( $post_id );
        $post_type = isset($post_data->post_type) ? $post_data->post_type : '';

        //error_log("post_type: ".$post_type);
        global $current_user;


        if ($post_type == 'answer'):

            $question_id = get_post_meta( $post_id, 'qa_answer_question_id', true );

            $question_data 	= get_post( $question_id );
            $question_title = get_the_title($question_id);
            $question_url = get_permalink($question_id);

            $answer_data 	= get_post( $post_id );
            $answer_url = get_permalink($post_id);
            $answer_url = get_permalink($post_id);


            error_log("answer_id: ".$post_id);


            $email_data = array();
            $class_qa_emails = new class_qa_emails();
            $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
            $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

            $enable = isset($qa_email_templates_data['answer_votedown']['enable']) ? $qa_email_templates_data['answer_votedown']['enable'] : 'no';

            if ($enable == 'yes'):

                $email_to = isset($qa_email_templates_data['answer_votedown']['email_to']) ? $qa_email_templates_data['answer_votedown']['email_to'] : '';
                $email_from_name = isset($qa_email_templates_data['answer_votedown']['email_from_name']) ? $qa_email_templates_data['answer_votedown']['email_from_name'] : $site_name;
                $email_from = isset($qa_email_templates_data['answer_votedown']['email_from']) ? $qa_email_templates_data['answer_votedown']['email_from'] : $qa_from_email;
                $email_subject = isset($qa_email_templates_data['answer_votedown']['subject']) ? $qa_email_templates_data['answer_votedown']['subject'] : '';
                $email_html = isset($qa_email_templates_data['answer_votedown']['html']) ? $qa_email_templates_data['answer_votedown']['html'] : '';

                $vars = array(
                    '{site_name}' => get_bloginfo('name'),
                    '{site_description}' => get_bloginfo('description'),
                    '{site_url}' => get_bloginfo('url'),
                    '{site_logo_url}' => get_option('question_bm_logo_url'),

                    '{user_name}' => $current_user->display_name,
                    '{user_avatar}' => get_avatar($current_user->ID, 60),
                    '{user_email}' => '',

                    '{question_title}'  => $question_data->post_title,
                    '{question_url}'  => $question_url,
                    '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_id.'&action=edit',
                    '{question_id}'  => $question_id,
                    '{question_content}'  => $question_data->post_content,

                    '{answer_title}'  => $answer_data->post_title,
                    '{answer_url}'  => $answer_url.'#single-answer-'.$post_id,
                    '{answer_edit_url}'  => get_admin_url().'post.php?post='.$post_id.'&action=edit',
                    '{answer_id}'  => $post_id,
                    '{answer_content}'  => $answer_data->post_content,
                );

                $answer_author = $answer_data->post_author;
                $answer_author_data = get_user_by('ID', $answer_author);
                $answer_author_email = $answer_author_data->user_email;
                //error_log("answer_author_email: ".$answer_author_email);

                $email_data['email_to'] = $answer_author_email;
                $email_data['email_bcc'] = $email_to;
                $email_data['email_from'] = $email_from;
                $email_data['email_from_name'] = $email_from_name;
                $email_data['subject'] = strtr($email_subject, $vars);
                $email_data['html'] = strtr($email_html, $vars);
                $email_data['attachments'] = array();

                $status = $class_qa_emails->qa_send_email($email_data);
                //error_log("status: ".$status);

            endif;
        elseif ($post_type == 'question'):

                $question_id = $post_id;

                //error_log("question_id: ".$question_id);


                $question_data 	= get_post( $question_id );
                $question_title = get_the_title($question_id);
                $question_url = get_permalink($question_id);
                $question_author = $question_data->post_author;

                $email_data = array();
                $class_qa_emails = new class_qa_emails();
                $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
                $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

                $enable = isset($qa_email_templates_data['question_votedown']['enable']) ? $qa_email_templates_data['question_votedown']['enable'] : 'no';

                error_log("enable: ".$enable);

                if ($enable == 'yes'):

                    $email_to = isset($qa_email_templates_data['question_votedown']['email_to']) ? $qa_email_templates_data['question_votedown']['email_to'] : '';
                    $email_from_name = isset($qa_email_templates_data['question_votedown']['email_from_name']) ? $qa_email_templates_data['question_votedown']['email_from_name'] : $site_name;
                    $email_from = isset($qa_email_templates_data['question_votedown']['email_from']) ? $qa_email_templates_data['question_votedown']['email_from'] : $qa_from_email;
                    $email_subject = isset($qa_email_templates_data['question_votedown']['subject']) ? $qa_email_templates_data['question_votedown']['subject'] : '';
                    $email_html = isset($qa_email_templates_data['question_votedown']['html']) ? $qa_email_templates_data['question_votedown']['html'] : '';

                    $vars = array(
                        '{site_name}' => get_bloginfo('name'),
                        '{site_description}' => get_bloginfo('description'),
                        '{site_url}' => get_bloginfo('url'),
                        '{site_logo_url}' => get_option('question_bm_logo_url'),

                        '{user_name}' => $current_user->display_name,
                        '{user_avatar}' => get_avatar($current_user->ID, 60),
                        '{user_email}' => '',

                        '{question_title}'  => $question_data->post_title,
                        '{question_url}'  => $question_url,
                        '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_id.'&action=edit',
                        '{question_id}'  => $question_id,
                        '{question_content}'  => $question_data->post_content,

                    );




                    $question_author_data = get_user_by('ID', $question_author);
                    $question_author_email = $question_author_data->user_email;

                    //error_log("question_author_email: ".$question_author_email);

                    $email_data['email_to'] = $question_author_email;
                    $email_data['email_bcc'] = $email_to;
                    $email_data['email_from'] = $email_from;
                    $email_data['email_from_name'] = $email_from_name;
                    $email_data['subject'] = strtr($email_subject, $vars);
                    $email_data['html'] = strtr($email_html, $vars);
                    $email_data['attachments'] = array();

                    $status = $class_qa_emails->qa_send_email($email_data);

                    //error_log("status: ".$status);


                endif;


            endif;

    }
}





add_action( 'qa_action_answer_vote_up', 'qa_action_answer_vote_up_email', 10 );

if ( ! function_exists( 'qa_action_answer_vote_up_email' ) ) {
    function qa_action_answer_vote_up_email( $post_id ) {

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $site_description = get_bloginfo('description');
        $site_url = get_bloginfo('url');
        $qa_logo_url = get_option('qa_logo_url');
        $qa_logo_url = wp_get_attachment_url($qa_logo_url);
        $qa_from_email = get_option('qa_from_email', $admin_email);

        $post_data = get_post( $post_id );
        $post_type = isset($post_data->post_type) ? $post_data->post_type : '';

        //error_log("post_type: ".$post_type);
        global $current_user;


        if ($post_type == 'answer'):

            $question_id = get_post_meta( $post_id, 'qa_answer_question_id', true );

            $question_data 	= get_post( $question_id );
            $question_title = get_the_title($question_id);
            $question_url = get_permalink($question_id);

            $answer_data 	= get_post( $post_id );
            $answer_url = get_permalink($post_id);
            $answer_url = get_permalink($post_id);


            error_log("answer_id: ".$post_id);


            $email_data = array();
            $class_qa_emails = new class_qa_emails();
            $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
            $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

            $enable = isset($qa_email_templates_data['answer_voteup']['enable']) ? $qa_email_templates_data['answer_voteup']['enable'] : 'no';

            if ($enable == 'yes'):

                $email_to = isset($qa_email_templates_data['answer_voteup']['email_to']) ? $qa_email_templates_data['answer_voteup']['email_to'] : '';
                $email_from_name = isset($qa_email_templates_data['answer_voteup']['email_from_name']) ? $qa_email_templates_data['answer_voteup']['email_from_name'] : $site_name;
                $email_from = isset($qa_email_templates_data['answer_voteup']['email_from']) ? $qa_email_templates_data['answer_voteup']['email_from'] : $qa_from_email;
                $email_subject = isset($qa_email_templates_data['answer_voteup']['subject']) ? $qa_email_templates_data['answer_voteup']['subject'] : '';
                $email_html = isset($qa_email_templates_data['answer_voteup']['html']) ? $qa_email_templates_data['answer_voteup']['html'] : '';

                $vars = array(
                    '{site_name}' => get_bloginfo('name'),
                    '{site_description}' => get_bloginfo('description'),
                    '{site_url}' => get_bloginfo('url'),
                    '{site_logo_url}' => get_option('question_bm_logo_url'),

                    '{user_name}' => $current_user->display_name,
                    '{user_avatar}' => get_avatar($current_user->ID, 60),
                    '{user_email}' => '',

                    '{question_title}'  => $question_data->post_title,
                    '{question_url}'  => $question_url,
                    '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_id.'&action=edit',
                    '{question_id}'  => $question_id,
                    '{question_content}'  => $question_data->post_content,

                    '{answer_title}'  => $answer_data->post_title,
                    '{answer_url}'  => $answer_url.'#single-answer-'.$post_id,
                    '{answer_edit_url}'  => get_admin_url().'post.php?post='.$post_id.'&action=edit',
                    '{answer_id}'  => $post_id,
                    '{answer_content}'  => $answer_data->post_content,
                );

                $answer_author = $answer_data->post_author;
                $answer_author_data = get_user_by('ID', $answer_author);
                $answer_author_email = $answer_author_data->user_email;
                //error_log("answer_author_email: ".$answer_author_email);

                $email_data['email_to'] = $answer_author_email;
                $email_data['email_bcc'] = $email_to;
                $email_data['email_from'] = $email_from;
                $email_data['email_from_name'] = $email_from_name;
                $email_data['subject'] = strtr($email_subject, $vars);
                $email_data['html'] = strtr($email_html, $vars);
                $email_data['attachments'] = array();

                $status = $class_qa_emails->qa_send_email($email_data);
                //error_log("status: ".$status);

            endif;
        elseif ($post_type == 'question'):

            $question_id = $post_id;

            //error_log("question_id: ".$question_id);


            $question_data 	= get_post( $question_id );
            $question_title = get_the_title($question_id);
            $question_url = get_permalink($question_id);
            $question_author = $question_data->post_author;

            $email_data = array();
            $class_qa_emails = new class_qa_emails();
            $qa_email_templates_data_default = $class_qa_emails->qa_email_templates_data();
            $qa_email_templates_data = get_option('qa_email_templates_data', $qa_email_templates_data_default);

            $enable = isset($qa_email_templates_data['question_voteup']['enable']) ? $qa_email_templates_data['question_votedown']['enable'] : 'no';

            error_log("enable: ".$enable);

            if ($enable == 'yes'):

                $email_to = isset($qa_email_templates_data['question_voteup']['email_to']) ? $qa_email_templates_data['question_voteup']['email_to'] : '';
                $email_from_name = isset($qa_email_templates_data['question_voteup']['email_from_name']) ? $qa_email_templates_data['question_voteup']['email_from_name'] : $site_name;
                $email_from = isset($qa_email_templates_data['question_voteup']['email_from']) ? $qa_email_templates_data['question_voteup']['email_from'] : $qa_from_email;
                $email_subject = isset($qa_email_templates_data['question_voteup']['subject']) ? $qa_email_templates_data['question_voteup']['subject'] : '';
                $email_html = isset($qa_email_templates_data['question_voteup']['html']) ? $qa_email_templates_data['question_voteup']['html'] : '';

                $vars = array(
                    '{site_name}' => get_bloginfo('name'),
                    '{site_description}' => get_bloginfo('description'),
                    '{site_url}' => get_bloginfo('url'),
                    '{site_logo_url}' => get_option('question_bm_logo_url'),

                    '{user_name}' => $current_user->display_name,
                    '{user_avatar}' => get_avatar($current_user->ID, 60),
                    '{user_email}' => '',

                    '{question_title}'  => $question_data->post_title,
                    '{question_url}'  => $question_url,
                    '{question_edit_url}'  => get_admin_url().'post.php?post='.$question_id.'&action=edit',
                    '{question_id}'  => $question_id,
                    '{question_content}'  => $question_data->post_content,

                );




                $question_author_data = get_user_by('ID', $question_author);
                $question_author_email = $question_author_data->user_email;

                //error_log("question_author_email: ".$question_author_email);

                $email_data['email_to'] = $question_author_email;
                $email_data['email_bcc'] = $email_to;
                $email_data['email_from'] = $email_from;
                $email_data['email_from_name'] = $email_from_name;
                $email_data['subject'] = strtr($email_subject, $vars);
                $email_data['html'] = strtr($email_html, $vars);
                $email_data['attachments'] = array();

                $status = $class_qa_emails->qa_send_email($email_data);

                error_log("status: ".$status);


            endif;


        endif;

    }
}





