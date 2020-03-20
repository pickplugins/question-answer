<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


$q_subscriber = get_post_meta(  get_the_ID(), 'q_subscriber', true );
$qa_assign_to = get_post_meta(  get_the_ID(), 'qa_assign_to', true );
$qa_assign_to = !empty($qa_assign_to) ? $qa_assign_to : array();



//var_dump($assign_to);

?>

<div class="subscribers">

    <div class="title"><?php  echo count($q_subscriber).' '.__('Subscribers', 'question-answer'); ?></div>
    <?php
    $max_subscriber = 10;

    $i = 1;
    if(is_array($q_subscriber))
    foreach($q_subscriber as $subscriber) {

        $user = get_user_by( 'ID', $subscriber );

        if(!empty($user->display_name))
        echo '<div title="'.$user->display_name.'" class="subscriber">'.get_avatar( $subscriber, "45" ).'</div>';

        if($i>=$max_subscriber){
            return;
            }
        }
    ?>

</div>

<?php if(!empty($qa_assign_to)): ?>

<div class="assign-to">
    <span class="assign-to-title">Assign to: </span>

    <?php
    foreach ($qa_assign_to as $userId){
        $user = get_user_by('id', $userId);
        $avatar_url = get_avatar_url($userId);

        ?>
        <div class="item" title="<?php echo $user->display_name; ?>">
            <img width="30" src="<?php echo $avatar_url; ?>">
        </div>
        <?php
    }
    ?>

</div>
<?php endif; ?>