<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	global $current_user;
	$qa_account_required_post_answer = get_option( 'qa_account_required_post_answer', 'yes' );
	$qa_submitted_answer_status = get_option( 'qa_submitted_answer_status', 'pending' );
	$qa_options_quick_notes = get_option( 'qa_options_quick_notes' );
	$qa_who_can_comment_answer = get_option( 'qa_who_can_comment_answer' );
    $qa_who_can_see_quick_notes = get_option( 'qa_who_can_see_quick_notes' );
    $qa_answer_editor_media_buttons = get_option( 'qa_answer_editor_media_buttons', 'no' );


    if(empty($qa_who_can_see_quick_notes)) $qa_who_can_see_quick_notes = array('administrator');

    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    $current_user_role = array_shift( $roles );
	
	//var_dump($current_user_role);
	//var_dump($qa_answer_editor_media_buttons);
	
	if(!empty($qa_who_can_answer) && !in_array( $current_user_role, $qa_who_can_answer)){
		return;
		}
	
?>

<div class="answer-post  clearfix">
	
	<div class="answer-post-header" _status="0">
		<span class="fs_18"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo __('Submit Answer', 'question-answer');?></span>
		<i class="fa fa-expand fs_28 float_right apost_header_status"></i>		
	</div>
	
	
<?php 

	if ( !is_user_logged_in() ) {
		if( $qa_account_required_post_answer=='yes' ){
			

			
			echo sprintf( __('<form class="nodisplay">Please <a href="%s">login</a> to submit answer.</form>', 'question-answer'), wp_login_url($_SERVER['REQUEST_URI'])  ) ;
			
			// Closing div .answer-post
			echo '</div>';
			return;
		}
	}
?>
	
	<?php do_action( 'qa_action_before_answer_post_form' ); ?>

	<form class="form-answer-post pickform" style="display: none;"  enctype="multipart/form-data"  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="hidden_answer_post" value="Y">
    <?php 

//var_dump($qa_options_quick_notes);
?>

        
        <?php
        
		if(!empty($qa_options_quick_notes) && !empty($current_user_role) && in_array( $current_user_role, $qa_who_can_see_quick_notes) ){
			
        ?>
    	<div class="quick-notes">
        <strong><?php echo __('Quick notes', 'question-answer'); ?></strong>
        <?php
			
			foreach($qa_options_quick_notes as $note){

			    if(!empty($note))
				echo '<input onclick="this.select();" type="text" value="'.$note.'" />';
				
				}
			
			?>
            </div>
            <?php
			
			}

		?>
   
