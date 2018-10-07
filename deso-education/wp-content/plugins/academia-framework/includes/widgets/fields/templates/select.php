<div class="select-wrap element"  data-require-element="<?php if(isset($require_element)){ echo esc_attr($require_element);} ?>"
     data-require-element-id="<?php if(isset($require_element_id)){ echo esc_attr($require_element_id);} ?>"
     data-require-compare="<?php if(isset($require_compare)){ echo esc_attr($require_compare);} ?>"
     data-require-values="<?php if(isset($require_values)){ echo esc_attr($require_values);} ?>"
    >
    <label for="<?php echo esc_attr($field_output_name); ?>"><?php echo esc_html($field_title); ?></label>
    <?php if(isset($multiple) && $multiple!=''){ ?>
        <input type="hidden" id="<?php echo esc_attr($field_output_id); ?>" name="<?php echo esc_attr($field_output_name); ?>" value="<?php if(isset($field_value)){ echo esc_attr($field_value) ;}else{echo '';}  ?>">
        <select class="widefat select2" id="<?php echo esc_attr($select_field_id); ?>" name="<?php echo esc_attr($select_field_name); ?>" <?php echo esc_attr($multiple) ?> data-multiple="1">
            <?php foreach ( $field_seclect_options as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>" > <?php echo htmlspecialchars( $option_value ); ?></option>
            <?php endforeach; ?>
        </select>
    <?php }else{ ?>
        <select class="widefat" id="<?php echo esc_attr($field_output_id); ?>" name="<?php echo esc_attr($field_output_name); ?>" data-allow-clear="<?php echo esc_attr($allow_clear)?>">
            <?php foreach ( $field_seclect_options as $option_key => $option_value ) : ?>
                <option value="<?php echo esc_attr( $option_key ); ?>" <?php if(isset($field_value)){ selected( $option_key, $field_value ); };  ?>  > <?php echo htmlspecialchars( $option_value ); ?></option>
            <?php endforeach; ?>
        </select>
    <?php } ?>
</div>
