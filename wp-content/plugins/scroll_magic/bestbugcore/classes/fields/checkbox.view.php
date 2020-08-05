<div class="bb-field-row" <?php echo $dependency ?>>
    <div class="bb-label">
        <label>
            <?php if(!empty($field['heading'])) esc_html_e($field['heading']) ?>
        </label>
    </div>
    <div class="bb-field bb-checkboxes">
        <?php foreach ($field['value'] as $value => $text) { ?>
            <label>
				<input class="bb-checkbox" type="checkbox" name="<?php echo esc_attr($field['param_name']) ?>[<?php echo esc_attr($value) ?>]" value="1" <?php if(array_key_exists( $value, $field['std'] ) && $field['std'][$value]) echo 'checked="checked"'; ?>><?php echo esc_html($text) ?>
            </label>
        <?php } ?>
        
    </div>
    <div class="bb-desc">
        <?php if(!empty($field['description'])) echo ($field['description']) ?>
    </div>
</div>