<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

	$qa_answer_review		= get_post_meta( get_the_ID(), 'qa_answer_review', true );
	$qa_answer_is_private 	= get_post_meta( get_the_ID(), 'qa_answer_is_private', true );
	
	$current_user	= wp_get_current_user();
	$author_id 		= get_post_field( 'post_author', get_the_ID() );
	$author 		= get_userdata($author_id);
	
	$status 		= isset( $qa_answer_review['users'][$current_user->ID]['type'] ) ? $qa_answer_review['users'][$current_user->ID]['type'] : '';
	$votted_up 		= ( $status == 'up' ) ? 'votted' : ''; 
	$votted_down 	= ( $status == 'down' ) ? 'votted' : ''; 
	
	$review_count 	= empty( $qa_answer_review['reviews'] ) ? 0 : (int)$qa_answer_review['reviews'];
	
	$question_id = get_post_meta( get_the_ID(), 'qa_answer_question_id', true );
	$question_author_id = get_post_field( 'post_author', $question_id );
	
	//var_dump($question_author_id);






$user_ID		= get_current_user_id();;
if( !empty($user_ID) ) {
    $status = 1;
    $tt_text = '<i class="fa fa-thumbs-down"></i> '.__('Report this', QA_TEXTDOMAIN);
}

$qa_flag 	= get_post_meta( get_the_ID(), 'qa_flag', true );

if(empty($qa_flag)) $qa_flag = array();
$flag_count 		= sizeof($qa_flag);




//echo '<pre>'.var_export($qa_flag, true).'</pre>';


?>

    <div class="qa-answer-left"> 
    
    	
		<?php 
		
		$avatar_html = '<img class="qa-answer-avatar" src="'.get_avatar_url($author_id).'" height="55" width="55" />';
		echo apply_filters('qa_filter_answer_author_avatar_html', $avatar_html); ?>
		
		<?php 
		
		$question_id 		= get_post_meta( get_the_ID(), 'qa_answer_question_id', true );
		$best_answer_id		= get_post_meta( $question_id, 'qa_meta_best_answer', true );
		$best_answer_class 	= ( get_the_ID() == $best_answer_id ) ? 'best_answer' : ''; 
		
		$best_answer_html = '<div title="'.__('Choose best answer', QA_TEXTDOMAIN).'" class="qa-best-answer '.$best_answer_class.'" answer_id="'.get_the_ID().'"><i class="fa fa-check" aria-hidden="true"></i></div>';
		
		echo apply_filters('qa_filter_answer_best_html', $best_answer_html);
		
		//echo apply_filters('qa_filter_answer_best_html', sprintf( '<div title="Choose best answer" class="qa-best-answer %s" answer_id="%s">%s</div>', $best_answer_class, get_the_ID(), '<i class="fa fa-check" aria-hidden="true"></i>' ) ); ?>
		
	</div>

    <div class="qa-answer-details clearfix">
        <div class="qa-answer-metas">
				
             <?php
            // include(ABSPATH.'wp-admin/includes/user.php. ');
			// echo '<pre>'.var_export($author->roles, true).'</pre>';
			 
			// $all_roles = get_editable_roles();
			 
			 ?>
                
                
			<?php echo apply_filters( 'qa_filter_single_answer_meta_author_name', '<a  href="#" class="qa-user-name">'.$author->display_name.'</a>' ); ?>
            
            <?php 
			
			if(!empty($author->roles))
			echo apply_filters( 'qa_filter_single_answer_meta_author_role', '<span class="qa-user-role">'.ucfirst(implode(', ', $author->roles)).'</span>', $author_id);  ?>
            <?php echo apply_filters( 'qa_filter_single_answer_meta_post_date', '<a href="'.get_permalink($question_id).'#single-answer-'.get_the_ID().'" class="qa-answer-date answer-link">'.get_the_date('M d, Y h:i A').'</a>' ); ?>

            
            <?php
    
            if( $author_id== $current_user->ID ){ 
			
			echo '<span class="qa-edit-answer">';
            echo apply_filters( 'qa_filter_single_answer_meta_edit_answer', '<a href="?answer-edit='.get_the_ID().'#single-answer-'.get_the_ID().'">'.__('Edit', QA_TEXTDOMAIN).'</a>' );
            echo '</span>';     
            }


             if( array_key_exists($user_ID, $qa_flag) && $qa_flag[$user_ID]['type']=='flag'  ) {

                $flag_text = __('Unflag', QA_TEXTDOMAIN);

             } else {

                 $flag_text = __('Flag', QA_TEXTDOMAIN);
             }

             echo '<div class="qa-flag qa-flag-action float_right" post_id="'.get_the_ID().'"><i class="fa fa-flag flag-icon"></i> <span class="flag-text">'.$flag_text.'</span><span class="flag-count">('.$flag_count.')</span> <span class="waiting"><i class="fa fa-cog fa-spin"></i></span> </div>';

             ?>




            <?php







            ?>
            
          
            
            <?php if( $qa_answer_is_private == 1 ){
				
				echo '<span class="qa-answer-private">';
				echo apply_filters( 'qa_filter_single_answer_meta_private', __('Private', QA_TEXTDOMAIN) );
				echo '</span>';
				}  
				?>
            
        
		</div>
			
		<?php if ( $qa_answer_is_private == '1' ) { 
		
		if( $author_id== $current_user->ID || in_array('administrator',  wp_get_current_user()->roles) || $question_author_id == $current_user->ID ){
			
			$private_answer_access = 'yes';
			
			}
		else{
			$private_answer_access = 'no';
			}

		if($private_answer_access=='yes'){
			
				?>
				<div class="qa-answer-content" id="answer-content-<?php echo get_the_ID(); ?>" answer_id="<?php echo get_the_ID(); ?>"> <?php the_content(); ?> </div>
				<?php
			
			}
		else{
			
			?>
			<div class="qa-answer-content"> <span class="qa-lock"> <i class="fa fa-lock"></i> <?php echo __('Answer is private, only admins or its author or questioner can read.',QA_TEXTDOMAIN); ?></span></div>	
			<?php 
			
			}
		//var_dump($private_answer_access);
		

			} 
		else {
			
			?>
            <div class="qa-answer-content" id="answer-content-<?php echo get_the_ID(); ?>" answer_id="<?php echo get_the_ID(); ?>"> <?php the_content(); ?> </div>
            
            
            
            <?php
			
			} 
			
			?>
		
	</div>