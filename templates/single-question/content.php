<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

?>

<?php do_action('qa_action_single_question_content_before');


//var_dump(get_the_ID());

	$author_id 	= get_post_field( 'post_author', get_the_ID() );
	$author 	= get_userdata($author_id);
	
	$polls = get_post_meta(get_the_ID(), 'polls', true);

    $qa_flag 	= get_post_meta( get_the_ID(), 'qa_flag', true );

    if(empty($qa_flag)) $qa_flag = array();
    $flag_count 		= sizeof($qa_flag);
    $user_ID		= get_current_user_id();


//echo '<pre>'.var_export($polls, true).'</pre>';

	if(!empty($polls) && is_serialized($polls) ){
		$polls = unserialize($polls);
		}

		//echo '<pre>'.var_export($polls, true).'</pre>';

	
	$author_name = !empty( $author->display_name ) ? $author->display_name : $author->user_login; 
	$author_role = !empty( $author->roles ) ? $author->roles[0] : __('Anonymous', 'question-answer');
	$author_date = !empty( $author->user_registered ) ? $author->user_registered : 'N/A'; 
	
	
	$comments = get_comments( array(
		'post_id' 	=> get_the_ID(), 
		'order' 	=> 'ASC', 
		'status'	=> 'approve', 
	) );
	
	$qa_allow_question_comment = get_option( 'qa_allow_question_comment', 'yes' );
	if( $qa_allow_question_comment == 'no' ) $comments = array();


global $qa_css;

$qa_color_single_user_role = get_option( 'qa_color_single_user_role' );
if( empty( $qa_color_single_user_role ) ) $qa_color_single_user_role = '';

$qa_color_single_user_role_background = get_option( 'qa_color_single_user_role_background' );
if( empty( $qa_color_single_user_role_background ) ) $qa_color_single_user_role_background = '';

$qa_color_add_comment_background = get_option( 'qa_color_add_comment_background' );
if( empty( $qa_color_add_comment_background ) ) $qa_color_add_comment_background = '';

$qa_flag_button_bg_color = get_option( 'qa_flag_button_bg_color' );


$qa_vote_button_bg_color = get_option( 'qa_vote_button_bg_color' );
if( empty( $qa_vote_button_bg_color ) ) $qa_vote_button_bg_color = '';

$qa_css .= ".single-question .qa-user-role{ color: $qa_color_single_user_role; background-color: $qa_color_single_user_role_background; } 
	.single-question .qa-add-comment, .single-question .qa-cancel-comment, .qa-answer-reply { background: $qa_color_add_comment_background; }";

if( !empty( $qa_flag_button_bg_color ) ) {

    $qa_css .=  '.single-question .qa-flag,.single-question .qa-comment-flag{background: $qa_flag_button_bg_color none repeat scroll 0 0;}';
};


$qa_css .= ".qa-single-vote .qa-thumb-up, .qa-single-vote .qa-thumb-reply, .qa-single-vote .qa-thumb-down{ background: $qa_vote_button_bg_color;border:1px solid ".$qa_vote_button_bg_color." } .votted{background: rgba(0, 0, 0, 0) linear-gradient(to bottom, ".$qa_vote_button_bg_color." 5%, #fff 60%) repeat scroll 0 0 !important; color:".$qa_vote_button_bg_color." !important; border:1px solid ".$qa_vote_button_bg_color." !important;}";






	//var_dump($author);
	
	
?>

<div itemprop="description" class="question-content">
	
	<div class="content-header">
		<div class="question-author-avatar meta"> <?php echo get_avatar( $author->user_email, "45" ); ?></div>
		<div class="qa-users-meta meta">
			<span itemprop="author" itemscope itemtype="http://schema.org/Person" class="qa-user">
				<span itemprop="name"><?php echo $author_name; ?></span>
            </span>
			<span class="qa-user-role"><?php echo ucfirst($author_role); ?></span>
			<span class="qa-user-badge"><?php echo apply_filters('qa_filter_single_question_badge','',$author->ID, 2); ?></span>            
			<span class="qa-member-since"><?php echo sprintf( __('Member Since %s', 'question-answer'), date( "M Y", strtotime( $author_date ) )); ?><?php //echo date( "M Y", strtotime( $author_date ) ); ?></span>
		</div>


