<div class="bb-field-row" <?php echo $dependency ?>>
    <div class="bb-label">
        <label for="<?php echo esc_attr($field['param_name']) ?>">
            <?php if(!empty($field['heading'])) esc_html_e($field['heading']) ?>
        </label>
    </div>
    <div class="bb-field">
        <select id="<?php echo esc_attr($field['param_name']) ?>" class="bb-dropdown" name="<?php echo esc_attr($field['param_name']) ?>" style="width:100%;">
            <?php foreach ($field['value'] as $value => $text) { ?>
                <option value="<?php echo esc_attr($value) ?>" <?php if($value == $field['std']) echo 'selected'; ?>><?php echo esc_html($text) ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="bb-desc">
        <?php if(!empty($field['description'])) echo ($field['description']) ?>
    </div>
</div>