<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access




$qa_settings_tab = array();

$qa_settings_tab[] = array(
    'id' => 'general',
    'title' => sprintf(__('%s General','question-answer'),'<i class="fas fa-tools"></i>'),
    'priority' => 1,
    'active' => true,
);

$qa_settings_tab[] = array(
    'id' => 'dashboard',
    'title' => sprintf(__('%s Dashboard','question-answer'),'<i class="fas fa-tachometer-alt"></i>'),
    'priority' => 2,
    'active' => false,
);




$qa_settings_tab[] = array(
    'id' => 'questions',
    'title' => sprintf(__('%s Questions','question-answer'),'<i class="far fa-question-circle"></i>'),
    'priority' => 3,
    'active' => false,
);


$qa_settings_tab[] = array(
    'id' => 'answers',
    'title' => sprintf(__('%s Answers','question-answer'),'<i class="fas fa-pencil-alt"></i>'),
    'priority' => 4,
    'active' => false,
);


$qa_settings_tab[] = array(
    'id' => 'pages',
    'title' => sprintf(__('%s Pages','question-answer'),'<i class="far fa-copy"></i>'),
    'priority' => 7,
    'active' => false,
);

$qa_settings_tab[] = array(
    'id' => 'style',
    'title' => sprintf(__('%s Style','question-answer'),'<i class="fas fa-palette"></i>'),
    'priority' => 8,
    'active' => false,
);

$qa_settings_tab[] = array(
    'id' => 'emails',
    'title' => sprintf(__('%s Emails','question-answer'),'<i class="fas fa-envelope-open-text"></i>'),
    'priority' => 9,
    'active' => false,
);



$qa_settings_tab = apply_filters('qa_settings_tabs', $qa_settings_tab);

$tabs_sorted = array();
foreach ($qa_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $qa_settings_tab);
	
?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Settings', 'question-answer'), QA_PLUGIN_NAME)?></h2>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	        <input type="hidden" name="qa_settings_hidden" value="Y">
            <?php
            if(!empty($_POST['qa_settings_hidden'])){

                $nonce = sanitize_text_field($_POST['_wpnonce']);

                if(wp_verify_nonce( $nonce, 'qa_nonce' ) && $_POST['qa_settings_hidden'] == 'Y') {




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













                    do_action('qa_settings_save');

                    ?>
                    <div class="updated notice  is-dismissible"><p><strong><?php _e('Changes Saved.', 'question-answer' ); ?></strong></p></div>

                    <?php
                }
            }
            ?>
            <div class="settings-tabs vertical has-right-panel">

                <div class="settings-tabs-right-panel">
                    <?php
                    foreach ($qa_settings_tab as $tab) {
                        $id = $tab['id'];
                        $active = $tab['active'];

                        ?>
                        <div class="right-panel-content <?php if($active) echo 'active';?> right-panel-content-<?php echo $id; ?>">
                            <?php

                            do_action('qa_settings_tabs_right_panel_'.$id);
                            ?>

                        </div>
                        <?php

                    }
                    ?>
                </div>

                <ul class="tab-navs">
                    <?php
                    foreach ($qa_settings_tab as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                        <?php
                    }
                    ?>
                </ul>



                <?php
                foreach ($qa_settings_tab as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    ?>

                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('qa_settings_tabs_content_'.$id, $tab);
                        ?>


                    </div>

                    <?php
                }
                ?>

            </div>

            <div class="clear clearfix"></div>
            <p class="submit">
                <?php wp_nonce_field( 'qa_nonce' ); ?>
                <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes','question-answer' ); ?>" />
            </p>
		</form>
</div>


<?php

wp_enqueue_script('settings-tabs');
wp_enqueue_style('settings-tabs');
wp_enqueue_style('font-awesome-5');


?>