<?php

if( array_key_exists($user_ID, $qa_flag) && $qa_flag[$user_ID]['type']=='flag'  ) {

$flag_text = __('Unflag', 'question-answer');

} else {

$flag_text = __('Flag', 'question-answer');
}

echo '<div class="qa-flag qa-flag-action float_right" post_id="'.get_the_ID().'"><i class="fa fa-flag flag-icon"></i> <span class="flag-text">'.$flag_text.'</span><span class="flag-count">('.$flag_count.')</span> <span class="waiting"><i class="fa fa-cog fa-spin"></i></span> </div>';

?>



		
		<?php do_action('qa_action_single_question_meta'); ?>




		
	</div> <!-- End Content Header -->
	
	<div class="content-body"> <?php echo get_the_content(); ?>
    
   
        <ul class="qa-polls">
        <?php
        if(!empty($polls) && is_array($polls)){
			
			foreach($polls as $id=>$poll){
				
				if(!empty($poll))
				echo '<li q_id="'.get_the_ID().'" data-id="'.$id.'"><i class="fa fa-circle-o" aria-hidden="true"></i><i class="fa fa-dot-circle-o" aria-hidden="true"></i> '.$poll.'</li>';
				
				}
			
			}

        ?>
        </ul>


    
    <div class="poll-result">
    	<i class="loading fa fa-spinner fa-spin" aria-hidden="true"></i>
        <div class="results">
        <?php 
		
		$poll_result = get_post_meta(get_the_ID(), 'poll_result', true);
		if(!empty($poll_result) && is_array($poll_result)){
			
			$total = count($poll_result);
			$count_values = array_count_values($poll_result);		
			//var_dump($count_values);
			echo '<div class="">'.__('Total:', 'question-answer').' '.$total.'</div>';
			
			foreach($count_values as $id=>$value){
				
				echo '<div class="poll-line"><div style="width:'.(($value/$total)*100).'%" class="fill">&nbsp;'.$polls[$id].' - ('.$value.')'.' </div></div>';
				
				}
			
			}

		
		
		//var_dump($poll_result);
		?>
        </div>
        
    </div>
    
    
    
	<div class="qa-content-tags"> 
	 
	<?php 
	
	
	$tag_list = wp_get_post_terms(get_the_ID(), 'question_tags', array("fields" => "all"));	
	$total_tag = count($tag_list);
	
	if(!empty($tag_list)){
		
		$tag_html = '';
		$i=1;
		foreach($tag_list as $tag){
			
			$tag_html.= '<a class="tag" href="#">'.$tag->name.'</a>';
			if($total_tag!=$i){
				$tag_html.= ' ';
				}
			
			$i++;
			}
		
		}
	else{
		
		$tag_html = __('N/A', 'question-answer');
		}

    if($total_tag>0)
	echo apply_filters( 'qa_filter_single_question_tags', __('Tags: ', 'question-answer' ).$tag_html );
	
	 ?>
     
     </div> <!-- End of Tags -->

        <div class="qa-answer-comment-reply qa-answer-comment-reply-<?php echo get_the_ID(); ?> clearfix ">

		<?php 
		$status = 0;
		$tt_text = '<i class="fa fa-lock"></i> '.__('Login First', 'question-answer');
		
	
		$current_user 	= wp_get_current_user();
		$user_ID		= $current_user->ID;
		
		
		if( !empty($user_ID) ) {
			$status = 1;
			$tt_text = '<i class="fa fa-thumbs-down"></i> '.__('Report this', 'question-answer');
		}
		
		foreach( $comments as $comment ) {

            $comment_date 	= new DateTime($comment->comment_date);
            $comment_date 	= $comment_date->format('M d, Y h:i A');
            $comment_author	= get_comment_author( $comment->comment_ID );
            if(!empty($comment->comment_author)){

            $comment_author = $comment->comment_author;
            }

            else{
            $comment_author =  __('Anonymous', 'question-answer');
            }

            $qa_flag_comment 	= get_comment_meta( $comment->comment_ID, 'qa_flag_comment', true );

            if(!is_array($qa_flag_comment)){
            $qa_flag_comment = array();
            }


            $flag_comment_count 		= sizeof($qa_flag_comment);

            if( array_key_exists($user_ID, $qa_flag_comment) && $qa_flag_comment[$user_ID]['type']=='flag'  ) {

            $flag_text = __('Unflag', 'question-answer');

            } else {

            $flag_text = __('Flag', 'question-answer');
            }

            $flag_html = '<div class="qa-comment-flag qa-comment-flag-action float_right" comment_id="'.$comment->comment_ID.'"><i class="fa fa-flag flag-icon"></i> <span class="flag-text">'.$flag_text.'</span><span class="flag-count">('.$flag_comment_count.')</span> <span class="waiting"><i class="fa fa-cog fa-spin"></i></span> </div>';

/*

			$qa_flag_comment 	= get_comment_meta( $comment->comment_ID, 'qa_flag_comment', true );
			$count_flag 		= count(explode(',', $qa_flag_comment ) ) - 1;

			if( !empty($user_ID) && qa_search_user($user_ID, $qa_flag_comment) ) {

				$flag_html = '
				<span class="qa-comment-action float_right qa_tt" action="unflag" user_id="'.$user_ID.'" status="'.$status.'" comment_id="'.$comment->comment_ID.'">
					'.__('Unflag', 'question-answer').' ('.$count_flag.')
					<span class="qa_ttt qa_w_160"><i class="fa fa-undo"></i> '.__('Undo Report', 'question-answer').'</span>
				</span>';

			} else {

				$flag_html = '
				<span class="qa-comment-action float_right qa_tt" action="flag" user_id="'.$user_ID.'" status="'.$status.'" comment_id="'.$comment->comment_ID.'">
					'.__('Flag', 'question-answer').' ('.$count_flag.')
					<span class="qa_ttt qa_w_160">'.$tt_text.'</span>
				</span>';

			}


*/
			
?>
                <div id="comment-<?php echo $comment->comment_ID; ?>" class="qa-single-comment single-reply">

                    <div class="qa-avatar float_left"><?php echo get_avatar( $comment->comment_author_email, "30" ); ?></div>
                    <div class="qa-comment-content">
                        <div class="ap-comment-header">
                            <a href="#" class="ap-comment-author"><?php echo $comment_author; ?></a> - <a class="comment-link" href="#comment-<?php echo $comment->comment_ID; ?>"> <?php echo $comment_date; ?></a>

                        </div>
                        <div class="ap-comment-texts">

<?php
ob_start();
qa_filter_badwords( comment_text( $comment->comment_ID ) );
echo ob_get_clean();

?>


                            </div>
                    </div>

                </div>
            <?php
			

			
			
		}

		?>
        </div>
            <?php


		if( $qa_allow_question_comment == 'yes' ) {

        $current_user 	= wp_get_current_user();
		?>

            <div class="qa-answer-reply" post_id="<?php echo get_the_ID(); ?>">
                <i class="fa fa-reply"></i>
                <span><?php echo __('Reply on This', 'question-answer'); ?></span>
            </div>
            <div class="qa-reply-popup qa-reply-popup-<?php echo get_the_ID(); ?>">
                <div class="qa-reply-form">
                    <span class="close"><i class="fa fa-times"></i></span>
                    <span class="qa-reply-header"><?php echo __('Replying as', 'question-answer'); ?> <?php echo $current_user->display_name; ?></span>
                    <textarea rows="4" cols="40" id="qa-answer-reply-<?php echo get_the_ID(); ?>"></textarea>
                    <span class="qa-reply-form-submit" id="<?php echo get_the_ID(); ?>"><?php echo __('Submit', 'question-answer'); ?></span>
                </div>
            </div>







		<?php } ?>
		

		
	
	</div> <!-- End of Content Body --> 
	
	
</div>

<?php do_action('qa_action_single_question_content_after'); ?>


