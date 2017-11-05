<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	
echo '<div class="meta-list clearfix">';

/*
 Title: Post Category HTML
 Filter: qa_filter_single_question_meta_category
*/		

	$category = get_the_terms(get_the_ID(), 'question_cat');
	if(!empty($category[0])){
		echo apply_filters( 'qa_filter_single_question_meta_category', sprintf( '<span class="qa-meta-item">%s %s</span>', '<i class="fa fa-folder-open"></i>', $category[0]->name ) );
	}
	
	
	
	
	
/*
 Title: Post Date HTML
 Filter: qa_filter_single_question_meta_post_date
*/	

  echo apply_filters( 'qa_filter_single_question_meta_post_date', sprintf( '<span class="qa-meta-item">%s %s</span>', '<i class="fa fa-clock-o"></i>', get_the_date('M d, Y h:i A') ) );
  // echo apply_filters( 'qa_filter_single_question_meta_post_date', sprintf( __('<span title="'.get_the_date().'" class="qa-meta-item">%s %s</span>', QA_TEXTDOMAIN), '<i class="fa fa-clock-o"></i>', qa_post_duration(get_the_ID()) ) );    
	
	//var_dump(get_the_date());
	
    //echo qa_post_duration(get_the_ID());
	
	
	
/*
 Title: Answer Count HTML
 Filter: qa_filter_single_question_meta_answer_count
*/	
	
	$wp_query_answer = new WP_Query(
		array (
			'post_type' 	=> 'answer',
			'post_status' 	=> 'publish',
			'meta_query' => array(
				array(
					'key'     => 'qa_answer_question_id',
					'value'   => get_the_ID(),
					'compare' => '=',
				),
			),
	) );
	
   echo apply_filters( 'qa_filter_single_question_meta_answer_count', sprintf('<span class="qa-meta-item">%s %s '.__('Answers', QA_TEXTDOMAIN).'</span>', '<i class="fa fa-comments"></i>', number_format_i18n($wp_query_answer->found_posts)) );

   wp_reset_query();
   
   
   
/*
 Title: Is Solved HTML
 Filter: qa_filter_single_question_meta_is_solved_html
*/	

	$current_user 	= wp_get_current_user();
	$author_id 		= get_post_field( 'post_author', get_the_ID() );
	
	$is_solved = get_post_meta( get_the_ID(), 'qa_question_status', true );
	
	if( $is_solved == 'solved' ){
		$is_solved_icon = '<i class="fa fa-check"></i>';		
		$is_solved_status = __('Solved', QA_TEXTDOMAIN);
		$is_solved_class = 'solved';
		$qa_ttt 			= 'Mark as Unsolved';		
		
	} else {
		
		$is_solved_icon 	= '<i class="fa fa-times"></i>';	
		$is_solved_status 	= __('Mark as Solved', QA_TEXTDOMAIN);
		$is_solved_class 	= 'not-solved';
		$qa_ttt 			= __('Mark as Solved', QA_TEXTDOMAIN);
	}

	if( $current_user->ID == $author_id || in_array( 'administrator', $current_user->roles ) ) { 
    	echo apply_filters( 'qa_filter_single_question_meta_is_solved_html', sprintf( '<div class="qa_tt"><span class="qa-meta-item qa-is-solved %s" post_id="%s">%s %s</span><span class="qa_ttt">%s</span></div>', $is_solved_class, get_the_ID(), $is_solved_icon, $is_solved_status, $qa_ttt ) );
	}
	
	
	
	
	
/*
 Title: Subscriber HTML
 Filter: qa_filter_single_question_meta_subscriber_html
*/	

	$q_subscriber = get_post_meta( get_the_ID(), 'q_subscriber', true );

	if(is_array($q_subscriber) && in_array($current_user->ID, $q_subscriber)){

		$subscribe_icon = '<i class="fa fa-bell"></i>';		
		$subscribe_class = 'subscribed';
		$qa_ttt_text = __('Subscribed', QA_TEXTDOMAIN);		
	
	} else {
	
		$subscribe_icon = '<i class="fa fa-bell-slash"></i>';	
		$subscribe_class = 'not-subscribed';
		$qa_ttt_text = __('Subscribe', QA_TEXTDOMAIN);	
	}

	echo apply_filters( 'qa_filter_single_question_meta_subscriber_html', sprintf( '<div class="qa_tt"><span class="qa-meta-item qa-subscribe %s" post_id="%s">%s</span><span class="qa_ttt">%s</span></div>', $subscribe_class, get_the_ID(), $subscribe_icon, $qa_ttt_text ) );

	
	
	
	
/*
 Title: Featured HTML
 Filter: qa_filter_single_question_meta_featured_html
*/	
	
	if(current_user_can('administrator') ){
		
	$qa_featured_questions 	= get_option( 'qa_featured_questions', array() );
	$featured_class 		= in_array( get_the_ID(), $qa_featured_questions ) ? 'qa-featured-yes' : 'qa-featured-no';
	$featured_icon 			= '<i class="fa fa-star" aria-hidden="true"></i>';

	echo apply_filters( 'qa_filter_single_question_meta_featured_html', sprintf( '<span class="qa-meta-item qa-featured %s" post_id="%s">%s</span>', $featured_class, get_the_ID(), $featured_icon ) );
		
		
		}
	


   
    
	echo '</div> <br class="clearfix" />';


?>
