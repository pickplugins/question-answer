<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_qa_dashboard{
	
	public function __construct() {

		add_shortcode( 'qa_dashboard', array( $this, 'qa_dashboard' ) );

	}




	public function qa_dashboard($atts, $content = null ) {
		$atts = shortcode_atts(
			array(

				'id' => 'flat',
			), $atts);

		ob_start();

		?>
        <div class="question-answer">
            <div class="dashboard">
                <?php

                do_action('question_answer_dashboard', $atts);

                ?>
            </div>
        </div>

		<?php

		return ob_get_clean();
	}



} new class_qa_dashboard();