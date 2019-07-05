<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 


/* Display question title field */

add_action('qa_question_submit_form', 'qa_question_submit_form_title', 0);

function qa_question_submit_form_title(){

    $post_title = isset($_POST['post_title']) ? sanitize_text_field($_POST['post_title']) : "";

    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Question title','question-answer'); ?></div>
        <div class="field-input">
            <input type="text" value="<?php echo $post_title; ?>" name="post_title">
            <p class="field-details"><?php esc_html_e('Write your question title','question-answer');
            ?></p>
        </div>
    </div>
    <?php
}


/* Display question details input field*/

add_action('qa_question_submit_form', 'qa_question_submit_form_content', 10);

function qa_question_submit_form_content(){

    $field_id = 'post_content';
    $allowed_html = apply_filters('qa_question_submit_allowed_html_tags', array());
    $post_content = isset($_POST['post_content']) ? wp_kses($_POST['post_content'], $allowed_html) : "";


    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Question details','question-answer'); ?></div>
        <div class="field-input">
            <?php
            ob_start();
            wp_editor( $post_content, $field_id, $settings = array('textarea_name'=>$field_id,
                'media_buttons'=>false,'wpautop'=>true,'editor_height'=>'200px', ) );
            echo ob_get_clean();

            ?>

            <p class="field-details"><?php esc_html_e('Write your question details','question-answer'); ?></p>

        </div>
    </div>
    <?php
}

/* Display is private checkbox */

add_action('qa_question_submit_form', 'qa_question_submit_form_is_private', 20);

function qa_question_submit_form_is_private(){

    $post_status = isset($_POST['post_status']) ? sanitize_text_field($_POST['post_status']) : "";
    $checked = !empty($post_status) ? 'checked' : '';

    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Is private?','question-answer'); ?></div>
        <div class="field-input">
            <label><input type="checkbox" value="1" name="post_status" <?php echo $checked; ?>><?php esc_html_e('Make private','question-answer'); ?></label>
            <p class="field-details"><?php esc_html_e('Check to create private question.','question-answer'); ?></p>

        </div>
    </div>
    <?php
}


/* Display category input field  */

add_action('qa_question_submit_form', 'qa_question_submit_form_categories', 30);

function qa_question_submit_form_categories(){

    $question_cat = isset($_POST['question_cat']) ? sanitize_text_field($_POST['question_cat']) : "";

    $categories = qa_get_terms('question_cat');

    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Question category','question-answer'); ?></div>
        <div class="field-input">
            <select name="question_cat" >
                <?php
                if(!empty($categories)):
                    foreach ($categories as $term_id => $term_name){

                        $selected = ($question_cat == $term_id) ? 'selected' : '';

                        ?>
                        <option <?php echo $selected; ?> value="<?php echo esc_attr($term_id); ?>"><?php echo esc_html
                            ($term_name); ?></option>
                        <?php
                    }
                endif;
                ?>
            </select>
            <p class="field-details"><?php esc_html_e('Select question category.','question-answer'); ?></p>

        </div>
    </div>
    <?php
}

/* Display tags input fields */

add_action('qa_question_submit_form', 'qa_question_submit_form_poll', 40);

function qa_question_submit_form_poll(){

    $qa_enable_poll                     = get_option('qa_enable_poll', 'no');


    if($qa_enable_poll != 'yes') return;


    $polls = isset($_POST['polls']) ? ($_POST['polls']) : array();


    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Polls','question-answer'); ?></div>
        <div class="field-input">

            <div class="poll-field-wrap">
                <button class="add-poll">Add Poll</button>

                <div class="poll-items">

                    <?php

                    if(!empty($polls))
                        foreach ($polls as $poll):
                            ?>
                            <div class="item">
                                <input type="text" name="polls[]" value="<?php echo $poll; ?>"/>
                                <span class="sort-hndle"> ... </span>
                                <button class="remove"> X </button>
                            </div>
                            <?php
                        endforeach;
                    ?>

                </div>


            </div>

            <p class="field-details"><?php esc_html_e('Add some polls.', 'question-answer'); ?></p>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {

            $( ".poll-items" ).sortable({handle:'.sort-hndle'});
            $(document).on('click', '.poll-field-wrap .remove', function(e){

                e.preventDefault();

                $(this).parent().remove();


            })
            $(document).on('click', '.poll-field-wrap .add-poll', function(e){

                e.preventDefault();
                var id = $.now();

                var html = '<div class="item">';
                html += '<input type="text" name="polls[]" value=""/>';
                html += '<span class="sort-hndle"> ... </span>';
                html += '<button class="remove" > X </button>';
                html += '</div>';


                $('.poll-items').append(html);


            })

        })
    </script>

    <?php
}

