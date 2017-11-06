<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_qa_dashboard{
	
	public function __construct() {

		//add_action('add_meta_boxes', array($this, 'meta_boxes_question'));
		//add_action('save_post', array($this, 'meta_boxes_question_save'));


		add_shortcode( 'qa_dashboard', array( $this, 'qa_dashboard' ) );

		add_filter('qa_filter_dashboard_account', array( $this, 'my_account_html' ));
		add_filter('qa_filter_dashboard_account_edit', array( $this, 'edit_account_html' ));
		add_filter('qa_filter_dashboard_my_questions', array( $this, 'my_questions' ));



	}

	function my_account_html(){

		return do_shortcode('[qa_my_account]');

	}

	function edit_account_html(){

		return do_shortcode('[qa_edit_account]');

	}

	function my_questions(){

		return do_shortcode('[qa_my_questions]');

	}


	function dashboard_tabs(){

		$tabs['account'] =array(
			'title'=>__('Account', 'question-answer'),
			'html'=>apply_filters('qa_filter_dashboard_account',''),

		);


		$tabs['account_edit'] =array(
			'title'=>__('Account Edit', 'question-answer'),
			'html'=>apply_filters('qa_filter_dashboard_account_edit',''),

		);

		$tabs['my_questions'] =array(
			'title'=>__('My Questions', 'question-answer'),
			'html'=>apply_filters('qa_filter_dashboard_my_questions',''),

		);


		return apply_filters('qa_filter_dashboard_tabs',$tabs);

	}



	public function qa_dashboard($atts, $content = null ) {
		$atts = shortcode_atts(
			array(

				'id' => 'flat',
			), $atts);

		ob_start();


		$qa_page_myaccount_id = get_option('qa_page_myaccount');
		$qa_page_myaccount_url = get_permalink($qa_page_myaccount_id);


		?>
		<div class="qa-dashboard">
			<?php


			if (is_user_logged_in() ):

				$dashboard_tabs = $this->dashboard_tabs();


				?>
				<ul class="navs">
					<?php


					foreach($dashboard_tabs as $tabs_key=>$tabs){

						$title = $tabs['title'];
						$html = $tabs['html'];


						?>
						<li>
							<a href="<?php echo $qa_page_myaccount_url; ?>?tabs=<?php echo $tabs_key; ?>">
								<?php echo $title; ?>
							</a>

						</li>
						<?php



					}
					?>
				</ul>
				<?php





				?>
				<div class="navs-content">
					<?php

					if(!empty($_GET['tabs'])){
						$current_tabs = sanitize_text_field($_GET['tabs']);

						//echo '<pre>'.var_export($current_tabs, true).'</pre>';

					}
					else{
						$current_tabs = 'account';

					}


					foreach($dashboard_tabs as $tabs_key=>$tabs){

						$title = $tabs['title'];
						$html = $tabs['html'];

						if($current_tabs==$tabs_key):

							?>
							<div class="<?php echo $tabs_key; ?>">
								<?php echo $html; ?>
							</div>
							<?php

						endif;


					}
					?>
				</div>
				<?php


			else:

			endif;

			?>
		</div>
		<?php

		return ob_get_clean();
	}



} new class_qa_dashboard();