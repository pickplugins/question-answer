<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('question_archive', 'question_archive_search');

function question_archive_search($atts){

    $class_qa_functions = new class_qa_functions();

    $filter_by = isset( $_GET['filter_by'] ) ? sanitize_text_field($_GET['filter_by']) : '';
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $order_by	= isset( $_GET['order_by'] ) ? sanitize_text_field( $_GET['order_by'] ) : '';
    $order 	= isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : '';
    $status 	= isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '';


    ?>
    <form id="qa-search-form" class="qa-search-form" action="" method="get">

        <div class="main-input">
            <div class="field-wrap">
                <span class="loading"><i class="fas fa-spinner fa-spin"></i></span>
                <input id="qa_keyword" type="search" value="" placeholder="Search..." name="qa_keyword">
                <input type="submit" value="Submit" placeholder="" name="submit">
                <span class="advance-toggle"><i class="fab fa-searchengin"></i> Advance</span>
            </div>
        </div>


        <div class="advance-input">

            <div class="field-wrap">
                <div class="field-label">Filter by</div>
                <select id="filter_by" name="filter_by"> <?php
                    $filter_by_list = $class_qa_functions->filter_by_args();
                    foreach( $filter_by_list as $key => $value ) {
                        ?><option <?php selected( $key, $filter_by ); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
                    } ?>
                </select>
            </div>

            <div class="field-wrap">
                <div class="field-label">Status</div>
                <select id="question_status" name="question_status"> <?php
                    $status_list = $class_qa_functions->qa_question_status();
                    foreach( $status_list as $key => $value ) {
                        ?><option <?php selected( $key, $status ); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
                    } ?>
                </select>
            </div>

            <div class="field-wrap">
                <div class="field-label">Categories</div>
                <select id="category" name="category">
                    <option value=""><?php echo __('Select a category', 'question-answer'); ?></option> <?php

                    foreach( qa_get_categories() as $cat_id => $cat_info ) { ksort($cat_info);



                        $this_category = get_term( $cat_id );

                        //var_dump($this_category);

                        //if(!empty($this_category))
                        foreach( $cat_info as $key => $value ) {

                            //var_dump($category);

                            if( $key == 0 )  {
                                ?><option <?php selected( $this_category->slug, $category ); ?> value="<?php echo $this_category->slug; ?>"><?php echo $value; ?></option><?php
                            } else {
                                $this_category = get_category( $key );

                                ?><option <?php selected( $this_category->slug, $category ); ?> value="<?php echo $this_category->slug; ?>">  - <?php echo $value; ?></option> <?php
                            }
                        }
                    } ?>
                </select>
            </div>

            <div class="field-wrap">
                <div class="field-label">Order by</div>

                <select id="order_by" name="order_by">
                    <?php
                    $order_by_args = $class_qa_functions->order_by_args();

                    foreach( $order_by_args as $key => $value ) {
                        ?><option <?php selected( $key, $order_by ); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option><?php
                    } ?>
                </select>
            </div>


            <div class="field-wrap">
                <div class="field-label">Order</div>

                <select id="order" name="order">
                    <option value="desc">Descending</option>
                    <option value="asc">Ascending</option>


                </select>
            </div>


        </div>




        <?php
        do_action('question_archive_search', $atts);
        ?>



    </form>

    <style type="text/css">
        .qa-search-form{
            padding: 25px 0;
        }

        .loading{
            display: none;
        }

        .qa-search-form select{
            width: 95%;
        }

        .qa-search-form .field-wrap{
            padding: 0 0px 20px 15px;
        }

        .qa-search-form .advance-input{
            display: none;
            grid-template-columns: auto auto auto;
            margin: 35px 0;
            background: #dddddd57;
            padding: 21px 15px;

        }

        .qa-search-form .main-input{

            text-align: center;
        }
        .qa-search-form .main-input input[type="search"]{
            padding: 10px 10px;
            width: 300px;
        }

        .qa-search-form .main-input input[type="submit"]{
            padding: 10px 30px;
            margin-right: 15px;
        }

        .advance-toggle{
            cursor: pointer;
        }
        .advance-toggle.active{
            font-weight: bold;
        }

    </style>


    <?php

}







add_action('question_archive', 'question_archive_list');

