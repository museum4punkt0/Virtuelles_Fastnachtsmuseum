<div class="bb-field-row" <?php echo $dependency ?>>
    <div class="bb-label">
        <label for="<?php echo esc_attr($field['param_name']) ?>">
            <?php if(!empty($field['heading'])) esc_html_e($field['heading']) ?>
        </label>
    </div>
    <div class="bb-number bb-field">
        <input type="button" value="-" class="minus" /><input id="<?php echo esc_attr($field['param_name']) ?>" class="bb-number-value" name="<?php echo esc_attr($field['param_name']) ?>" type="number" value="<?php echo esc_attr($field['value']) ?>" step="1" /><input type="button" value="+" class="plus" />
    </div>
    <div class="bb-desc">
        <?php if(!empty($field['description'])) echo ($field['description']) ?>
    </div>
</div>