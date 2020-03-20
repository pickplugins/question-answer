<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	add_action('publish_answer', 'qa_email_action_answer_published_function', 10 );
	
	if ( ! function_exists( 'qa_email_action_answer_published_function' ) ) {
		function qa_email_action_answer_submitted_function( $answer_ID ) {
			
			$answer_data = get_post( $answer_ID );
			if( $answer_data->post_type === 'answer' ):
			
			$qa_answer_question_id = get_post_meta( $answer_ID, 'qa_answer_question_id', true );
			$answer_url = get_permalink($qa_answer_question_id);
			
			global $current_user;
			$vars = array(
				'{site_name}'=> get_bloginfo('name'),
				'{site_description}' => get_bloginfo('description'),
				'{site_url}' => get_bloginfo('url'),						
				'{site_logo_url}' => get_option('question_bm_logo_url'),
			  
				'{user_name}' => $current_user->display_name,						  
				'{user_avatar}' => get_avatar( $current_user->ID, 60 ),
				'{user_email}' => '',
			
				'{answer_title}'  => $answer_data->post_title,						  			
				'{answer_url}'  => $answer_url,
				'{answer_edit_url}'  => get_admin_url().'post.php?post='.$answer_ID.'&action=edit',						
				'{answer_id}'  => $answer_ID,
				'{answer_content}'  => $answer_data->post_content,												
			);

			$admin_email = get_option('admin_email');
			$class_qa_emails = new class_qa_emails();
		
			$qa_email_templates_data = get_option( 'qa_email_templates_data' );
				
			if( empty( $qa_email_templates_data ) ) {
				
				$templates_data = $class_qa_emails->qa_email_templates_data();
			} else {

				$templates_data = $class_qa_emails->qa_email_templates_data();
				$templates_data =array_merge($templates_data, $qa_email_templates_data);
			}
			
			$email_body = strtr($templates_data['new_answer_published']['html'], $vars);
			$email_subject =strtr($templates_data['new_answer_published']['subject'], $vars);
		
			$qa_email_on_answer_published = get_option( 'qa_email_on_answer_published', 'yes' );
			
			if( $qa_email_on_answer_published == 'yes' )
			$class_qa_emails->qa_send_email( $admin_email, $email_subject, $email_body );
			
			endif;
		}
	}
	
	
	
	
	
	
	