function question_archive_list($atts){

    if ( get_query_var('paged') ) { $paged = get_query_var('paged');}
    elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
    else { $paged = 1; }

    $qa_post_per_page = get_option('qa_question_item_per_page', 10);

    $query_args = array (
        'post_type' => 'question',
        'post_status' => array( 'publish', 'private' ),
        //'author_name' => $user_slug,
        //'s' => $keywords,
        'order' => empty( $order ) ? 'DESC' : $order,
        'orderby' => empty( $order_by ) ? 'modified' : $order_by,
        //'tax_query' => $tax_query,
        //'meta_query' => $meta_query,
        'posts_per_page' => $qa_post_per_page,
        'paged' => $paged,
    );



    $query_args = apply_filters('question_archive_query_args', $query_args);
    //var_dump($query_args);

    $qa_archive_query = new WP_Query( $query_args);





    if ( $qa_archive_query->have_posts() ) :

        ?>

        <div class="question-list">
        <?php

        do_action( 'question_archive_loop_before', $qa_archive_query );




        while ( $qa_archive_query->have_posts() ) : $qa_archive_query->the_post();

            $post_id = get_the_ID();
            $qa_featured_questions 	= get_post_meta($post_id, 'qa_featured_questions', true);
            $is_featured = ($qa_featured_questions == 'yes') ? 'featured': '';
            ?>
            <div class="single-question <?php echo $is_featured; ?>">

                <?php
                do_action( 'question_archive_loop', $post_id,  $qa_archive_query );

                ?>
            </div>
            <?php

        endwhile;
        ?>
        </div>
        <?php
        do_action( 'question_archive_loop_after', $qa_archive_query );

        wp_reset_query();
    else:
        do_action( 'question_archive_no_post', $qa_archive_query );

    endif;



}





/**
 * @param $query_args
 * @return mixed
 */
function question_archive_query_args($query_args){

    $filter_by = isset($_GET['filter_by']) ? sanitize_text_field($_GET['filter_by']) : '';
    $qa_keyword = isset($_GET['qa_keyword']) ? sanitize_text_field($_GET['qa_keyword']) : '';
    $order_by = isset($_GET['order_by']) ? sanitize_text_field($_GET['order_by']) : '';
    $order = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : '';
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $question_status = isset($_GET['question_status']) ? sanitize_text_field($_GET['question_status']) : '';


    if(!empty($filter_by) && $filter_by == 'featured'){

        $query_args = array();
    }elseif(!empty($filter_by) && $filter_by == 'recent'){

        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';

    }elseif(!empty($filter_by) && $filter_by == 'solved'){

        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '=',
        );
    }elseif(!empty($filter_by) && $filter_by == 'unsolved'){

        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '!=',
        );
    }elseif(!empty($filter_by) && $filter_by == 'top_viewed'){


        $query_args['orderby'] = 'meta_value_num';
        $query_args['meta_key'] = 'qa_view_count';
        $query_args['order'] = 'DESC';


    }

    if(!empty($qa_keyword)){

        $query_args['s'] = $qa_keyword;


    }





    return $query_args;



}


add_filter('question_archive_query_args', 'question_archive_query_args');






















add_action('question_archive_loop', 'question_archive_loop_vote', 10, 2);

function question_archive_loop_vote($post_id,  $qa_archive_query){

global $qa_css;

$qa_color_archive_view_count = get_option( 'qa_color_archive_view_count' );
if( empty( $qa_color_archive_view_count ) ) $qa_color_archive_view_count = '';


$qa_css .= ".questions-archive .view-count{ color: $qa_color_archive_view_count; }";



$qa_answer_review		= get_post_meta( $post_id, 'qa_answer_review', true );
$review_count 	= empty( $qa_answer_review['reviews'] ) ? 0 : (int)$qa_answer_review['reviews'];

if(empty($qa_view_count)){$qa_view_count = 0;}

?>
<div class="question-side-box">
    <span class="vote-count"><?php echo apply_filters('qa_filter_answer_vote_count_html', $review_count); ?></span><span class="vote-text"><?php echo __('Vote', 'question-answer'); ?></span>
</div>
<?php




}


add_action('question_archive_loop', 'question_archive_loop_answer_count', 10, 2);

function question_archive_loop_answer_count($post_id,  $qa_archive_query){

    $wp_answer_query = new WP_Query( array (
        'post_type' => 'answer',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' 		=> 'qa_answer_question_id',
                'value' 	=> $post_id,
                'compare'	=> '=',
            ),
        ),
    ) );

    global $qa_css;

    $qa_color_archive_answer_count = get_option( 'qa_color_archive_answer_count' );
    if( empty( $qa_color_archive_answer_count ) ) $qa_color_archive_answer_count = '';


    $qa_css .= ".questions-archive .answer-count{ color: $qa_color_archive_answer_count; }";

    ?>
    <div class="question-side-box">
        <span class="answer-count"><?php echo $wp_answer_query->found_posts; ?></span><span class="answer-text"><?php echo __('Answer', 'question-answer'); ?></span>
    </div>


    <?php
}

add_action('question_archive_loop', 'question_archive_loop_view_count', 10, 2);

