<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 12/22/15
 * Time: 11:34 AM
 */

$lesson_id = uniqid();
// Get current user and check if he bought current course
$bought_course = false;
$current_user = wp_get_current_user();
if( !empty($current_user->user_email) and !empty($current_user->ID) ) {
    if ( function_exists('wc_customer_bought_product') && wc_customer_bought_product( $current_user->user_email, $current_user->ID, get_the_id() ) ) {
        $bought_course = true;
    }
}
$iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
if($private=='true' && !$bought_course ){
    $iconClass = 'fa fa-lock';
}
?>
<div class="lesson-title">
    <a href="javascript:;" data-id="lesson_content_<?php echo esc_attr($lesson_id) ?>">
        <?php echo wp_kses_post($title); ?> <span><i class="fa fa-caret-down"></i></span>
    </a>
    <div class="meta">
        <span class="lesson-icon"><i class="<?php echo esc_attr($iconClass) ?>" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($icon_tool_tip); ?>"></i></span>
        <span class="preview-video" >
             <?php if(isset($preview_video) && $preview_video!=''){ ?>
                <a href="<?php echo esc_url($preview_video)?>" data-rel="prettyPhoto"><?php esc_html_e('Preview','g5plus-academia'); ?></a>
             <?php } ?>
        </span>
        <span class="estimate-time">
            <?php echo wp_kses_post($estimate_time); ?>
        </span>
        <span class="badge <?php echo esc_attr($badge) ?>">
                <?php
                switch($badge) {
                    case 'test':
                       esc_html_e('Test','g5plus-academia');
                        break;
                    case 'video':
                        esc_html_e('Video','g5plus-academia');
                        break;
                    case 'exam':
                        esc_html_e('Exam','g5plus-academia');
                        break;
                    case 'quiz':
                        esc_html_e('Quiz','g5plus-academia');
                        break;
                    case 'lecture':
                        esc_html_e('Lecture','g5plus-academia');
                        break;
                    case 'seminar':
                        esc_html_e('Seminar','g5plus-academia');
                        break;
                    case 'free':
                        esc_html_e('Free','g5plus-academia');
                        break;
                    case 'practice':
                        esc_html_e('Practice','g5plus-academia');
                        break;
                    case 'exercise':
                        esc_html_e('Exercise','g5plus-academia');
                        break;
                    case 'activity':
                        esc_html_e('Activity','g5plus-academia');
                        break;
                    case 'final':
                        esc_html_e('Final','g5plus-academia');
                        break;
                    case 'end-of-course':
                        esc_html_e('End of course','g5plus-academia');
                        break;

                }
                ?>
        </span>
    </div>

</div>
<div class="lesson-content" id="lesson_content_<?php echo esc_attr($lesson_id) ?>">
    <?php
        if($private!='true' || $bought_course ){
            echo sprintf('%s', $content);
        }
        if($private=='true' && !$bought_course ){
            esc_html_e('The content of this lesson is locked. To unlock it, you need to Buy this Course.','g5plus-academia');
        }
    ?>
</div>