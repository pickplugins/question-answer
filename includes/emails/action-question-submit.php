<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	add_action( 'qa_action_after_question_submit', 'qa_email_action_question_submit_function', 10,1 );
	
	if ( ! function_exists( 'qa_email_action_question_submit_function' ) ) {
		function qa_email_action_question_submit_function( $question_ID ) {
			
			global $current_user;
			$question_data = get_post( $question_ID );
			
			$vars = array(
				'{site_name}'=> get_bloginfo('name'),
				'{site_description}' => get_bloginfo('description'),
				'{site_url}' => get_bloginfo('url'),						
				'{site_logo_url}' => get_option('question_bm_logo_url'),
			  
				'{user_name}' => $current_user->display_name,						  
				'{user_avatar}' => get_avatar( $current_user->ID, 60 ),
				'{user_email}' => '',
			
				'{question_title}'  => $question_data->post_title,						  			
				'{question_url}'  => get_permalink($question_ID),
				'{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',						
				'{question_id}'  => $question_ID,
				'{question_content}'  => $question_data->post_content,												
			);

			$admin_email = get_option('admin_email');
			$class_qa_email_templates_design = new class_qa_email_templates_design();
		
			$qa_email_templates_data = get_option( 'qa_email_templates_data' );
				
			if( empty( $qa_email_templates_data ) ) {
				
				$templates_data = $class_qa_email_templates_design->qa_email_templates_data();
			} else {

				$templates_data = $class_qa_email_templates_design->qa_email_templates_data();
				$templates_data =array_merge($templates_data, $qa_email_templates_data);
			}
			
			$email_body = strtr($templates_data['new_question_submitted']['html'], $vars);
			$email_subject =strtr($templates_data['new_question_submitted']['subject'], $vars);
		
			$qa_email_on_question_submission = get_option( 'qa_email_on_question_submission', 'yes' );
			
			if( $qa_email_on_question_submission == 'yes' )
			$class_qa_email_templates_design->qa_send_email( $admin_email, $email_subject, $email_body );
		}
	}
	
	
	
	
	
	
	