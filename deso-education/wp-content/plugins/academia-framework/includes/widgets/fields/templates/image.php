<div class="media-wrap element"  data-require-element="<?php if(isset($require_element)){ echo esc_attr($require_element);} ?>"
     data-require-element-id="<?php if(isset($require_element_id)){ echo esc_attr($require_element_id);} ?>"
     data-require-compare="<?php if(isset($require_compare)){ echo esc_attr($require_compare);} ?>"
     data-require-values="<?php if(isset($require_values)){ echo esc_attr($require_values);} ?>">
    <label
        for="<?php echo esc_attr($field_output_name); ?>"><?php echo esc_html($field_title); ?></label>
    <div class="media ">


        <?php if(isset($url) && $url!=''){ ?>
            <img src="<?php echo esc_url($url) ?>" width="<?php echo esc_attr($img_width) ?>" height="<?php echo esc_attr($img_height) ?>">
        <?php } ?>
        <a href="javascript:void(0);"
           class="button widget-acf-upload-button" data-width="<?php echo esc_attr($img_width) ?>" data-height="<?php echo esc_attr($img_height) ?>">Upload <?php echo esc_attr($field_title) ?></a>
        <?php if(isset($url) && $url!=''){ ?>
            <a href="javascript:void(0);" class="button  remove-media">Remove</a>
        <?php } ?>
        <input type="hidden" data-type="id" id="<?php echo esc_attr($field_output_id); ?>"
               name="<?php echo esc_attr($field_output_name . '[attachment_id]'); ?>"
               value="<?php if(isset($attachment_id)){ echo esc_attr($attachment_id) ;} else { echo '';}  ?>" >

        <input type="hidden" data-type="url" id="<?php echo esc_attr($field_output_id); ?>"
               name="<?php echo esc_attr($field_output_name . '[url]'); ?>"
               value="<?php if(isset($url)){ echo esc_attr($url) ;} else { echo '';} ?>" >
    </div>
</div>
