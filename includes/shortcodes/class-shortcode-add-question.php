<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_qa_shortcode_add_question{
	
    public function __construct(){
		add_shortcode( 'qa_add_question', array( $this, 'qa_add_question_display' ) );
   	}	
	
	public function qa_add_question_display($atts, $content = null ) {
			
		$atts = shortcode_atts( array(
					
		), $atts);


        $qa_account_required_post_question = get_option('qa_account_required_post_question');
        $qa_page_myaccount = get_option('qa_page_myaccount');
        $dashboard_page_url = get_permalink($qa_page_myaccount);

        if($qa_account_required_post_question == 'yes' && !is_user_logged_in()){

            do_action('qa_submit_question_login_required');

            return apply_filters('qa_submit_question_login_required_text', sprintf(__('%s Please <a href="%s">login</a> to submit question.', 'question-answer'), '<i class="fas fa-sign-in-alt"></i>', $dashboard_page_url));

        }



        include( QA_PLUGIN_DIR . 'templates/add-question/add-question-hook.php');

		ob_start();
		include( QA_PLUGIN_DIR . 'templates/add-question/add-question-new.php');
		return ob_get_clean();
	}
	
} new class_qa_shortcode_add_question();