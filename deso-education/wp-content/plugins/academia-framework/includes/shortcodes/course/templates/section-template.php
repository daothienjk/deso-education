<?php if(!empty($title)): ?>
    <div class="course_title course-section fs-13 p-bg"><?php echo esc_attr($title); ?></div>
<?php endif; ?>
<?php if( !empty( $content ) ){ ?>
    <div class="course_lessons_section">
        <div class="panel-group" id="accordion_<?php echo esc_attr($accordeon_id); ?>" role="tablist" aria-multiselectable="true">
            <?php echo wpb_js_remove_wpautop($content); ?>
        </div>
    </div>

<?php } ?>