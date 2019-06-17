## Add custom input field to question submit form
You can add custom input field to question submit form via action hook and validated data and save as you want.

```php
/*
 *  Display HTML inout field on form
 * Action hook:  qa_question_submit_form
 * Arguments: none
 *
*/

function qa_question_submit_form_custom_field(){

    $custom_field = isset($_POST['custom_field']) ? sanitize_text_field($_POST['custom_field']) : "";
    
    ?>
    <div class="qa-form-field-wrap">
        <div class="field-title"><?php esc_html_e('Custom field title','question-answer'); ?></div>
        <div class="field-input">
            <input type="text" value="<?php echo $custom_field; ?>" name="custom_field">
            <p class="field-details"><?php esc_html_e('Custom field details','question-answer'); ?>
            </p>
        </div>
    </div>
    <?php
}

add_action('qa_question_submit_form','qa_question_submit_form_custom_field', 60);

```

```php
/*
 *  Check input field data error handle
 * Filter hook:  qa_question_submit_errors
 * Arguments:
 * $qa_error => WP_Error objects
 * $post_data => Form $_POST data variable
 *
*/

function qa_question_submit_errors_custom_field($qa_error, $post_data){

    if(empty($post_data['custom_field'])){

        $qa_error->add( 'custom_field', __( '<strong>ERROR</strong>: custom_field error message.', 'question-answer'
        ) );
    }

    return $qa_error;
}

add_filter('qa_question_submit_errors','qa_question_submit_errors_custom_field', 90,2);

```

```php

/*
 *  Update/Save data to question based on post id
 * Action hook:  qa_question_submitted
 * Arguments:
 * $question_ID => Submitted question post id.
 * $post_data => Form $_POST data variable.
 *
*/

function qa_question_submitted_custom_field($question_ID, $post_data){

    $custom_field = isset($post_data['custom_field']) ? sanitize_text_field($post_data['custom_field']) : "";


    update_post_meta($question_ID,'custom_field', $custom_field);

}

add_action('qa_question_submitted','qa_question_submitted_custom_field', 90, 2);

```
