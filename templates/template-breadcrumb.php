<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	
	function qa_breadcrumb_menu(){
		
			$class_qa_functions = new class_qa_functions();
			$menu_items = $class_qa_functions->qa_breadcrumb_menu_items_function();
		
		
			foreach( $menu_items as $item_key => $item_details ) {
				
				$link 	= isset( $item_details['link'] ) ? $item_details['link'] : '';
				$title 	= isset( $item_details['title'] ) ? $item_details['title'] : '';
				
				echo  '<div class="item '.$item_key.'"><a href="'.$link.'">'.$title.'</a></div>';
				
			}
		
		}
		
		
	add_action('qa_breadcrumb_menu','qa_breadcrumb_menu');
	
	add_action('qa_breadcrumb_menu','qa_breadcrumb_menu_notifications');	
	
	
	
	
	
	
	
	
	
	function qa_breadcrumb_links($action){
		
		$archive_page_id = get_option( 'qa_page_question_archive' );
		$archive_page_title = empty( $archive_page_id ) ? __('Question Archive', 'question-answer') : get_the_title( $archive_page_id );
		$archive_page_href = empty( $archive_page_id ) ? '#' : get_the_permalink( $archive_page_id );
		
		echo apply_filters( 'qa_filter_breadcrumb_question_archive_link_html', sprintf( '<i class="fa fa-angle-double-right separator" aria-hidden="true"></i> <a class="link" href="%s">%s</a>', $archive_page_href, $archive_page_title ) );
		
		if( is_single() ) 
		echo apply_filters( 'qa_filter_breadcrumb_single_question_title_html', sprintf( ' <i class="fa fa-angle-double-right separator" aria-hidden="true"></i> <a class="link" href="#" >%s</a>', get_the_title() ) );
		
	}
		
		
	add_action('qa_breadcrumb_links','qa_breadcrumb_links');
	
		
	
	
	
	
	
	
	
?>
	
	
<div class="qa-breadcrumb">
	
        <?php
		
		do_action('qa_action_breadcrumb_before');
		

		$total_found = qa_breadcrumb_total_count();

		if($total_found>0){
			$pending_class= 'pending';
			if($total_found>10 && $total_found<20){
				
				$total_found = '10+';
				}

        }

		else{
			$pending_class= '';
			}
		
		?> 
    
    
    <div class="menu-box">
    	<i class="fa fa-bars"></i>
		<?php
        if(is_user_logged_in()){
			?>
            <i class="bubble <?php echo $pending_class; ?>"><?php echo $total_found; ?></i>    
            <?php
			
			}
		?>
        
        <div class="menu-box-hover">
        <?php do_action('qa_breadcrumb_menu'); ?>
        </div>
    </div>
    
	
	
    <div class="links">
    <?php do_action('qa_breadcrumb_links'); ?>
    </div> 

	
</div>