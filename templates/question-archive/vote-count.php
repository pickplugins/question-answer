<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 


	
	global $qa_css;
	
	$qa_color_archive_view_count = get_option( 'qa_color_archive_view_count' );
	if( empty( $qa_color_archive_view_count ) ) $qa_color_archive_view_count = '';

	
	$qa_css .= ".questions-archive .view-count{ color: $qa_color_archive_view_count; }";
	


    $qa_answer_review		= get_post_meta( get_the_ID(), 'qa_answer_review', true );
    $review_count 	= empty( $qa_answer_review['reviews'] ) ? 0 : (int)$qa_answer_review['reviews'];
	
	if(empty($qa_view_count)){$qa_view_count = 0;}
	
	?>
	<div class="question-side-box">
	<span class="vote-count"><?php echo apply_filters('qa_filter_answer_vote_count_html', $review_count); ?></span><span class="vote-text"><?php echo __('Vote', 'question-answer'); ?></span>
	</div>   
