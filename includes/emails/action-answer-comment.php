<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	add_action('qa_action_answer_comment', 'qa_email_action_answer_comment_function', 10 );
	
	if ( ! function_exists( 'qa_email_action_answer_comment_function' ) ) {
		function qa_email_action_answer_comment_function( $comment_ID ) {
			
			$comment_data = get_comment($comment_ID);
			$comment_content = $comment_data->comment_content;			
			$answer_ID = $comment_data->comment_post_ID;
			$answer_data = get_post( $answer_ID );
			
			
			if( $answer_data->post_type == 'answer' ):
			
			$qa_answer_question_id = get_post_meta( $answer_ID, 'qa_answer_question_id', true );
			
			$question_url = get_permalink($qa_answer_question_id);			
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
			
				'{question_url}'  => $question_url,				
			
				'{answer_title}'  => $answer_data->post_title,						  			
				'{answer_url}'  => $answer_url,
				'{answer_edit_url}'  => get_admin_url().'post.php?post='.$answer_ID.'&action=edit',						
				'{answer_id}'  => $answer_ID,
				'{answer_content}'  => $answer_data->post_content,
				
				'{comment_content}'  => $comment_content,	
				'{comment_url}'  => $question_url.'#comment-'.$comment_ID,							
																
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
			
			$email_body = strtr($templates_data['answer_comment']['html'], $vars);
			$email_subject =strtr($templates_data['answer_comment']['subject'], $vars);
		
			$qa_email_on_answer_published = get_option( 'qa_email_on_answer_published', 'yes' );
			

			if( $qa_email_on_answer_published == 'yes' ){

				$a_subscriber = get_post_meta($answer_ID, 'a_subscriber', true);
				if(is_array($a_subscriber))
				foreach($a_subscriber as $subscriber){
					$subscriber_data = get_user_by('id', $subscriber);
					
					//update_option('hello_answer',$subscriber_data->user_email); // testing

					$class_qa_email_templates_design->qa_send_email( $subscriber_data->user_email, $email_subject, $email_body );
					}
 
				//$class_qa_email_templates_design->qa_send_email( $admin_email, $email_subject, $email_body );
				}
			
			endif;
		}
	}
	
	
	
	
	
	
	