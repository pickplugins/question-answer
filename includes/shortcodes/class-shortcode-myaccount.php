<?php

/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

class class_qa_shortcode_myaccount{

    public function __construct(){

		add_shortcode( 'qa_myaccount', array( $this, 'qa_myaccount' ) );
   	}

	public function qa_myaccount($atts, $content = null ) {

		$atts = shortcode_atts( array(

		), $atts);



		ob_start();

		include( QA_PLUGIN_DIR . 'templates/my-account/my-account.php');

		return ob_get_clean();
	}
}


new class_qa_shortcode_myaccount();