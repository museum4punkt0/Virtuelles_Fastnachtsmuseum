<div class="bb-field-row" <?php echo $dependency ?>>
    <div class="bb-label">
        <label>
            <?php if(!empty($field['heading'])) esc_html_e($field['heading']) ?>
        </label>
    </div>
    <div class="bb-field">
        <label class="bb-toggle" for="<?php echo esc_attr($field['param_name']) ?>-checkbox">
            <input id="<?php echo esc_attr($field['param_name']) ?>-checkbox" class="checkbox" type="checkbox" <?php if($field['value'] == 'yes') echo 'checked="checked"'; ?>><div class="slider round"></div>
            
            <input id="<?php echo esc_attr($field['param_name']) ?>" class="bb-value" name="<?php echo esc_attr($field['param_name']) ?>" type="text" value="<?php echo esc_attr($field['value']) ?>" />
        </label>
    </div>
    <div class="bb-desc">
        <?php if(!empty($field['description'])) echo ($field['description']) ?>
    </div>
</div>