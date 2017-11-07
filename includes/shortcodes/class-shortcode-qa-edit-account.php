<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_qa_shortcode_qa_edit_account{
	
    public function __construct(){
		add_shortcode( 'qa_edit_account', array( $this, 'qa_edit_account' ) );
   	}	
		
	public function qa_edit_account($atts, $content = null ) {
			
		$atts = shortcode_atts( array(
					
		), $atts);

		global $current_user;
		$current_user_id = get_current_user_id();


		if(isset($_POST['qa_edit_account_hidden'])){

		}

		if(isset($_POST['_wpnonce']) && wp_verify_nonce( $_POST['_wpnonce'], 'qa_edit_account_nonce' ) && $_POST['qa_edit_account_hidden'] == 'Y') {

			wp_update_user( array( 'ID' => $current_user_id, ' user_email' => sanitize_email($_POST['user_email']) ) );
			wp_update_user( array( 'ID' => $current_user_id, 'user_url' => esc_url($_POST['user_url']) ) );

			update_user_meta( $current_user_id, 'description' , sanitize_text_field($_POST['description']) );

		}
		else{

		}




		ob_start();

		?>
		<div class="qa-edit-account">

			<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
				<input type="hidden" name="qa_edit_account_hidden" value="Y">

				<div class="item">
					<div class="header"><?php echo __('Email', 'question-answer'); ?></div>
					<input type="email" name="user_email" value="<?php echo $current_user->user_email; ?>" />
				</div>

				<div class="item">
					<div class="header"><?php echo __('Website', 'question-answer'); ?></div>
					<input type="text" name="user_url" value="<?php echo $current_user->user_url; ?>" />
				</div>

				<div class="item">
					<div class="header"><?php echo __('Biographical Info', 'question-answer'); ?></div>
					<textarea name="description"><?php echo $current_user->description; ?></textarea>
				</div>

				<?php wp_nonce_field( 'qa_edit_account_nonce' ); ?>
				<input type="submit" value="<?php echo __('Update', 'question-answer'); ?>">

			</form>


		</div>
		<?php

		//include( QA_PLUGIN_DIR . 'templates/my-account/my-account.php');

		return ob_get_clean();
	}
}


new class_qa_shortcode_qa_edit_account();