<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	add_action( 'qa_action_answer_vote_up', 'qa_email_action_answer_voteup_function', 10 );
	
	if ( ! function_exists( 'qa_email_action_answer_voteup_function' ) ) {
		function qa_email_action_answer_voteup_function( $answer_ID ) {
			
			//update_option( 'qa_check_action', 'sdsds' );
			
			
			
			
			global $current_user;
			$question_ID 	= get_post_meta($answer_ID, 'qa_answer_question_id', true);
			$question_data 	= get_post( $question_ID );
			$answer_data 	= get_post( $answer_ID );			
			
			$question_url = get_permalink($question_ID);

			$vars = array(
				'{site_name}'=> get_bloginfo('name'),
				'{site_description}' => get_bloginfo('description'),
				'{site_url}' => get_bloginfo('url'),						
				'{site_logo_url}' => get_option('question_bm_logo_url'),
			  
				'{user_name}' => $current_user->display_name,						  
				'{user_avatar}' => get_avatar( $current_user->ID, 60 ),
				'{user_email}' => '',
			
				'{question_title}'  => $question_data->post_title,						  			
				'{question_url}'  => $question_url,
				'{question_edit_url}'  => get_admin_url().'post.php?post='.$question_ID.'&action=edit',						
				'{question_id}'  => $question_ID,
				'{question_content}'  => $question_data->post_content,	
				
				'{answer_url}'  => $question_url.'#single-answer-'.$answer_ID,
				'{answer_title}'  => $answer_data->post_title,					
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
			
			$email_body = strtr($templates_data['answer_voteup']['html'], $vars);
			$email_subject =strtr($templates_data['answer_voteup']['subject'], $vars);
		
			$qa_email_on_answer_voting = get_option( 'qa_email_on_answer_voting', 'yes' );
			
			if( $qa_email_on_answer_voting == 'yes' ){

				$answer_post_data 	= get_post( $answer_ID );
				$author_data = get_user_by('id', $answer_post_data->post_author);
				//update_option( 'qa_check_action', $author_data->user_email );
				
				$class_qa_emails->qa_send_email( $author_data->user_email, $email_subject, $email_body );
				
				}
			
		}
	}
	
	
	
	
	
	
	