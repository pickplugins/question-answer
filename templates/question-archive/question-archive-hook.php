<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


add_action( 'question_answer_archive', 'question_answer_archive_top_nav', 10 );
if ( ! function_exists( 'question_answer_archive_top_nav' ) ) {
    function question_answer_archive_top_nav( $wp_query ) {
        include( QA_PLUGIN_DIR. 'templates/question-archive/top-nav.php');

    }
}

add_action( 'qa_action_question_archive_single', 'qa_action_question_archive_single_function', 10 );
if ( ! function_exists( 'qa_action_question_archive_single_function' ) ) {
    function qa_action_question_archive_single_function( $wp_query ) {
        include( QA_PLUGIN_DIR. 'templates/question-archive/single-question.php');
    }
}





add_action( 'qa_action_question_archive_question_meta', 'qa_action_question_archive_question_meta', 10 );
if ( ! function_exists( 'qa_action_question_archive_question_meta' ) ) {
    function qa_action_question_archive_question_meta( $wp_query ) {
        include( QA_PLUGIN_DIR. 'templates/question-archive/question-meta.php');
    }
}




add_action( 'qa_action_question_archive_answer_count', 'qa_action_question_archive_answer_count_function', 10 );
if ( ! function_exists( 'qa_action_question_archive_answer_count_function' ) ) {
    function qa_action_question_archive_answer_count_function() {
        include( QA_PLUGIN_DIR. 'templates/question-archive/answer-count.php');
    }
}


add_action( 'qa_action_question_archive_view_count', 'qa_action_question_archive_view_count_function', 10 );

if ( ! function_exists( 'qa_action_question_archive_view_count_function' ) ) {
    function qa_action_question_archive_view_count_function() {
        include( QA_PLUGIN_DIR. 'templates/question-archive/view-count.php');
    }
}


add_action( 'qa_action_question_archive_view_count', 'qa_action_question_archive_vote_count_function', 10 );
if ( ! function_exists( 'qa_action_question_archive_vote_count_function' ) ) {
    function qa_action_question_archive_vote_count_function() {
        include( QA_PLUGIN_DIR. 'templates/question-archive/vote-count.php');
    }
}


add_action( 'qa_action_submit_search', 'qa_action_submit_search_function', 10 );

if ( ! function_exists( 'qa_action_submit_search_function' ) ) {
    function qa_action_submit_search_function() {
        include( QA_PLUGIN_DIR. 'templates/question-archive/search-hook.php');
    }
}






/**
 * @param $query_args
 * @return mixed
 */
function qa_archive_filter($query_args){



    if(isset($_GET['filter']) && $_GET['filter'] == 'featured'){

        $query_args = array();
    }

    elseif(isset($_GET['filter']) && $_GET['filter'] == 'solved'){

        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '=',
        );
    }

    elseif(isset($_GET['filter']) && $_GET['filter'] == 'unsolved'){

        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '!=',
        );
    }

    elseif(isset($_GET['filter']) && $_GET['filter'] == 'top_viewed'){


        $query_args['orderby'] = 'meta_value_num';
        $query_args['meta_key'] = 'qa_view_count';
        $query_args['order'] = 'DESC';


    }

    elseif(isset($_GET['qa-keyword'])){


        $keyword = isset($_GET['qa-keyword']) ? $_GET['qa-keyword'] : '';
        $question_status= isset($_GET['question_status']) ? $_GET['question_status'] : '';
        //$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';
        $qa_category = isset($_GET['qa_category']) ? $_GET['qa_category'] : '';


        if(!empty($keyword))
            $query_args['s'] = $keyword;


        //$query_args['orderby'] = 'meta_value';
        //$query_args['meta_key'] = $order_by;


        if(!empty($qa_category)):
            $query_args['tax_query'][] = array(
                array(
                    'taxonomy' => 'question_cat',
                    'field' => 'slug',
                    'terms' => $qa_category,
                )
            );
        endif;

        if(!empty($question_status)):
            $query_args['meta_query'][] = array(
                'key'     => 'qa_question_status',
                'value'   => $question_status,
                'compare' => '=',
            );
        endif;
    }





    return $query_args;



}


add_filter('qa_query_args', 'qa_archive_filter');



function qa_archive_sticky_filter($query_args){


    if(isset($_GET['filter']) && $_GET['filter'] == 'featured'){
        $qa_featured_questions = get_option( 'qa_featured_questions', array('') );

        $query_args['post__in'] = $qa_featured_questions;


    }
    elseif(isset($_GET['filter']) && $_GET['filter'] == 'solved'){

        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '=',
        );
    }

    elseif(isset($_GET['filter']) && $_GET['filter'] == 'unsolved'){

        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => 'solved',
            'compare' => '!=',
        );
    }

    elseif(isset($_GET['filter']) && $_GET['filter'] == 'top_viewed'){


        $query_args['orderby'] = 'meta_value_num';
        $query_args['meta_key'] = 'qa_view_count';
        $query_args['order'] = 'DESC';


    }
    $keyword = isset($_GET['qa-keyword']) ? $_GET['qa-keyword'] : '';
    $question_status= isset($_GET['question_status']) ? $_GET['question_status'] : '';
    //$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';
    $qa_category = isset($_GET['qa_category']) ? $_GET['qa_category'] : '';


    if(!empty($keyword))
        $query_args['s'] = $keyword;


    //$query_args['orderby'] = 'meta_value';
    //$query_args['meta_key'] = $order_by;


    if(!empty($qa_category)):
        $query_args['tax_query'][] = array(
            array(
                'taxonomy' => 'question_cat',
                'field' => 'slug',
                'terms' => $qa_category,
            )
        );
    endif;

    if(!empty($question_status)):
        $query_args['meta_query'][] = array(
            'key'     => 'qa_question_status',
            'value'   => $question_status,
            'compare' => '=',
        );
    endif;


    return $query_args;

}



add_filter('qa_query_sticky_args', 'qa_archive_sticky_filter');
