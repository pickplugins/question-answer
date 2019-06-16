<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



add_action( 'qa_action_before_single_question', 'qa_action_before_single_question_top_nav', 0 );
	
add_action( 'qa_action_single_question_main', 'qa_action_admin_actions_function', 0 );
add_action( 'qa_action_single_question_main', 'qa_action_single_question_content_function', 0 );
add_action( 'qa_action_single_question_meta', 'qa_action_single_question_meta_function', 10 );
add_action( 'qa_action_single_question_main', 'qa_action_single_question_social_share_function', 0 );
add_action( 'qa_action_single_question_main', 'qa_action_single_question_subscriber_function', 0 );
add_action( 'qa_action_single_question_main', 'qa_action_answer_posting_function', 0 );
add_action( 'qa_action_single_question_main', 'qa_action_answer_section_function', 0 );
add_action( 'qa_action_single_answer_content', 'qa_action_single_answer_vote_function', 10 );
add_action( 'qa_action_single_answer_content', 'qa_action_single_answer_content_function', 10 );
add_action( 'qa_action_single_answer_reply', 'qa_action_single_answer_reply_function', 10 );



if ( ! function_exists( 'qa_action_before_single_question_top_nav' ) ) {
    function qa_action_before_single_question_top_nav() {
        include( QA_PLUGIN_DIR. 'templates/single-question/top-nav.php');
    }
}



	// Answer action functions
	if ( ! function_exists( 'qa_action_answer_section_function' ) ) {
		function qa_action_answer_section_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/answer-section.php');
		}
	}
	
	
	if ( ! function_exists( 'qa_action_single_answer_vote_function' ) ) {
		function qa_action_single_answer_vote_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/answer-vote.php');
		}
	}	
	
	if ( ! function_exists( 'qa_action_single_answer_content_function' ) ) {
		function qa_action_single_answer_content_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/answer-content.php');
		}
	}
	
	if ( ! function_exists( 'qa_action_answer_posting_function' ) ) {
		function qa_action_answer_posting_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/answer-posting.php');
		}
	}
	
	if ( ! function_exists( 'qa_action_single_answer_reply_function' ) ) {
		function qa_action_single_answer_reply_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/answer-reply.php');
		}
	}
	

	
	


	if ( ! function_exists( 'qa_action_admin_actions_function' ) ) {
	    function qa_action_admin_actions_function() {
		    include( QA_PLUGIN_DIR. 'templates/single-question/admin-actions.php');
	    }
	}







	
	if ( ! function_exists( 'qa_action_single_question_meta_function' ) ) {
		function qa_action_single_question_meta_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/meta.php');
		}
	}


	if ( ! function_exists( 'qa_action_single_question_content_function' ) ) {
		function qa_action_single_question_content_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/content.php');
		}
	}
	
	if ( ! function_exists( 'qa_action_single_question_social_share_function' ) ) {
		function qa_action_single_question_social_share_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/social-share.php');
		}
	}
	
	if ( ! function_exists( 'qa_action_single_question_subscriber_function' ) ) {
		function qa_action_single_question_subscriber_function() {
			include( QA_PLUGIN_DIR. 'templates/single-question/subscriber.php');
		}
	}
	



	add_action( 'qa_action_question_edit', 'qa_action_question_edit_title', 10 );

	if ( ! function_exists( 'qa_action_question_edit_title' ) ) {
	    function qa_action_question_edit_title() {
		    include( QA_PLUGIN_DIR. 'templates/single-question/question-edit.php');
	    }
	}


add_action( 'qa_action_answer_edit', 'qa_action_answer_edit_html', 10 );

if ( ! function_exists( 'qa_action_answer_edit_html' ) ) {
	function qa_action_answer_edit_html() {
		include( QA_PLUGIN_DIR. 'templates/single-question/answer-edit.php');
	}
}









