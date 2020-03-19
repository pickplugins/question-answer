<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 




$q_subscriber = get_post_meta(get_the_id(), 'q_subscriber', true);
$last_activity_user_id = get_post_meta(get_the_id(), 'last_activity_user_id', true);


$q_subscriber_count = count($q_subscriber);

if(!empty($last_activity_user_id)){
    $last_subscriber_data = get_user_by('ID', $last_activity_user_id);
    $last_subscriber_name = isset($last_subscriber_data->display_name) ? $last_subscriber_data->display_name : __('Anonymous','question-answer');
}




	?>

<div class="meta">


    <?php
    $qa_question_status = get_post_meta( get_the_ID(), 'qa_question_status', true );
    if( $qa_question_status == 'solved' ){
        $is_solved_class = 'solved';
        $is_solved_icon = '<i class="fa fa-check-circle"></i>';
        $is_solved_text = __('Solved', 'question-answer');
    }
    else{
        $is_solved_class = 'not-solved';
        $is_solved_icon = '<i class="fa fa-times"></i>';
        $is_solved_text = __('Not Solved', 'question-answer');
    }
    ?>

    <a href="<?php echo '?filter_by=solved'; ?>" class="is-solved <?php echo $is_solved_class; ?>"><?php  echo $is_solved_icon.' '.$is_solved_text; ?></a>

    <span><?php echo __('Asked by', 'question-answer'); ?> <a href="<?php echo '?user_slug='.get_the_author_meta('user_login'); ?>" class="author"><?php echo get_the_author_meta('display_name'); ?></a></span>

    <?php if( !empty($category) ) { ?>
        <a href="<?php echo '?category='.$category[0]->slug; ?>" class="category"><i class="fa fa-folder-open"></i> <?php echo $category[0]->name; ?></a>
    <?php } ?>
    <a href="<?php echo '?date='.get_the_date('d-m-Y'); ?>" class="date"><i class="fa fa-clock-o"></i> <?php echo get_the_date('M d, Y'); ?></a>

    <?php if(!empty($last_subscriber_name)): ?>
    <span class="meta answered-by"><?php echo sprintf(__('Last replied by %s', 'question-answer'), $last_subscriber_name); ?></span>
    <?php endif; ?>
</div>