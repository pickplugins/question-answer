## Add custom input field to question submit form

you can add custom input field to question submit form via action hook and validated data and save as you want.

```

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
