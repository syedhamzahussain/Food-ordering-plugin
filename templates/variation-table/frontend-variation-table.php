<?php
/**
 *
 * Contain frontend view of variation table
 *
 * @package Wholesale Product Page Customizer For WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="cwppe-variation-table-wrapper">
	<?php
	$secondary_attributes = $this->cwppe_get_varitaions( $product );
	$total_attributes     = count( $secondary_attributes );


	$secondary_var_count = 1;
	foreach ( $secondary_attributes as $att => $values ) {
		if ( $att !== $primary_variation ) {


			echo '<div class="secondary-section" > <h3>' . wp_kses_post( wc_attribute_label( $att, $product ) ) . ':</h3> <ul class="cwppe_selectable">';
			foreach ( $values['options'] as $key => $value ) {

				if ( strtoupper( wc_attribute_label( $att, $product ) ) === 'COLOR' ) {
					?>
					<li class="ui-widget-content" att-type="secondary" data_secondary_variation_count="<?php echo wp_kses_post( $secondary_var_count ); ?>" data_value="<?php echo wp_kses_post( $value ); ?>" secondary_data_attribute_name="<?php echo wp_kses_post( $att ); ?>">
						<span class="cwppe-active secondary-att-item-span" style="background-color:<?php echo wp_kses_post( $value ); ?>;" title="<?php echo wp_kses_post( $value ); ?>"></span>
					</li>
					<?php
				} else {
					?>

					<li class="ui-widget-content" att-type="secondary" data_secondary_variation_count="<?php echo wp_kses_post( $secondary_var_count ); ?>" data_value="<?php echo wp_kses_post( $value ); ?>" secondary_data_attribute_name="<?php echo wp_kses_post( $att ); ?>"><span class="secondary-att-item-span cwppe-active"><?php echo wp_kses_post( $value ); ?></span></li>

					<?php
				}
			}
			echo '</ul></div>';
			$secondary_var_count++;
		}
	}
	?>
	<div class="cwpee-primary-variation-wrapper">
		<div class="cwpee-primary-title" >
			<h3><?php echo wp_kses_post( wc_attribute_label( $primary_variation, $product ) ); ?>:</h3>
		</div>
		<div class="cwpee-primary-meta-wrapper">
			<?php
			$primary_attritube_options = $this->cwppe_get_varitaions( $product, $primary_variation );
			echo '<div class="primary-section" ><ul class="cwppe_selectable_primary">';
			foreach ( $primary_attritube_options['options'] as $key => $value ) {

				if ( strtoupper( wc_attribute_label( $primary_attritube_options['label'], $product ) ) === 'COLOR' ) {
					
					?>

					<br>
					<li class="ui-widget-content cwppe-primary"  att-type="primary" data_value="<?php echo wp_kses_post( $value ); ?>" data_attribute_name="<?php echo wp_kses_post(  $primary_variation ); ?>">
						<span class="cwppe-active primary-att-item-span" style="background-color:<?php echo wp_kses_post( $value ); ?>" title="<?php echo wp_kses_post( $value ); ?>" ></span>
						<span class="primary-att-item-span"><?php echo wp_kses_post( get_woocommerce_currency_symbol() ); ?> <span class='variation-items <?php echo 'price_' . wp_kses_post( $value ); ?> cwppe-price'>0.00</span></span>
						<span class='primary-att-item-span quantity-span'>
							<button type="button" class="dec-quantity">-</button>
							<input type='number' name ='cwppe-quantity' placeholder="0" value="0" min="0" default="0" class ='cwppe-quantity <?php echo 'quantity_' . wp_kses_post( $value ); ?>' />
							<button type="button" class="inc-quantity">+</button>

						</span>
					</li>
					<br>
					<?php
				} else {
					?>
					<br>
					<li class="ui-widget-content cwppe-primary"  att-type="primary" data_value="<?php echo wp_kses_post( $value ); ?>" data_attribute_name="<?php echo wp_kses_post(  $primary_variation ); ?>">
						<span class="cwppe-active primary-att-item-span"  title="<?php echo wp_kses_post( $value ); ?>" ><?php echo wp_kses_post( $value ); ?></span>
						<span class="primary-att-item-span"><?php echo wp_kses_post( get_woocommerce_currency_symbol() ); ?> <span class='variation-items <?php echo 'price_' . wp_kses_post( str_replace( ' ', '_', $value ) ); ?> cwppe-price'>0.00</span></span>
						<span class='primary-att-item-span quantity-span'>
							<button type="button" class="dec-quantity">-</button>
							<input type='number' name ='cwppe-quantity' placeholder="0" value="0" min="0" default="0" class ='cwppe-quantity <?php echo 'quantity_' . wp_kses_post( str_replace( ' ', '_', $value ) ); ?>' />
							<button type="button" class="inc-quantity">+</button>
						</span>
					</li>
					<br>

					<?php
				}
			}
			echo '</ul>'
			?>
			<button type='button' name ='cwppe-add-to-cart' primary-attribute-type = "<?php echo wp_kses_post(  $primary_variation ); ?>" product-id="<?php echo wp_kses_post( $product->get_id() ); ?>" class ='cwppe-add-to-cart btn btn-info'>Add To Cart</button>
			<?php
			' </div>';
			?>

		</div>
		<br>
	</div>
	<input type="hidden" name="number_of_attributes" class="number_of_attributes" value="<?php echo wp_kses_post( $total_attributes ); ?>"/>
<?php
$i = 0;
foreach ( $secondary_attributes as $att => $values ) {
	if ( $att !== $primary_variation ) {
		?>

			<input type="hidden" name="" class="secondary-h hidden-secondary-<?php echo wp_kses_post( $i ); ?>" <?php echo 'secondary_att_' . wp_kses_post( $i ) . '=' . wp_kses_post( $att ); ?> value=""/>
		<?php
		$i++;
	}
}
?>
</div>
</div>
<br>
<?php