<?php 
	$editor_id 		= 'qa-answer-editor';
	$editor_content	= '';
	$checked		= '';

	if ( !empty($_POST['hidden_answer_post']) ) {

        $nonce = sanitize_text_field($_POST['_wpnonce']);
        if(wp_verify_nonce( $nonce, 'nonce_answer_post' ) && $_POST['hidden_answer_post'] == 'Y') {}
        else return;



		$is_private 	= isset( $_POST['is_private'] ) ? sanitize_text_field($_POST['is_private']) : '';
		$editor_content = isset( $_POST[$editor_id] ) ? $_POST[$editor_id] : '';
		
		
		$filter = apply_filters( 'qa_filter_kses', array(
			'a'             => array(
				'href'  => array(),
				'title' => array()
			),
			'br'            => array(),
			'em'            => array(),
			'strong'        => array(),
			'code'          => array(
				'class' => array()
			),
			'pre'          => array(
				'class' => array()
			),			
			
			'blockquote'    => array(),
			'quote'         => array(),
			'span'          => array(
				'style' 	=> array()
			),
			'img'           => array(
				'src'    	=> array(),
				'alt'    	=> array(),
				'width'  	=> array(),
				'height' 	=> array(),
				'style'  	=> array()
			),
			'ul'            => array(),
			'li'            => array(),
			'ol'            => array(),
		));

		//$answer_content = wp_kses( $editor_content, $filter );
		$answer_content = $editor_content;		
		
		
		if ( $is_private == 1 ) $checked = 'checked';
		
		if ( !empty( $editor_content) ) {
			
			$new_answer_post = array(
				'post_type'		=> 'answer',
				'post_title'    => __('#Replay', 'question-answer').' - '.qa_shorten_string($answer_content) .' by '. $current_user->user_login ,
				'post_status'   => $qa_submitted_answer_status,
				'post_content'  => $answer_content,
			  
			);
			$new_answer_post_ID = wp_insert_post($new_answer_post, true);
			
			echo "<script>jQuery(document).ready(function(jQuery) { 
				jQuery('.answer-post-header').trigger( 'click' ); 
				
				jQuery('html, body').delay(300).animate({
					scrollTop: jQuery('.answer-post-header').offset().top - 50
				}, 1500);
				
			});</script>";
			
			echo "<div class='validations'><div class='success'>";
			
			echo apply_filters( "qa_filter_answer_submit_success_message", "<i class='fa fa-check'></i>".__("Answer submitted", 'question-answer'), $new_answer_post_ID );
			
			echo "</div><div class='success'>";
			
			echo apply_filters( "qa_filter_answer_submit_status_message", "<i class='fa fa-check'></i>". __('Status', 'question-answer').": $qa_submitted_answer_status", $new_answer_post_ID );
			
			echo "</div></div>";
			
			$userid = get_current_user_id();
			
			$q_id = get_the_ID();
			$a_id = $new_answer_post_ID;
			$c_id = '';
			$user_id = $userid;
			$action = 'new_answer';

			do_action('qa_action_notification_save', $q_id, $a_id, $c_id, $user_id, $action);
			do_action( 'qa_email_action_question_submit', $q_id );
			
			
			/*
			By answering subscribe to question.
			*/
			$q_subscriber = get_post_meta(get_the_ID(), 'q_subscriber', true);
			
			if(empty($q_subscriber)){
				update_post_meta(get_the_ID(),'q_subscriber',array($userid) );
				
				}
			else{
				
				if(!in_array($userid,$q_subscriber)){
					
					$q_subscriber = array_merge($q_subscriber, array($userid));
					update_post_meta(get_the_ID(),'q_subscriber',$q_subscriber );
					
					}

				
				}
			
		
					
			update_post_meta($new_answer_post_ID,'qa_answer_question_id', get_the_ID() );
			update_post_meta($new_answer_post_ID,'qa_answer_is_private', $is_private );
			
			wp_safe_redirect( wp_get_referer() );
			$editor_content = '';
			}
		else{
			
			echo '<div class="validations">';
			echo '<div class="failed"><i class="fa fa-exclamation-circle"></i> '.__('Content is empty.', 'question-answer').'</div>';
			
			echo '</div>';
			
			}

	}

	$editor_settings['editor_height'] = 150;
    $editor_settings['tinymce'] = true;
    $editor_settings['quicktags'] = true;
    $editor_settings['media_buttons'] = false;
    $editor_settings['drag_drop_upload'] = true;

    if($qa_answer_editor_media_buttons == 'yes'){

        $editor_settings['media_buttons'] = true;

    }

    wp_editor($editor_content, $editor_id, $editor_settings);
?>
	<br>
	<div class="qa_tt">
		<label for="is_private">
			<input id="is_private" type="checkbox" <?php echo $checked; ?> class="" value="1" name="is_private" />
			<?php echo __('Make your answer private.', 'question-answer'); ?>
		</label>
		
	</div>
	<br><br>
	<div class="qa_tt">
		
        <?php wp_nonce_field( 'nonce_answer_post' ); ?>
		<input id="is_private" type="submit" class="submit submit_answer_button" value="<?php echo __('Submit Answer','question-answer'); ?>" />
		<span class="qa_ttt"><?php echo __('Your answer will be under review.', 'question-answer'); ?></span>
		
	</div>
	
	</form>
	
	
	<?php do_action( 'qa_action_after_answer_post_form' ); ?>
	
</div> <!-- .answer-post -->


