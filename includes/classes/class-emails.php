<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_job_bm_emails{
	
	public function __construct(){


		}



		
		
	public function job_bm_send_email($email_data){
		

		
		$email_to = isset($email_data['email_to']) ? $email_data['email_to'] : '';
        $email_bcc = isset($email_data['email_bcc']) ? $email_data['email_bcc'] : '';

		$email_from = isset($email_data['email_from']) ? $email_data['email_from'] : get_option('admin_email');
		$email_from_name = isset($email_data['email_from_name']) ? $email_data['email_from_name'] : get_bloginfo('name');
		$subject = isset($email_data['subject']) ? $email_data['subject'] : '';
		$email_body = isset($email_data['html']) ? $email_data['html'] : '';
		$attachments = isset($email_data['attachments']) ? $email_data['attachments'] : '';
					

		$headers = array();
		$headers[] = "From: ".$email_from_name." <".$email_from.">";
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-Type: text/html; charset=UTF-8";
        if(!empty($email_bcc)){
            $headers[] = "Bcc: ".$email_bcc;
        }
        $headers = apply_filters('job_bm_mail_headers', $headers);

		$status = wp_mail($email_to, $subject, $email_body, $headers, $attachments);

        return $status;
		
		}	
		
		
		
		
		

	public function job_bm_email_templates_data(){
		
		$templates_data_html = array();
        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');




		include( QA_PLUGIN_DIR.'templates/emails/answer_comment.php');
        include( QA_PLUGIN_DIR.'templates/emails/answer_votedown.php');
        include( QA_PLUGIN_DIR.'templates/emails/answer_voteup.php');
        include( QA_PLUGIN_DIR.'templates/emails/comment_flag.php');
        include( QA_PLUGIN_DIR.'templates/emails/comment_unflag.php');
        include( QA_PLUGIN_DIR.'templates/emails/new_answer_published.php');
        include( QA_PLUGIN_DIR.'templates/emails/new_answer_submitted.php');
        include( QA_PLUGIN_DIR.'templates/emails/new_question_published.php');
        include( QA_PLUGIN_DIR.'templates/emails/new_question_submitted.php');
        include( QA_PLUGIN_DIR.'templates/emails/question_solved.php');
        include( QA_PLUGIN_DIR.'templates/emails/question_unsolved.php');





		
		$templates_data = array(

            'new_question_submitted'=>array(
                'name'=>__('New Question Submitted', 'job-board-manager'),
                'description'=>__('Notification email for when new question submitted.', 'job-board-manager'),
                'subject'=>__('New Question Submitted - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['new_question_submitted'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),

            'new_question_published'=>array(
                'name'=>__('New question published', 'job-board-manager'),
                'description'=>__('Notification email for when new question published.', 'job-board-manager'),
                'subject'=>__('New Question Published - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['new_question_published'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),

            'new_answer_submitted'=>array(
                'name'=>__('New Answer Submitted', 'job-board-manager'),
                'description'=>__('Notification email for new answer submitted.', 'job-board-manager'),
                'subject'=>__('New Answer Submitted - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['new_answer_submitted'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),

            'new_answer_published'=>array(
                'name'=>__('New Answer Published', 'job-board-manager'),
                'description'=>__('Notification email for new answer published.', 'job-board-manager'),
                'subject'=>__('New Answer Published - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['new_answer_published'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),

            'question_solved'=>array(
                'name'=>__('Question solved', 'job-board-manager'),
                'description'=>__('Notification email for question solved.', 'job-board-manager'),
                'subject'=>__('Question solved - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['question_solved'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),


            'question_unsolved'=>array(
                'name'=>__('Question unsolved', 'job-board-manager'),
                'description'=>__('Notification email for Question unsolved.', 'job-board-manager'),
                'subject'=>__('Question unsolved - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['question_unsolved'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),



            'comment_flag'=>array(
                'name'=>__('Comment flag', 'job-board-manager'),
                'description'=>__('Notification email for admin when Comment flag.', 'job-board-manager'),
                'subject'=>__('Comment flag - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['comment_flag'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),


            'comment_unflag'=>array(
                'name'=>__('Comment unflag', 'job-board-manager'),
                'description'=>__('Notification email for Comment unflag.', 'job-board-manager'),
                'subject'=>__('Comment unflag - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['comment_unflag'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),

            'answer_voteup'=>array(
                'name'=>__('Answer Voted Up', 'job-board-manager'),
                'description'=>__('Notification email for Answer Voted Up.', 'job-board-manager'),
                'subject'=>__('Answer voted up - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['answer_voteup'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),


            'answer_votedown'=>array(
                'name'=>__('Answer Voted Down', 'job-board-manager'),
                'description'=>__('Notification email for answer voted down.', 'job-board-manager'),
                'subject'=>__('Answer voted down - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['answer_votedown'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),

            'answer_comment'=>array(
                'name'=>__('Answer Comment', 'job-board-manager'),
                'description'=>__('Notification email for Answer Comment.', 'job-board-manager'),
                'subject'=>__('Answer comment - {site_url}', 'job-board-manager'),
                'html'=>$templates_data_html['answer_comment'],
                'email_to'=>$admin_email,
                'email_from'=>$admin_email,
                'email_from_name'=> $site_name,
                'enable'=> 'yes',
            ),
			
			

		);
		
		$templates_data = apply_filters('job_bm_email_templates_data', $templates_data);
		
		return $templates_data;

		}
		


	public function email_templates_parameters(){



        $parameters = array(

            'new_question_submitted'=>array(
                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',


                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),

            ),

            'new_question_published'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),

            'new_answer_submitted'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{answer_id}'  => 'Answer ID',
                    '{answer_title}'  => 'Answer title',
                    '{answer_url}'  => 'Answer post URL',
                    '{answer_edit_url}'  => 'Answer admin post edit URL',
                    '{answer_author_id}'  => 'Answer post author ID',
                    '{answer_author_name}'  => 'Answer post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),

            'new_answer_published'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{answer_id}'  => 'Answer ID',
                    '{answer_title}'  => 'Answer title',
                    '{answer_url}'  => 'Answer post URL',
                    '{answer_edit_url}'  => 'Answer admin post edit URL',
                    '{answer_author_id}'  => 'Answer post author ID',
                    '{answer_author_name}'  => 'Answer post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),

            'question_solved'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),


            'question_unsolved'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),



            'comment_flag'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{comment_id}'  => 'Comment ID',
                    '{comment_url}'  => 'Comment post URL',
                    '{comment_edit_url}'  => 'Comment admin post edit URL',
                    '{comment_author_id}'  => 'Comment post author ID',
                    '{comment_author_name}'  => 'Comment post author name',


                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),


            'comment_unflag'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{comment_id}'  => 'Comment ID',
                    '{comment_url}'  => 'Comment post URL',
                    '{comment_edit_url}'  => 'Comment admin post edit URL',
                    '{comment_author_id}'  => 'Comment post author ID',
                    '{comment_author_name}'  => 'Comment post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),

            'answer_voteup'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{answer_id}'  => 'Answer ID',
                    '{answer_title}'  => 'Answer title',
                    '{answer_url}'  => 'Answer post URL',
                    '{answer_edit_url}'  => 'Answer admin post edit URL',
                    '{answer_author_id}'  => 'Answer post author ID',
                    '{answer_author_name}'  => 'Answer post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),


            'answer_votedown'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{answer_id}'  => 'Answer ID',
                    '{answer_title}'  => 'Answer title',
                    '{answer_url}'  => 'Answer post URL',
                    '{answer_edit_url}'  => 'Answer admin post edit URL',
                    '{answer_author_id}'  => 'Answer post author ID',
                    '{answer_author_name}'  => 'Answer post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),

            'answer_comment'=>array(

                'parameters'=> array(
                    '{site_url}'=>'Website Home URL',
                    '{site_description}'=>'Website tagline',
                    '{site_logo_url}'=>'Logo url',

                    '{question_id}'  => 'Question ID',
                    '{question_title}'  => 'Question title',
                    '{question_url}'  => 'Question post URL',
                    '{question_edit_url}'  => 'Question admin post edit URL',
                    '{question_author_id}'  => 'Question post author ID',
                    '{question_author_name}'  => 'Question post author name',

                    '{answer_id}'  => 'Answer ID',
                    '{answer_title}'  => 'Answer title',
                    '{answer_url}'  => 'Answer post URL',
                    '{answer_edit_url}'  => 'Answer admin post edit URL',
                    '{answer_author_id}'  => 'Answer post author ID',
                    '{answer_author_name}'  => 'Answer post author name',

                    '{current_user_id}'  => 'Logged-in user ID',
                    '{current_user_name}'  => 'Logged-in user display name',
                    '{current_user_avatar}'  =>'Logged-in user avatar',
                ),
            ),



        );
		
												
			$parameters = apply_filters('job_bm_emails_templates_param',$parameters);
		
		
			return $parameters;
		
		}
		

	}
	
new class_job_bm_emails();