/* Display tags input fields */

add_action('qa_question_submit_form', 'qa_question_submit_form_tags', 50);

function qa_question_submit_form_tags(){

    $question_tags = isset($_POST['question_tags']) ? sanitize_text_field($_POST['question_tags']) : "";


    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Question tags','question-answer'); ?></div>
        <div class="field-input">
            <input type="text" value="<?php echo esc_attr($question_tags); ?>" name="question_tags">
            <p class="field-details"><?php esc_html_e('Put some tags here, use comma( , ) to separate.', 'question-answer'); ?></p>
        </div>
    </div>
    <?php
}




/* display reCaptcha */

add_action('qa_question_submit_form', 'qa_question_submit_form_recaptcha', 60);

function qa_question_submit_form_recaptcha(){

    $qa_reCAPTCHA_enable_question		= get_option('qa_reCAPTCHA_enable_question');
    $qa_reCAPTCHA_site_key		        = get_option('qa_reCAPTCHA_site_key');

    if($qa_reCAPTCHA_enable_question != 'yes'){
        return;
    }

    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">

            <div class="g-recaptcha" data-sitekey="<?php echo $qa_reCAPTCHA_site_key; ?>"></div>
            <script src="https://www.google.com/recaptcha/api.js"></script>

            <p class="field-details"><?php esc_html_e('Please prove you are human.','question-answer'); ?></p>

        </div>
    </div>
    <?php
}


/* Display nonce  */

add_action('qa_question_submit_form', 'qa_question_submit_form_nonce' );

function qa_question_submit_form_nonce(){



    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">

            <?php wp_nonce_field( 'qa_q_submit_nonce','qa_q_submit_nonce' ); ?>

        </div>
    </div>
    <?php
}


/* Display submit button */

add_action('qa_question_submit_form', 'qa_question_submit_form_submit', 90);

function qa_question_submit_form_submit(){

    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"></div>
        <div class="field-input">
            <input type="submit"  name="submit" value="<?php _e('Submit', 'question-answer'); ?>" />
        </div>
    </div>
    <?php
}





/* Process the submitted data  */

add_action('qa_question_submit_data', 'qa_question_submit_data');

