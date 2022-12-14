<?php
/**
 * Discount deals Meta Box Functions
 *
 * @package     Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Output a select input box.
 *
 * @param array $field Data about the field to render.
 */
function discount_deals_select( $field ) {
	$field = wp_parse_args(
		$field,
		array(
			'class'                 => 'discount-deals-field ',
			'style'                 => '',
			'value'                 => '',
			'name'                  => $field['id'],
			'required'              => false,
			'custom_attributes'     => array(),
			'has_value_description' => false,
			'value_description'     => '',
		)
	);

	$wrapper_attributes = array(
		'class'         => 'discount-deals-table__row',
		'data-name'     => $field['id'],
		'data-type'     => 'select',
		'data-required' => $field['required'] ? 1 : 0,
	);

	$label_attributes = array(
		'for' => $field['id'],
	);

	$field_attributes          = (array) $field['custom_attributes'];
	$field_attributes['style'] = $field['style'];
	$field_attributes['id']    = $field['id'];
	$field_attributes['name']  = $field['name'];
	$field_attributes['class'] = $field['class'];
	if ( $field['required'] ) {
		$field_attributes['required'] = 'required';
	}
	?>
	<tr <?php echo wc_implode_html_attributes( $wrapper_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<td class="discount-deals-table__col discount-deals-table__col--label">
			<label <?php echo wc_implode_html_attributes( $label_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			<?php if ( $field['required'] ) : ?>
				<span class="required">*</span>
			<?php endif; ?>
		</td>
		<td class="discount-deals-table__col discount-deals-table__col--field">
			<select <?php echo wc_implode_html_attributes( $field_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<?php
				foreach ( $field['options'] as $key => $value ) {
					echo '<option value="' . esc_attr( $key ) . '"' . wc_selected( $key, $field['value'] ) . '>' . esc_html( $value ) . '</option>';
				}
				?>
			</select>
			<?php if ( $field['has_value_description'] ) : ?>
				<div class="<?php echo esc_attr( $field['id'] ); ?>_description">
					<p><?php echo wp_kses_post( $field['value_description'] ); ?></p></div>
			<?php endif; ?>
		</td>
	</tr>
	<?php
}//end discount_deals_select()

/**
 * Output a select input box.
 *
 * @param array $field Data about the field to render.
 */
function discount_deals_editor( $field ) {
	$field = wp_parse_args(
		$field,
		array(
			'class'             => 'discount-deals-field ',
			'style'             => '',
			'value'             => '',
			'name'              => $field['id'],
			'required'          => false,
			'custom_attributes' => array(),
		)
	);

	$wrapper_attributes = array(
		'class' => 'discount-deals-table__row',
	);

	$label_attributes = array(
		'for' => $field['id'],
	);

	?>
	<tr <?php echo wc_implode_html_attributes( $wrapper_attributes );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<td class="discount-deals-table__col discount-deals-table__col--label">
			<label <?php echo wc_implode_html_attributes( $label_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			<?php if ( $field['required'] ) : ?>
				<span class="required">*</span>
			<?php endif; ?>
		</td>
		<td class="discount-deals-table__col discount-deals-table__col--field">
			<?php
			wp_editor( $field['value'], 'editor_' . $field['id'], array(
				'media_buttons' => true,
				'textarea_rows' => 8,
				'tabindex'      => 4,
				'textarea_name' => $field['name']
			) );
			if ( ! empty( $field['description'] ) ) {
				?>
				<div class="<?php echo esc_attr( $field['id'] ); ?>_description">
					<p><?php echo wp_kses_post( $field['description'] ); ?></p>
				</div>
			<?php 
			}
			?>
		</td>
	</tr>
	<?php
}//end discount_deals_editor()


/**
 * Output a radio input box.
 *
 * @param array $field Data about the field to render.
 */
function discount_deals_radio( $field ) {
	$field = wp_parse_args(
		$field,
		array(
			'class'             => 'discount-deals-field ',
			'style'             => '',
			'wrapper_class'     => '',
			'value'             => '',
			'name'              => $field['id'],
			'required'          => false,
			'custom_attributes' => array(),
			'options'           => array(),
		)
	);

	$wrapper_attributes = array( 'class' => 'discount-deals-table__row ' . $field['wrapper_class'], );

	$label_attributes = array(
		'for' => $field['id'],
	);
	?>
	<tr <?php echo wc_implode_html_attributes( $wrapper_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<td class="discount-deals-table__col discount-deals-table__col--label">
			<label <?php echo wc_implode_html_attributes( $label_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			<?php if ( $field['required'] ) : ?>
				<span class="required">*</span>
			<?php endif; ?>
		</td>
		<td class="discount-deals-table__col discount-deals-table__col--field">
			<?php
			echo '<ul class="wc-radios">';

			foreach ( $field['options'] as $key => $value ) {

				echo '<li><label><input
				name="' . esc_attr( $field['name'] ) . '"
				value="' . esc_attr( $key ) . '"
				type="radio"
				class="' . esc_attr( $field['class'] ) . '"
				style="' . esc_attr( $field['style'] ) . '"
				' . checked( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '
				/> ' . esc_html( $value ) . '</label>
		            </li>';
			}
			echo '</ul>';

			if ( ! empty( $field['description'] ) ) {
				?>
				<div class="<?php echo esc_attr( $field['id'] ); ?>_description">
					<p><?php echo wp_kses_post( $field['description'] ); ?></p></div>
				<?php
			}
			?>
		</td>
	</tr>
	<?php
}//end discount_deals_radio()


/**
 * Output a radio input box.
 *
 * @param array $field Data about the field to render.
 */
function discount_deals_html( $field ) {
	$field = wp_parse_args(
		$field,
		array(
			'class'         => 'discount-deals-field ',
			'style'         => '',
			'wrapper_class' => '',
			'html'          => '',
			'required'      => false,
		)
	);

	$wrapper_attributes = array( 'class' => 'discount-deals-table__row ' . $field['wrapper_class'], );

	$label_attributes = array(
		'for' => $field['id'],
	);
	?>
	<tr <?php echo wc_implode_html_attributes( $wrapper_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<td class="discount-deals-table__col discount-deals-table__col--label">
			<label <?php echo wc_implode_html_attributes( $label_attributes );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			<?php if ( $field['required'] ) : ?>
				<span class="required">*</span>
			<?php endif; ?>
		</td>
		<td class="discount-deals-table__col discount-deals-table__col--field">
			<?php
			echo $field['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</td>
	</tr>
	<?php
}//end discount_deals_html()


/**
 * Output a radio input box.
 *
 * @param array $field Data about the field to render.
 */
function discount_deals_text_input( $field ) {
	$field = wp_parse_args(
		$field,
		array(
			'class'             => 'discount-deals-field ',
			'style'             => '',
			'value'             => '',
			'name'              => $field['id'],
			'type'              => 'text',
			'placeholder'       => '',
			'data_type'         => '',
			'required'          => false,
			'custom_attributes' => array(),
		)
	);

	$wrapper_attributes = array( 'class' => 'discount-deals-table__row ' . $field['wrapper_class'], );

	$label_attributes = array(
		'for' => $field['id'],
	);

	$data_type = empty( $field['data_type'] ) ? '' : $field['data_type'];

	switch ( $data_type ) {
		case 'price':
			$field['class'] .= ' wc_input_price';
			$field['value'] = wc_format_localized_price( $field['value'] );
			break;
		case 'decimal':
			$field['class'] .= ' wc_input_decimal';
			$field['value'] = wc_format_localized_decimal( $field['value'] );
			break;
		case 'stock':
			$field['class'] .= ' wc_input_stock';
			$field['value'] = wc_stock_amount( $field['value'] );
			break;
		case 'url':
			$field['class'] .= ' wc_input_url';
			$field['value'] = esc_url( $field['value'] );
			break;

		default:
			break;
	}
	$required_text = $field['required'] ? 'required="required"' : '';
	?>
	<tr <?php echo wc_implode_html_attributes( $wrapper_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<td class="discount-deals-table__col discount-deals-table__col--label">
			<label <?php echo wc_implode_html_attributes( $label_attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $field['label'] ); ?></label>
			<?php if ( $field['required'] ) : ?>
				<span class="required">*</span>
			<?php endif; ?>
		</td>
		<td class="discount-deals-table__col discount-deals-table__col--field">
			<?php
			echo '<input type="' . esc_attr( $field['type'] ) . '" ' . $required_text . ' class="' . esc_attr( $field['class'] ) . '" style="' . esc_attr( $field['style'] ) . '" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" ' . implode( ' ', $field['custom_attributes'] ) . ' /> '; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( ! empty( $field['description'] ) ) {
				?>
				<div class="<?php echo esc_attr( $field['id'] ); ?>_description">
					<p><?php echo wp_kses_post( $field['description'] ); ?></p></div>
			<?php } ?>
		</td>
	</tr>
	<?php
}//end discount_deals_text_input()