function question_archive_loop_view_count($post_id,  $qa_archive_query){

    $wp_answer_query = new WP_Query( array (
        'post_type' => 'answer',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' 		=> 'qa_answer_question_id',
                'value' 	=> $post_id,
                'compare'	=> '=',
            ),
        ),
    ) );

    global $qa_css;

    $qa_color_archive_view_count = get_option( 'qa_color_archive_view_count' );
    if( empty( $qa_color_archive_view_count ) ) $qa_color_archive_view_count = '';


    $qa_css .= ".questions-archive .view-count{ color: $qa_color_archive_view_count; }";

    $qa_view_count = get_post_meta($post_id, 'qa_view_count', true);

    if(empty($qa_view_count)){$qa_view_count = 0;}

    ?>
    <div class="question-side-box">
        <span class="view-count"><?php echo $qa_view_count; ?></span><span class="answer-text"><?php echo __('View', 'question-answer'); ?></span>
    </div>

    <?php
}

add_action('question_archive_loop', 'question_archive_loop_thumb', 10, 2);

function question_archive_loop_thumb($post_id,  $qa_archive_query){
    $question_post = get_post($post_id);

    $author_id = $question_post->post_author;
    ?>
    <div class="thumb">
        <?php echo get_avatar( $author_id, "45" ); ?>
    </div>
    <?php
}



add_action('question_archive_loop', 'question_archive_loop_details', 10, 2);

function question_archive_loop_details($post_id,  $qa_archive_query){
    $question_post = get_post($post_id);

    $author_id = $question_post->post_author;
    ?>

    <div class="question-details">
        <div class="title"><a href="<?php echo get_permalink(); ?>"><?php echo get_the_title(); ?></a></div>
        <?php
        do_action( 'question_archive_loop_meta', $post_id );
        ?>

    </div>
    <?php
}



add_action('question_archive_loop_meta', 'question_archive_loop_meta', 10);

function question_archive_loop_meta($post_id){

    $q_subscriber = get_post_meta($post_id, 'q_subscriber', true);
    $q_subscriber = !empty($q_subscriber) ? $q_subscriber : array();


    $last_activity_user_id = get_post_meta($post_id, 'last_activity_user_id', true);


    $q_subscriber_count = count($q_subscriber);

    if(!empty($last_activity_user_id)){
        $last_subscriber_data = get_user_by('ID', $last_activity_user_id);
        $last_subscriber_name = isset($last_subscriber_data->display_name) ? $last_subscriber_data->display_name : __('Anonymous','question-answer');
    }




    ?>

    <div class="meta">


        <?php
        $qa_question_status = get_post_meta( $post_id, 'qa_question_status', true );
        if( $qa_question_status == 'solved' ){
            $is_solved_class = 'solved';
            $is_solved_icon = '<i class="fa fa-check-circle"></i>';
            $is_solved_text = __('Solved', 'question-answer');
        }
        else{
            $is_solved_class = 'not-solved';
            $is_solved_icon = '<i class="fa fa-times"></i>';
            $is_solved_text = __('Not Solved', 'question-answer');
        }

        $display_name = get_the_author_meta('display_name');
        $display_name = !empty($display_name) ?$display_name :__('Anonymous','');

        ?>

        <a href="<?php echo '?filter_by=solved'; ?>" class="is-solved <?php echo $is_solved_class; ?>"><?php  echo $is_solved_icon.' '.$is_solved_text; ?></a>

        <span><i class="far fa-user-circle"></i>  <?php echo __('Asked by', 'question-answer'); ?> <a href="<?php echo '?user_slug='.get_the_author_meta('user_login'); ?>" class="author"><?php echo $display_name; ?></a></span>

        <?php if( !empty($category) ) { ?>
            <a href="<?php echo '?category='.$category[0]->slug; ?>" class="category"><i class="fa fa-folder-open"></i> <?php echo $category[0]->name; ?></a>
        <?php } ?>
        <a href="<?php echo '?date='.get_the_date('d-m-Y'); ?>" class="date"><i class="far fa-clock"></i> <?php echo get_the_date('M d, Y'); ?></a>

        <?php if(!empty($last_subscriber_name)): ?>
            <span class="meta answered-by"><?php echo sprintf(__('%s Last replied by %s', 'question-answer'),'<i class="fas fa-reply"></i>', $last_subscriber_name); ?></span>
        <?php endif; ?>
    </div>
    <?php
}






add_action('question_archive_loop_after', 'question_archive_loop_after', 10);

function question_archive_loop_after($qa_archive_query){

    if ( get_query_var('paged') ) { $paged = get_query_var('paged');}
    elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
    else { $paged = 1; }

    $big = 999999999;
    $paginate = array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'total' => $qa_archive_query->max_num_pages
    );

    ?>
    <div class="qa-paginate"> <?php echo paginate_links($paginate); ?> </div>

    <?php

}





add_action('question_archive_no_post', 'question_archive_no_post', 10);

function question_archive_no_post($qa_archive_query){


    ?>
    <div class="no-post"><?php echo "No post found"; ?></div>
    <?php

}

