<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}
?>
<h4 id="<?php echo esc_attr( $name . '_' . $field['id'] ); ?>" class="frm_primary_label frm-font-semibold frm-text-grey-600 frm-mt-sm frm-mb-xs">
	<?php echo esc_html( $field_label ); ?>
</h4>
<?php
if ( isset( $default_value ) && is_array( $default_value ) ) {
	?>
	<p class="frm6 frm_form_field">
		<label for="default_value_<?php echo esc_attr( $name . '_' . $field['id'] ); ?>" class="frm_description" id="label_default_<?php echo esc_attr( $name . '_' . $field['id'] ); ?>">
			<?php esc_html_e( 'Default Value', 'formidable-pro' ); ?>
		</label>
		<span class="frm-with-right-icon">
			<?php
			FrmProAppHelper::icon_by_class(
				'frm_icon_font frm_more_horiz_solid_icon frm-show-inline-modal',
				array(
					'data-open' => 'frm-smart-values-box',
				)
		 	);
			?>
			<input type="text" name="default_value_<?php echo esc_attr( $field['id'] ); ?>[<?php echo esc_attr( $name ); ?>]" id="default_value_<?php echo esc_attr( $name . '_' . $field['id'] ); ?>" value="<?php echo esc_attr( isset( $default_value[ $name ] ) ? $default_value[ $name ] : '' ); ?>" aria-labelledby="<?php echo esc_attr( $name . '_' . $field['id'] ); ?> label_default_<?php echo esc_attr( $name . '_' . $field['id'] ); ?>" data-changeme="field_<?php echo esc_attr( $field['field_key'] . '_' . $name ); ?>" data-changeatt="value" />
		</span>
	</p>
	<?php
}

$sub      = 'placeholder';
$label    = __( 'Placeholder Text', 'formidable-pro' );
$subname  = $name . '_' . $sub;
$field_id = 'field_options_' . $subname . '_' . $field['id'];
?>
<p class="frm6 frm_form_field">
	<label for="<?php echo esc_attr( $field_id ); ?>" class="frm_description" id="label_<?php echo esc_attr( $subname . '_' . $field['id'] ); ?>">
		<?php echo esc_html( $label ); ?>
	</label>
	<input type="text" name="field_options[<?php echo esc_attr( $sub . '_' . $field['id'] ); ?>][<?php echo esc_attr( $name ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( isset( $field[ $sub ][ $name ] ) ? $field[ $sub ][ $name ] : '' ); ?>" aria-labelledby="<?php echo esc_attr( $name . '_' . $field['id'] ); ?> label_<?php echo esc_attr( $subname . '_' . $field['id'] ); ?>" data-changeme="field_<?php echo esc_attr( $field['field_key'] . '_' . $name ); ?>" data-changeatt="placeholder" />
</p>

<?php
$sub      = 'desc';
$label    = __( 'Description', 'formidable-pro' );
$subname  = $name . '_' . $sub;
$field_id = 'field_options_' . $subname . '_' . $field['id'];
?>
<p class="frm_form_field">
	<label for="<?php echo esc_attr( $field_id ); ?>" class="frm_description" id="label_<?php echo esc_attr( $subname . '_' . $field['id'] ); ?>">
		<?php echo esc_html( $label ); ?>
	</label>
	<input type="text" name="field_options[<?php echo esc_attr( $subname . '_' . $field['id'] ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( isset( $field[ $subname ] ) ? $field[ $subname ] : '' ); ?>" aria-labelledby="<?php echo esc_attr( $name . '_' . $field['id'] ); ?> label_<?php echo esc_attr( $subname . '_' . $field['id'] ); ?>" data-changeme="field_<?php echo esc_attr( $subname . '_' . $field['id'] ); ?>" />
</p>
