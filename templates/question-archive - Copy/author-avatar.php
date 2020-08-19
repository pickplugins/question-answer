<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 



	
	?>
<div class="question-author-avatar qa-user-card-loader" author_id="<?php echo $author_id; ?>" has_loaded="no">
    <?php echo get_avatar( get_the_author_meta('ID'), "45" ); ?>
    <div class="qa-user-card">
        <div class="card-loading">
            <i class="fa fa-cog fa-spin"></i>
        </div>
        <div class="card-data"></div>
    </div>
</div>
