<?php


if ( ! defined('ABSPATH')) exit;  // if direct access


$class_qa_functions = new class_qa_functions();
//var_dump(qa_get_categories());

$category = '';

$tax_query = array();
if( !empty($_GET['category']) || !empty($category) ){

    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : $category;
    $tax_query[] = array(
        array(
            'taxonomy' => 'question_cat',
            'field' => 'slug',
            'terms' => $category,
        )
    );
}


$order_by	= empty( $_GET['order_by'] ) ? '' : sanitize_text_field( $_GET['order_by'] );
$filter_by 	= isset( $_GET['filter_by'] ) ? sanitize_text_field( $_GET['filter_by'] ) : '';
$order_by	= empty( $_GET['order_by'] ) ? '' : sanitize_text_field( $_GET['order_by'] );
$order 	= isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : '';



$qa_page_myaccount = get_option('qa_page_myaccount');
$dashboard_page_url = get_permalink($qa_page_myaccount);

	?>

<div class="top-nav">
    <div class="nav-left">


        <?php
        $current_filter = isset($_GET['filter']) ? $_GET['filter'] : 'dashboard';
        $qa_page_question_archive = get_option('qa_page_question_archive');
        $qa_page_question_archive_url = get_permalink($qa_page_question_archive);

        ?>
        <div class="item <?php echo ($current_filter == 'dashboard') ? 'active' : ''; ?>"><a href="<?php echo $dashboard_page_url; ?>"><i class="fas fa-bars"></i></a></div>

        <div class="item <?php echo ($current_filter == 'recent') ? 'active' : ''; ?>"><a href="<?php echo $qa_page_question_archive_url; ?>?filter=recent"><i class="fas fa-history"></i> <?php echo __('Recent','question-answer'); ?></a></div>
        <div class="item <?php echo ($current_filter == 'top_viewed') ? 'active' : ''; ?>"><a href="<?php echo $qa_page_question_archive_url; ?>?filter=top_viewed"><i class="fas fa-binoculars"></i> <?php echo __('Top Viewed','question-answer'); ?></a></div>
        <div class="item <?php echo ($current_filter == 'featured') ? 'active' : ''; ?>"><a href="<?php echo $qa_page_question_archive_url; ?>?filter=featured"><i class="far fa-star"></i> <?php echo __('Featured','question-answer'); ?></a></div>
        <div class="item <?php echo ($current_filter == 'solved') ? 'active' : ''; ?>"><a href="<?php echo $qa_page_question_archive_url; ?>?filter=solved"><i class="fas fa-tasks"></i> <?php echo __('Solved','question-answer'); ?></a></div>
        <div class="item <?php echo ($current_filter == 'unsolved') ? 'active' : ''; ?>"><a href="<?php echo $qa_page_question_archive_url; ?>?filter=unsolved"><i class="fas fa-list-ul"></i> <?php echo __('Unsolved','question-answer'); ?></a></div>


        <div class="item search"><i class="fas fa-search" aria-hidden="true"></i>

            <div class="question-search">
                <form action="<?php echo $qa_page_question_archive_url; ?>" method="get">
                    <div class="form-field">
                        <div class="input-title"><?php echo __('Keyword','question-answer'); ?></div>
                        <div class="input-field">
                            <input autocomplete="off" placeholder="Write..."  type="text" value="" name="qa-keyword">
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="input-title"><?php echo __('Select Category','question-answer'); ?></div>
                        <div class="input-field">
                            <select name="qa_category">
                                <option value=""><?php echo __('All categories', 'question-answer'); ?></option>
                                <?php

                                foreach( qa_get_categories() as $cat_id => $cat_info ) {
                                    ksort($cat_info);

                                    $this_category = get_term( $cat_id );

                                    //var_dump($this_category);

                                    //if(!empty($this_category))
                                    foreach( $cat_info as $key => $value ) {

                                        //var_dump($category);

                                        if( $key == 0 )  {
                                            ?><option <?php selected( $this_category->slug, $category ); ?> value="<?php echo $this_category->slug; ?>"><?php echo $value; ?></option><?php
                                        } else {
                                            $this_category = get_category( $key );

                                            ?><option <?php selected( $this_category->slug, $category ); ?> value="<?php echo $this_category->slug; ?>">  - <?php echo $value; ?></option> <?php
                                        }
                                    }
                                } ?>

                            </select>
                        </div>
                    </div>






                    <div class="form-field">
                        <div class="input-title"><?php echo __('Question Status','question-answer'); ?></div>
                        <div class="input-field">
                            <select id="filter_by" name="question_status"> <?php
                                $status = $class_qa_functions->qa_question_status();
                                foreach( $status as $key => $value ) {
                                    ?><option <?php selected( $key, $filter_by ); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
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

        <div class="item ask-question"><a href="<?php echo $qa_page_question_post_url; ?>"><i class="fas fa-question-circle"></i> <?php echo __('Ask Question','question-answer'); ?></a></div>

        <?php
        if( is_user_logged_in() ):



        $userid = get_current_user_id();
        $paged = 1;
        global $wpdb;
        $PER_PAGE = 10;

        $total_entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}qa_notification WHERE subscriber_id='$userid' ORDER BY id DESC" );


        $OFFSET 	= ($paged - 1) * $PER_PAGE;
        $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}qa_notification WHERE subscriber_id='$userid' ORDER BY id DESC LIMIT $PER_PAGE  OFFSET $OFFSET" );
        //$wdm_downloads = $wpdb->get_results( $entries, OBJECT );

        $entries_unread = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}qa_notification WHERE subscriber_id='$userid' AND status='unread' ORDER BY id DESC LIMIT $PER_PAGE  OFFSET $OFFSET" );

        $total_unread_count = count($entries_unread);


        ?>









        <div class="item notifications">

            <i class="fas fa-bell"></i>
            <span class="count"><?php if($total_unread_count >=20) echo __('20+','question-answer'); else echo $total_unread_count; ?></span>

            <div class="notification-wrapper">
                <div class="notification-list-top">

                    <span class="mark-all-read"><?php echo sprintf(__('%s Mark all as read',  'question-answer'), '<i class="far fa-check-circle"></i>'); ?></span>

                </div>
                <div class="notification-list">

                    <div class="list-items">
                        <?php

                        if(!empty($entries)):
                        foreach( $entries as $entry ){


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

                        $user = get_user_by( 'ID', $user_id);

                        if(!empty($user->display_name)){
                            $user_display_name = $user->display_name;
                        }
                        else{
                            $user_display_name = __('Anonymous', 'question-answer');
                        }


                        if($status=='unread'){
                            $notify_mark_html = '<span class="notify-mark" notify_id="'.$id.'" >
                            <i class="far fa-bell"></i>
                            </span>';
                        }
                        else{
                            $notify_mark_html = '<span class="notify-mark" notify_id="'.$id.'" ><i class="far fa-bell-slash"></i></span>';
                        }

                        //var_dump($id);

                        ?>

                        <div class="item item-<?php echo $id; ?> <?php if($status == 'unread') echo $status; ?>">
                            <?php


                            echo '<img src="'.get_avatar_url($user_id,  array('size'=>40)).'" class="thumb">';

                            if( $action == 'new_question' ) {

                                echo '<span class="name">'.$user_display_name.'</span> '.__('posted', 'question-answer').' <span class="action">'.__('New Question',  'question-answer').'</span> <a href="'.get_permalink($q_id).'" class="link">'.get_the_title($q_id).'</a> ';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php

                            }

                            elseif( $action == 'new_answer' ) {


                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Answered', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#single-answer-'.$a_id.'" class="link">'.get_the_title($q_id).'</a> ';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php

                            }


                            elseif( $action == 'best_answer' ) {

                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Choosed best answer', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#single-answer-'.$a_id.'" class="link">'.get_the_title($a_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php


                            }

                            elseif( $action == 'best_answer_removed' ) {

                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Removed best answer', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#single-answer-'.$a_id.'" class="link">'.get_the_title($a_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php


                            }

                            elseif($action=='new_comment'){

                                $comment_post_data = get_comment( $c_id );

                                if(!empty($comment_post_data->comment_post_ID)):

                                    $comment_post_id = $comment_post_data->comment_post_ID;

                                    $comment_post_type = get_post_type($comment_post_id);

                                    if($comment_post_type=='answer'){

                                        $flag_post_type = 'answer';

                                        $q_id = get_post_meta( $comment_post_id, 'qa_answer_question_id', true );


                                    }
                                    else{
                                        $flag_post_type = 'question';


                                    }

                                    $q_id = get_post_meta( $a_id, 'qa_answer_question_id', true );
                                    echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Commented', 'question-answer').'</span> on '.$flag_post_type.' <a href="'.get_permalink($q_id).'#comment-'.$c_id.'" class="link">'.get_the_title($a_id).'</a>';

                                    ?>
                                    <div class="meta">

                                        <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                        <?php echo $notify_mark_html; ?>
                                    </div>
                                <?php


                                endif;


                            }



                            elseif($action=='comment_flag'){

                                $comment_post_data = get_comment( $c_id );
                                $comment_post_id = $comment_post_data->comment_post_ID ;

                                $comment_post_type = get_post_type($comment_post_id);

                                if($comment_post_type=='answer'){

                                    $flag_post_type = 'answer';
                                    $link_extra = '#comment-'.$c_id;
                                    $q_id = get_post_meta( $comment_post_id, 'qa_answer_question_id', true );
                                }
                                else{
                                    $flag_post_type = 'question';
                                    $link_extra = '#comment-'.$c_id;
                                    $q_id = $comment_post_id;
                                }



                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Flagged comment', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#comment-'.$c_id.'" class="link">'.get_the_title($q_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php



                            }


                            elseif($action=='comment_vote_up'){

                                $comment_post_data = get_comment( $c_id );
                                $comment_post_id = $comment_post_data->comment_post_ID ;

                                $comment_post_type = get_post_type($comment_post_id);

                                if($comment_post_type=='answer'){

                                    $flag_post_type = 'answer';
                                    $link_extra = '#comment-'.$c_id;
                                    $q_id = get_post_meta( $comment_post_id, 'qa_answer_question_id', true );
                                }
                                else{
                                    $flag_post_type = 'question';
                                    $link_extra = '#comment-'.$c_id;
                                    $q_id = $comment_post_id;
                                }



                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('comment vote up', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#comment-'.$c_id.'" class="link">'.get_the_title($q_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php



                            }

                            elseif($action=='comment_vote_down'){

                                $comment_post_data = get_comment( $c_id );
                                $comment_post_id = $comment_post_data->comment_post_ID ;

                                $comment_post_type = get_post_type($comment_post_id);

                                if($comment_post_type=='answer'){

                                    $flag_post_type = 'answer';
                                    $link_extra = '#comment-'.$c_id;
                                    $q_id = get_post_meta( $comment_post_id, 'qa_answer_question_id', true );
                                }
                                else{
                                    $flag_post_type = 'question';
                                    $link_extra = '#comment-'.$c_id;
                                    $q_id = $comment_post_id;
                                }



                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('comment vote down', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#comment-'.$c_id.'" class="link">'.get_the_title($q_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php


                            }








                            elseif($action=='vote_up'){

                                $q_id = get_post_meta( $a_id, 'qa_answer_question_id', true );
                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Vote Up', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#single-answer-'.$a_id.'" class="link">'.get_the_title($a_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php



                            }
                            elseif($action=='vote_down'){

                                $q_id = get_post_meta( $a_id, 'qa_answer_question_id', true );
                                echo ' <span class="name">'.$user_display_name.'</span> <span class="action">'.__('Vote Down', 'question-answer').'</span> <a href="'.get_permalink($q_id).'#single-answer-'.$a_id.'" class="link">'.get_the_title($a_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php



                            }


                            elseif($action=='q_solved'){

                                echo ' <span class="name">'.$user_display_name.'</span> '.__('marked', 'question-answer').' <span class="action">'.__('Solved', 'question-answer').'</span> <a href="'.get_permalink($q_id).'" class="link">'.get_the_title($q_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php


                            }

                            elseif($action=='q_not_solved'){

                                echo ' <span class="name">'.$user_display_name.'</span> '.__('marked', 'question-answer').' <span class="action">'.__('Not Solved','question-answer').'</span> <a href="'.get_permalink($q_id).'" class="link">'.get_the_title($q_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php


                            }

                            elseif($action=='flag'){

                                if(!empty($a_id)){

                                    $flag_post_type = 'answer';
                                    $link_extra = '#single-answer-'.$a_id;
                                    $q_id = get_post_meta( $a_id, 'qa_answer_question_id', true );
                                    $post_id = $a_id;
                                }
                                if(!empty($q_id)){

                                    $flag_post_type = 'question';
                                    $link_extra = '';
                                    $post_id = $q_id;
                                }




                                echo ' <span class="name">'.$user_display_name.'</span> '.sprintf(__('flagged your %s', 'question-answer'), $flag_post_type).' <span class="name"></span> <a href="'.get_permalink($q_id).$link_extra.'" class="link">'.get_the_title($post_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php


                            }

                            elseif($action=='unflag'){

                                if(!empty($a_id)){

                                    $flag_post_type = 'answer';
                                    $link_extra = '#single-answer-'.$a_id;
                                }
                                else{

                                    $flag_post_type = 'question';
                                    $link_extra = '';
                                }


                                $q_id = get_post_meta( $a_id, 'qa_answer_question_id', true );
                                echo ' <span class="name">'.$user_display_name.'</span> '.$flag_post_type.' <span class="action">'.__('unflagged ', 'question-answer').'</span> <a href="'.get_permalink($q_id).$link_extra.'" class="link">'.get_the_title($q_id).'</a>';

                                ?>
                                <div class="meta">

                                    <span class="notify-time"><i class="far fa-clock"></i> <?php echo $datetime; ?></span>
                                    <?php echo $notify_mark_html; ?>
                                </div>
                                <?php



                            }

                            ?>
                        </div> <!-- .item -->
                            <?php

                            }
                            else:

                                ?>
                                <div class="empty-notify item"><i class="fa fa-bell-slash-o" aria-hidden="true"></i> <?php echo __('No notification right now.', 'question-answer'); ?></div>
                            <?php
                            endif;

                            ?>
                        </div>

                </div>
                <div class="notification-list-bottom">
                    <div class="load-notifications" pagenum="2"><span class="spinner"><i class="fas fa-spinner fa-spin"></i></span><?php echo __('Load more','question-answer'); ?></div>
                </div>
            </div>


        </div>

        <?php
        endif;
        ?>

    </div>
    <div class="clear"></div>


</div>
