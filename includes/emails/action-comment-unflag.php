<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


	add_action( 'qa_action_comment_unflag', 'qa_email_action_comment_unflag_function', 10 );
	
	if ( ! function_exists( 'qa_email_action_comment_unflag_function' ) ) {
		function qa_email_action_comment_unflag_function( $comment_ID ) {
			
			global $current_user;
			
			
			$comment = get_comment( $comment_ID ); 
			$comment_content = $comment->comment_content;	
			
			$question_ID = $comment->comment_post_ID ;
			$question_data = get_post( $question_ID );
		
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
			
			$email_body = strtr($templates_data['comment_unflag']['html'], $vars);
			$email_subject =strtr($templates_data['comment_unflag']['subject'], $vars);
		
			$qa_email_on_comment_unflagged = get_option( 'qa_email_on_comment_unflagged', 'yes' );
			
			if( $qa_email_on_comment_unflagged == 'yes' ){
				
				//update_option('hello_answer',$email_body);
				//update_option('hello_answer',$comment->comment_author_email);
				$class_qa_email_templates_design->qa_send_email( $comment->comment_author_email, $email_subject, $email_body );
				
				}
			
		}
	}
	
	
	
	
	
	
	