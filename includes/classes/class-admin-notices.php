<?php
if (!defined('ABSPATH')) exit; // if direct access 

class question_answer_admin_notices
{

    public function __construct()
    {
        //add_action('admin_notices', array($this, 'data_upgrade'));
    }

    public function data_upgrade()
    {



        $question_answer_info = get_option('question_answer_info');
        $settingsUpdate = isset($question_answer_info['settingsUpdate']) ? $question_answer_info['settingsUpdate'] : 'no';


        $actionurl = admin_url() . 'edit.php?post_type=question&page=QAsettingsUpdate';
        $actionurl = wp_nonce_url($actionurl,  'QAsettingsUpdate');

        $nonce = isset($_REQUEST['_wpnonce']) ? sanitize_text_field($_REQUEST['_wpnonce']) : '';

        if (wp_verify_nonce($nonce, 'QAsettingsUpdate')) {
            $question_answer_info['settingsUpdate'] = 'processing';
            update_option('question_answer_info', $question_answer_info);

            return;
        }


        if (empty($settingsUpdate) || $settingsUpdate == 'no') {

?>
            <div class="notice notice-error is-dismissible">
                <p>
                    <?php
                    echo sprintf(__('Data migration required for <b>Question Answer</b> plugin, please <a class="button button-primary" href="%s">click to start</a> migration.', 'accordions'), esc_url_raw($actionurl));
                    ?>
                </p>
            </div>
<?php


        }
    }
}

new question_answer_admin_notices();
