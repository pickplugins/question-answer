<?php


if (!defined('ABSPATH')) exit;  // if direct access




add_action('question_answer_single_question', 'question_answer_single_question_scripts', 2);

if (!function_exists('question_answer_single_question_scripts')) {
    function question_answer_single_question_scripts()
    {

        wp_enqueue_script('question-single');
        wp_localize_script('question-single', 'qa_ajax', array('qa_ajaxurl' => admin_url('admin-ajax.php')));
    }
}


add_action('question_answer_single_question', 'question_answer_single_question_top_nav', 5);

if (!function_exists('question_answer_single_question_top_nav')) {
    function question_answer_single_question_top_nav()
    {




        $class_qa_functions = new class_qa_functions();

        $category = '';

        $tax_query = array();
        if (!empty($_GET['category']) || !empty($category)) {

            $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : $category;
            $tax_query[] = array(
                array(
                    'taxonomy' => 'question_cat',
                    'field' => 'slug',
                    'terms' => $category,
                )
            );
        }


        $order_by    = empty($_GET['order_by']) ? '' : sanitize_text_field($_GET['order_by']);
        $filter_by     = isset($_GET['filter_by']) ? sanitize_text_field($_GET['filter_by']) : '';
        $order_by    = empty($_GET['order_by']) ? '' : sanitize_text_field($_GET['order_by']);
        $order     = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : '';





?>
        <div class="qa-wrapper">
            <div class="top-nav">
                <div class="nav-left">


                    <?php

                    $qa_page_question_archive = get_option('qa_page_question_archive');
                    $qa_page_question_archive_url = get_permalink($qa_page_question_archive);

                    ?>

                    <div class="item"><a href="<?php echo $qa_page_question_archive_url; ?>"> <i class="fas fa-reply-all"></i> <?php echo __('Back to Archive', 'question-answer'); ?></a></div>


                    <div class="item search"><i class="fa fa-search" aria-hidden="true"></i>

                        <div class="question-search">
                            <form action="<?php echo $qa_page_question_archive_url; ?>" method="get">
                                <div class="form-field">
                                    <div class="input-title"><?php echo __('Keyword', 'question-answer'); ?></div>
                                    <div class="input-field">
                                        <input autocomplete="off" placeholder="Write..." type="text" value="" name="qaKeyword">
                                    </div>
                                </div>

                                <div class="form-field">
                                    <div class="input-title"><?php echo __('Select Category', 'question-answer'); ?></div>
                                    <div class="input-field">
                                        <select name="qa_category">
                                            <option value=""><?php echo __('All categories', 'question-answer'); ?></option>
                                            <?php

                                            foreach (qa_get_categories() as $cat_id => $cat_info) {
                                                ksort($cat_info);

                                                $this_category = get_term($cat_id);

                                                //if(!empty($this_category))
                                                foreach ($cat_info as $key => $value) {


                                                    if ($key == 0) {
                                            ?><option <?php selected($this_category->slug, $category); ?> value="<?php echo esc_attr($this_category->slug); ?>"><?php echo esc_html($value); ?></option><?php
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        $this_category = get_category($key);

                                                                                                                                                                                                        ?><option <?php selected($this_category->slug, $category); ?> value="<?php echo esc_attr($this_category->slug); ?>"> - <?php echo esc_html($value); ?></option> <?php
                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                                                                            } ?>

                                        </select>
                                    </div>
                                </div>






                                <div class="form-field">
                                    <div class="input-title"><?php echo __('Question Status', 'question-answer'); ?></div>
                                    <div class="input-field">
                                        <select id="filter_by" name="question_status"> <?php
                                                                                        $status = $class_qa_functions->qa_question_status();
                                                                                        foreach ($status as $key => $value) {
                                                                                        ?><option <?php selected($key, $filter_by); ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option><?php
                                                                                                                                                                                                                    } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-field">
                                    <div class="input-title"></div>
                                    <div class="input-field">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>

                            </form>
                        </div>


                    </div>
                </div>





                <div class="nav-right">

                    <?php

                    $qa_page_question_post = get_option('qa_page_question_post');
                    $qa_page_question_post_url = get_permalink($qa_page_question_post);

                    ?>

                    <div class="item ask-question"><a href="<?php echo $qa_page_question_post_url; ?>"><?php echo __('Ask Question', 'question-answer'); ?></a></div>

                    <?php
                    if (is_user_logged_in()) :

                        $userid = get_current_user_id();
                        $paged = 1;
                        global $wpdb;
                        $PER_PAGE = 10;

                        $total_entries = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}qa_notification WHERE subscriber_id='$userid' ORDER BY id DESC");


                        $OFFSET     = ($paged - 1) * $PER_PAGE;
                        $entries = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}qa_notification WHERE subscriber_id='$userid' ORDER BY id DESC LIMIT $PER_PAGE  OFFSET $OFFSET");
                        //$wdm_downloads = $wpdb->get_results( $entries, OBJECT );

                        $entries_unread = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}qa_notification WHERE subscriber_id='$userid' AND status='unread' ORDER BY id DESC LIMIT $PER_PAGE  OFFSET $OFFSET");

                        $total_unread_count = count($entries_unread);


                    ?>


                        <div class="item notifications"><i class="fas fa-bell"></i>
                            <span class="count"><?php if ($total_unread_count >= 20) echo __('20+', 'question-answer');
                                                else echo $total_unread_count; ?></span>

                            <div class="notification-wrapper">
                                <div class="notification-list-top">
                                    <span class="mark-all-read"><?php echo sprintf(__('%s Mark all as read',  'question-answer'), '<i class="far fa-check-circle"></i>'); ?></span>

                                </div>
                                <div class="notification-list">

                                    <div class="list-items">
                                        <?php

                                        if (!empty($entries)) :
                                            foreach ($entries as $entry) {


                                                $id = $entry->id;
                                                $q_id = $entry->q_id;
                                                $a_id = $entry->a_id;
                                                $c_id = $entry->c_id;
                                                $user_id = $entry->user_id;
                                                $subscriber_id = $entry->subscriber_id;
                                                $action = $entry->action;
                                                $datetime = $entry->datetime;
                                                $status = $entry->status;

                                                $entry_date = new DateTime($datetime);
                                                $datetime = $entry_date->format('M d, Y h:i A');

                                                $user = get_user_by('ID', $user_id);

                                                if (!empty($user->display_name)) {
                                                    $user_display_name = $user->display_name;
                                                } else {

                                                    $qa_contact_name = get_post_meta($id, 'qa_contact_name', true);

                                                    $user_display_name = !empty($qa_contact_name) ? $qa_contact_name : __('Anonymous', 'question-answer');
                                                }


                                                if ($status == 'unread') {
                                                    $notify_mark_html = '<span class="notify-mark" notify_id="' . $id . '" ><i class="far fa-bell"></i></span>';
                                                } else {
                                                    $notify_mark_html = '<span class="notify-mark" notify_id="' . $id . '" ><i class="far fa-bell-slash"></i></span>';
                                                }


                                        ?>

                                                <div class="item item-<?php echo $id; ?> <?php if ($status == 'unread') echo $status; ?>">
                                                    <?php


                                                    echo '<img src="' . get_avatar_url($user_id,  array('size' => 40)) . '" class="thumb">';

                                                    if ($action == 'new_question') {

                                                        echo '<span class="name">' . $user_display_name . '</span> ' . __('posted', 'question-answer') . ' <span class="action">' . __('New Question',  'question-answer') . '</span> <a href="' . get_permalink($q_id) . '" class="link">' . get_the_title($q_id) . '</a> ';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php

                                                    } elseif ($action == 'new_answer') {


                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Answered', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#single-answer-' . $a_id . '" class="link">' . get_the_title($q_id) . '</a> ';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php

                                                    } elseif ($action == 'best_answer') {

                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Choosed best answer', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#single-answer-' . $a_id . '" class="link">' . get_the_title($a_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php


                                                    } elseif ($action == 'best_answer_removed') {

                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Removed best answer', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#single-answer-' . $a_id . '" class="link">' . get_the_title($a_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                        <?php


                                                    } elseif ($action == 'new_comment') {

                                                        $comment_post_data = get_comment($c_id);

                                                        if (!empty($comment_post_data->comment_post_ID)) :

                                                            $comment_post_id = $comment_post_data->comment_post_ID;

                                                            $comment_post_type = get_post_type($comment_post_id);

                                                            if ($comment_post_type == 'answer') {

                                                                $flag_post_type = 'answer';

                                                                $q_id = get_post_meta($comment_post_id, 'qa_answer_question_id', true);
                                                            } else {
                                                                $flag_post_type = 'question';
                                                            }

                                                            $q_id = get_post_meta($a_id, 'qa_answer_question_id', true);
                                                            echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Commented', 'question-answer') . '</span> on ' . $flag_post_type . ' <a href="' . get_permalink($q_id) . '#comment-' . $c_id . '" class="link">' . get_the_title($a_id) . '</a>';

                                                        ?>
                                                            <div class="meta">

                                                                <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                                <?php echo $notify_mark_html; ?>
                                                            </div>
                                                        <?php


                                                        endif;
                                                    } elseif ($action == 'comment_flag') {

                                                        $comment_post_data = get_comment($c_id);



                                                        $comment_post_id = $comment_post_data->comment_post_ID;

                                                        $comment_post_type = get_post_type($comment_post_id);

                                                        if ($comment_post_type == 'answer') {

                                                            $flag_post_type = 'answer';
                                                            $link_extra = '#comment-' . $c_id;
                                                            $q_id = get_post_meta($comment_post_id, 'qa_answer_question_id', true);
                                                        } else {
                                                            $flag_post_type = 'question';
                                                            $link_extra = '#comment-' . $c_id;
                                                            $q_id = $comment_post_id;
                                                        }



                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Flagged comment', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#comment-' . $c_id . '" class="link">' . get_the_title($q_id) . '</a>';

                                                        ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php



                                                    } elseif ($action == 'comment_vote_up') {

                                                        $comment_post_data = get_comment($c_id);
                                                        $comment_post_id = $comment_post_data->comment_post_ID;

                                                        $comment_post_type = get_post_type($comment_post_id);

                                                        if ($comment_post_type == 'answer') {

                                                            $flag_post_type = 'answer';
                                                            $link_extra = '#comment-' . $c_id;
                                                            $q_id = get_post_meta($comment_post_id, 'qa_answer_question_id', true);
                                                        } else {
                                                            $flag_post_type = 'question';
                                                            $link_extra = '#comment-' . $c_id;
                                                            $q_id = $comment_post_id;
                                                        }



                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('comment vote up', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#comment-' . $c_id . '" class="link">' . get_the_title($q_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php



                                                    } elseif ($action == 'comment_vote_down') {

                                                        $comment_post_data = get_comment($c_id);
                                                        $comment_post_id = $comment_post_data->comment_post_ID;

                                                        $comment_post_type = get_post_type($comment_post_id);

                                                        if ($comment_post_type == 'answer') {

                                                            $flag_post_type = 'answer';
                                                            $link_extra = '#comment-' . $c_id;
                                                            $q_id = get_post_meta($comment_post_id, 'qa_answer_question_id', true);
                                                        } else {
                                                            $flag_post_type = 'question';
                                                            $link_extra = '#comment-' . $c_id;
                                                            $q_id = $comment_post_id;
                                                        }



                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('comment vote down', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#comment-' . $c_id . '" class="link">' . get_the_title($q_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php


                                                    } elseif ($action == 'vote_up') {

                                                        $q_id = get_post_meta($a_id, 'qa_answer_question_id', true);
                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Vote Up', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#single-answer-' . $a_id . '" class="link">' . get_the_title($a_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php



                                                    } elseif ($action == 'vote_down') {

                                                        $q_id = get_post_meta($a_id, 'qa_answer_question_id', true);
                                                        echo ' <span class="name">' . $user_display_name . '</span> <span class="action">' . __('Vote Down', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '#single-answer-' . $a_id . '" class="link">' . get_the_title($a_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php



                                                    } elseif ($action == 'q_solved') {

                                                        echo ' <span class="name">' . $user_display_name . '</span> ' . __('marked', 'question-answer') . ' <span class="action">' . __('Solved', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '" class="link">' . get_the_title($q_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php


                                                    } elseif ($action == 'q_not_solved') {

                                                        echo ' <span class="name">' . $user_display_name . '</span> ' . __('marked', 'question-answer') . ' <span class="action">' . __('Not Solved', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . '" class="link">' . get_the_title($q_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php


                                                    } elseif ($action == 'flag') {

                                                        if (!empty($a_id)) {

                                                            $flag_post_type = 'answer';
                                                            $link_extra = '#single-answer-' . $a_id;
                                                            $q_id = get_post_meta($a_id, 'qa_answer_question_id', true);
                                                            $post_id = $a_id;
                                                        }
                                                        if (!empty($q_id)) {

                                                            $flag_post_type = 'question';
                                                            $link_extra = '';
                                                            $post_id = $q_id;
                                                        }




                                                        echo ' <span class="name">' . $user_display_name . '</span> ' . sprintf(__('flagged your %s', 'question-answer'), $flag_post_type) . ' <span class="name"></span> <a href="' . get_permalink($q_id) . $link_extra . '" class="link">' . get_the_title($post_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php


                                                    } elseif ($action == 'unflag') {

                                                        if (!empty($a_id)) {

                                                            $flag_post_type = 'answer';
                                                            $link_extra = '#single-answer-' . $a_id;
                                                        } else {

                                                            $flag_post_type = 'question';
                                                            $link_extra = '';
                                                        }


                                                        $q_id = get_post_meta($a_id, 'qa_answer_question_id', true);
                                                        echo ' <span class="name">' . $user_display_name . '</span> ' . $flag_post_type . ' <span class="action">' . __('unflagged ', 'question-answer') . '</span> <a href="' . get_permalink($q_id) . $link_extra . '" class="link">' . get_the_title($q_id) . '</a>';

                                                    ?>
                                                        <div class="meta">

                                                            <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                                            <?php echo $notify_mark_html; ?>
                                                        </div>
                                                    <?php



                                                    }

                                                    ?>
                                                </div>
                                            <?php


                                            }
                                        else :

                                            ?>
                                            <div class="empty-notify item"><i class="fa fa-bell-slash-o" aria-hidden="true"></i> <?php echo __('No notification right now.', 'question-answer'); ?></div>
                                        <?php
                                        endif;

                                        ?>
                                    </div>

                                </div>
                                <div class="notification-list-bottom">
                                    <div class="load-notifications" pagenum="2"><span class="spinner"><i class="fas fa-spinner fa-spin"></i></span><?php echo __('Load more', 'question-answer'); ?></div>
                                </div>
                            </div>


                        </div>

                    <?php

                    endif;

                    ?>



                </div>


            </div>
        </div>

    <?php


    }
}


add_action('question_answer_single_question', 'question_answer_single_question_notice', 5);

function question_answer_single_question_notice($question_id)
{

    $question_answer_settings = get_option('question_answer_settings');
    $single_question_notice = isset($question_answer_settings['single_question_notice']) ? $question_answer_settings['single_question_notice'] : '';

    if (!empty($single_question_notice)) :
    ?>
        <div class="qa-notice">
            <?php echo $single_question_notice; ?>
        </div>

    <?php
    endif;
}



add_action('question_answer_single_question', 'question_answer_single_question_admin_actions', 10);

function question_answer_single_question_admin_actions($post_id)
{

    $post_statuses = get_post_statuses();
    $current_post_status = get_post_status($post_id);
    $qa_visiblity = get_post_meta($post_id, 'qa_visiblity', true);

    $current_post_status = ($qa_visiblity == 'private') ? 'private' : $current_post_status;


    $current_user = wp_get_current_user();
    $current_user_role = isset($current_user->roles[0]) ? $current_user->roles[0] : '';

    $manage_roles = ['administrator', 'qa_manager'];



    ?>
    <?php if (in_array($current_user_role, $manage_roles)) : ?>

        <div class="admin-actions">

            <form class="post-status" id="qa-admin-action">

                <?php foreach ($post_statuses as $status_index => $status_name) { ?>
                    <label> <input <?php if ($current_post_status == $status_index) echo 'checked'; ?> name="post_status" type="radio" value="<?php echo $status_index; ?>"> <?php echo $status_name; ?></label>
                <?php } ?>

                <input type="hidden" value="<?php echo esc_attr(get_the_id()); ?>" name="post_id">
                <?php wp_nonce_field('nonce_qa_update_post_status'); ?>
                <input type="submit" class="admin_actions_submit" value="<?php echo __('Update', 'question-answer'); ?>" />

            </form>

        </div>
    <?php endif; ?>
    <?php

}





add_action('question_answer_single_question', 'qa_action_single_question_content_header', 10);


if (!function_exists('qa_action_single_question_content_header')) {
    function qa_action_single_question_content_header()
    {

        $post_id = get_the_ID();

        $author_id     = get_post_field('post_author', $post_id);
        $author     = get_userdata($author_id);

        $qa_contact_email = get_post_meta($post_id, 'qa_contact_email', true);
        $qa_contact_name = get_post_meta($post_id, 'qa_contact_name', true);

        $qa_contact_name = !empty($qa_contact_name) ? $qa_contact_name : __('Anonymous', 'question-answer');


        $author_name = !empty($author->display_name) ? $author->display_name : $qa_contact_name;
        $author_role = !empty($author->roles) ? $author->roles[0] : '';
        $author_date = !empty($author->user_registered) ? $author->user_registered : 'N/A';
        $author_email = !empty($author->user_email) ? $author->user_email : $qa_contact_email;


    ?>
        <div class="question-content">

            <div class="content-header">

                <div class="question-vote">

                    <?php

                    $qa_answer_review        = get_post_meta(get_the_ID(), 'qa_answer_review', true);
                    $qa_answer_is_private     = get_post_meta(get_the_ID(), 'qa_answer_is_private', true);

                    $current_user    = wp_get_current_user();
                    $author_id         = get_post_field('post_author', get_the_ID());
                    $author         = get_userdata($author_id);

                    $status         = isset($qa_answer_review['users'][$current_user->ID]['type']) ? $qa_answer_review['users'][$current_user->ID]['type'] : '';
                    $votted_up         = ($status == 'up') ? 'votted' : '';
                    $votted_down     = ($status == 'down') ? 'votted' : '';

                    $review_count     = empty($qa_answer_review['reviews']) ? 0 : (int)$qa_answer_review['reviews'];

                    $question_id = get_post_meta(get_the_ID(), 'qa_answer_question_id', true);
                    $question_author_id = get_post_field('post_author', $question_id);


                    ?>


                    <div data-id="<?php echo get_the_ID(); ?>" class="qa-single-vote qa-single-vote-<?php echo get_the_ID(); ?>">
                        <span class="qa-thumb-up ap-tip vote-up <?php echo $votted_up; ?>" post_id="<?php echo get_the_ID(); ?>">
                            <?php echo apply_filters('qa_filter_answer_vote_up_html', '<i class="fa s_22 fa-thumbs-up"></i>'); ?>
                        </span>
                        <span class="net-vote-count net-vote-count-<?php echo get_the_ID(); ?>">
                            <?php echo apply_filters('qa_filter_answer_vote_count_html', $review_count); ?>
                            <?php //echo $review_count; 
                            ?>
                        </span>

                        <span class="qa-thumb-down ap-tip vote-down <?php echo $votted_down; ?>" post_id="<?php echo get_the_ID(); ?>">
                            <?php echo apply_filters('qa_filter_answer_vote_up_html', '<i class="fa s_22 fa-thumbs-down"></i>'); ?>
                        </span>
                    </div>
                </div>


                <div class="question-author-avatar meta">
                    <?php echo get_avatar($author_email, "45"); ?>
                </div>
                <div class="qa-user qa-user-card-loader" author_id="<?php echo $author_id; ?>" has_loaded="no">
                    <?php echo apply_filters('qa_question_author_name', $author_name); ?>
                    <div class="qa-user-card">
                        <div class="card-loading">
                            <i class="fa fa-cog fa-spin"></i>
                        </div>
                        <div class="card-data"></div>
                    </div>
                </div>


                <?php
                echo apply_filters('qa_filter_single_question_meta_post_date', sprintf('<span class="qa-meta-item">%s %s</span>', '<i class="far fa-calendar-alt"></i>', get_the_date('M d, Y h:i A')));


                $wp_query_answer = new WP_Query(
                    array(
                        'post_type'     => 'answer',
                        'post_status'     => 'publish',
                        'meta_query' => array(
                            array(
                                'key'     => 'qa_answer_question_id',
                                'value'   => get_the_ID(),
                                'compare' => '=',
                            ),
                        ),
                    )
                );

                echo apply_filters('qa_filter_single_question_meta_answer_count', sprintf('<span class="qa-meta-item">%s %s ' . __('Answers', 'question-answer') . '</span>', '<i class="fas fa-reply-all"></i>', number_format_i18n($wp_query_answer->found_posts)));



                wp_reset_query();


                $category = get_the_terms(get_the_ID(), 'question_cat');
                if (!empty($category[0])) {
                    echo apply_filters('qa_filter_single_question_meta_category', sprintf('<span class="qa-meta-item">%s %s</span>', '<i class="fas fa-sitemap"></i>', $category[0]->name));
                }

                ?>



                <div class="qa-users-meta meta">

                    <?php
                    do_action('qa_question_user_meta', $question_id);
                    ?>



                    <span class="qa-user-badge"><?php echo apply_filters('qa_filter_single_question_badge', '', $author_id, 2); ?></span>
                    <span class="qa-member-since"><?php echo sprintf(__('Member Since %s', 'question-answer'), date("M Y", strtotime($author_date))); ?><?php //echo date( "M Y", strtotime( $author_date ) ); 
                                                                                                                                                        ?></span>
                </div>


                <?php



                do_action('qa_action_single_question_meta');

                $question_id = get_the_ID();

                $mark_as_close = get_post_meta($question_id, 'mark_as_close', true);


                ?>
                <div class="meta-list clearfix">
                    <?php

                    /*
             Title: Post Category HTML
             Filter: qa_filter_single_question_meta_category
            */

                    if ($mark_as_close == 'yes') :
                    ?>
                        <span class="qa-closed"><i class="fa fa-lock"></i> <?php echo __('Closed', 'question-answer'); ?></span>

                    <?php
                    endif;



                    /*
             Title: Post Date HTML
             Filter: qa_filter_single_question_meta_post_date
            */


                    // echo apply_filters( 'qa_filter_single_question_meta_post_date', sprintf( __('<span title="'.get_the_date().'" class="qa-meta-item">%s %s</span>', 'question-answer'), '<i class="fa fa-clock-o"></i>', qa_post_duration(get_the_ID()) ) );


                    //echo qa_post_duration(get_the_ID());




                    /*
             Title: Featured HTML
             Filter: qa_filter_single_question_meta_featured_html
            */



                    $qa_featured_questions     = get_option('qa_featured_questions', array());
                    $featured_class         = in_array(get_the_ID(), $qa_featured_questions) ? 'qa-featured-yes' : 'qa-featured-no';
                    $featured_icon             = '<i class="fa fa-star" aria-hidden="true"></i>';


                    if (current_user_can('administrator')) {
                    ?>
                        <div class="qa-meta-item qa-featured <?php echo $featured_class; ?>" post_id="<?php echo  get_the_ID(); ?>">

                            <span class="featured"><i class="fa fa-star" aria-hidden="true"></i> Featured</span>
                            <span class="not-featured"><i class="fa fa-star" aria-hidden="true"></i> Not featured</span>
                            <span class="make-featured"><i class="fa fa-star" aria-hidden="true"></i> Make featured</span>
                            <span class="cancel-featured"><i class="fa fa-times" aria-hidden="true"></i> Cancel featured</span>

                        </div>
                    <?php
                    }


                    echo apply_filters('qa_filter_single_question_meta_featured_html', sprintf('', $featured_class, get_the_ID(), $featured_icon));





                    /*
             Title: Is Solved HTML
             Filter: qa_filter_single_question_meta_is_solved_html
            */

                    $current_user     = wp_get_current_user();
                    $author_id         = get_post_field('post_author', get_the_ID());

                    $is_solved = get_post_meta(get_the_ID(), 'qa_question_status', true);

                    if ($is_solved == 'solved') {

                        $is_solved_class = 'solved';
                    } else {

                        $is_solved_class     = 'unsolved';
                    }

                    if ($current_user->ID == $author_id || in_array('administrator', $current_user->roles)) {

                    ?>
                        <div class="qa-meta-item qa-is-solved <?php echo $is_solved_class; ?>" post_id="<?php echo get_the_ID(); ?>">
                            <?php //echo $is_solved_icon; 
                            ?> <?php //echo $is_solved_status; 
                                ?>

                            <span class="unsolved"><i class="fa fa-times"></i> <?php echo __('Unsolved', 'question-answer'); ?></span>
                            <span class="solved"><i class="fa fa-check"></i> <?php echo __('Solved', 'question-answer'); ?></span>
                            <span class="mark-solved"><i class="fa fa-check"></i> <?php echo __('Mark as Solved', 'question-answer'); ?></span>
                            <span class="mark-unsolved"><i class="fa fa-times"></i> <?php echo __('Mark as Unsolved', 'question-answer'); ?></span>

                        </div>
                    <?php



                        //echo apply_filters( 'qa_filter_single_question_meta_is_solved_html', sprintf( '', $is_solved_class, get_the_ID(), $is_solved_icon, $is_solved_status, $qa_ttt ) );
                    }





                    /*
             Title: Subscriber HTML
             Filter: qa_filter_single_question_meta_subscriber_html
            */

                    $q_subscriber = get_post_meta(get_the_ID(), 'q_subscriber', true);

                    if (is_array($q_subscriber) && in_array($current_user->ID, $q_subscriber)) {

                        $subscribe_icon = '<i class="fa fa-bell"></i>';
                        $subscribe_class = 'subscribed';
                        $qa_ttt_text = __('Subscribed', 'question-answer');
                    } else {

                        $subscribe_icon = '<i class="fa fa-bell-slash"></i>';
                        $subscribe_class = 'not-subscribed';
                        $qa_ttt_text = __('Subscribe', 'question-answer');
                    }


                    ?>
                    <div class="qa-meta-item qa-subscribe <?php echo $subscribe_class; ?>" post_id="<?php echo get_the_ID(); ?>">
                        <span class="subscribed-done"><i class="fa fa-bell"></i> Subscribed</span>
                        <span class="start-subscribe"><i class="fa fa-bell"></i> Subscribe</span>
                        <span class="stop-subscribe"><i class="fa fa-bell-slash"></i> Not subscribe</span>
                        <span class="cancel-subscribe"><i class="fa fa-bell-slash"></i> Cancel subscribe</span>
                    </div>
                    <?php


                    //echo apply_filters( 'qa_filter_single_question_meta_subscriber_html', sprintf( '', $subscribe_class, get_the_ID(), $subscribe_icon, $qa_ttt_text ) );


                    $qa_flag     = get_post_meta(get_the_ID(), 'qa_flag', true);

                    if (empty($qa_flag)) $qa_flag = array();
                    $flag_count         = sizeof($qa_flag);
                    $user_ID        = get_current_user_id();


                    if (array_key_exists($user_ID, $qa_flag) && $qa_flag[$user_ID]['type'] == 'flag') {

                        $flag_text = __('Unflag', 'question-answer');
                    } else {

                        $flag_text = __('Flag', 'question-answer');
                    }

                    echo '<div class="qa-meta-item qa-flag qa-flag-action" post_id="' . get_the_ID() . '"><i class="fa fa-flag flag-icon"></i> <span class="flag-text">' . $flag_text . '</span><span class="flag-count">(' . $flag_count . ')</span> <span class="waiting"><i class="fa fa-cog fa-spin"></i></span> </div>';













                    ?>
                </div>




            </div>
        </div>

    <?php







    }
}







add_action('question_answer_single_question', 'qa_action_single_question_meta', 10);


if (!function_exists('qa_action_single_question_meta')) {
    function qa_action_single_question_meta()
    {
    }
}










add_action('question_answer_single_question', 'question_answer_single_question_content', 10);


function question_answer_single_question_content()
{


    ?>
    <div class="question-content">
        <?php
        $content = get_the_content();
        // $content = wp_specialchars_decode($content, ENT_QUOTES);


        $WP_Embed = new WP_Embed();
        $content = $WP_Embed->autoembed($content);
        $content = wpautop($content);
        $content = do_shortcode($content);


        echo $content;
        ?>
    </div>
    <?php

}

add_action('question_answer_single_question', 'question_answer_single_question_subscriber', 15);



if (!function_exists('question_answer_single_question_subscriber')) {
    function question_answer_single_question_subscriber()
    {



        $q_subscriber = get_post_meta(get_the_ID(), 'q_subscriber', true);
        $qa_assign_to = get_post_meta(get_the_ID(), 'qa_assign_to', true);
        $qa_assign_to = !empty($qa_assign_to) ? $qa_assign_to : array();

        $q_subscriber_count = !empty($q_subscriber) ? count($q_subscriber) : 0;


    ?>

        <div class="subscribers">

            <div class="title"><?php echo sprintf(__('%s %s Subscribers', 'question-answer'), '<i class="far fa-bell"></i>', $q_subscriber_count); ?></div>
            <?php
            $max_subscriber = 10;

            $i = 1;
            if (is_array($q_subscriber))
                foreach ($q_subscriber as $subscriber) {

                    $user = get_user_by('ID', $subscriber);

                    if (!empty($user->display_name))
                        echo '<div title="' . $user->display_name . '" class="subscriber">' . get_avatar($subscriber, "45") . '</div>';

                    if ($i >= $max_subscriber) {
                        return;
                    }
                }
            ?>

        </div>

        <?php if (!empty($qa_assign_to)) : ?>

            <div class="assign-to">
                <span class="assign-to-title">Assign to: </span>

                <?php

                if (!empty($qa_assign_to))
                    foreach ($qa_assign_to as $userId) {
                        $user = get_user_by('id', $userId);
                        $avatar_url = get_avatar_url($userId);



                ?>
                    <div class="item" title="<?php echo isset($user->display_name) ?  $user->display_name : 'hhhhhhhhhhhhh'; ?>">
                        <img width="30" src="<?php echo $avatar_url; ?>">
                    </div>
                <?php
                    }
                ?>

            </div>
        <?php endif;
    }
}


add_action('question_answer_single_question', 'question_answer_single_question_answer_posting', 20);


if (!function_exists('question_answer_single_question_answer_posting')) {
    function question_answer_single_question_answer_posting()
    {




        global $current_user;

        $logged_user_id = get_current_user_id();
        $logged_userdata = get_userdata($logged_user_id);


        $mark_as_close = get_post_meta(get_the_ID(), 'mark_as_close', true);


        if ($mark_as_close == 'yes') :

        ?>
            <div class="question-closed">
                <?php echo sprintf(__('%s Question is closed, you can\'t answer or comment.', ''), '<i class="far fa-times-circle"></i>'); ?>
            </div>
        <?php

        else :
            $qa_account_required_post_answer = get_option('qa_account_required_post_answer', 'yes');
            $qa_submitted_answer_status = get_option('qa_submitted_answer_status', 'pending');
            $qa_options_quick_notes = get_option('qa_options_quick_notes');
            $qa_who_can_comment_answer = get_option('qa_who_can_comment_answer');
            $qa_who_can_see_quick_notes = get_option('qa_who_can_see_quick_notes');
            $qa_answer_editor_media_buttons = get_option('qa_answer_editor_media_buttons', 'no');


            if (empty($qa_who_can_see_quick_notes)) $qa_who_can_see_quick_notes = array('administrator');


            $current_user_role = isset($logged_userdata->roles) ? array_shift($logged_userdata->roles) : array();

            if (!empty($qa_who_can_answer) && !in_array($current_user_role, $qa_who_can_answer)) return;

        ?>

            <div class="answer-post  clearfix">

                <div class="answer-post-header" _status="0">
                    <span class="fs_16"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo sprintf(__('%s Submit Answer', 'question-answer'), '<i class="far fa-edit"></i>'); ?></span>
                    <i class="fa fa-expand fs_24 float_right apost_header_status"></i>
                </div>

                <?php if (!is_user_logged_in() && $qa_account_required_post_answer == 'yes') {

                    $qa_page_myaccount = get_option('qa_page_myaccount');

                    echo sprintf(__('<form class="nodisplay">Please <a href="%s">login</a> to submit answer.</form>', 'question-answer'), get_permalink($qa_page_myaccount));
                    echo '</div>';
                    return;
                } ?>

                <?php do_action('qa_action_before_answer_post_form'); ?>

                <form class="form-answer-post" style="display: none;" enctype="multipart/form-data" action="">

                    <?php


                    if (!empty($qa_options_quick_notes) && !empty($current_user_role) && in_array($current_user_role, $qa_who_can_see_quick_notes)) : ?>

                        <div class="quick-notes">

                            <strong><?php echo __('Quick notes', 'question-answer'); ?></strong>
                            <?php foreach ($qa_options_quick_notes as $note) : if (empty($note)) continue; ?>
                                <input onclick="this.select();" type="text" value="<?php echo $note; ?>" />
                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>


                    <?php
                    $editor_settings['editor_height'] = 150;
                    $editor_settings['tinymce'] = true;
                    $editor_settings['quicktags'] = true;
                    $editor_settings['media_buttons'] = false;
                    $editor_settings['drag_drop_upload'] = true;

                    if ($qa_answer_editor_media_buttons == 'yes') $editor_settings['media_buttons'] = true;

                    wp_editor('', 'qa_answer_editor', $editor_settings);
                    ?>

                    <p><label for="is_private">
                            <input id="is_private" type="checkbox" class="" value="1" name="is_private" />
                            <?php echo __('Make your answer private.', 'question-answer'); ?>
                        </label></p>

                    <div class="answer_posting_notice"></div>



                    <?php wp_nonce_field('nonce_answer_post'); ?>
                    <input type="hidden" name="question_id" value="<?php echo esc_attr(get_the_ID()); ?>" />
                    <div class="qa_button submit_answer_button hint--top" aria-label="<?php echo __('Answer will review', 'question-answer'); ?>">
                        <?php echo __('Submit Answer', 'question-answer'); ?>
                    </div>

                </form>


                <?php do_action('qa_action_after_answer_post_form'); ?>

            </div> <!-- .answer-post -->

        <?php

        endif;
    }
}



add_action('question_answer_single_question', 'question_answer_single_question_answers', 30);



if (!function_exists('question_answer_single_question_answers')) {
    function question_answer_single_question_answers()
    {


        $question_id = get_the_ID();


        if (get_query_var('paged')) $paged = get_query_var('paged');
        elseif (get_query_var('page')) $paged = get_query_var('page');
        else $paged = 1;

        $qa_answer_item_per_page     = get_option('qa_answer_item_per_page');
        $qa_show_answer_filter         = get_option('qa_show_answer_filter');
        $qa_answer_filter_options     = get_option('qa_answer_filter_options');
        $qa_sort_answer             = isset($_GET['qa_sort_answer']) ? sanitize_text_field($_GET['qa_sort_answer']) : '';
        $qa_meta_best_answer = get_post_meta($question_id, 'qa_meta_best_answer', true);

        $meta_query[] = array(
            'key'         => 'qa_answer_question_id',
            'value'     => get_the_ID(),
            'compare'    => '=',
        );

        if ('answers_older' === $qa_sort_answer) $order = 'ASC';

        if ('answers_voted' === $qa_sort_answer) {

            $meta_query[] = array(
                'relation' => 'OR',
                array(
                    'key'         => 'qa_answer_review_users_up',
                    'value'     => 0,
                    'compare'    => '>',
                ),
                array(
                    'key'         => 'qa_answer_review_users_down',
                    'value'     => 0,
                    'compare'    => '>',
                ),
            );
        }

        if ('answers_top_voted' === $qa_sort_answer) {

            $order_by     = 'meta_value';
            $meta_key     = 'qa_answer_review_value';
        }


        $wp_query = new WP_Query(array(
            'post_type' => 'answer',
            'post_status' => 'publish',
            'orderby' => !empty($order_by) ? $order_by : 'date',
            'meta_key' => !empty($meta_key) ? $meta_key : '',
            'meta_query' => $meta_query,
            'order' => !empty($order) ? $order : 'DESC',
            'post__not_in' => [$qa_meta_best_answer],

            'posts_per_page' => !empty($qa_answer_item_per_page) ? $qa_answer_item_per_page : 10,
            'paged' => $paged,
        ));

        ?>

        <div id="answer-of-<?php the_ID(); ?>" <?php post_class('container-answer-section entry-content'); ?>>
            <div class="answer-section-header">

                <span class="fs_16"><?php echo sprintf(__('%s %s Answers', 'question-answer'), '<i class="far fa-comments"></i>', do_shortcode("[qa_querstion_answer_count id='" . $question_id . "']")); ?></span>



                <?php if ($qa_show_answer_filter == 'yes') { ?>
                    <div class="float_right answer_header_status">
                        <form enctype="multipart/form-data" id="qa_sort_answer_form" action="<?php echo str_replace('%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>" method="GET">
                            <span><?php echo __('Sort By:', 'question-answer'); ?></span>
                            <select name="qa_sort_answer" class="qa_sort_answer">
                                <option value=""><?php echo __('All Answers', 'question-answer'); ?></option>
                                <option <?php if ($qa_sort_answer == 'answers_voted') echo 'selected'; ?> value="answers_voted"><?php echo __('Voted Answers', 'question-answer'); ?></option>


                                <option <?php if ($qa_sort_answer == 'answers_top_voted') echo 'selected'; ?> value="answers_top_voted"><?php echo __('Top Voted Answers', 'question-answer'); ?></option>
                                <option <?php if ($qa_sort_answer == 'answers_older') echo 'selected'; ?> value="answers_older"><?php echo __('Older Answers', 'question-answer'); ?></option>


                                <?php if (isset($qa_answer_filter_options['answers_voted'])) { ?>

                                <?php } ?>

                                <?php if (isset($qa_answer_filter_options['answers_top_voted'])) { ?>

                                <?php } ?>

                                <?php if (isset($qa_answer_filter_options['answers_older'])) { ?>

                                <?php } ?>

                            </select>
                        </form>
                    </div>
                <?php } ?>


            </div>

            <div class="all-single-answer">
                <?php


                if (!empty($qa_meta_best_answer)) :



                    $qa_answer_review_value         = get_post_meta($qa_meta_best_answer, 'qa_answer_review_value', true);
                    $qa_answer_review_users_up         = get_post_meta($qa_meta_best_answer, 'qa_answer_review_users_up', true);
                    $qa_answer_review_users_down     = get_post_meta($qa_meta_best_answer, 'qa_answer_review_users_down', true);

                    $reviewd = ($qa_answer_review_users_up > 0 || $qa_answer_review_users_down > 0) ? 'reviewd' : '';

                    $question_id         = get_post_meta($qa_meta_best_answer, 'qa_answer_question_id', true);
                    $best_answer_id        = get_post_meta($question_id, 'qa_meta_best_answer', true);
                    $best_answer_class     = ($qa_meta_best_answer == $best_answer_id) ? 'list_best_answer' : '';

                ?>
                    <div id="single-answer-<?php echo $qa_meta_best_answer; ?>" <?php post_class("single-answer $reviewd $best_answer_class"); ?>>
                        <div class="best-answer-ribbon"><span><i class="fa fa-trophy best-answer-icon" aria-hidden="true"></i> <?php echo __('Best Answer', 'question-answer'); ?></span></div>
                        <?php do_action('qa_action_single_answer_content', $qa_meta_best_answer);
                        ?>
                        <?php do_action('qa_action_single_answer_reply', $qa_meta_best_answer);
                        ?>

                    </div>
                    <?php

                endif;


                if ($wp_query->have_posts()) :
                    while ($wp_query->have_posts()) : $wp_query->the_post();

                        $qa_answer_review_value         = get_post_meta(get_the_ID(), 'qa_answer_review_value', true);
                        $qa_answer_review_users_up         = get_post_meta(get_the_ID(), 'qa_answer_review_users_up', true);
                        $qa_answer_review_users_down     = get_post_meta(get_the_ID(), 'qa_answer_review_users_down', true);

                        $reviewd = ($qa_answer_review_users_up > 0 || $qa_answer_review_users_down > 0) ? 'reviewd' : '';

                        $question_id         = get_post_meta(get_the_ID(), 'qa_answer_question_id', true);
                        $best_answer_id        = get_post_meta($question_id, 'qa_meta_best_answer', true);
                        $best_answer_class     = (get_the_ID() == $best_answer_id) ? 'list_best_answer' : '';

                    ?>

                        <div id="single-answer-<?php echo get_the_ID(); ?>" <?php post_class("single-answer $reviewd $best_answer_class"); ?>>
                            <div class="best-answer-ribbon"><span><i class="fa fa-trophy best-answer-icon" aria-hidden="true"></i> <?php echo __('Best Answer', 'question-answer'); ?></span></div>
                            <?php do_action('qa_action_single_answer_content', get_the_ID()); ?>
                            <?php do_action('qa_action_single_answer_reply', get_the_ID()); ?>

                        </div> <?php


                            endwhile;


                                ?>

                    <div class="answer-pagination">



                        <?php

                        $total_pages = $wp_query->max_num_pages;
                        $post_url = get_permalink($question_id);

                        $previous_page = $paged + 1;
                        $previous_page .= "/";
                        if ($paged > 0 && $paged < $total_pages) : ?>
                            <div class="nav previous">
                                <a rel="nofollow" href="<?php echo esc_url($post_url . $previous_page); ?>"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo __('Previuos', 'question-answer'); ?></a>
                            </div>
                        <?php endif; ?>


                        <?php
                        $next_page = $paged - 1;
                        if ($next_page == 1) {
                            $next_page = ""; // if the first page, don't include the "1/" at the end of the URL
                        } else {
                            $next_page .= "/";
                        }
                        if ($paged > 1 && $paged <= $total_pages) : ?>
                            <div class="nav next">
                                <a rel="nofollow" href="<?php echo esc_url($post_url . $next_page); ?>"><?php echo __('Next', 'question-answer'); ?> <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                            </div>
                        <?php endif; ?>

                    </div>









                <?php

                    wp_reset_query();
                endif;
                ?>

            </div> <br>


        </div>

        <?php

        global $qa_css;

        $qa_color_best_answer_background = get_option('qa_color_best_answer_background', true);

        if (!empty($qa_color_best_answer_background)) {

            $qa_css .= '.all-single-answer .list_best_answer .qa-answer-details{ background: ' . $qa_color_best_answer_background . '; }';
        }
    }
}









add_action('qa_action_single_answer_content', 'qa_action_single_answer_vote', 30);
add_action('qa_action_single_answer_content', 'qa_action_single_answer_content', 35);



if (!function_exists('qa_action_single_answer_vote')) {
    function qa_action_single_answer_vote($answer_id)
    {


        $qa_answer_review        = get_post_meta($answer_id, 'qa_answer_review', true);
        $qa_answer_is_private     = get_post_meta($answer_id, 'qa_answer_is_private', true);

        $current_user    = wp_get_current_user();
        $author_id         = get_post_field('post_author', $answer_id);
        $author         = get_userdata($author_id);

        $status         = isset($qa_answer_review['users'][$current_user->ID]['type']) ? $qa_answer_review['users'][$current_user->ID]['type'] : '';
        $votted_up         = ($status == 'up') ? 'votted' : '';
        $votted_down     = ($status == 'down') ? 'votted' : '';

        $review_count     = empty($qa_answer_review['reviews']) ? 0 : (int)$qa_answer_review['reviews'];

        $question_id = get_post_meta($answer_id, 'qa_answer_question_id', true);
        $question_author_id = get_post_field('post_author', $question_id);




        ?>

        <div data-id="<?php echo $answer_id; ?>" class="qa-single-vote qa-single-vote-<?php echo $answer_id; ?>">
            <span class="qa-thumb-up ap-tip vote-up <?php echo $votted_up; ?>" post_id="<?php echo $answer_id; ?>">
                <?php echo apply_filters('qa_filter_answer_vote_up_html', '<i class="fa s_22 fa-thumbs-up"></i>'); ?>
            </span>
            <span class="net-vote-count net-vote-count-<?php echo $answer_id; ?>">
                <?php echo apply_filters('qa_filter_answer_vote_count_html', $review_count); ?>
                <?php //echo $review_count; 
                ?>
            </span>

            <span class="qa-thumb-down ap-tip vote-down <?php echo $votted_down; ?>" post_id="<?php echo $answer_id; ?>">
                <?php echo apply_filters('qa_filter_answer_vote_up_html', '<i class="fa s_22 fa-thumbs-down"></i>'); ?>
            </span>
        </div>

    <?php


    }
}

if (!function_exists('qa_action_single_answer_content')) {
    function qa_action_single_answer_content($answer_id)
    {


        $qa_answer_review        = get_post_meta($answer_id, 'qa_answer_review', true);
        $qa_answer_is_private     = get_post_meta($answer_id, 'qa_answer_is_private', true);

        $current_user    = wp_get_current_user();
        $author_id         = (int) get_post_field('post_author', $answer_id);
        $author         = get_userdata($author_id);

        $loggedin_user_id = $current_user->ID;



        $status         = isset($qa_answer_review['users'][$current_user->ID]['type']) ? $qa_answer_review['users'][$current_user->ID]['type'] : '';
        $votted_up         = ($status == 'up') ? 'votted' : '';
        $votted_down     = ($status == 'down') ? 'votted' : '';

        $review_count     = empty($qa_answer_review['reviews']) ? 0 : (int)$qa_answer_review['reviews'];

        $question_id = get_post_meta($answer_id, 'qa_answer_question_id', true);
        $question_author_id = get_post_field('post_author', $question_id);
        $can_edit_answer         = get_option('qa_can_edit_answer', 'no');




        $answer_data = get_post($answer_id);



        $user_ID        = get_current_user_id();;
        if (!empty($user_ID)) {
            $status = 1;
            $tt_text = '<i class="fa fa-thumbs-down"></i> ' . __('Report this', 'question-answer');
        }

        $qa_flag     = get_post_meta($answer_id, 'qa_flag', true);

        if (empty($qa_flag)) $qa_flag = array();
        $flag_count         = sizeof($qa_flag);




        //echo '<pre>'.var_export($qa_flag, true).'</pre>';


    ?>

        <div class="qa-answer-left">


            <?php

            $avatar_html = '<img class="qa-answer-avatar" src="' . get_avatar_url($author_id) . '" height="55" width="55" />';
            echo apply_filters('qa_filter_answer_author_avatar_html', $avatar_html);

            $question_id         = get_post_meta($answer_id, 'qa_answer_question_id', true);
            $best_answer_id        = get_post_meta($question_id, 'qa_meta_best_answer', true);
            $best_answer_class     = ($answer_id == $best_answer_id) ? 'best_answer' : '';

            $best_answer_html = '<div title="' . __('Choose best answer', 'question-answer') . '" class="qa-best-answer ' . $best_answer_class . '" answer_id="' . $answer_id . '"><i class="fa fa-check" aria-hidden="true"></i></div>';

            echo apply_filters('qa_filter_answer_best_html', $best_answer_html);

            ?>

        </div>

        <div class="qa-answer-details clearfix">
            <div class="qa-answer-metas">

                <?php

                if (empty($author->display_name)) {

                    $author_name = __('Anonymous', 'question-answer');
                } else {
                    $author_name = $author->display_name;
                }

                ?>
                <div href="#" class="qa-user-name qa-user-card-loader" author_id="<?php echo $author_id; ?>" has_loaded="no">
                    <?php echo apply_filters('qa_filter_single_answer_meta_author_name', $author_name); ?>
                    <div class="qa-user-card ">
                        <div class="card-loading">
                            <i class="fa fa-cog fa-spin"></i>
                        </div>
                        <div class="card-data"></div>
                    </div>
                </div>
                <?php


                if ($author_id == $current_user->ID && $can_edit_answer == 'yes') {
                ?>
                    <?php
                    echo apply_filters('qa_filter_single_answer_meta_edit_answer', '<a rel="nofollow" class="qa-edit-answer" href="?answer_edit=' . $answer_id . '">' . __('Edit', 'question-answer') . '</a>');
                    ?>

                <?php
                }

                echo apply_filters('qa_filter_single_answer_meta_post_date', '<a rel="nofollow" title="' . get_the_date('M d, Y h:i A') . '" href="' . get_permalink($question_id) . '#single-answer-' . $answer_id . '" class="qa-answer-date answer-link">' . get_the_date('M d, Y') . '</a>');

                if (array_key_exists($user_ID, $qa_flag) && $qa_flag[$user_ID]['type'] == 'flag') {

                    $flag_text = __('Unflag', 'question-answer');
                } else {

                    $flag_text = __('Flag', 'question-answer');
                }

                echo '<div class="qa-flag qa-flag-action float_right" post_id="' . $answer_id . '"><i class="fa fa-flag flag-icon"></i> <span class="flag-text">' . $flag_text . '</span><span class="flag-count">(' . $flag_count . ')</span> <span class="waiting"><i class="fa fa-cog fa-spin"></i></span> </div>';

                if ($qa_answer_is_private == 1) {

                    echo '<span class="qa-answer-private">';
                    echo apply_filters('qa_filter_single_answer_meta_private', __('Private', 'question-answer'));
                    echo '</span>';
                }
                ?>


            </div>

            <?php
            if ($qa_answer_is_private == '1') {
                $current_user_id = $current_user->ID;

                $access_to_private_answer = get_option('access_to_private_answer', ['administrator']);

                $user = new WP_User($current_user_id);
                $current_user_role = isset($user->roles[0]) ? $user->roles[0] : '';



                if (($author_id == $current_user_id) || in_array($current_user_role, $access_to_private_answer)) {
                    $private_answer_access = 'yes';
                } else {
                    $private_answer_access = 'no';
                }

                $answer_content = wp_specialchars_decode($answer_data->post_content, ENT_QUOTES);

                // if ($author_id == $current_user->ID || in_array('administrator',  wp_get_current_user()->roles) || $question_author_id == $current_user->ID) {

                //     $private_answer_access = 'yes';
                // } else {
                //     $private_answer_access = 'no';
                // }

                if ($private_answer_access == 'yes') {



            ?>
                    <div class="qa-answer-content" id="answer-content-<?php echo $answer_id; ?>" answer_id="<?php echo $answer_id; ?>"> <?php echo wpautop(do_shortcode($answer_content));
                                                                                                                                        ?> </div>
                <?php

                } else {

                ?>
                    <div class="qa-answer-content"> <span class="qa-lock"> <i class="fa fa-lock"></i> <?php echo __('Answer is private, only admins or its author or questioner can read.', 'question-answer'); ?></span></div>
                <?php

                }
            } else {
                $answer_content = wp_specialchars_decode($answer_data->post_content, ENT_QUOTES);

                ?>
                <div class="qa-answer-content" id="answer-content-<?php echo $answer_id; ?>" answer_id="<?php echo $answer_id; ?>"> <?php echo wpautop(do_shortcode($answer_content));
                                                                                                                                    ?> </div>



            <?php

            }

            ?>

        </div>
        <?php


    }
}




add_action('qa_action_single_answer_reply', 'qa_action_single_answer_reply', 10);


if (!function_exists('qa_action_single_answer_reply')) {
    function qa_action_single_answer_reply($answer_id)
    {


        $current_user    = wp_get_current_user();

        $post_id = $answer_id;

        $question_id = (int) get_post_meta($post_id, 'qa_answer_question_id', true);

        $mark_as_close = get_post_meta($question_id, 'mark_as_close', true);

        $qa_who_can_comment_answer = get_option('qa_who_can_comment_answer');
        $author_id     = get_post_field('post_author', $post_id);
        $author     = get_userdata($author_id);

        $qa_answer_is_private     = get_post_meta($post_id, 'qa_answer_is_private', true);

        $question_id = get_post_meta($post_id, 'qa_answer_question_id', true);
        $question_author_id = get_post_field('post_author', $question_id);
        $qa_answer_reply_order = get_option('qa_answer_reply_order', 'DESC');

        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        $current_user_role = array_shift($roles);
        $current_user_ID = get_current_user_id();




        if ($qa_answer_is_private == '1') {
            if ($question_author_id == $current_user->ID || in_array($current_user_role, $qa_who_can_comment_answer) || $author_id == $current_user->ID) {
                $private_answer_access = 'yes';
        ?>
                <div class="qa-answer-comment-reply qa-answer-comment-reply-<?php echo $post_id; ?> clearfix ">
                    <?php

                    $args = array(
                        'post_id'     => $post_id,
                        'order'     => $qa_answer_reply_order,
                        'status'    => 'approve',
                        'number' => 2,
                    );

                    $comments_query = new WP_Comment_Query;
                    $comments = $comments_query->query($args);

                    foreach ($comments as $comment) {
                        $comment_date     = new DateTime($comment->comment_date);
                        $comment_date     = $comment_date->format('M d, Y h:i A');
                        $comment_author    = get_comment_author($comment->comment_ID);
                        $comment_author_user_data = get_user_by('email', $comment->comment_author_email);

                        if (!empty($comment->comment_author)) {
                            $comment_author = $comment->comment_author;
                        } else {
                            $comment_author =  __('Anonymous', 'question-answer');
                        }
                    ?>
                        <div id="comment-<?php echo $comment->comment_ID; ?>" class="qa-single-comment single-reply">
                            <div class="qa-avatar float_left ">
                                <?php echo get_avatar($comment->comment_author_email, "30"); ?>
                            </div>
                            <div class="qa-comment-content">
                                <div class="ap-comment-header">
                                    <div href="#" class="ap-comment-author qa-user-card-loader" author_id="<?php echo $comment_author_user_data->ID; ?>" has_loaded="no">
                                        <?php echo $comment_author; ?>
                                        <div class="qa-user-card">
                                            <div class="card-loading">
                                                <i class="fa fa-cog fa-spin"></i>
                                            </div>
                                            <div class="card-data"></div>
                                        </div>
                                    </div>
                                    - <a rel="nofollow" class="comment-link" href="#comment-<?php echo $comment->comment_ID; ?>"> <?php echo $comment_date; ?></a>
                                </div>
                                <div class="ap-comment-texts">
                                    <?php
                                    ob_start();


                                    qa_filter_badwords(comment_text($comment->comment_ID));
                                    echo ob_get_clean();
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php

                    }
                    ?>
                </div>

                <?php

                if ($current_user_ID == 0) {

                    $qa_page_myaccount = get_option('qa_page_myaccount');
                ?>
                    <a rel="nofollow" class="qa-answer-reply" href="<?php echo get_permalink($qa_page_myaccount); ?> ">
                        <i class="fa fa-sign-in"></i>
                        <span><?php echo __('Sign in to Reply', 'question-answer'); ?></span>
                    </a>
                <?php
                } else {
                ?>
                    <div class="qa-answer-reply" post_id="<?php echo $post_id; ?>">
                        <i class="fa fa-reply"></i>
                        <span><?php echo __('Reply on this', 'question-answer'); ?></span>
                    </div>
            <?php

                }
            } else {
                $private_answer_access = 'no';
            }
        } else {

            ?>
            <div class="qa-answer-comment-reply qa-answer-comment-reply-<?php echo $post_id; ?> clearfix ">

                <?php
                $comments = get_comments(
                    array(
                        'post_id'     => $post_id,
                        'order'     => $qa_answer_reply_order,
                        'status'    => 'approve',
                        'number' => 3,
                    )
                );


                $count_comments = wp_count_comments($post_id);
                $total_comments = $count_comments->approved;
                $comment_remain_count = $total_comments - 3;
                $current_user     = wp_get_current_user();
                $user_ID        = $current_user->ID;
                $status = 1;
                $tt_text = '<i class="fa fa-thumbs-down"></i> ' . __('Report this', 'question-answer');
                if (!empty($user_ID)) {
                }


                foreach ($comments as $comment) {

                    $comment_date     = new DateTime($comment->comment_date);
                    $comment_date     = $comment_date->format('M d, Y h:i A');
                    $comment_author    = get_comment_author($comment->comment_ID);


                    $comment_author_user_data = get_user_by('email', $comment->comment_author_email);

                    if (!empty($comment->comment_author)) {

                        $comment_author = $comment->comment_author;
                    } else {
                        $comment_author =  __('Anonymous', 'question-answer');
                    }


                    $qa_flag_comment     = get_comment_meta($comment->comment_ID, 'qa_flag_comment', true);

                    if (!is_array($qa_flag_comment)) {
                        $qa_flag_comment = array();
                    }


                    $flag_comment_count         = sizeof($qa_flag_comment);

                    //$flag_comment_count 		= count(explode(',', $qa_flag_comment ) ) - 1;
                    //var_export($qa_flag_comment);

                ?>
                    <div id="comment-<?php echo $comment->comment_ID; ?>" class="qa-single-comment single-reply">
                        <div class="qa-avatar float_left ">
                            <?php echo get_avatar($comment->comment_author_email, "30"); ?>

                        </div>
                        <div class="qa-comment-content">
                            <div class="ap-comment-header">
                                <?php

                                if (!empty($comment_author_user_data->display_name)) :
                                ?>
                                    <div class="ap-comment-author qa-user-card-loader" author_id="<?php echo $comment_author_user_data->ID; ?>" has_loaded="no">
                                        <?php echo $comment_author_user_data->display_name; ?>
                                        <div class="qa-user-card">
                                            <div class="card-loading">
                                                <i class="fa fa-cog fa-spin"></i>
                                            </div>
                                            <div class="card-data"></div>
                                        </div>
                                    </div> - <a rel="nofollow" class="comment-link" href="#comment-<?php echo $comment->comment_ID; ?>"> <?php echo $comment_date; ?></a>
                                <?php

                                endif;


                                if (array_key_exists($user_ID, $qa_flag_comment) && $qa_flag_comment[$user_ID]['type'] == 'flag') {

                                    $flag_text = __('Unflag', 'question-answer');
                                } else {

                                    $flag_text = __('Flag', 'question-answer');
                                }

                                ?>
                                <div class="qa-comment-flag qa-comment-flag-action float_right" comment_id="<?php echo $comment->comment_ID; ?>">
                                    <i class="fa fa-flag flag-icon"></i>
                                    <span class="flag-text"><?php echo $flag_text; ?></span>
                                    <span class="flag-count">(<?php echo $flag_comment_count; ?>)</span>
                                    <span class="waiting"><i class="fa fa-cog fa-spin"></i></span>

                                </div>

                                <?php

                                $qa_vote_comment     = get_comment_meta($comment->comment_ID, 'qa_vote_comment', true);
                                if (!is_array($qa_vote_comment)) {
                                    $qa_vote_comment = array();
                                }

                                $down_vote_count = 0;
                                $up_vote_count = 0;

                                if (!empty($qa_vote_comment)) {

                                    foreach ($qa_vote_comment as $comment_vote) {

                                        $type = $comment_vote['type'];

                                        if ($type == 'down') {
                                            $down_vote_count += 1;
                                        } else {
                                            $up_vote_count += 1;
                                        }
                                    }



                                    $vote_count         = $up_vote_count - $down_vote_count;
                                } else {
                                    $vote_count         = 0;
                                }




                                //$vote_count 		= sizeof($qa_vote_comment);
                                $comment_votted_up_class = '';
                                $comment_votted_down_class = '';

                                if (array_key_exists($user_ID, $qa_vote_comment) && $qa_vote_comment[$user_ID]['type'] == 'up') {

                                    $comment_votted_up_class = 'comment-votted';
                                }

                                if (array_key_exists($user_ID, $qa_vote_comment) && $qa_vote_comment[$user_ID]['type'] == 'down') {

                                    $comment_votted_down_class = 'comment-votted';
                                }


                                ?>
                                <div class="comment-vote float_right">
                                    <span vote_type="up" class="comment-thumb-up comment-vote-action <?php echo  $comment_votted_up_class; ?>" comment_id="<?php echo $comment->comment_ID; ?>">
                                        <?php echo apply_filters('qa_filter_comment_vote_up_html', '<i class="fa s_22 fa-thumbs-up"></i>'); ?>
                                    </span>
                                    <span class="comment-vote-count comment-vote-count-<?php echo $comment->comment_ID; ?>">
                                        <?php echo apply_filters('qa_filter_comment_vote_count_html', $vote_count); ?>
                                        <?php //echo $review_count; 
                                        ?>
                                    </span>
                                    <span vote_type="down" class="comment-thumb-down comment-vote-action <?php echo $comment_votted_down_class; ?>" comment_id="<?php echo $comment->comment_ID; ?>">
                                        <?php echo apply_filters('qa_filter_comment_vote_down_html', '<i class="fa s_22 fa-thumbs-down"></i>'); ?>
                                    </span>
                                </div>







                            </div>
                            <div class="ap-comment-texts">
                                <?php

                                ob_start();
                                qa_filter_badwords(comment_text($comment->comment_ID));
                                echo ob_get_clean();


                                ?>
                            </div>
                        </div>

                    </div>
                <?php

                }

                ?>
            </div>

            <?php
            if ($comment_remain_count > 0) :
            ?>
                <a rel="nofollow" total_comments="<?php echo $total_comments; ?>" per_page="3" paged="1" class="qa-load-comments" post_id="<?php echo $post_id; ?>" href="#"><?php echo sprintf(__('<span class="count">%s</span>+ more comments.'), $comment_remain_count); ?> <span class="icon-loading"><i class='fa fa-cog fa-spin'></i></span></a>
            <?php
            endif;
            ?>



            <?php
            if ($mark_as_close != 'yes') :

                if ($current_user_ID == 0) {
                    $qa_page_myaccount = get_option('qa_page_myaccount');

            ?>
                    <a class="qa-answer-reply" href="<?php echo get_permalink($qa_page_myaccount); ?> ">
                        <i class="fa fa-sign-in"></i>
                        <span><?php echo __('Sign in to Reply', 'question-answer'); ?></span>
                    </a>
                <?php
                } else {
                ?>
                    <div class="qa-answer-reply qa-comment-reply" post_id="<?php echo $post_id; ?>">
                        <i class="fa fa-reply"></i>
                        <span><?php echo __('Reply on this', 'question-answer'); ?></span>
                    </div>
        <?php
                }
            endif;
        }


        ?>

        <?php if ($mark_as_close != 'yes') : ?>

            <div class="qa-reply-popup qa-reply-popup-<?php echo $post_id; ?>">
                <div class="qa-reply-form">
                    <span class="close"><i class="fa fa-times"></i></span>
                    <span class="qa-reply-header"><?php echo __('Replying as', 'question-answer'); ?> <?php echo $current_user->display_name; ?></span>
                    <textarea rows="4" cols="40" id="qa-answer-reply-<?php echo $post_id; ?>"></textarea>
                    <span class="qa-reply-form-submit" id="<?php echo $post_id; ?>"><?php echo __('Submit', 'question-answer'); ?></span>
                </div>
            </div>
    <?php endif;
    }
}














add_action('qa_question_user_card', 'qa_question_user_card_cover', 10, 1);
add_action('qa_question_user_card', 'qa_question_user_card_avatar', 10, 1);
add_action('qa_question_user_card', 'qa_question_user_card_author_name', 10, 1);
add_action('qa_question_user_card', 'qa_question_user_card_author_follow', 10, 1);
add_action('qa_question_user_card', 'qa_card_author_total_question', 10, 1);
add_action('qa_question_user_card', 'qa_card_author_total_answer', 10, 1);
add_action('qa_question_user_card', 'qa_card_author_total_comment', 10, 1);
add_action('qa_question_user_card', 'qa_card_author_total_follower', 10, 1);




function qa_question_user_card_cover($author_id)
{

    $author     = get_userdata($author_id);
    $cover_photo = get_user_meta($author_id, 'cover_photo', true);


    if (empty($cover_photo)) {
        $cover_photo = QA_PLUGIN_URL . "assets/front/images/card-cover.jpg";
    }

    $qa_page_user_profile = get_option('qa_page_user_profile');

    $qa_page_user_profile_url = get_permalink($qa_page_user_profile);

    ?>
    <div class="card-cover">
        <a rel="nofollow" href="<?php echo $qa_page_user_profile_url; ?>?id=<?php echo $author_id ?>">
            <img src="<?php echo $cover_photo; ?>" />
        </a>
    </div>
<?php

}

function qa_question_user_card_avatar($author_id)
{

    $author     = get_userdata($author_id);

    $profile_photo = get_user_meta($author_id, 'profile_photo', true);

    if (empty($profile_photo)) {
        $profile_photo = get_avatar_url($author_id, array('size' => '75'));
    }


?>
    <div class="card-avatar">
        <img src="<?php echo $profile_photo; ?>" />
    </div>
<?php

}



function qa_question_user_card_author_name($author_id)
{

    $author     = get_userdata($author_id);
?>
    <div class="card-author-name">
        <?php echo $author->display_name; ?>
    </div>
<?php

}

function qa_question_user_card_author_follow($author_id)
{

    global $wpdb;
    $table = $wpdb->prefix . "qa_follow";
    $logged_user_id = get_current_user_id();

    $follow_result = $wpdb->get_results("SELECT * FROM $table WHERE author_id = '$author_id' AND follower_id = '$logged_user_id'", ARRAY_A);

    $already_insert = $wpdb->num_rows;
    if ($already_insert > 0) {
        $follow_text = __('Following', 'question-answer');
        $follow_class = 'following';
    } else {
        $follow_text = __('Follow', 'question-answer');
        $follow_class = '';
    }


?>
    <div class="card-author-follow qa-follow <?php echo $follow_class; ?>" author_id="<?php echo $author_id; ?>"><?php echo $follow_text;  ?></div>
<?php

}


function qa_card_author_total_question($author_id)
{

    $author_total_question = qa_author_total_question($author_id);
?>
    <div class="card-question-count card-meta"><?php echo sprintf(__("Total question: %s", 'question-answer'), $author_total_question); ?></div>
<?php

}

function qa_card_author_total_answer($author_id)
{

    $author_total_answer = qa_author_total_answer($author_id);
?>
    <div class="card-answer-count card-meta"><?php echo sprintf(__("Total answer: %s", 'question-answer'), $author_total_answer); ?></div>
<?php

}


function qa_card_author_total_comment($author_id)
{

    $author_total_comment = qa_author_total_comment($author_id);
?>
    <div class="card-answer-count card-meta"><?php echo sprintf(__("Total comment: %s", 'question-answer'), $author_total_comment); ?></div>
<?php

}


function qa_card_author_total_follower($author_id)
{

    $author_total_follower = qa_author_total_follower($author_id);
?>
    <div class="card-follower-count card-meta"><?php echo sprintf(__("Total follower: %s", 'question-answer'), $author_total_follower); ?></div>
<?php

}