function qa_question_submit_data($post_data){

    $qa_reCAPTCHA_enable_question		= get_option('qa_reCAPTCHA_enable_question');
    $qa_account_required_post_question 	= get_option('qa_account_required_post_question', 'yes');
    $qa_question_login_page_id 			= get_option('qa_question_login_page_id');
    $login_page_url 					= get_permalink($qa_question_login_page_id);
    $qa_page_myaccount 			        = get_option('qa_page_myaccount', '' );
    $qa_submitted_post_status 			= get_option('qa_submitted_question_status', 'pending' );
    $qa_enable_poll                     = get_option('qa_enable_poll', 'no');

    $qa_page_myaccount_url = !empty($qa_page_myaccount) ? get_permalink($qa_page_myaccount) : wp_login_url($_SERVER['REQUEST_URI']);

    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
    } else {
        $user_id = 0;
    }

    $qa_error = new WP_Error();




    if(empty($post_data['post_title'])){

        $qa_error->add( 'post_title', __( '<strong>ERROR</strong>: Question title should not empty.', 'question-answer' ) );
    }

    if(empty($post_data['post_content'])){

        $qa_error->add( 'post_content', __( '<strong>ERROR</strong>: Question details should not empty.', 'question-answer' ) );
    }


    if(empty($post_data['polls']) && $qa_enable_poll =='yes'){

        $qa_error->add( 'polls', __( '<strong>ERROR</strong>: Polls should not empty.', 'question-answer' ) );
    }

    if(empty($post_data['g-recaptcha-response']) && $qa_reCAPTCHA_enable_question =='yes'){

        $qa_error->add( 'g-recaptcha-response', __( '<strong>ERROR</strong>: reCaptcha test failed.', 'question-answer' ) );
    }

    if($qa_account_required_post_question=='yes' && !$user_id){

        $qa_error->add( 'login',  sprintf (__('<strong>ERROR</strong>: Please <a target="_blank" href="%s">login</a> to submit question.',
            'question-answer'), $qa_page_myaccount_url ));
    }

    if(! isset( $_POST['qa_q_submit_nonce'] )
        || ! wp_verify_nonce( $_POST['qa_q_submit_nonce'], 'qa_q_submit_nonce' ) ){

        $qa_error->add( '_wpnonce', __( '<strong>ERROR</strong>: security test failed.', 'question-answer' ) );
    }



    $errors = apply_filters( 'qa_question_submit_errors', $qa_error, $post_data );






    if ( !$qa_error->has_errors() ) {

        $allowed_html = array();

        $post_title = isset($post_data['post_title']) ? $post_data['post_title'] :'';
        $post_content = isset($post_data['post_content']) ? wp_kses($post_data['post_content'], $allowed_html) : "";

        $post_status = isset($post_data['post_status']) ? $post_data['post_status'] :'';


        $question_ID = wp_insert_post(
            array(
                'post_title'    => $post_title,
                'post_content'  => $post_content,
                'post_status'   => !empty($post_status) ? 'private' : $qa_submitted_post_status,
                'post_type'   	=> 'question',
                'post_author'   => $user_id,
            )
        );

        do_action('qa_question_submitted', $question_ID, $post_data);


    }
    else{

        $error_messages = $qa_error->get_error_messages();

        ?>
        <div class="errors">

            <?php

            foreach ($error_messages as $message){

                ?>
                <div class="error"><?php echo $message; ?></div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}


/* Update taxonomy data */

add_action('qa_question_submitted', 'qa_question_submitted', 90, 2);

function qa_question_submitted($question_ID, $post_data){

    $user_id = get_current_user_id();

    $question_tags = isset($post_data['question_tags']) ? sanitize_text_field($post_data['question_tags']) : "";
    $question_cat = isset($post_data['question_cat']) ? sanitize_text_field($post_data['question_cat']) : "";
    $question_polls = isset($post_data['polls']) ? ($post_data['polls']) : array();


    wp_set_post_terms( $question_ID, $question_tags, 'question_tags', true );
    wp_set_post_terms( $question_ID, $question_cat, 'question_cat' );


    update_post_meta($question_ID,'q_subscriber',array($user_id));
    update_post_meta($question_ID,'polls', $question_polls);

}


/* Display success message after submitted question */

add_action('qa_question_submitted', 'qa_question_submitted_message', 90, 2);

function qa_question_submitted_message($question_ID, $post_data){

    ?>
    <div class="qa-q-submitted">
        <?php echo apply_filters('qa_q_submitted_thank_you', _e('Thanks for submit question, we will review soon.', 'question-answer')); ?>
    </div>
    <?php


}



/* Display success message after submitted question */

add_action('qa_question_submitted', 'qa_question_submitted_notification', 50, 2);

function qa_question_submitted_notification($question_ID, $post_data){


    $admin_email = get_option('admin_email');
    $admin = get_user_by( 'email', $admin_email );
    $subscriber_id = $admin->ID;
    $user_id = get_current_user_id();

    $notification_data = array();


    $notification_data['user_id'] = get_current_user_id();
    $notification_data['q_id'] = $question_ID;
    $notification_data['a_id'] = '';
    $notification_data['c_id'] = '';
    $notification_data['subscriber_id'] = $subscriber_id;
    $notification_data['action'] = 'new_question';

    do_action('qa_action_notification_save', $notification_data);



}


/* Redirect to new page when redirect is enable */


add_action('qa_question_submitted', 'qa_question_submitted_redirect', 99, 2);

function qa_question_submitted_redirect($question_ID, $post_data){

    $qa_page_question_post_redirect 	= get_option('qa_page_question_post_redirect');
    $redirect_page_url 					= get_permalink($qa_page_question_post_redirect);


    if(!empty($qa_page_question_post_redirect)){
        wp_safe_redirect($redirect_page_url);
        exit;
    }


}