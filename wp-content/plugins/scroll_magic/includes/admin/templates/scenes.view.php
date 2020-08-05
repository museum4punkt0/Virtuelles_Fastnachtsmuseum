<?php $this->subform(); ?>
<table class="wp-list-table widefat" id="rc-shortcode-table">
	<thead>
		<tr>
			<th width="100px"><?php esc_html_e('ID', 'bestbug') ?></th>
			<th><?php esc_html_e('Scene Title', 'bestbug') ?></th>
			<th><?php esc_html_e('CSS Class', 'bestbug') ?></th>
			<th width="200px" style="text-align: center"><?php esc_html_e('Action', 'bestbug') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($this->scenes as $id => $scene) {
		?>
			<tr>
				<td><strong><?php echo esc_html($scene->ID) ?></strong></td>
				<td><?php echo esc_html($scene->post_title) ?></td>
				<td><?php echo esc_html($scene->post_name) ?>
				</td>
				<td style="text-align: right">
					<a class="button success bbhelp--top" bbhelp-label="<?php esc_html_e('Edit', 'bestbug'); ?>" title="Edit" href="<?php echo admin_url('admin.php?page='.BESTBUG_SCENE_ADD.'&idScene=' . $scene->ID) ?>">
						<span class="dashicons dashicons-edit"></span>
					</a>
					<button data-base-url="<?php echo admin_url('admin.php?page='.BESTBUG_SCENE_ADD.'&idScene='); ?>" class="bbsm-button-duplicate button primary bbhelp--top" bbhelp-label="<?php esc_html_e('Duplicate', 'bestbug'); ?>" data-id="<?php echo esc_html($scene->ID) ?>">
						<span class="dashicons dashicons-admin-page"></span></button>
					<button class="bbsm-button-delete button danger bbhelp--top" bbhelp-label="<?php esc_html_e('Delete', 'bestbug'); ?>" data-id="<?php echo esc_html($scene->ID) ?>">
						<span class="dashicons dashicons-trash"></span></button>
				</td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<?php $this->subform(); ?>
